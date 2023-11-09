const booking_route = document.querySelector('#booking-route-select')
let route_price = 0
let extra_price = 0
let depart_time = ''
let arrive_time = ''
let route_selected = null
let icon_selected = []
let passenger_payment = []
let extra_id = [] // extra id to post
let is_extra = [] // extra service select
let is_passenger = [] // passenger info
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

            const booking_extra = document.querySelector('#booking-route-extra')
            const inputs = booking_extra.querySelectorAll('input[type="number"]')
            inputs.forEach((input) => { input.value = 0 })
            is_extra = []

            document.querySelector('[name="booking_route_selected"]').value = route.querySelector('.selected-route').value
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


// Passenger
function progressCondition(step) {
    if(step === 'select') {
        let route_list = booking_route.querySelectorAll('.booking-route-list')
        route_list.forEach((route) => {
            if(route.classList.contains('active')) document.querySelector('#progress-next').disabled = false
        })

        progress_payment.classList.add('d-none')
        progress_payment.disabled = true
    }

    if(step === 'passenger') {
        const passenger_next = document.querySelector('#progress-next-passenger')
        progress_next.classList.add('d-none')
        passenger_next.classList.remove('d-none')
        passenger_next.disabled = false

        progress_payment.classList.add('d-none')
        progress_payment.disabled = true
    }
    else if(step !== 'passenger') {
        const passenger_next = document.querySelector('#progress-next-passenger')
        progress_next.classList.remove('d-none')
        passenger_next.classList.add('d-none')
        passenger_next.disabled = true
    }

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

        progress_next.classList.remove('d-none')
        progress_payment.classList.add('d-none')
        progress_payment.disabled = true
    }

    if(step === 'payment') {
        setLitinerary()
        setPassengerDetail()
        setExtraDetail()

        progress_next.classList.add('d-none')
        progress_payment.classList.remove('d-none')
        progress_payment.disabled = false
    }
}

function setExtraDetail() {
    const extra_service = document.querySelector('#payment-extra-service')
    const extra_meal = document.querySelector('#payment-extra-meal')
    const extra_activity = document.querySelector('#payment-extra-activity')
    while (extra_meal.firstChild) {
        extra_meal.removeChild(extra_meal.lastChild);
    }
    while (extra_activity.firstChild) {
        extra_activity.removeChild(extra_activity.lastChild);
    }

    if(is_extra.length === 0) extra_service.classList.add('d-none')
    else extra_service.classList.remove('d-none')

    let _extra = Object.groupBy(is_extra, ex => { return ex.type })
    if(_extra['meal']) {
        
        let row = document.createElement('div')
        let col_12 = document.createElement('div')
        let header = document.createElement('p')

        row.setAttribute('class', 'row')
        col_12.setAttribute('class', 'col-12')
        header.setAttribute('class', 'mb-1 fw-bold text-dark')
        header.innerHTML = 'Meal'

        extra_meal.appendChild(row)
        row.appendChild(col_12)
        col_12.appendChild(header)

        _extra['meal'].forEach((meal) => {
            let p = document.createElement('p')
            p.setAttribute('class', 'mb-0 ms-2 text-dark')
            p.innerHTML = `<img src="${meal.icon}" class="me-3" width="40" height="auto"> ${meal.name} - [ <strong>Fare </strong> ${meal.qty} x ${meal.amount.toLocaleString("en-US")} ] : ${(meal.qty*meal.amount).toLocaleString("en-US")} THB`
            extra_meal.appendChild(p)
        })
    }

    if(_extra['activity']) {
        let row = document.createElement('div')
        let col_12 = document.createElement('div')
        let header = document.createElement('p')

        row.setAttribute('class', 'row')
        col_12.setAttribute('class', 'col-12')
        header.setAttribute('class', 'mb-1 fw-bold text-dark')
        header.innerHTML = 'Activity'

        extra_activity.appendChild(row)
        row.appendChild(col_12)
        col_12.appendChild(header)

        _extra['activity'].forEach((activity) => {
            let p = document.createElement('p')
            p.setAttribute('class', 'mb-0 ms-2 text-dark')
            p.innerHTML = `<img src="${activity.icon}" class="me-3" width="40" height="auto"> ${activity.name} - [ <strong>Fare </strong> ${activity.qty} x ${activity.amount.toLocaleString("en-US")} ] : ${(activity.qty*activity.amount).toLocaleString("en-US")} THB`
            extra_activity.appendChild(p)
        })
    }
}

function setPassengerDetail() {
    const passenger_detail = document.querySelector('#payment-passenger-detail')
    while (passenger_detail.firstChild) {
        passenger_detail.removeChild(passenger_detail.lastChild);
    }
    let _passenger = Object.groupBy(is_passenger, pass => { return pass._type })

    if(_passenger['Adult']) {
        let row = document.createElement('div')
        let col_12 = document.createElement('div')
        let header = document.createElement('p')

        row.setAttribute('class', 'row')
        col_12.setAttribute('class', 'col-12')
        header.setAttribute('class', 'mb-1 fw-bold')
        header.innerHTML = 'Adult'
        
        passenger_detail.appendChild(row)
        row.appendChild(col_12)
        col_12.appendChild(header)

        _passenger['Adult'].forEach((adult) => {
            let p = document.createElement('p')
            p.setAttribute('class', 'mb-0 ms-2')
            let title = adult.title.charAt(0).toUpperCase() + adult.title.slice(1)
            let lead = adult.type === 'lead' ? `<span class="badge bg-primary-soft">Lead passenger</span>` : ''
            let email = adult.type === 'lead' ? ` : <strong class="fw-bold">Email :</strong> ${adult.email}` : ''
            p.innerHTML = `${title} ${adult.first_name} ${adult.last_name} [ <strong class="fw-bold">Date of birth</strong> ${adult.birth_day} ] ${email} ${lead}`
            passenger_detail.appendChild(p)
        })
    }

    if(_passenger['Child']) {
        let row = document.createElement('div')
        let col_12 = document.createElement('div')
        let header = document.createElement('p')

        row.setAttribute('class', 'row')
        col_12.setAttribute('class', 'col-12')
        header.setAttribute('class', 'mt-3 mb-1 fw-bold')
        header.innerHTML = 'Children'
        
        passenger_detail.appendChild(row)
        row.appendChild(col_12)
        col_12.appendChild(header)

        _passenger['Child'].forEach((child) => {
            let p = document.createElement('p')
            p.setAttribute('class', 'mb-0 ms-2')
            let title = child.title.charAt(0).toUpperCase() + child.title.slice(1)
            p.innerHTML = `${title} ${child.first_name} ${child.last_name} [ <strong class="fw-bold">Date of birth</strong> ${child.birth_day} ]`
            passenger_detail.appendChild(p)
        })
    }

    if(_passenger['Infant']) {
        let row = document.createElement('div')
        let col_12 = document.createElement('div')
        let header = document.createElement('p')

        row.setAttribute('class', 'row')
        col_12.setAttribute('class', 'col-12')
        header.setAttribute('class', 'mt-3 mb-1 fw-bold')
        header.innerHTML = 'Baby'
        
        passenger_detail.appendChild(row)
        row.appendChild(col_12)
        col_12.appendChild(header)

        _passenger['Infant'].forEach((infant) => {
            let p = document.createElement('p')
            p.setAttribute('class', 'mb-0 ms-2')
            let title = infant.title.charAt(0).toUpperCase() + infant.title.slice(1)
            p.innerHTML = `${title} ${infant.first_name} ${infant.last_name} [ <strong class="fw-bold">Date of birth</strong> ${infant.birth_day} ]`
            passenger_detail.appendChild(p)
        })
    }
}

function setLitinerary() {
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

function progressPassenger() {
    const _passenger = document.querySelector('#booking-route-passenger')
    let _email = document.querySelector('#passenger-email')
    let _cemail = document.querySelector('#passenger-confirm-email')
    let _input = _passenger.querySelectorAll('input')
    let _select = _passenger.querySelectorAll('select')
    let input_required = select_required = email_confirm = 0

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

    if(_email.value !== _cemail.value) {
        _email.classList.add('border-danger')
        _cemail.classList.add('border-danger')
        _email.focus()
        email_confirm++
    }
    else {
        _email.classList.remove('border-danger')
        _cemail.classList.remove('border-danger')
        email_confirm = 0
    }

    if(input_required === 0 && select_required === 0 && email_confirm === 0) {
        setPassengerPayment()
        progress_next.click()
    }
}


function setPassengerPayment() {
    is_passenger = []
    
    const booking_passenger = document.querySelector('#booking-route-passenger')
    const lead_passenger = booking_passenger.querySelector('#lead-passenger')
    const normal_passenger = booking_passenger.querySelectorAll('.normal-passenger')
    let lead_select = lead_passenger.querySelector('select')
    let lead_inputs = lead_passenger.querySelectorAll('input')

    isLeadPassenger(lead_inputs, lead_select.value)
    if(normal_passenger) isNormalPassenger(normal_passenger)
}

function isLeadPassenger(lead_inputs, lead_title) {
    let _passenger = ''
    let set_lead = []

    lead_inputs.forEach((input) => {
        if(input.name === 'first_name[]') set_lead.push(input.value)
        if(input.name === 'last_name[]') set_lead.push(input.value)
        if(input.name === 'birth_day[]') set_lead.push(input.value)
        if(input.name === 'email') set_lead.push(input.value)
    })

    _passenger = {
        'type': 'lead',
        '_type': 'Adult',
        'title': lead_title,
        'first_name': set_lead[0],
        'last_name': set_lead[1],
        'birth_day': set_lead[2],
        'email': set_lead[3]
    }

    is_passenger.push(_passenger)
}

function isNormalPassenger(normal_passenger) {
    normal_passenger.forEach((passenger) => {
        let _passenger = ''
        let set_passenger = []
        let select = passenger.querySelector('select')
        let inputs = passenger.querySelectorAll('input')

        inputs.forEach((input) => {
            if(input.name === 'first_name[]') set_passenger.push(input.value)
            if(input.name === 'last_name[]') set_passenger.push(input.value)
            if(input.name === 'birth_day[]') set_passenger.push(input.value)
            if(input.name === 'passenger_type[]') set_passenger.push(input.value)
        })

        _passenger = {
            'type': 'normal',
            '_type': set_passenger[3],
            'title': select.value,
            'first_name': set_passenger[0],
            'last_name': set_passenger[1],
            'birth_day': set_passenger[2]
        }

        is_passenger.push(_passenger)
    })
}

function inc(element, index) {
    const el = document.querySelector(`#extra-${element}-index-${index}`)
    const icon = document.querySelector(`#extra-${element}-img-${index}`)
    const name = document.querySelector(`#extra-${element}-name-${index}`)
    const amount = document.querySelector(`.extra-${element}-amount-${index}`)
    let qty = parseInt(el.value) + 1
    el.value = qty
    let _extra_amount = parseToNumber(amount.innerText)
    extra_price+= _extra_amount
    setExtra(icon.src, name.innerText, _extra_amount, qty, element)
    updateSumPrice()
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
        extra_price-= _extra_amount
        setExtra(icon.src, name.innerText, _extra_amount, qty, element)
        updateSumPrice()
    }
}

function updateSumPrice() {
    let sum_amount = route_price + extra_price
    document.querySelector('#sum-price').innerHTML = `${sum_amount.toLocaleString("en-US", { minimumFractionDigits: 2 })}`
}

function setExtra(icon, name, amount, qty, type) {
    let _extra = {
        'type': type,
        'name': name,
        'icon': icon,
        'qty': qty,
        'amount': amount
    }

    if(qty > 0) {
        let index = is_extra.findIndex(extra => { return extra.name === name && extra.type === type })
        if(index >= 0) is_extra[index].qty = qty
        else is_extra.push(_extra)
    }
    else {
        let index = is_extra.findIndex(extra => { return extra.name === name && extra.type === type })
        is_extra.splice(index, 1)
    }
}