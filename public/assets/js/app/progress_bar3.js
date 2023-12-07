const booking_routes = document.querySelectorAll('.booking-route-select')
let route_selected = []
let icon_selected = []
let price_all = []
let sum_price = []
let is_passenger = []
let extra_price = 0
let payment_info = {
    route_selected: [],
    extra_selected: []
}

if(booking_routes) {
    booking_routes.forEach((route, index) => {
        route_selected.push([])
        icon_selected.push([])
        payment_info.extra_selected.push([])
        sum_price.push(0)
        let route_list = route.querySelectorAll('.booking-route-list')
        route_list.forEach((route, key) => {
            route.addEventListener('click', (e) => {
                // set route //////////////////////////////////////////
                route_list.forEach((item) => { 
                    item.classList.remove('active')
                    item.classList.add('route-hover')
                })
                let route_active = document.querySelector(`.list-position_${route.dataset.list}_${route.dataset.key}`)
                route_active.classList.add('active')
                route_active.classList.remove('route-hover')
                route_selected[index] = key
                // END set route /////////////////////////////////////
                
                // set icon //////////////////////////////////////////
                let icons = route.querySelectorAll('.icon-selected')
                let icon_list = []
                icons.forEach((icon) => {
                    icon_list.push(icon.src)
                })
                icon_selected[index] = icon_list
                // END set icon //////////////////////////////////////

                // set price ////////////////////////////////////////
                let _price = route.querySelector('.route-price')
                route_price = parseToNumber(_price.innerText)
                sum_price[index] = route_price

                let price_list = []
                price_list.push(route.querySelector('.selected-adult-price').value)
                price_list.push(route.querySelector('.selected-child-price').value)
                price_list.push(route.querySelector('.selected-infant-price').value)
                price_all[index] = price_list

                let total_price = sum_price.reduce((num1, num2) => { return num1+num2 })
                document.querySelector('#sum-price').innerHTML = `${total_price.toLocaleString("en-US", { minimumFractionDigits: 2 })}`
                // END set price ///////////////////////////////////

                // save route to payment /////////////////////////////
                payment_info.route_selected[index] = {
                    'depart': document.querySelector(`.depart-station-name-${index}`).innerText,
                    'arrive': document.querySelector(`.arrive-station-name-${index}`).innerText,
                    'depart_time': route.querySelector('.depart-time').innerText,
                    'arrive_time': route.querySelector('.arrival-time').innerText,
                    'travel_date': document.querySelector(`.travel-date-${index}`).innerText,
                    'route_price': parseToNumber(route.querySelector('.route-price').innerText),
                    'icons': icon_list
                }

                // END save route to payment /////////////////////////////

                let ch_r = route_selected.filter((r) => { return r.length === 0 })
                if(ch_r.length === 0)
                    document.querySelector('#progress-next').disabled = false
            })
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
let active = 1
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
        // let route_list = booking_routes.querySelectorAll('.booking-route-list')
        booking_routes.forEach((routes) => {
            let route_list = routes.querySelectorAll('.booking-route-list')
            route_list.forEach((route) => {
                if(route.classList.contains('active')) document.querySelector('#progress-next').disabled = false
            })
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
        const r_extra = document.querySelector('#booking-multi-route-extra')
        const ex_route = r_extra.querySelectorAll('.booking-route-extra')
        ex_route.forEach((_extra, ex_index) => {
            let list_index = _extra.dataset.list
            const shuttlebus_list = _extra.querySelectorAll('.route-shuttle-bus')
            const longtailboat_list = _extra.querySelectorAll('.route-longtail-boat')
            const meal_list = _extra.querySelectorAll(`.route-meal`)
            const activity_list = _extra.querySelectorAll('.route-activity')

            let shuttlebus_selected = _extra.querySelector(`#route-shuttle-bus-index-${list_index}_${route_selected[list_index]}`)
            shuttlebus_list.forEach((item) => { item.classList.add('d-none') })
            shuttlebus_selected.classList.remove('d-none')

            let longtailboat_selected = _extra.querySelector(`#route-longtail-boat-index-${list_index}_${route_selected[list_index]}`)
            longtailboat_list.forEach((item) => { item.classList.add('d-none') })
            longtailboat_selected.classList.remove('d-none')

            let meal_select = _extra.querySelector(`#route-meal-index-${list_index}_${route_selected[list_index]}`)
            meal_list.forEach((item) => { item.classList.add('d-none') })
            meal_select.classList.remove('d-none')

            let activity_select = _extra.querySelector(`#route-activity-index-${list_index}_${route_selected[list_index]}`)
            activity_list.forEach((item) => { item.classList.add('d-none') })
            activity_select.classList.remove('d-none')
        })

        progress_next.classList.remove('d-none')
        progress_payment.classList.add('d-none')
        progress_payment.disabled = true
    }

    if(step === 'payment') {
        setLitinerary()
        // setPassengerDetail()
        // setExtraDetail()

        progress_next.classList.add('d-none')
        progress_payment.classList.remove('d-none')
        progress_payment.disabled = false
    }
}

function clearElementLitinerry(litinerry) {
    const div_list = litinerry.querySelectorAll('div')
    div_list.forEach((div) => { div.remove() })
}

function setLitinerary() {
    // document.querySelector('.is_depart_time').innerHTML = depart_time
    // document.querySelector('.is_arrive_time').innerHTML = arrive_time
    console.log(payment_info.route_selected)
    const set_litinerry = document.querySelector('#set-litinerary')
    clearElementLitinerry(set_litinerry)
    payment_info.route_selected.forEach((route, index) => {
        let div_index = document.createElement('div')
            div_index.setAttribute('class', `mb-3 pb-3 border-bottom div-index-${index}`)
        let h5_station = document.createElement('h5')
            h5_station.setAttribute('class', 'mb-0')
        let p_date = document.createElement('p')
            p_date.setAttribute('class', 'mb-1')
        let p_departTime = document.createElement('div')
            p_departTime.setAttribute('class', 'd-flex')
        let p_arriveTime = document.createElement('div')
            p_arriveTime.setAttribute('class', 'd-flex')
        let p_station_to = document.createElement('p')
            p_station_to.setAttribute('class', 'ms-2 mb-0')
        let div_icon = document.createElement('div')
            div_icon.setAttribute('class', 'd-flex mw--48')
            div_icon.setAttribute('id', `route-icon-payment-${index}`)
        
        h5_station.innerHTML = `${route.depart} - ${route.arrive}`
            div_index.appendChild(h5_station)
        p_date.innerHTML = `<span class="badge bg-booking-select-depart fw-bold">Multiple trip</span> : ${route.travel_date}`
            div_index.appendChild(p_date)
        p_departTime.innerHTML = `<p class="is_d_depart_time mb-0 me-2 fw-bold">${route.depart_time} : </p><p class="ms-2 mb-0">${route.depart}</p>`
            div_index.appendChild(p_departTime)

        route.icons.forEach((icon) => {
            let img = document.createElement('img')
            img.src = icon
            img.setAttribute('class', 'me-1 w-100')
    
            div_icon.appendChild(img)
        })
            div_index.appendChild(div_icon)

        p_arriveTime.innerHTML = `<p class="is_d_arrive_time mb-0 me-2 fw-bold">${route.arrive_time} : </p><p class="ms-2 mb-0">${route.arrive}</p>`
            div_index.appendChild(p_arriveTime)
        
        set_litinerry.appendChild(div_index)
    })

    // const route_icon = document.querySelector('.route-icon-payment')
    // const icon_list = route_icon.querySelectorAll('img')

    // icon_list.forEach((icon) => { icon.remove() })

    // icon_selected.forEach((icon) => {
    //     let img = document.createElement('img')
    //     img.src = icon
    //     img.setAttribute('class', 'me-1 w-100')

    //     route_icon.appendChild(img)
    // })

    // let adult_qty = document.querySelector('#passenger-adult')
    // let adult_price = document.querySelector('.payment-adult-price')
    // let child_price = document.querySelector('.payment-child-price')
    // let child_qty = document.querySelector('#passenger-child')
    // let infant_price = document.querySelector('.payment-infant-price')
    // let infant_qty = document.querySelector('#passenger-infant')
    // let sum_of_payment = 0

    // if(adult_price) {
    //     adult_price.innerHTML = parseToNumber(passenger_payment[0]).toLocaleString("en-US")
    //     let adult_sum = parseToNumber(adult_qty.value)*parseToNumber(passenger_payment[0])
    //     document.querySelector('.sum-of-adult').innerHTML = adult_sum.toLocaleString("en-US")
    //     sum_of_payment+= adult_sum
    // }
    // if(child_price) {
    //     child_price.innerHTML = parseToNumber(passenger_payment[1]).toLocaleString("en-US")
    //     let child_sum = parseToNumber(child_qty.value)*parseToNumber(passenger_payment[1])
    //     document.querySelector('.sum-of-child').innerHTML = child_sum.toLocaleString("en-US")
    //     sum_of_payment+= child_sum
    // }
    // if(infant_price) {
    //     infant_price.innerHTML = parseToNumber(passenger_payment[2]).toLocaleString("en-US")
    //     let infant_sum = parseToNumber(infant_qty.value)*parseToNumber(passenger_payment[2])
    //     document.querySelector('.sum-of-infant').innerHTML = infant_sum.toLocaleString("en-US")
    //     sum_of_payment+= infant_sum
    // }

    // document.querySelector('.sum-of-payment').innerHTML = sum_of_payment.toLocaleString("en-US")
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
        header.innerHTML = 'Infant'
        
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

function setExtraDetail() {
    let sum = 0
    const extra_service = document.querySelector('#payment-extra-service')
    const extra_meal = document.querySelector('#payment-extra-meal')
    const extra_activity = document.querySelector('#payment-extra-activity')
    const extra_shuttlebus = document.querySelector('#payment-extra-shuttle-bus')
    const extra_longtailboat = document.querySelector('#payment-extra-longtail-boat')

    while (extra_meal.firstChild) { extra_meal.removeChild(extra_meal.lastChild) }
    while (extra_activity.firstChild) { extra_activity.removeChild(extra_activity.lastChild) }
    while (extra_shuttlebus.firstChild) { extra_shuttlebus.removeChild(extra_shuttlebus.lastChild) }
    while (extra_longtailboat.firstChild) { extra_longtailboat.removeChild(extra_longtailboat.lastChild) }

    extra_longtailboat.classList.add('d-none')
    extra_shuttlebus.classList.add('d-none')
    extra_activity.classList.add('d-none')
    extra_meal.classList.add('d-none')

    let _extra = Object.groupBy(is_extra, ex => { return ex.type })
    // console.log(_extra)
    if(_extra['bus']) {
        extra_shuttlebus.classList.remove('d-none')
        let row = document.createElement('div')
        let col_12 = document.createElement('div')
        let header = document.createElement('p')

        row.setAttribute('class', 'row')
        col_12.setAttribute('class', 'col-12')
        header.setAttribute('class', 'mb-1 fw-bold text-dark')
        header.innerHTML = 'Shuttle Bus'

        extra_shuttlebus.appendChild(row)
        row.appendChild(col_12)
        col_12.appendChild(header)

        _extra['bus'].forEach((bus) => {
            sum += bus.qty*bus.amount
            let p = document.createElement('p')
            p.setAttribute('class', 'mb-0 ms-2 text-dark')
            p.innerHTML = `<i class="fa-solid fa-van-shuttle fs-3 me-3"></i> ${bus.name} - [ <strong>Fare </strong> ${bus.qty} x ${bus.amount.toLocaleString("en-US")} ] : ${(bus.qty*bus.amount).toLocaleString("en-US")} THB`
            extra_shuttlebus.appendChild(p)
        })
    }

    if(_extra['boat']) {
        extra_longtailboat.classList.remove('d-none')
        let row = document.createElement('div')
        let col_12 = document.createElement('div')
        let header = document.createElement('p')

        row.setAttribute('class', 'row')
        col_12.setAttribute('class', 'col-12')
        header.setAttribute('class', 'mb-1 fw-bold text-dark')
        header.innerHTML = 'Longtail Boat'

        extra_longtailboat.appendChild(row)
        row.appendChild(col_12)
        col_12.appendChild(header)

        _extra['boat'].forEach((boat) => {
            sum += boat.qty*boat.amount
            let p = document.createElement('p')
            p.setAttribute('class', 'mb-0 ms-2 text-dark')
            p.innerHTML = `<i class="fa-solid fa-sailboat fs-3 me-3"></i> ${boat.name} - [ <strong>Fare </strong> ${boat.qty} x ${boat.amount.toLocaleString("en-US")} ] : ${(boat.qty*boat.amount).toLocaleString("en-US")} THB`
            extra_longtailboat.appendChild(p)
        })
    }

    if(_extra['meal']) {
        extra_meal.classList.remove('d-none')
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
            sum += meal.qty*meal.amount
            let p = document.createElement('p')
            p.setAttribute('class', 'mb-0 ms-2 text-dark')
            p.innerHTML = `<img src="${meal.icon}" class="me-3" width="40" height="auto"> ${meal.name} - [ <strong>Fare </strong> ${meal.qty} x ${meal.amount.toLocaleString("en-US")} ] : ${(meal.qty*meal.amount).toLocaleString("en-US")} THB`
            extra_meal.appendChild(p)
        })
    }

    if(_extra['activity']) {
        extra_activity.classList.remove('d-none')
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
            sum += activity.qty*activity.amount
            let p = document.createElement('p')
            p.setAttribute('class', 'mb-0 ms-2 text-dark')
            p.innerHTML = `<img src="${activity.icon}" class="me-3" width="40" height="auto"> ${activity.name} - [ <strong>Fare </strong> ${activity.qty} x ${activity.amount.toLocaleString("en-US")} ] : ${(activity.qty*activity.amount).toLocaleString("en-US")} THB`
            extra_activity.appendChild(p)
        })
    }

    if(is_extra.length === 0) extra_service.classList.add('d-none')
    else {
        document.querySelector('#sum-of-extra').innerHTML = sum.toLocaleString("en-US")
        extra_service.classList.remove('d-none')
    }
}


// set passendger
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


function inc(element, index, route_index) {
    const el = document.querySelector(`#extra-${element}-index-${index}`)
    const icon = document.querySelector(`#extra-${element}-img-${index}`)
    const name = document.querySelector(`#extra-${element}-name-${index}`)
    const amount = document.querySelector(`.extra-${element}-amount-${index}`)
    let qty = parseInt(el.value) + 1
    el.value = qty
    let _extra_amount = parseToNumber(amount.innerText)
    extra_price+= _extra_amount
    let ico_src = icon === null ? '' : icon.src
    setExtra(ico_src, name.innerText, _extra_amount, qty, element, route_index)
    updateSumPrice()
}

function dec(element, index, route_index) {
    const el = document.querySelector(`#extra-${element}-index-${index}`)
    const icon = document.querySelector(`#extra-${element}-img-${index}`)
    const name = document.querySelector(`#extra-${element}-name-${index}`)
    const amount = document.querySelector(`.extra-${element}-amount-${index}`)
    if(parseInt(el.value) > 0) {
        let qty = parseInt(el.value) - 1
        el.value = qty
        let _extra_amount = parseToNumber(amount.innerText)
        extra_price-= _extra_amount
        let ico_src = icon === null ? '' : icon.src
        setExtra(ico_src, name.innerText, _extra_amount, qty, element, route_index)
        updateSumPrice()
    }
}

function updateSumPrice() {
    let sum_amount = route_price + extra_price
    document.querySelector('#sum-price').innerHTML = `${sum_amount.toLocaleString("en-US", { minimumFractionDigits: 2 })}`
}

let is_extra = []
function setExtra(icon, name, amount, qty, type, route_index) {
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

    payment_info.extra_selected[route_index] = is_extra

    // console.log(payment_info.extra_selected)
}