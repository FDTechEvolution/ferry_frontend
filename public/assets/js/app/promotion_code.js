const promo_input = document.querySelector('.booking-promocode-input')
const promo_submit = document.querySelector('#button-promocode-submit')
if(promo_input.value === '') {
    promo_input.value = '10%FLEXI'
    promo_submit.click()
}
