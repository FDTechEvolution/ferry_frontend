const booking_route = document.querySelector('#booking-route-select')
const depart_route = booking_route.querySelector('#booking-depart')
const return_route = booking_route.querySelector('#booking-return')
let route_depart_selected = false
let route_return_selected = false
let depart_price = 0
let return_price = 0
let route_depart_index = null
let route_return_index = null
let depart_extra = []
let return_extra = []

if(depart_route) {
    let route_list = depart_route.querySelectorAll('.booking-depart-list')

    route_list.forEach((route, index) => {
        route.addEventListener('click', (e) => {
            route_list.forEach((item) => { 
                item.classList.remove('active')
                item.classList.add('route-hover')
            })

            route_depart_index = index
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

            route_return_index = index
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

function progressCondition(step) {
    if(step === 'select') {

    }

    if(step === 'extra') {
        extraList('.depart-meal', `#extra-depart-meal-index-${route_depart_index}`)
        extraList('.depart-activity', `#extra-depart-activity-index-${route_depart_index}`)

        extraList('.return-meal', `#extra-return-meal-index-${route_return_index}`)
        extraList('.return-activity', `#extra-return-activity-index-${route_return_index}`)
    }
}

function extraList(lists, list) {
    const _extra = document.querySelector('#booking-route-extra')

    const _lists = _extra.querySelectorAll(lists)
    const _list = _extra.querySelector(list)
    _lists.forEach((list) => { list.classList.add('d-none') })
    _list.classList.remove('d-none')
}

function inc(type, element, index) {
    const el = document.querySelector(`#${type}-${element}-index-${index}`)
    const icon = document.querySelector(`#${type}-${element}-img-${index}`)
    const name = document.querySelector(`#${type}-${element}-name-${index}`)
    const amount = document.querySelector(`.${type}-${element}-amount-${index}`)
    let qty = parseInt(el.value) + 1
    el.value = qty
    
    let _extra_amount = parseToNumber(amount.innerText)
    setExtra(icon.src, name.innerText, _extra_amount, qty, element, type)
}

function dec(type, element, index) {
    const el = document.querySelector(`#${type}-${element}-index-${index}`)
    const icon = document.querySelector(`#${type}-${element}-img-${index}`)
    const name = document.querySelector(`#${type}-${element}-name-${index}`)
    const amount = document.querySelector(`.${type}-${element}-amount-${index}`)
    if(parseInt(el.value) > 0) {
        let qty = parseInt(el.value) - 1
        el.value = qty

        let _extra_amount = parseToNumber(amount.innerText)
        setExtra(icon.src, name.innerText, _extra_amount, qty, element, type)
    }
}

function setExtra(icon, name, amount, qty, element, type) {
    let _extra = {
        'type': element,
        'name': name,
        'icon': icon,
        'qty': qty,
        'amount': amount
    }

    if(qty > 0) {
        if(type === 'depart') {
            let index = depart_extra.findIndex(extra => { return extra.name === name && extra.type === element })
            if(index >= 0) depart_extra[index].qty = qty
            else depart_extra.push(_extra)
        }
        if(type === 'return') {
            let index = return_extra.findIndex(extra => { return extra.name === name && extra.type === element })
            if(index >= 0) return_extra[index].qty = qty
            else return_extra.push(_extra)
        }
    }
    else {
        if(type === 'depart') {
            let index = depart_extra.findIndex(extra => { return extra.name === name && extra.type === element })
            depart_extra.splice(index, 1)
        }
        if(type === 'return') {
            let index = return_extra.findIndex(extra => { return extra.name === name && extra.type === element })
            return_extra.splice(index, 1)
        }
    }

    // console.log(depart_extra)

    // console.log(return_extra)
}