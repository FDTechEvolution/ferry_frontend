const booking_route = document.querySelector('#booking-route-select')
let route_price = 0
let extra_price = 0
let depart_time = ''
let arrive_time = ''
let route_selected = null
let icon_selected = []
let passenger_payment = []
if(booking_route) {
    let route_list = booking_route.querySelectorAll('.booking-route-list')

    route_list.forEach((route, index) => {
        route.addEventListener('click', (e) => {
            route_list.forEach((item) => { 
                item.classList.remove('active')
                item.classList.add('route-hover')
            })
            let _price = route.querySelector('.route-price')
            depart_time = route.querySelector('.depart-time').innerText
            arrive_time = route.querySelector('.arrival-time').innerText
            document.querySelector('#progress-next').disabled = false

            route_price = parseToNumber(_price.innerText)
            document.querySelector('.set-time-route-select').innerHTML = `${depart_time} - ${arrive_time}`
            document.querySelector('#sum-price').innerHTML = `${route_price.toLocaleString("en-US", { minimumFractionDigits: 2 })}`
            route.classList.add('active')
            route.classList.remove('route-hover')

            route_selected = index
            let icons = route.querySelectorAll('.icon-selected')
            let icon_list = []
            let price_list = []
            icons.forEach((icon) => {
                icon_list.push(icon.src)
            })
            icon_selected = icon_list

            price_list.push(route.querySelector('.selected-adult-price').value)
            price_list.push(route.querySelector('.selected-child-price').value)
            price_list.push(route.querySelector('.selected-infant-price').value)
            passenger_payment = price_list
        })
    })
}

function setPassengerPayment() {

}

function parseToNumber(str) {
    return parseFloat(str.split(',').join(''));
}

// Step bar

const progress_bar = document.querySelector('.process-steps')
const progress_prev = document.querySelector('#progress-prev')
const progress_next = document.querySelector('#progress-next')
const steps = progress_bar.querySelectorAll('.process-step-item')
const progress = document.querySelectorAll('.procress-step')
let active = isStep
updateProgress()

if(progress_next) {
    progress_next.addEventListener('click', () => {
        active++
        if(active > steps.length) {
            active = steps.length
        }
        updateProgress()
    })
}

if(progress_prev) {
    progress_prev.addEventListener('click', () => {
        active--
        if(active < 1) {
            active = 1
        }
        updateProgress()
    })
}

function updateProgress() {
    steps.forEach((step, index) => {
        if(index < active) {
            step.classList.add('complete')
            step.classList.remove('active')
            step.classList.remove('text-primary')
            progress[index].classList.add('d-none')
        }
        else if(index === active) {
            progressCondition(step.getAttribute('data-step'))
            step.classList.remove('complete')
            step.classList.add('active')
            step.classList.add('text-primary')
            progress[index].classList.remove('d-none')
        }
        else {
            step.classList.remove('active')
            step.classList.remove('text-primary')
            progress[index].classList.add('d-none')
        }
    })

    if (active === 1) {
        progress_prev.disabled = true
    } else if (active === steps.length -1) {
        progress_next.disabled = true
    } else {
        progress_prev.disabled = false
        progress_next.disabled = false
    }
}


// Passenger
function progressCondition(step) {
    if(step === 'select') {
        let route_list = booking_route.querySelectorAll('.booking-route-list')
        route_list.forEach((route) => {
            if(route.classList.contains('active')) document.querySelector('#progress-next').disabled = false
        })
    }

    // if(step === 'passenger') {
    //     const passenger_next = document.querySelector('#progress-next-passenger')
    //     progress_next.classList.add('d-none')
    //     passenger_next.classList.remove('d-none')
    //     passenger_next.disabled = false
    // }
    // else if(step !== 'passenger') {
    //     const passenger_next = document.querySelector('#progress-next-passenger')
    //     progress_next.classList.remove('d-none')
    //     passenger_next.classList.add('d-none')
    //     passenger_next.disabled = true
    // }

    if(step === 'extra') {
        const _extra = document.querySelector('#booking-route-extra')
        const meal_list = _extra.querySelectorAll(`.route-meal`)
        const activity_list = _extra.querySelectorAll('.route-activity')

        let meal_select = _extra.querySelector(`#route-meal-index-${route_selected}`)
        meal_list.forEach((item) => { item.classList.add('d-none') })
        meal_select.classList.remove('d-none')

        let activity_select = _extra.querySelector(`#route-activity-index-${route_selected}`)
        activity_list.forEach((item) => { item.classList.add('d-none') })
        activity_select.classList.remove('d-none')
    }

    if(step === 'payment') {
        document.querySelector('.is_depart_time').innerHTML = depart_time
        document.querySelector('.is_arrive_time').innerHTML = arrive_time
        const route_icon = document.querySelector('#route-icon-payment')
        const icon_list = route_icon.querySelectorAll('img')

        icon_list.forEach((icon) => { icon.remove() })

        icon_selected.forEach((icon) => {
            let img = document.createElement('img')
            img.src = icon
            img.setAttribute('class', 'me-1 w-100')

            route_icon.appendChild(img)
        })

        let adult_qty = document.querySelector('#passenger-adult')
        let adult_price = document.querySelector('.payment-adult-price')
        let child_price = document.querySelector('.payment-child-price')
        let child_qty = document.querySelector('#passenger-child')
        let infant_price = document.querySelector('.payment-infant-price')
        let infant_qty = document.querySelector('#passenger-infant')
        let sum_of_payment = 0

        if(adult_price) {
            adult_price.innerHTML = parseToNumber(passenger_payment[0]).toLocaleString("en-US")
            let adult_sum = parseToNumber(adult_qty.innerText)*parseToNumber(passenger_payment[0])
            document.querySelector('.sum-of-adult').innerHTML = adult_sum.toLocaleString("en-US")
            sum_of_payment+= adult_sum
        }
        if(child_price) {
            child_price.innerHTML = parseToNumber(passenger_payment[1]).toLocaleString("en-US")
            let child_sum = parseToNumber(child_qty.innerText)*parseToNumber(passenger_payment[1])
            document.querySelector('.sum-of-child').innerHTML = child_sum.toLocaleString("en-US")
            sum_of_payment+= child_sum
        }
        if(infant_price) {
            infant_price.innerHTML = parseToNumber(passenger_payment[2]).toLocaleString("en-US")
            let infant_sum = parseToNumber(infant_qty.innerText)*parseToNumber(passenger_payment[2])
            document.querySelector('.sum-of-infant').innerHTML = infant_sum.toLocaleString("en-US")
            sum_of_payment+= infant_sum
        }

        document.querySelector('.sum-of-payment').innerHTML = sum_of_payment.toLocaleString("en-US")
    }
}

function progressPassenger() {
    const _passenger = document.querySelector('#booking-route-passenger')
    let _input = _passenger.querySelectorAll('input')
    let _select = _passenger.querySelectorAll('select')
    let input_required = select_required = 0

    _input.forEach((input, index) => {
        if(input.required) {
            input_required++
            if(input.value === '') {
                input.classList.add('border-danger')
                input.focus()
            }
            else {
                input_required--
                input.classList.remove('border-danger')
            }
        }
    })

    _select.forEach((select, index) => {
        if(select.required) {
            select_required++
            if(select.value === '') {
                select.classList.add('border-danger')
                select.focus()
            }
            else {
                select_required--
                select.classList.remove('border-danger')
            }
        }
    })

    if(input_required === 0 && select_required === 0) progress_next.click()
}

function inc(element, index) {
    const el = document.querySelector(`#extra-${element}-index-${index}`)
    let extra_amount = document.querySelector(`.extra-${element}-amount-${index}`)
    el.value = parseInt(el.value) + 1
    let _extra_amount = parseToNumber(extra_amount.innerText)
    extra_price+= _extra_amount
    updateSumPrice()
}

function dec(element, index) {
    const el = document.querySelector(`#extra-${element}-index-${index}`)
    let extra_amount = document.querySelector(`.extra-${element}-amount-${index}`)
    if(parseInt(el.value) > 0) {
        el.value = parseInt(el.value) -1
        let _extra_amount = parseToNumber(extra_amount.innerText)
        extra_price-= _extra_amount
        updateSumPrice()
    }
}

function updateSumPrice() {
    let sum_amount = route_price + extra_price
    document.querySelector('#sum-price').innerHTML = `${sum_amount.toLocaleString("en-US", { minimumFractionDigits: 2 })}`
}