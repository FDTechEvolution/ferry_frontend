function inc(element, index) {
    const el = document.querySelector(`#extra-${element}-index-${index}`)
    const icon = document.querySelector(`#extra-${element}-img-${index}`)
    const name = document.querySelector(`#extra-${element}-name-${index}`)
    const amount = document.querySelector(`.extra-${element}-amount-${index}`)
    let qty = parseInt(el.value) + 1
    el.value = qty
    let _extra_amount = parseToNumber(amount.innerText)
    let ico_src = icon === null ? '' : icon.src
}

function dec(element, index) {
    const el = document.querySelector(`#extra-${element}-index-${index}`)
    const icon = document.querySelector(`#extra-${element}-img-${index}`)
    const name = document.querySelector(`#extra-${element}-name-${index}`)
    const amount = document.querySelector(`.extra-${element}-amount-${index}`)
    if(parseInt(el.value) > 0) {
        let qty = parseInt(el.value) - 1
        el.value = qty
        let _extra_amount = parseToNumber(amount.innerText)
        let ico_src = icon === null ? '' : icon.src
    }
}

function parseToNumber(str) {
    return parseFloat(str.split(',').join(''));
}

const btn_person = document.querySelector('#button-person')
if(btn_person) {
    btn_person.addEventListener('click', () => {
        const bookingno = document.querySelector('.person-number-booking')
        if(bookingno.value === '') bookingno.classList.add('border-danger')
        else {
            bookingno.classList.remove('border-danger')
            getperson(bookingno.value)
        }
    })
}

async function getperson(bookingno) {
    const loading = document.querySelector('.person-loading')
    loading.classList.remove('d-none')

    let data = new FormData()
    data.append('booking_number', bookingno)
    data.append('booking_current', booking_current)

    console.log(bookingno, booking_current)

    let response = await fetch(`/ajax/booking/check-booking`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            body: data
                        })
    let res = await response.json()
    loading.classList.add('d-none')

    console.log(res)
}