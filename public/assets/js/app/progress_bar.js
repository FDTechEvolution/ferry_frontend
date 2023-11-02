const booking_route = document.querySelector('#booking-route-select')
let sum_price = ''
if(booking_route) {
    let route_list = booking_route.querySelectorAll('.booking-route-list')

    route_list.forEach((route) => {
        route.addEventListener('click', (e) => {
            route_list.forEach((item) => { 
                item.classList.remove('active')
                item.classList.add('route-hover')
            })
            let _price = route.querySelector('.route-price')
            document.querySelector('#progress-next').disabled = false

            sum_price = parseToNumber(_price.innerText)
            document.querySelector('#sum-price').innerHTML = `${sum_price.toLocaleString("en-US", { minimumFractionDigits: 2 })}`
            route.classList.add('active')
            route.classList.remove('route-hover')
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
        progress_prev.disabled = true;
    } else if (active === steps.length -1) {
        progress_next.disabled = true;
    } else {
        progress_prev.disabled = false;
        progress_next.disabled = false;
    }
}