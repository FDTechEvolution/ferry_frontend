<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function index(Request $request) {
        if(isset($request['_p']))
            return view('pages.payment.index', ['_p' => $request['_p'], '_b' => $request['_b']]);
        else
            // return view('pages.payment.index', ['_b' => 'BO2311300126']);
            return redirect()->route('home');
    }

    public function payment(Request $request) {
        if(!isset($request->payments) || !isset($request->payment_method)) {
            return view('pages.payment.updated', ['message' => 'Nothing...', 'bookingno' => $request->bookingno]);
        }

        $response = Http::reqres()->post('/payment/create', [
            'payment_id' => $request->payments,
            'payment_method' => $request->payment_method
        ]);

        $res = $response->json();
        $data = $res['data'];
        $booking_id = $res['booking'];

        if($data['respCode'] == '0000') {
            return redirect()->route('payment-index', ['_p' => $data['webPaymentUrl'], '_b' => $booking_id]);
        }

        return redirect()->route('home');
    }

    public function print($bookingno = null) {
        $link = config('services.store.image');
        return redirect()->away($link.'/print/ticket/'.$bookingno);
    }
}
