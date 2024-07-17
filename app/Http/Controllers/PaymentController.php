<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function index(Request $request) {
        if(isset($request['_p']))
            return view('pages.payment.index', ['_p' => $request['_p'], '_b' => $request['_b'], '_e' => $request['_e']]);
        else
            // return view('pages.payment.index', ['_b' => 'BO2311300126']);
            return redirect()->route('home');
    }

    public function payment(Request $request) {
        if(!isset($request->payments) || !isset($request->payment_method)) {
            return view('pages.payment.updated', ['message' => 'Nothing...', 'bookingno' => $request->bookingno]);
        }

        if(isset($request->payment_type) && $request->payment_type == '2c2p') {
            $res  = $this->payment_2c2p($request);
            if($res != false) {
                return redirect()->route('payment-index', ['_p' => $res['_p'], '_b' => $res['_b'], '_e' => $request->passenger_email]);
            }
        }

        if(isset($request->payment_type) && $request->payment_type == 'ctsv') {
            $res = $this->payment_ctsv($request);
            if($res != false) {
                return view('pages.payment.ctsv_payment', ['_p' => $res, '_b' => $request->bookingno, '_e' => $request->passenger_email]);
            }
        }

        return redirect()->route('home');
    }

    private function payment_2c2p($request) {
        $response = Http::reqres()->post('/payment/create', [
            'payment_id' => $request->payments,
            'payment_method' => $request->payment_method
        ]);

        $res = $response->json();
        $data = $res['data'];
        $booking_id = $res['booking'];

        if($data['respCode'] == '0000') {
            return ['_p' => $data['webPaymentUrl'], '_b' => $booking_id, '_e' => $request->passenger_email];
        }
        return false;
    }

    private function payment_ctsv($request) {
        $response = Http::reqres()->post('/payment/create-ctsv', [
            'payment_id' => $request->payments,
            'payment_method' => $request->payment_method
        ]);

        $res = $response->json();
        if($res['result']) return $res['data'];
        return false;
    }

    public function print($bookingno = null) {
        $link = config('services.store.image');
        return redirect()->away($link.'/print/ticket/'.$bookingno);
    }

    public function paymentCtsvResponse(Request $request) {
        if(isset($request['code']) && isset($request['message']) && isset($request['desc']) && isset($request['email'])) {
            $bookingno = explode('-', $request['desc'])[0];
            return view('pages.payment.ctsv_response', [
                'payment_code' => $request['code'],
                'payment_result' => $request['message'],
                'bookingno' => $bookingno,
                'email' => $request['email']
            ]);
        }

        return redirect()->route('home');
    }
}
