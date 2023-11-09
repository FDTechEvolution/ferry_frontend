const booking_route = document.querySelector('#booking-route-select')
const depart_route = booking_route.querySelector('#booking-depart')
const return_route = booking_route.querySelector('#booking-return')
let route_depart_selected = false
let route_return_selected = false
let depart_price = 0
let return_price = 0

if(depart_route) {
    let route_list = depart_route.querySelectorAll('.booking-depart-list')

    route_list.forEach((route, index) => {
        route.addEventListener('click', (e) => {
            route_list.forEach((item) => { 
                item.classList.remove('active')
                item.classList.add('route-hover')
            })

            route_depart_selected = true
            routeSelected()
            route.classList.add('active')
            route.classList.remove('route-hover')

            depart_time = route.querySelector('.depart-time').innerText
            arrive_time = route.querySelector('.arrival-time').innerText
            document.querySelector('.set-time-route-depart').innerHTML = ` | ${depart_time} - ${arrive_time}`

            let _price = route.querySelector('.route-price')
            depart_price = parseToNumber(_price.innerText)
            updateRoutePrice()

            document.querySelector('[name="booking_depart_selected"]').value = route.querySelector('.selected-route').value
        })
    })
}

if(return_route) {
    let route_list = return_route.querySelectorAll('.booking-return-list') 

    route_list.forEach((route, index) => {
        route.addEventListener('click', (e) => {
            route_list.forEach((item) => { 
                item.classList.remove('active')
                item.classList.add('route-return-hover')
            })

            route_return_selected = true
            routeSelected()
            route.classList.add('active')
            route.classList.remove('route-return-hover')

            depart_time = route.querySelector('.depart-time').innerText
            arrive_time = route.querySelector('.arrival-time').innerText
            document.querySelector('.set-time-route-return').innerHTML = ` | ${depart_time} - ${arrive_time}`

            let _price = route.querySelector('.route-price')
            return_price = parseToNumber(_price.innerText)
            updateRoutePrice()

            document.querySelector('[name="booking_return_selected"]').value = route.querySelector('.selected-route').value
        })
    })
}

function routeSelected() {
    if(route_depart_selected && route_return_selected)
        document.querySelector('#progress-next').disabled = false
}

function updateRoutePrice() {
    document.querySelector('#sum-price').innerHTML = (depart_price + return_price).toLocaleString("en-US", { minimumFractionDigits: 2 })
}

function parseToNumber(str) {
    return parseFloat(str.split(',').join(''));
}

// Step bar
const progress_bar = document.querySelector('.process-steps')
const progress_prev = document.querySelector('#progress-prev')
const progress_next = document.querySelector('#progress-next')
const progress_payment = document.querySelector('#progress-payment')
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
            // progressCondition(step.getAttribute('data-step'))
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