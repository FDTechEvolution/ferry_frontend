const booking_route = document.querySelector('#booking-route-select')
let sum_price = ''
let route_selected = null
if(booking_route) {
    let route_list = booking_route.querySelectorAll('.booking-route-list')

    route_list.forEach((route, index) => {
        route.addEventListener('click', (e) => {
            route_list.forEach((item) => { 
                item.classList.remove('active')
                item.classList.add('route-hover')
            })
            let _price = route.querySelector('.route-price')
            let depart_time = route.querySelector('.depart-time')
            let arraive_time = route.querySelector('.arrival-time')
            document.querySelector('#progress-next').disabled = false

            sum_price = parseToNumber(_price.innerText)
            document.querySelector('.set-time-route-select').innerHTML = `${depart_time.innerText} - ${arraive_time.innerText}`
            document.querySelector('#sum-price').innerHTML = `${sum_price.toLocaleString("en-US", { minimumFractionDigits: 2 })}`
            route.classList.add('active')
            route.classList.remove('route-hover')

            route_selected = index
        })
    })
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
        let meal_select = _extra.querySelector(`#route-meal-index-${route_selected}`)
        meal_list.forEach((item) => { item.classList.add('d-none') })
        meal_select.classList.remove('d-none')
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