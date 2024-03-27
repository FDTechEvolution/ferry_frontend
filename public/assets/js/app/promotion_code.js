const promo_input = document.querySelector('.booking-promocode-input')
const promo_submit = document.querySelector('#button-promocode-submit')
const station = document.querySelectorAll('.is-station-from')
if(promo_input.value === '') {
    let status = checkStation(station)
    setCode(status)
}

function checkStation(station) {
    let status = false
    station.forEach((item) => {
        if(item.innerText.search('Lipe') >= 0) status = true
    })

    return status
}

function setCode(status) {
    const promocode = 'Cg4z8qUMS'
    if(status && promocode !== '') {
        promo_input.value = promocode
        promo_submit.click()
    }
}
