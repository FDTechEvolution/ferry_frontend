const booking_route = document.querySelector('#booking-route-select')
let route_price = 0
let premium_price = 0
let extra_price = 0
let set_extra = 0
let depart_time = ''
let arrive_time = ''
let route_selected = null
let route_promo = false
let selected_promo = false
let icon_selected = []
let passenger_payment = []
let extra_id = [] // extra id to post
let is_extra = [] // extra service select
let is_passenger = [] // passenger info
let addon_route = []
let promocode_from = []
let promocode_to = []
let promocode_route = []
let promocode_premiumflex = 'N'
let promocode_select = 'N'
let promo = null
if(booking_route) {
    let route_list = booking_route.querySelectorAll('.booking-route-list')
    let btn_route_list = document.querySelectorAll('.btn-route-list')
    const route_addon_checked = document.querySelectorAll('.route-addon-checked-depart')
    const route_addon_detail = document.querySelectorAll('.route-addon-detail-depart')

    route_list.forEach((route, index) => {
        let btn_select = document.querySelector(`.btn-route-select-${index}`)
        btn_select.addEventListener('click', (e) => {
            route_list.forEach((item) => {
                item.classList.remove('active')
            })
            btn_route_list.forEach((btn) => {
                btn.disabled = false
                btn.innerText = 'Select'
            })
            btn_select.disabled = true
            btn_select.innerText = 'Selected'

            promocode_select = route.querySelector('.route-status').value

            let is_promo_selected = route.querySelector('.promo-avaliable')
            if(is_promo_selected) selected_promo = true
            else selected_promo = false

            if(document.querySelector('.promo-price')) route_promo = true
            else route_promo = false

            let _price = route.querySelector('.route-price')
            depart_time = route.querySelector('.depart-time').innerText
            arrive_time = route.querySelector('.arrival-time').innerText
            document.querySelector('#progress-next').disabled = false
            let sum_c_price = document.querySelector('.your-booking-fare-child')
            let sum_i_price = document.querySelector('.your-booking-fare-infant')

            let a_per_price = document.querySelector(`.adult-per-price-depart-${index}`).innerText
            let c_per_price = document.querySelector(`.child-per-price-depart-${index}`)
            let i_per_price = document.querySelector(`.infant-per-price-depart-${index}`)

            route_price = parseToNumber(_price.innerText)
            document.querySelector('.set-time-route-select').innerHTML = `${depart_time} - ${arrive_time}`
            document.querySelector('.your-booking-premium-flex').classList.add('d-none')

            // set Your Booking
            document.querySelector('.your-booking-summary').classList.remove('d-none')
            document.querySelector('.your-booking-depart-time').innerHTML = `<i class="fa-regular fa-clock"></i> ${depart_time}`
            document.querySelector('.your-booking-destination-from').innerHTML = '<i class="fa-solid fa-ship"></i> ' + route.querySelector('.station-from-text').innerText
            document.querySelector('.your-booking-arrive-time').innerHTML = `<i class="fa-regular fa-clock"></i> ${arrive_time}`
            document.querySelector('.your-booking-destination-to').innerHTML = '<i class="fa-solid fa-anchor"></i> ' + route.querySelector('.station-to-text').innerText
            document.querySelector('.your-booking-fare-adult').innerHTML = `${a_per_price.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} <small class="smaller">THB</small>`
            if(sum_c_price) sum_c_price.innerHTML = `${c_per_price.innerText.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} <small class="smaller">THB</small>`
            if(sum_i_price) sum_i_price.innerHTML = `${i_per_price.innerText.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} <small class="smaller">THB</small>`
            document.querySelector('.your-booking-amount').innerHTML = `${route_price.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} <small class="smaller">THB</small>`

            document.querySelector('#sum-price').innerHTML = `${route_price.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })}`
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

            route_addon_checked.forEach((addon) => {
                addon.checked = false
                addon.name = ''
                addon_route = []
            })
            route_addon_detail.forEach((detail) => { detail.name = '' })

            price_list.push(route.querySelector('.selected-adult-price').value)
            price_list.push(route.querySelector('.selected-child-price').value)
            price_list.push(route.querySelector('.selected-infant-price').value)
            passenger_payment = price_list

            const booking_extra = document.querySelector('#booking-route-extra')
            const inputs = booking_extra.querySelectorAll('input[type="number"]')
            inputs.forEach((input) => { input.value = 0 })
            is_extra = []

            document.querySelector('[name="booking_route_selected"]').value = route.querySelector('.selected-route').value
            document.querySelector('[name="booking_route_active"]').value = route.querySelector('.route-status').value

            if(promo === null) updateDiscountBySearchForm()
            else updateDiscountByBookingSummary()
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
let payment_selected = false
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
        document.querySelector('#btn-back-to-home').classList.remove('d-none')
        document.querySelector('#progress-prev').classList.add('d-none')
        route_list.forEach((route) => {
            if(route.classList.contains('active')) document.querySelector('#progress-next').disabled = false
        })

        progress_payment.classList.add('d-none')
        progress_payment.disabled = true
    }

    if(step === 'premium') {
        document.querySelector('#btn-back-to-home').classList.add('d-none')
        document.querySelector('#progress-prev').classList.remove('d-none')
        let promo_premiumflex = document.querySelector('.ispremiumflex').value
        let use_promocode = document.querySelector('[name="use_promocode"]')
        let select_promo = document.querySelector('.selected-route-promocode')

        const txt_price = document.querySelector('.is-premium-price')
        const your_booking = document.querySelector('.your-booking-premium-flex')
        const ispremiumflex = document.querySelector('#is-premiumflex')
        const nonePremiumFlex = document.querySelector('#none-premiumflex')
        let _premium_price = promo_premiumflex === 'Y' ? 0 : ((route_price*110)/100) - route_price

        // console.log(promo_premiumflex)
        if(use_promocode.value !== '') {
            if(promo_premiumflex === 'Y') select_promo.classList.remove('d-none')
        }

        your_booking.classList.remove('d-none')
        if(promocode_premiumflex === 'Y') {
            txt_price.innerHTML = '0'
        }
        else {
            txt_price.innerHTML = _premium_price.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
        }

        if(nonePremiumFlex.checked) {
            premium_price = 0
            updateSumPrice()
        }
        if(ispremiumflex.checked) {
            premium_price = _premium_price
            updateSumPrice()
        }

        ispremiumflex.addEventListener('click', () => {
            premium_price = _premium_price
            updateSumPrice()
        })
        nonePremiumFlex.addEventListener('click', () => {
            premium_price = 0
            updateSumPrice()
        })
    }

    if(step === 'passenger') {
        const passenger_next = document.querySelector('#progress-next-passenger')
        progress_next.classList.add('d-none')
        passenger_next.classList.remove('d-none')
        passenger_next.disabled = false

        progress_payment.classList.add('d-none')
        progress_payment.disabled = true

        const sub_passenger = document.querySelectorAll('.sub-passenger-b-date')
        let startDate_adult = new Date()
        startDate_adult.setFullYear(startDate_adult.getFullYear() - 100)
        let startDate_child = new Date()
        startDate_child.setFullYear(startDate_child.getFullYear() - 12)
        let startDate_infant = new Date()
        startDate_infant.setFullYear(startDate_infant.getFullYear() - 2)

        $('.lead-passenger-b-day').datepicker()
        $('.lead-passenger-b-day').datepicker('setEndDate', new Date())
        $('.lead-passenger-b-day').datepicker('setStartDate', startDate_adult)

        if(sub_passenger) {
            sub_passenger.forEach((item) => {
                let is_startDate = null
                if(item.dataset.type == 'Adult') is_startDate = startDate_adult
                if(item.dataset.type == 'Child') is_startDate = startDate_child
                if(item.dataset.type == 'Infant') is_startDate = startDate_infant

                $(`#${item.id}`).datepicker()
                $(`#${item.id}`).datepicker('setEndDate', new Date())
                $(`#${item.id}`).datepicker('setStartDate', is_startDate)
            })
        }
    }

    if(step === 'extra') {
        const _extra = document.querySelector('#booking-route-extra')
        const meal_list = _extra.querySelectorAll(`.route-meal`)
        const activity_list = _extra.querySelectorAll('.route-activity')
        // const shuttlebus_list = _extra.querySelectorAll('.route-shuttle-bus')
        // const longtailboat_list = _extra.querySelectorAll('.route-longtail-boat')
        const route_addon_lists = _extra.querySelectorAll('.route-addon-lists-depart')
        const route_addon_checked = _extra.querySelectorAll('.form-check-input-default')

        const route_addons = _extra.querySelectorAll(`.route-addon-index-${route_selected}-depart`)

        if(set_extra === 0) {
            route_addon_lists.forEach((item) => {
                // let uncheck = item.querySelectorAll(`input[type="checkbox"]`)
                // uncheck.forEach((uc) => {
                //     // uc.checked = true
                //     let type = uc.dataset.type
                //     let subtype = uc.dataset.subtype
                //     let routeindex = uc.dataset.routeindex
                //     let addon_detail = document.querySelector(`.addon-detail-${type}-${subtype}-${routeindex}-depart`)
                //     uc.name = ``
                //     addon_detail.name = ``
                // })
                item.classList.add('d-none')
            })
            route_addons.forEach((item) => {
                // let check = item.querySelectorAll(`input[type="checkbox"]`)
                // check.forEach((c) => {
                //     c.checked = true
                //     let type = c.dataset.type
                //     let subtype = c.dataset.subtype
                //     let routeindex = c.dataset.routeindex
                //     let addon_name = document.querySelector(`.addon-name-${type}-${subtype}-${routeindex}-depart`)
                //     let addon_price = document.querySelector(`.${type}-${subtype}-${routeindex}-depart`)
                //     let addon_detail = document.querySelector(`.addon-detail-${type}-${subtype}-${routeindex}-depart`)
                //     addon_route.push({'name': addon_name.innerText, 'price': addon_price.value, 'type': `${type}-${subtype}-${routeindex}`})
                //     c.name = 'route_addon_depart[]'
                //     addon_detail.name = 'route_addon_detail_depart[]'
                //     extra_price += parseInt(addon_price.value)
                // })
                document.querySelector('.your-booking-extra').classList.remove('d-none')
                item.classList.remove('d-none')
                // updateSumPrice()
            })
        }

        // extra_price = 0
        // addon_route = []
        // route_addon_checked.forEach((route_addon, index) => {
            // route_addon.addEventListener('change', (e) => {
            //     let type = e.target.dataset.type
            //     let subtype = e.target.dataset.subtype
            //     let routeindex = e.target.dataset.routeindex
            //     let addon_name = document.querySelector(`.addon-name-${type}-${subtype}-${routeindex}-depart`)
            //     let addon_price = document.querySelector(`.${type}-${subtype}-${routeindex}-depart`)
            //     let addon_detail = document.querySelector(`.addon-detail-${type}-${subtype}-${routeindex}-depart`)
            //     if(e.target.checked) {
            //         let addon_index = addon_route.findIndex((addon) => { return addon.type === `${type}-${subtype}-${routeindex}` })
            //         if(addon_index < 0) addon_route.push({'name': addon_name.innerText, 'price': addon_price.value, 'type': `${type}-${subtype}-${routeindex}`})
            //         extra_price += parseInt(addon_price.value)
            //         e.target.name = 'route_addon_depart[]'
            //         addon_detail.name = 'route_addon_detail_depart[]'
            //         addon_detail.disabled = false
            //         updateSumPrice()
            //     }
            //     else {
            //         let addon_index = addon_route.findIndex((addon) => { return addon.type === `${type}-${subtype}-${routeindex}` })
            //         if(addon_index >= 0) addon_route.splice(addon_index, 1)
            //         extra_price -= parseInt(addon_price.value)
            //         e.target.name = ''
            //         addon_detail.name = ''
            //         addon_detail.value = ''
            //         addon_detail.disabled = true
            //         updateSumPrice()
            //     }
            // })
        // })

        let meal_select = _extra.querySelector(`#route-meal-index-${route_selected}`)
        meal_list.forEach((item) => { item.classList.add('d-none') })
        meal_select.classList.remove('d-none')

        let activity_select = _extra.querySelector(`#route-activity-index-${route_selected}`)
        activity_list.forEach((item) => { item.classList.add('d-none') })
        activity_select.classList.remove('d-none')

        // let shuttlebus_selected = _extra.querySelector(`#route-shuttle-bus-index-${route_selected}`)
        // shuttlebus_list.forEach((item) => { item.classList.add('d-none') })
        // shuttlebus_selected.classList.remove('d-none')

        // let longtailboat_selected = _extra.querySelector(`#route-longtail-boat-index-${route_selected}`)
        // longtailboat_list.forEach((item) => { item.classList.add('d-none') })
        // longtailboat_selected.classList.remove('d-none')

        const passenger_next = document.querySelector('#progress-next-passenger')
        progress_next.classList.remove('d-none')
        passenger_next.classList.add('d-none')
        passenger_next.disabled = true
    }

    else if(step !== 'passenger') {
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
        if(payment_selected) progress_payment.disabled = false
    }
}

function selectRouteAddon(e, _type) {
    let type = e.dataset.type
    let subtype = e.dataset.subtype
    let routeindex = e.dataset.routeindex
    let addon_name = document.querySelector(`.addon-name-${type}-${subtype}-${routeindex}-depart`)
    let addon_price = document.querySelector(`.${type}-${subtype}-${routeindex}-depart`)
    let addon_detail = document.querySelector(`.addon-detail-${type}-${subtype}-${routeindex}-depart`)
    if(e.checked) {
        let addon_index = addon_route.findIndex((addon) => { return addon.type === `${type}-${subtype}-${routeindex}` })
        if(addon_index < 0) addon_route.push({'name': addon_name.innerText, 'price': addon_price.value, 'type': `${type}-${subtype}-${routeindex}`})
        extra_price += parseInt(addon_price.value)
        e.name = 'route_addon_depart[]'
        addon_detail.name = 'route_addon_detail_depart[]'
        addon_detail.disabled = false
        updateSumPrice()
    }
    else {
        let addon_index = addon_route.findIndex((addon) => { return addon.type === `${type}-${subtype}-${routeindex}` })
        if(addon_index >= 0) addon_route.splice(addon_index, 1)
        extra_price -= parseInt(addon_price.value)
        e.name = ''
        addon_detail.name = ''
        addon_detail.value = ''
        addon_detail.disabled = true
        updateSumPrice()
    }
}


let payment_methods = document.querySelectorAll('.payment-methods')
if(payment_methods) {
    payment_methods.forEach((payment) => {
        payment.addEventListener('click', () => {
            payment_selected = true
            progress_payment.disabled = false
        })
    })
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

    // let _extra = Object.groupBy(is_extra, ex => { return ex.type })
    let _extra2 = is_extra.reduce((acc, data) => {
        (acc[data['type']] = acc[data['type']] || []).push(data);
        return acc;
    }, {})
    // console.log(_extra, _extra2)
    if(_extra2['bus']) {
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

        _extra2['bus'].forEach((bus) => {
            sum += bus.qty*bus.amount
            let p = document.createElement('p')
            p.setAttribute('class', 'mb-0 ms-2 text-dark')
            p.innerHTML = `<i class="fa-solid fa-van-shuttle fs-3 me-3"></i> ${bus.name} - [ <strong>Fare </strong> ${bus.qty} x ${bus.amount.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} ] : ${(bus.qty*bus.amount).toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} THB`
            extra_shuttlebus.appendChild(p)
        })
    }

    if(_extra2['boat']) {
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

        _extra2['boat'].forEach((boat) => {
            sum += boat.qty*boat.amount
            let p = document.createElement('p')
            p.setAttribute('class', 'mb-0 ms-2 text-dark')
            p.innerHTML = `<i class="fa-solid fa-sailboat fs-3 me-3"></i> ${boat.name} - [ <strong>Fare </strong> ${boat.qty} x ${boat.amount.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} ] : ${(boat.qty*boat.amount).toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} THB`
            extra_longtailboat.appendChild(p)
        })
    }

    if(_extra2['meal']) {
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

        _extra2['meal'].forEach((meal) => {
            sum += meal.qty*meal.amount
            let p = document.createElement('p')
            p.setAttribute('class', 'mb-0 ms-2 text-dark')
            p.innerHTML = `<img src="${meal.icon}" class="me-3" width="40" height="auto"> ${meal.name} - [ <strong>Fare </strong> ${meal.qty} x ${meal.amount.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} ] : ${(meal.qty*meal.amount).toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} THB`
            extra_meal.appendChild(p)
        })
    }

    if(_extra2['activity']) {
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

        _extra2['activity'].forEach((activity) => {
            sum += activity.qty*activity.amount
            let p = document.createElement('p')
            p.setAttribute('class', 'mb-0 ms-2 text-dark')
            p.innerHTML = `<img src="${activity.icon}" class="me-3" width="40" height="auto"> ${activity.name} - [ <strong>Fare </strong> ${activity.qty} x ${activity.amount.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} ] : ${(activity.qty*activity.amount).toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} THB`
            extra_activity.appendChild(p)
        })
    }

    if(is_extra.length === 0) extra_service.classList.add('d-none')
    else {
        document.querySelector('#sum-of-extra').innerHTML = sum.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
        extra_service.classList.remove('d-none')
    }
}

function setPassengerDetail() {
    const passenger_detail = document.querySelector('#payment-passenger-detail')
    while (passenger_detail.firstChild) {
        passenger_detail.removeChild(passenger_detail.lastChild);
    }
    // let _passenger = Object.groupBy(is_passenger, pass => { return pass._type })
    let _passenger = is_passenger.reduce((acc, data) => {
        (acc[data['_type']] = acc[data['_type']] || []).push(data);
        return acc;
    }, {})

    // console.log(_passenger)

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
        adult_price.innerHTML = parseToNumber(passenger_payment[0]).toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
        let adult_sum = parseToNumber(adult_qty.value)*parseToNumber(passenger_payment[0])
        document.querySelector('.sum-of-adult').innerHTML = adult_sum.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
        sum_of_payment+= adult_sum
    }
    if(child_price) {
        child_price.innerHTML = parseToNumber(passenger_payment[1]).toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
        let child_sum = parseToNumber(child_qty.value)*parseToNumber(passenger_payment[1])
        document.querySelector('.sum-of-child').innerHTML = child_sum.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
        sum_of_payment+= child_sum
    }
    if(infant_price) {
        infant_price.innerHTML = parseToNumber(passenger_payment[2]).toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
        let infant_sum = parseToNumber(infant_qty.value)*parseToNumber(passenger_payment[2])
        document.querySelector('.sum-of-infant').innerHTML = infant_sum.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
        sum_of_payment+= infant_sum
    }

    document.querySelector('.sum-of-payment').innerHTML = sum_of_payment.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
    document.querySelector('.sum-of-premium').innerHTML = premium_price.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
    let promo_sum = document.querySelector('.sum-of-promocode')
    let sum_discount = 0
    if(route_promo) {
        let discount = sum_of_payment - route_price
        sum_discount = discount
        let minus = discount !== 0 ? '- ' : ''
        document.querySelector('.promocode-show').classList.remove('d-none')
        promo_sum.innerHTML = minus + discount.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
    }
    else {
        document.querySelector('.promocode-show').classList.add('d-none')
        promo_sum.innerHTML = 0
    }

    const addon_list = document.querySelector('.amount-detail-list')
    const addon_lists = addon_list.querySelectorAll('.addon-route-detail')
    addon_lists.forEach((list) => { list.remove() })
    let route_addon_price = 0
    addon_route.forEach((addon) => {
        let h6 = document.createElement('h6')
        h6.setAttribute('class', 'd-flex justify-content-end align-items-end addon-route-detail')
        h6.innerHTML = `${addon.name} <p class="w--20 w-sm-30 me-2 mb-0"> ${addon.price} </p><small class="smaller">THB</small>`
        addon_list.appendChild(h6)
        route_addon_price += parseInt(addon.price)
    })

    document.querySelector('.sum-amount').innerHTML = (route_price + premium_price + route_addon_price).toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
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
    let ico_src = icon === null ? '' : icon.src
    setExtra(ico_src, name.innerText, _extra_amount, qty, element)
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
        let ico_src = icon === null ? '' : icon.src
        setExtra(ico_src, name.innerText, _extra_amount, qty, element)
        updateSumPrice()
    }
}

function updateSumPrice() {
    let result_premuim_price = 0
    let your_booking = {
        premium_flex: document.querySelector('.your-booking-premium-flex-price'),
        extra: document.querySelector('.your-booking-extra-price'),
        total: document.querySelector('.your-booking-amount')
    }
    if(promocode_premiumflex === 'N') {
        result_premuim_price = premium_price
        your_booking.premium_flex.innerHTML = `${result_premuim_price.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} <small class="smaller">THB</small>`
    }
    else {
        result_premuim_price = 0
        your_booking.premium_flex.innerHTML = `0 <small class="smaller">THB</small>`
    }

    your_booking.extra.innerHTML = `${extra_price.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} <small class="smaller">THB</small>`

    let sum_amount = route_price + extra_price + result_premuim_price
    let sum_amount_digit = `${sum_amount.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })}`
    document.querySelector('#sum-price').innerHTML = sum_amount_digit
    your_booking.total.innerHTML = `${sum_amount_digit} <small class="smaller">THB</small>`
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

const promoSubmit = document.querySelector('#button-promocode-submit')
const current_price = []
let promo_active = []
if(promoSubmit) {
    const promocode = document.querySelector('.booking-promocode-input')
    const booking_date = document.querySelector('.is-booking-date')
    const route_list = booking_route.querySelectorAll('.booking-route-list')
    promoSubmit.addEventListener('click', async () => {
        const _promocode = promocode.value
        const use_promocode = document.querySelector('[name="use_promocode"]')
        const booking_discount = document.querySelector('.your-booking-discount')

        if(_promocode !== '') {
            const _departdate = await dateFormatSet(booking_date.innerText)
            const result = await getPromoCode(_promocode, _departdate)

            clearRouteToDefault()

            if(result.data !== null && result.data.result) {
                const btn_cancel = `<i class="fa-solid fa-pen-to-square text-primary cursor-pointer cancel-promocode" onClick="editPromotionCode()" title="Edit Promocode"></i>`
                document.querySelector('.your-booking-promocode-discount').innerHTML = `[${_promocode}] ${btn_cancel}`

                booking_discount.classList.remove('d-none')
                promocode_from = result.data.promo_line.from
                promocode_to = result.data.promo_line.to
                promocode_route = result.data.promo_line.route

                promo = result.data.data
                promocode_premiumflex = promo.isfreepremiumflex === 'Y' ? 'Y' : 'N'
                if(promo.isfreepremiumflex === 'Y') {
                    document.querySelector('.is-premium-price').innerHTML = '0'
                    document.querySelector('.your-booking-premium-flex-price').innerHTML = '0 <small class="smaller">THB</small>'
                }

                route_list.forEach((route, index) => {
                    const station_from_id = route.querySelector('.station-from-text').dataset.id
                    const station_to_id = route.querySelector('.station-to-text').dataset.id
                    const route_id = route.dataset.id

                    const route_ispromo = route.querySelector('.route-status').value
                    const promo_price = route.querySelector('.route-price')
                    if(current_price.length < route_list.length) current_price.push(promo_price.innerText)

                    const route_promo_condition = promoCondition(route_id, station_from_id, station_to_id)
                    // console.log(route_promo_condition)
                    if(route_promo_condition._route || route_promo_condition._from || route_promo_condition._to) {
                        promo_active[index] = true
                        if(route_ispromo === 'Y') {
                            const scp = route.querySelector('.summary-current-price')
                            const spa = route.querySelector('.summary-promo-avaliable')
                            scp.classList.remove('d-none')
                            spa.classList.remove('d-none')
                            scp.querySelector('.current-price').innerHTML = current_price[index]
                            const discount = promotionPriceCal(current_price[index], promo.discount, promo.discount_type)
                            promo_price.innerHTML = numberFormat(discount)
                        }
                    }
                    else {
                        promo_active[index] = false
                    }
                })

                if(route_selected !== null) {
                    const discount = promotionPriceCal(current_price[route_selected], promo.discount, promo.discount_type)
                    const is_discount = parseInt(current_price[route_selected].replace(/,/g, "")) - discount
                    const discount_price = document.querySelector('.your-booking-discount-price')
                    if(promocode_select === 'Y' && promo_active[route_selected]) {
                        discount_price.innerHTML = `- ${numberFormat(is_discount)} <small class="smaller">THB</small>`
                        route_price = discount
                        updateSumPrice()
                    }
                    else
                        discount_price.innerHTML =`0 <small class="smaller">THB</small>`
                }

                use_promocode.value = _promocode
                // document.querySelector('.your-booking-promocode').remove()
                document.querySelector('.your-booking-promocode').classList.add('d-none')
                $.SOW.core.toast.show('success', '', 'Promocode Active.', 'bottom-end', 3, true);
            }
            else {
                if(current_price.length > 0) {
                    route_list.forEach((route, index) => {
                        const scp = route.querySelector('.summary-current-price')
                        const spa = route.querySelector('.summary-promo-avaliable')
                        scp.classList.add('d-none')
                        spa.classList.add('d-none')

                        const promo_price = route.querySelector('.route-price')
                        promo_price.classList.remove('text-warning')
                        promo_price.innerHTML = numberFormat(current_price[index])
                    })
                }

                if(route_selected !== null) {
                    if(current_price.length > 0) {
                        route_price = parseInt(current_price[route_selected].replace(/,/g, ""))
                        updateSumPrice()
                    }
                }

                promo = null
                promocode_premiumflex = 'N'
                use_promocode.value = ''
                promo_active = []
                booking_discount.classList.add('d-none')
                $.SOW.core.toast.show('danger', '', 'Promotion code incorrect or promotion code ran out.', 'bottom-end', 3, true);
                updateDiscountByBookingSummary()
            }
            document.querySelector('.booking-promocode-input').classList.remove('border-danger')
        }
        else {
            document.querySelector('.booking-promocode-input').classList.add('border-danger')
            document.querySelector('.your-booking-discount').classList.add('d-none')
        }
    })
}

function promoCondition(route, station_from, station_to) {
    let result = {_route: false, _from: false, _to: false}
    if(promocode_route.length === 0 && promocode_from.length === 0 && promocode_to.length === 0) {
        result._route = result._from = result._to = true
        return result
    }
    else {
        if(promocode_route.length > 0) {
            result._route = findPromocodeCondition(promocode_route, route)
        }
        if(promocode_from.length > 0) {
            result._from = findPromocodeCondition(promocode_from, station_from)
        }
        if(promocode_to.length > 0) {
            result._to = findPromocodeCondition(promocode_to, station_to)
        }

        return result
    }
}

function findPromocodeCondition(promo_array, promo_item) {
    const indexOf = promo_array.findIndex((item) => { return promo_item === item })
    if(indexOf >= 0) return true
    return false
}

function clearRouteToDefault() {
    const route_list = booking_route.querySelectorAll('.booking-route-list')
    if(current_price.length > 0) {
        route_list.forEach((route, index) => {
            const scp = route.querySelector('.summary-current-price')
            const spa = route.querySelector('.summary-promo-avaliable')
            scp.classList.add('d-none')
            spa.classList.add('d-none')

            const promo_price = route.querySelector('.route-price')
            promo_price.innerHTML = numberFormat(current_price[index])
        })
    }

    if(route_selected !== null) {
        if(current_price.length > 0) {
            route_price = parseInt(current_price[route_selected].replace(/,/g, ""))
            updateSumPrice()
        }
    }
}

function editPromotionCode() {
    document.querySelector('.your-booking-promocode').classList.remove('d-none')
    // const route_list = booking_route.querySelectorAll('.booking-route-list')
    // route_list.forEach((route, index) => {
    //     const scp = route.querySelector('.summary-current-price')
    //     const spa = route.querySelector('.summary-promo-avaliable')
    //     scp.classList.add('d-none')
    //     spa.classList.add('d-none')

    //     const promo_price = route.querySelector('.route-price')
    //     promo_price.innerHTML = numberFormat(current_price[index])
    // })

    // if(route_selected !== null) {
    //     if(current_price.length > 0) {
    //         route_price = parseInt(current_price[route_selected].replace(/,/g, ""))
    //         updateSumPrice()
    //     }
    // }

    // const booking_discount = document.querySelector('.your-booking-discount')
    // booking_discount.classList.add('d-none')
    // document.querySelector('.your-booking-discount-price').innerHTML = `0 <small class="smaller">THB</small>`
}

function updateDiscountByBookingSummary() {
    const booking_discount = document.querySelector('.your-booking-discount')
    if(promocode_select === 'Y' && promo_active[route_selected]) {
        booking_discount.classList.remove('d-none')
        const discount = promotionPriceCal(current_price[route_selected], promo.discount, promo.discount_type)
        const is_discount = parseInt(current_price[route_selected].replace(/,/g, "")) - discount
        document.querySelector('.your-booking-discount-price').innerHTML = `- ${numberFormat(is_discount)} <small class="smaller">THB</small>`
    }
    else {
        // booking_discount.classList.add('d-none')
        document.querySelector('.your-booking-discount-price').innerHTML = `0 <small class="smaller">THB</small>`
    }
}

function updateDiscountBySearchForm() {
    const _promocode = document.querySelector('[name="use_promocode"]').value

    if(_promocode !== '') {
        const booking_discount = document.querySelector('.your-booking-discount')
        const booking_discount_price = document.querySelector('.your-booking-discount-price')

        let current_price = []
        const _current_price = document.querySelectorAll('.price-position-set')
        _current_price.forEach((c, i) => {
            if(c.querySelector('.current-price')) current_price.push(c.querySelector('.current-price').innerText)
            else current_price.push(c.querySelector('.route-price').innerText)
        })

        if(promocode_select === 'Y' && selected_promo) {
            booking_discount.classList.remove('d-none')
            const _promocode = document.querySelector('[name="use_promocode"]').value
            document.querySelector('.your-booking-promocode-discount').innerHTML = `[${_promocode}]`

            const discount = parseInt(current_price[route_selected].replace(/,/g, ""))
            const is_discount = discount - route_price
            booking_discount_price.innerHTML = `- ${numberFormat(is_discount)} <small class="smaller">THB</small>`
        }
        else
            booking_discount_price.innerHTML = `0 <small class="smaller">THB</small>`
    }
}

function promotionPriceCal(price, discount, type) {
    const stripped = price.replace(/,/g, "")
    const _price = parseInt(stripped)
    const _discount = parseInt(discount)
    if(type === 'PERCENT')
        return _price - ((_discount/100) * _price)
    if(type === 'THB')
        return _price - _discount
}

async function dateFormatSet(date) {
    let f_date = new Date(date)
    let year = f_date.toLocaleString("en-US", { year: "numeric" })
    let month = f_date.toLocaleString("en-US", { month: "2-digit" })
    let day = f_date.toLocaleString("en-US", { day: "2-digit" })

    return `${year}/${month}/${day}`
}

async function getPromoCode(promocode, depart_date) {
    let data = new FormData()
    data.append('promocode', promocode)
    data.append('trip_type', 'one-way')
    data.append('depart_date', depart_date)

    getPromocodeLoading()

    let response = await fetch('/ajax/promotion', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: data
                    })
    let res = await response.json()

    getPromocodeLoaded()
    return res
}

function numberFormat(number) {
    return number.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
}

function getPromocodeLoading() {
    document.querySelector('.promocode-loading').classList.add('d-none')
    document.querySelector('.promocode-loaded').classList.remove('d-none')
    document.querySelector('.booking-promocode-input').disabled = true
    document.querySelector('#button-promocode-submit').disabled = true
}

function getPromocodeLoaded() {
    document.querySelector('.promocode-loading').classList.remove('d-none')
    document.querySelector('.promocode-loaded').classList.add('d-none')
    document.querySelector('.booking-promocode-input').disabled = false
    document.querySelector('#button-promocode-submit').disabled = false
}
