const booking_route = document.querySelector('#booking-route-select')
const depart_route = booking_route.querySelector('#booking-depart')
const return_route = booking_route.querySelector('#booking-return')
let route_selected = { depart: false, return: false }
let premium_price = 0
let set_extra = 0
let route_index = { depart: null, return: null }
let price = { depart: 0, return: 0 }
let icon_selected = { depart: [], return: [] }
let extra_id = { depart: [], return: [] }
let extra_price = { depart: 0, return: 0 }
let addon_route = { depart: [], return: [] }
let payment = { // PAYMENT INFO
        time: {
                depart: { depart_time: null, arrive_time: null },
                return: { depart_time: null, arrive_time: null }
            },
        passenger: { depart: [], return: [] },
        is_passenger: [],
        extra: { depart: [], return: [] }
    }
let route_promo = { depart: false, return: false }
let selected_promo = { depart: false, return: false }
let promocode_from = []
let promocode_to = []
let promocode_route = []
let promocode_premiumflex = 'N'
let promocode_select = {depart: 'N', return: 'N'}
let promo = null
let route_selected_index = {depart: null, return: null}

if(depart_route) {
    let route_list = depart_route.querySelectorAll('.booking-depart-list')
    let btn_route_list = document.querySelectorAll('.btn-route-depart-list')
    const route_addon_checked = document.querySelectorAll('.route-addon-checked-depart')
    const route_addon_detail = document.querySelectorAll('.route-addon-detail-depart')

    route_list.forEach((route, index) => {
        let btn_select = document.querySelector(`.btn-route-depart-select-${index}`)
        btn_select.addEventListener('click', (e) => {
            set_extra = 0
            route_list.forEach((item) => {
                item.classList.remove('active')
            })
            btn_route_list.forEach((btn) => {
                btn.disabled = false
                btn.innerText = 'Select'
            })
            btn_select.disabled = true
            btn_select.innerText = 'Selected'

            promocode_select.depart = route.querySelector('.route-status-depart').value

            let is_promo_selected = route.querySelector('.promo-avaliable-depart')
            if(is_promo_selected) selected_promo.depart = true
            else selected_promo.depart = false

            if(document.querySelector('.promo-price')) route_promo.depart = true
            else route_promo.depart = false

            route_index.depart = index
            route_selected.depart = true
            routeSelected()
            route.classList.add('active')
            route.classList.remove('route-hover')

            let icons = route.querySelectorAll('.icon-selected')
            let icon_list = []
            let price_list = []
            icons.forEach((icon) => {
                icon_list.push(icon.src)
            })
            icon_selected.depart = icon_list

            route_addon_checked.forEach((addon) => {
                addon.checked = false
                addon.name = ''
                addon_route.depart = []
            })
            route_addon_detail.forEach((detail) => { detail.name = '' })

            price_list.push(route.querySelector('.selected-adult-price').value)
            price_list.push(route.querySelector('.selected-child-price').value)
            price_list.push(route.querySelector('.selected-infant-price').value)
            payment.passenger.depart = price_list

            payment.time.depart.depart_time = route.querySelector('.depart-time').innerText
            payment.time.depart.arrive_time = route.querySelector('.arrival-time').innerText
            document.querySelector('.set-time-route-depart').innerHTML = ` | ${payment.time.depart.depart_time} - ${payment.time.depart.arrive_time}`

            // set Your Booking
            document.querySelector('.your-booking-summary').classList.remove('d-none')
            document.querySelector('.your-booking-depart-time').innerHTML = `<i class="fa-regular fa-clock"></i> ${payment.time.depart.depart_time}`
            document.querySelector('.your-booking-depart-from').innerHTML = '<i class="fa-solid fa-ship"></i> ' + route.querySelector('.station-depart-from-text').innerText
            document.querySelector('.your-booking-arrive-time').innerHTML = `<i class="fa-regular fa-clock"></i> ${payment.time.depart.arrive_time}`
            document.querySelector('.your-booking-depart-to').innerHTML = '<i class="fa-solid fa-anchor"></i> ' + route.querySelector('.station-depart-to-text').innerText

            let _price = route.querySelector('.route-price')
            price.depart = parseToNumber(_price.innerText)
            updateRoutePrice('depart', index)

            const booking_extra = document.querySelector('#booking-route-extra')
            const depart_extra = booking_extra.querySelector('#depart-route-extra')
            const inputs = depart_extra.querySelectorAll('input[type="number"]')
            inputs.forEach((input) => { input.value = 0 })
            extra_price.depart = 0
            extra_id.depart = []

            route_selected_index.depart = index
            if(promo === null) updateDiscountBySearchForm('depart')
            else updateDiscountByBookingSummary('depart')

            document.querySelector('[name="booking_depart_selected"]').value = route.querySelector('.selected-route').value
        })
    })
}

if(return_route) {
    let route_list = return_route.querySelectorAll('.booking-return-list')
    let btn_route_list = document.querySelectorAll('.btn-route-return-list')
    const route_addon_checked = document.querySelectorAll('.route-addon-checked-return')
    const route_addon_detail = document.querySelectorAll('.route-addon-detail-return')

    route_list.forEach((route, index) => {
        let btn_select = document.querySelector(`.btn-route-return-select-${index}`)
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

            promocode_select.return = route.querySelector('.route-status-return').value

            let is_promo_selected = route.querySelector('.promo-avaliable-return')
            if(is_promo_selected) selected_promo.return = true
            else selected_promo.return = false

            if(document.querySelector('.promo-price')) route_promo.return = true
            else route_promo.return = false

            route_index.return = index
            route_selected.return = true
            routeSelected()
            route.classList.add('active')
            route.classList.remove('route-return-hover')

            let icons = route.querySelectorAll('.icon-selected')
            let icon_list = []
            let price_list = []
            icons.forEach((icon) => {
                icon_list.push(icon.src)
            })
            icon_selected.return = icon_list

            route_addon_checked.forEach((addon) => {
                addon.checked = false
                addon.name = ''
                addon_route.return = []
            })
            route_addon_detail.forEach((detail) => { detail.name = '' })

            price_list.push(route.querySelector('.selected-adult-price').value)
            price_list.push(route.querySelector('.selected-child-price').value)
            price_list.push(route.querySelector('.selected-infant-price').value)
            payment.passenger.return = price_list

            payment.time.return.depart_time = route.querySelector('.depart-time').innerText
            payment.time.return.arrive_time = route.querySelector('.arrival-time').innerText
            document.querySelector('.set-time-route-return').innerHTML = ` | ${payment.time.return.depart_time} - ${payment.time.return.arrive_time}`

            // set Your Booking
            document.querySelector('.your-booking-summary').classList.remove('d-none')
            document.querySelector('.your-booking-return-depart-time').innerHTML = `<i class="fa-regular fa-clock"></i> ${payment.time.depart.depart_time}`
            document.querySelector('.your-booking-return-from').innerHTML = '<i class="fa-solid fa-ship"></i> ' + route.querySelector('.station-return-from-text').innerText
            document.querySelector('.your-booking-return-arrive-time').innerHTML = `<i class="fa-regular fa-clock"></i> ${payment.time.depart.arrive_time}`
            document.querySelector('.your-booking-return-to').innerHTML = '<i class="fa-solid fa-anchor"></i> ' + route.querySelector('.station-return-to-text').innerText

            let _price = route.querySelector('.route-price')
            price.return = parseToNumber(_price.innerText)
            updateRoutePrice('return', index)

            const booking_extra = document.querySelector('#booking-route-extra')
            const return_extra = booking_extra.querySelector('#return-route-extra')
            const inputs = return_extra.querySelectorAll('input[type="number"]')
            inputs.forEach((input) => { input.value = 0 })
            extra_price.return = 0
            extra_id.return = []

            route_selected_index.return = index
            if(promo === null) updateDiscountBySearchForm('return')
            else updateDiscountByBookingSummary('return')

            document.querySelector('[name="booking_return_selected"]').value = route.querySelector('.selected-route').value
        })
    })
}

if(depart_route && return_route) {
    const use_promocode = document.querySelector('[name="use_promocode"]')
    const promocode = document.querySelector('.booking-promocode-input')
    if(use_promocode.value !== '') {
        promocode.value = use_promocode.value
        const route_list_return = return_route.querySelectorAll('.booking-return-list')
        const route_list_depart = depart_route.querySelectorAll('.booking-depart-list')
        const booking_date_depart = document.querySelector('.is-booking-date-depart')
        const booking_date_return = document.querySelector('.is-booking-date-return')

        promocodeProcess(use_promocode.value, booking_date_depart, booking_date_return, route_list_depart, route_list_return)
    }
}

function routeSelected() {
    if(route_selected.depart && route_selected.return)
        document.querySelector('#progress-next').disabled = false
}

function updateRoutePrice(type, index) {
    let a_per_price = document.querySelector(`.adult-per-price-${type}-${index}`).innerText
    let c_per_price = document.querySelector(`.child-per-price-${type}-${index}`)
    let i_per_price = document.querySelector(`.infant-per-price-${type}-${index}`)

    let fare_passenger = document.querySelector(`.fare-passenger-${type}`)
    fare_passenger.classList.remove('d-none')
    let sum_a_price = fare_passenger.querySelector('.your-booking-fare-adult')
    let sum_c_price = fare_passenger.querySelector('.your-booking-fare-child')
    let sum_i_price = fare_passenger.querySelector('.your-booking-fare-infant')

    document.querySelector('.your-booking-premium-flex').classList.add('d-none')

    sum_a_price.innerHTML = `${a_per_price.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} <small class="smaller">THB</small>`
    if(sum_c_price) sum_c_price.innerHTML = `${c_per_price.innerText.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} <small class="smaller">THB</small>`
    if(sum_i_price) sum_i_price.innerHTML = `${i_per_price.innerText.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} <small class="smaller">THB</small>`
    document.querySelector('.your-booking-amount').innerHTML = `${(price.depart + price.return).toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} <small class="smaller">THB</small>`

    document.querySelector('#sum-price').innerHTML = (price.depart + price.return).toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
}

function parseToNumber(str) {
    return parseFloat(str.split(',').join(''));
}

// STEP BAR ////////////////////////////////////////////////////////////////////////////////
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

function progressCondition(step) {
    if(step === 'select') {
        document.querySelector('#btn-back-to-home').classList.remove('d-none')
        document.querySelector('#progress-prev').classList.add('d-none')
        const your_booking = document.querySelector('.your-booking-premium-flex')
        if(your_booking) your_booking.classList.add('d-none')

        let depart_list = booking_route.querySelectorAll('.booking-depart-list')
        let return_list = booking_route.querySelectorAll('.booking-return-list')
        depart_list.forEach((route) => {
            if(route.classList.contains('active')) document.querySelector('#progress-next').disabled = false
        })
        return_list.forEach((route) => {
            if(route.classList.contains('active')) document.querySelector('#progress-next').disabled = false
        })

        progress_payment.classList.add('d-none')
        progress_payment.disabled = true
        premium_price = 0
        updateSumPrice()
    }

    if(step === 'premium') {
        document.querySelector('#btn-back-to-home').classList.add('d-none')
        document.querySelector('#progress-prev').classList.remove('d-none')
        document.querySelector('.your-booking-extra').classList.add('d-none')
        let promo_premiumflex = document.querySelector('.ispremiumflex').value
        let use_promocode = document.querySelector('[name="use_promocode"]')
        let select_promo = document.querySelector('.selected-route-promocode')

        const txt_price = document.querySelector('.is-premium-price')
        const ispremiumflex = document.querySelector('#is-premiumflex')
        const nonePremiumFlex = document.querySelector('#none-premiumflex')
        const your_booking = document.querySelector('.your-booking-premium-flex')
        let route_price = (price.depart + price.return)
        // let _premium_price = ((route_price*110)/100) - route_price
        let _selected_promo = false;
        if(selected_promo.depart) _selected_promo = true
        if(selected_promo.return) _selected_promo = true
        // let _premium_price = promo_premiumflex === 'Y' ? 0 : ((route_price*110)/100) - route_price
        let _premium_price = ((route_price*110)/100) - route_price

        if(use_promocode.value !== '') {
            if(promo_premiumflex === 'Y') select_promo.classList.remove('d-none')
        }

        your_booking.classList.remove('d-none')
        txt_price.innerHTML = _premium_price.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
        // if(promocode_premiumflex === 'Y') {
        //     txt_price.innerHTML = '0'
        // }
        // else {
        //     txt_price.innerHTML = _premium_price.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
        // }

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
        // start date
        let startDate_adult = new Date()
        startDate_adult.setFullYear(startDate_adult.getFullYear() - 100)
        let startDate_child = new Date()
        startDate_child.setFullYear(startDate_child.getFullYear() - 12)
        let startDate_infant = new Date()
        startDate_infant.setFullYear(startDate_infant.getFullYear() - 2)

        // end date
        let endDate_adult = new Date()
        endDate_adult.setFullYear(endDate_adult.getFullYear() - 12)
        let endDate_child = new Date()
        endDate_child.setFullYear(endDate_child.getFullYear() - 2)

        $('.lead-passenger-b-day').datepicker()
        $('.lead-passenger-b-day').datepicker('setEndDate', endDate_adult)
        $('.lead-passenger-b-day').datepicker('setStartDate', startDate_adult)
        $('.lead-passenger-b-day').datepicker('setDaysOfWeekDisabled')

        if(sub_passenger) {
            sub_passenger.forEach((item) => {
                let is_rangeDate = []
                if(item.dataset.type == 'Adult') is_rangeDate = [startDate_adult, endDate_adult]
                if(item.dataset.type == 'Child') is_rangeDate = [startDate_child, endDate_child]
                if(item.dataset.type == 'Infant') is_rangeDate = [startDate_infant, new Date()]

                // console.log(is_rangeDate)
                $(`#${item.id}`).datepicker()
                $(`#${item.id}`).datepicker('setEndDate', is_rangeDate[1])
                $(`#${item.id}`).datepicker('setStartDate', is_rangeDate[0])
                $(`#${item.id}`).datepicker('setDaysOfWeekDisabled')
            })
        }
    }
    else if(step !== 'passenger') {
        // const passenger_next = document.querySelector('#progress-next-passenger')
        // progress_next.classList.remove('d-none')
        // passenger_next.classList.add('d-none')
        // passenger_next.disabled = true

        progress_next.classList.remove('d-none')
        progress_payment.classList.add('d-none')
        progress_payment.disabled = true
    }

    if(step === 'extra') {
        // extra_price.return = 0
        // extra_price.depart = 0
        // addon_route.depart = []
        // addon_route.return = []
        // extraList('.depart-route-shuttle-bus', `#depart-route-shuttle-bus-index-${route_index.depart}`, `.route-addon-index-${route_index.depart}`)
        // extraList('.depart-route-longtail-boat', `#depart-route-longtail-boat-index-${route_index.depart}`)
        if(set_extra === 0) routeAddonList('.route-addon-lists-depart', `.route-addon-index-${route_index.depart}-depart`, 'depart')
        extraList('.depart-meal', `#extra-depart-meal-index-${route_index.depart}`)
        extraList('.depart-activity', `#extra-depart-activity-index-${route_index.depart}`)
        const depart_route_addon_checked = document.querySelectorAll('.route-addon-checked-depart input')
        depart_route_addon_checked.forEach((route_addon) => {
            // if(route_addon.checked) {
            //     let type = route_addon.dataset.type
            //     let subtype = route_addon.dataset.subtype
            //     let routeindex = route_addon.dataset.routeindex
            //     let addon_name = document.querySelector(`.addon-name-${type}-${subtype}-${routeindex}-depart`)
            //     let addon_price = document.querySelector(`.${type}-${subtype}-${routeindex}-depart`)
            //     let addon_detail = document.querySelector(`.addon-detail-${type}-${subtype}-${routeindex}-depart`)
            //     route_addon.name = `route_addon_depart[]`
            //     addon_detail.name = `route_addon_detail_depart[]`
            //     extra_price.depart += parseInt(addon_price.value)
            //     addon_route.depart.push({'name': addon_name.innerText, 'price': addon_price.value, 'type': `${type}-${subtype}-${routeindex}-depart`})
            //     document.querySelector('.your-booking-extra').classList.remove('d-none')
            //     updateSumPrice()
            // }

            // route_addon.addEventListener('change', (e) => {
            //     routeAddonCheck(e, 'depart')
            // })
        })

        // extraList('.return-route-shuttle-bus', `#return-route-shuttle-bus-index-${route_index.return}`)
        // extraList('.return-route-longtail-boat', `#return-route-longtail-boat-index-${route_index.return}`)
        routeAddonList('.route-addon-lists-return', `.route-addon-index-${route_index.return}-return`, 'return')
        extraList('.return-meal', `#extra-return-meal-index-${route_index.return}`)
        extraList('.return-activity', `#extra-return-activity-index-${route_index.return}`)
        const return_route_addon_checked = document.querySelectorAll('.route-addon-checked-return input')
        return_route_addon_checked.forEach((route_addon) => {
            // if(route_addon.checked) {
            //     let type = route_addon.dataset.type
            //     let subtype = route_addon.dataset.subtype
            //     let routeindex = route_addon.dataset.routeindex
            //     let addon_name = document.querySelector(`.addon-name-${type}-${subtype}-${routeindex}-return`)
            //     let addon_price = document.querySelector(`.${type}-${subtype}-${routeindex}-return`)
            //     let addon_detail = document.querySelector(`.addon-detail-${type}-${subtype}-${routeindex}-return`)
            //     route_addon.name = `route_addon_return[]`
            //     addon_detail.name = `route_addon_detail_return[]`
            //     extra_price.return += parseInt(addon_price.value)
            //     addon_route.return.push({'name': addon_name.innerText, 'price': addon_price.value, 'type': `${type}-${subtype}-${routeindex}-return`})
            //     document.querySelector('.your-booking-extra').classList.remove('d-none')
            //     updateSumPrice()
            // }

            // route_addon.addEventListener('change', (e) => {
            //     routeAddonCheck(e, 'return')
            // })
        })

        // progress_next.classList.remove('d-none')
        // progress_payment.classList.add('d-none')
        // progress_payment.disabled = true

        const passenger_next = document.querySelector('#progress-next-passenger')
        progress_next.classList.remove('d-none')
        passenger_next.classList.add('d-none')
        passenger_next.disabled = true
    }

    if(step === 'payment') {
        setLitinerary()
        setPassengerDetail()
        let extra_sum_depart = setExtraDetail('depart')
        let extra_sum_return = setExtraDetail('return')
        let extra_sum = extra_sum_depart + extra_sum_return
        if(extra_sum > 0) {
            document.querySelector('#payment-extra-service').classList.remove('d-none')
            document.querySelector('#sum-of-extra').innerHTML = extra_sum.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
        }
        else document.querySelector('#payment-extra-service').classList.add('d-none')

        progress_next.classList.add('d-none')
        progress_payment.classList.remove('d-none')
        if(payment_selected) progress_payment.disabled = false
    }
}
// END STEP BAR ///////////////////////////////////////////////////////////////////////////////////


let payment_methods = document.querySelectorAll('.payment-methods')
if(payment_methods) {
    payment_methods.forEach((payment) => {
        payment.addEventListener('click', () => {
            payment_selected = true
            progress_payment.disabled = false
        })
    })
}


// EXTRA STEP //////////////////////////////////////////////////////////////////////////////////////
function extraList(lists, list) {
    const _extra = document.querySelector('#booking-route-extra')

    const _lists = _extra.querySelectorAll(lists)
    const _list = _extra.querySelectorAll(list)
    if(_lists && _list) {
        _lists.forEach((list) => { list.classList.add('d-none') })
        _list.forEach((list) => { list.classList.remove('d-none') })
    }
}

function routeAddonList(lists, list, _type) {
    const _extra = document.querySelector('#booking-route-extra')

    const _lists = _extra.querySelectorAll(lists)
    const _list = _extra.querySelectorAll(list)
    if(_lists && _list) {
        _lists.forEach((list) => {
            let uncheck = list.querySelectorAll(`input[type="checkbox"]`)
            uncheck.forEach((uc) => {
                // uc.checked = true
                let type = uc.dataset.type
                let subtype = uc.dataset.subtype
                let routeindex = uc.dataset.routeindex
                let addon_detail = document.querySelector(`.addon-detail-${type}-${subtype}-${routeindex}-${_type}`)
                uc.name = ``
                addon_detail.name = ``
            })
            list.classList.add('d-none')
        })
        _list.forEach((list) => {
            // let check = list.querySelectorAll(`input[type="checkbox"]`)
            // check.forEach((c) => {
            //     c.checked = true
            //     let type = c.dataset.type
            //     let subtype = c.dataset.subtype
            //     let routeindex = c.dataset.routeindex
            //     let addon_name = document.querySelector(`.addon-name-${type}-${subtype}-${routeindex}-${_type}`)
            //     let addon_price = document.querySelector(`.${type}-${subtype}-${routeindex}-${_type}`)
            //     let addon_detail = document.querySelector(`.addon-detail-${type}-${subtype}-${routeindex}-${_type}`)
            //     c.name = `route_addon_${_type}[]`
            //     addon_detail.name = `route_addon_detail_${_type}[]`
            //     if(_type === 'depart') {
            //         addon_route.depart.push({'name': addon_name.innerText, 'price': addon_price.value, 'type': `${type}-${subtype}-${routeindex}-${_type}`})
            //         extra_price.depart += parseInt(addon_price.value)
            //     }
            //     if(_type === 'return') {
            //         addon_route.return.push({'name': addon_name.innerText, 'price': addon_price.value, 'type': `${type}-${subtype}-${routeindex}-${_type}`})
            //         extra_price.return += parseInt(addon_price.value)
            //     }
            // })
            document.querySelector('.your-booking-extra').classList.remove('d-none')
            list.classList.remove('d-none')
            updateSumPrice()
        })
    }
}

function selectRouteAddon(e, _type) {
    let type = e.dataset.type
    let subtype = e.dataset.subtype
    let routeindex = e.dataset.routeindex
    let addon_id = e.dataset.addon
    let addon_name = document.querySelector(`.addon-name-${type}-${subtype}-${routeindex}-${_type}`)
    let addon_price = document.querySelector(`.${type}-${subtype}-${routeindex}-${_type}`)
    let addon_detail = document.querySelector(`.addon-detail-${type}-${subtype}-${routeindex}-${_type}`)
    if(e.checked) {
        if(_type === 'depart') {
            let addon_index = addon_route.depart.findIndex((addon) => { return addon.type === `${type}-${subtype}-${routeindex}-${_type}` })
            if(addon_index < 0) addon_route.depart.push({'id': addon_id, 'name': addon_name.innerText, 'price': addon_price.value, 'type': `${type}-${subtype}-${routeindex}-${_type}`})

            extra_price.depart += parseInt(addon_price.value)
            e.name = `route_addon_${_type}[]`
            addon_detail.name = `route_addon_detail_${_type}[]`
            addon_detail.disabled = false
        }
        if(_type === 'return') {
            let addon_index = addon_route.return.findIndex((addon) => { return addon.type === `${type}-${subtype}-${routeindex}-${_type}` })
            if(addon_index < 0) addon_route.return.push({'id': addon_id, 'name': addon_name.innerText, 'price': addon_price.value, 'type': `${type}-${subtype}-${routeindex}-${_type}`})

            extra_price.return += parseInt(addon_price.value)
            e.name = `route_addon_${_type}[]`
            addon_detail.name = `route_addon_detail_${_type}[]`
            addon_detail.disabled = false
        }

        updateSumPrice()
    }
    else {
        if(_type === 'depart') {
            let addon_index = addon_route.depart.findIndex((addon) => { return addon.type === `${type}-${subtype}-${routeindex}-${_type}` })
            if(addon_index >= 0) addon_route.depart.splice(addon_index, 1)
            extra_price.depart -= parseInt(addon_price.value)
        }
        if(_type === 'return') {
            let addon_index = addon_route.return.findIndex((addon) => { return addon.type === `${type}-${subtype}-${routeindex}-${_type}` })
            if(addon_index >= 0) addon_route.return.splice(addon_index, 1)
            extra_price.return -= parseInt(addon_price.value)
        }
        e.name = ''
        addon_detail.name = ''
        addon_detail.value = ''
        addon_detail.disabled = true
        updateSumPrice()
    }
}

// function routeAddonCheck(e, _type) {
//     set_extra = 1
//     let type = e.target.dataset.type
//     let subtype = e.target.dataset.subtype
//     let routeindex = e.target.dataset.routeindex
//     let addon_name = document.querySelector(`.addon-name-${type}-${subtype}-${routeindex}-${_type}`)
//     let addon_price = document.querySelector(`.${type}-${subtype}-${routeindex}-${_type}`)
//     let addon_detail = document.querySelector(`.addon-detail-${type}-${subtype}-${routeindex}-${_type}`)
//     if(e.target.checked) {
//         if(_type === 'depart') {
//             let addon_index = addon_route.depart.findIndex((addon) => { return addon.type === `${type}-${subtype}-${routeindex}-${_type}` })
//             if(addon_index < 0) addon_route.depart.push({'name': addon_name.innerText, 'price': addon_price.value, 'type': `${type}-${subtype}-${routeindex}-${_type}`})

//             extra_price.depart += parseInt(addon_price.value)
//             e.target.name = `route_addon_${_type}[]`
//             addon_detail.name = `route_addon_detail_${_type}[]`
//             addon_detail.disabled = false
//         }
//         if(_type === 'return') {
//             let addon_index = addon_route.return.findIndex((addon) => { return addon.type === `${type}-${subtype}-${routeindex}-${_type}` })
//             if(addon_index < 0) addon_route.return.push({'name': addon_name.innerText, 'price': addon_price.value, 'type': `${type}-${subtype}-${routeindex}-${_type}`})

//             extra_price.return += parseInt(addon_price.value)
//             e.target.name = `route_addon_${_type}[]`
//             addon_detail.name = `route_addon_detail_${_type}[]`
//             addon_detail.disabled = false
//         }

//         updateSumPrice()
//     }
//     else {
//         if(_type === 'depart') {
//             let addon_index = addon_route.depart.findIndex((addon) => { return addon.type === `${type}-${subtype}-${routeindex}-${_type}` })
//             if(addon_index >= 0) addon_route.depart.splice(addon_index, 1)
//             extra_price.depart -= parseInt(addon_price.value)
//         }
//         if(_type === 'return') {
//             let addon_index = addon_route.return.findIndex((addon) => { return addon.type === `${type}-${subtype}-${routeindex}-${_type}` })
//             if(addon_index >= 0) addon_route.return.splice(addon_index, 1)
//             extra_price.return -= parseInt(addon_price.value)
//         }
//         e.target.name = ''
//         addon_detail.name = ''
//         addon_detail.value = ''
//         addon_detail.disabled = true
//         updateSumPrice()
//     }
// }

function inc(type, element, index) {
    const el = document.querySelector(`#${type}-${element}-index-${index}`)
    const icon = document.querySelector(`#${type}-${element}-img-${index}`)
    const name = document.querySelector(`#${type}-${element}-name-${index}`)
    const amount = document.querySelector(`.${type}-${element}-amount-${index}`)
    let qty = parseInt(el.value) + 1
    el.value = qty

    let _extra_amount = parseToNumber(amount.innerText)
    if(type === 'depart') extra_price.depart += _extra_amount
    if(type === 'return') extra_price.return += _extra_amount
    let ico_src = icon === null ? '' : icon.src
    setExtra(ico_src, name.innerText, _extra_amount, qty, element, type)
    updateSumPrice()
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
        if(type === 'depart') extra_price.depart -= _extra_amount
        if(type === 'return') extra_price.return -= _extra_amount
        let ico_src = icon === null ? '' : icon.src
        setExtra(ico_src, name.innerText, _extra_amount, qty, element, type)
        updateSumPrice()
    }
}

function updateSumPrice() {
    let result_premuim_price = 0
    let result_extra_depart = 0
    let result_extra_return = 0
    let your_booking = {
        premium_flex: document.querySelector('.your-booking-premium-flex-price'),
        extra: document.querySelector('.your-booking-extra-price'),
        total: document.querySelector('.your-booking-amount')
    }
    const person_adult = document.querySelector('.person-adult-icon').innerText
    const person_child = document.querySelector('.person-child-icon').innerText
    const person_infant = document.querySelector('.person-infant-icon').innerText
    const person_all = parseInt(person_adult) + parseInt(person_child) + parseInt(person_infant)

    let s_price = price.depart + price.return
    let new_pflex_price = numberFormat(s_price - (s_price*(100 - 10))/100).toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })

    if(promocode_premiumflex === 'N') {
        result_premuim_price = premium_price
        let price_status = result_premuim_price > 0 ? '+ ' : ''
        your_booking.premium_flex.innerHTML = `${price_status}${new_pflex_price} <small class="smaller">THB</small>`
    }
    else {
        result_premuim_price = 0
        let price_status = premium_price > 0 ? '- ' : ''
        your_booking.premium_flex.innerHTML = `${price_status}${new_pflex_price} <small class="smaller">THB</small>`
    }

    // console.log(addon_route.depart)
    // console.log(addon_route.return)

    addon_route.depart.forEach((item) => { result_extra_depart += parseInt(item.price) })
    addon_route.return.forEach((item) => { result_extra_return += parseInt(item.price) })

    const extra_price = person_all*(result_extra_depart + result_extra_return)
    const extra_type = extra_price > 0 ? '+ ' : ''
    your_booking.extra.innerHTML = `${extra_type}${extra_price.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} <small class="smaller">THB</small>`

    let sum_amount = (price.depart + price.return) + ((result_extra_depart + result_extra_return) * person_all) + result_premuim_price
    let sum_amount_digit = `${sum_amount.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })}`
    document.querySelector('#sum-price').innerHTML = sum_amount_digit
    your_booking.total.innerHTML = `${sum_amount_digit} <small class="smaller">THB</small>`
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
            let index = payment.extra.depart.findIndex(extra => { return extra.name === name && extra.type === element })
            if(index >= 0) payment.extra.depart[index].qty = qty
            else payment.extra.depart.push(_extra)
        }
        if(type === 'return') {
            let index = payment.extra.return.findIndex(extra => { return extra.name === name && extra.type === element })
            if(index >= 0) payment.extra.return[index].qty = qty
            else payment.extra.return.push(_extra)
        }
    }
    else {
        if(type === 'depart') {
            let index = payment.extra.depart.findIndex(extra => { return extra.name === name && extra.type === element })
            payment.extra.depart.splice(index, 1)
        }
        if(type === 'return') {
            let index = payment.extra.return.findIndex(extra => { return extra.name === name && extra.type === element })
            payment.extra.return.splice(index, 1)
        }
    }
}
// END EXTRA STEP //////////////////////////////////////////////////////////////////////////////////



// PASSENGER STEP //////////////////////////////////////////////////////////////////////////////////
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
        document.querySelector('#booking-form').submit()
    }
}

function setPassengerPayment() {
    payment.is_passenger = []

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

    payment.is_passenger.push(_passenger)
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

        payment.is_passenger.push(_passenger)
    })
}
// END PASSENGER STEP ////////////////////////////////////////////////////////////////////////////////////



// PAYMENT STEP //////////////////////////////////////////////////////////////////////////////////////////
function setLitinerary() {
    document.querySelector('.is_d_depart_time').innerHTML = payment.time.depart.depart_time
    document.querySelector('.is_d_arrive_time').innerHTML = payment.time.depart.arrive_time
    document.querySelector('.is_r_depart_time').innerHTML = payment.time.return.depart_time
    document.querySelector('.is_r_arrive_time').innerHTML = payment.time.return.arrive_time
    setIconAtPayment()

    let sum_depart = setPassengerAmountPayment('depart')
    let sum_return = setPassengerAmountPayment('return')
    document.querySelector('.sum-of-payment').innerHTML = (sum_depart + sum_return).toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
    document.querySelector('.sum-of-premium').innerHTML = premium_price.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })

    let promo_sum = document.querySelector('.sum-of-promocode')
    let sum_discount = 0
    if(selected_promo.depart) {
        let discount = sum_depart - price.depart
        sum_discount += discount
        let minus = sum_discount !== 0 ? '- ' : ''
        if(route_promo.depart) document.querySelector('.promocode-show').classList.remove('d-none')
        promo_sum.innerHTML = minus + sum_discount.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
    }
    else {
        document.querySelector('.promocode-show').classList.add('d-none')
        let minus = sum_discount !== 0 ? '- ' : ''
        promo_sum.innerHTML = minus + sum_discount.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
    }

    if(selected_promo.return) {
        let discount = sum_return - price.return
        sum_discount += discount
        let minus = sum_discount !== 0 ? '- ' : ''
        if(route_promo.return) document.querySelector('.promocode-show').classList.remove('d-none')
        promo_sum.innerHTML = minus + sum_discount.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
    }
    else {
        let minus = sum_discount !== 0 ? '- ' : ''
        if(selected_promo.depart) {
            promo_sum.innerHTML = minus + sum_discount.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
        }
        else {
            document.querySelector('.promocode-show').classList.add('d-none')
            promo_sum.innerHTML = minus + sum_discount.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
        }
    }

    const addon_list = document.querySelector('.amount-detail-list')
    const addon_lists = addon_list.querySelectorAll('.addon-route-detail')
    addon_lists.forEach((list) => { list.remove() })
    let route_addon_price = 0
    addon_route.depart.forEach((addon) => {
        let h6 = document.createElement('h6')
        h6.setAttribute('class', 'd-flex justify-content-end align-items-end addon-route-detail')
        h6.innerHTML = `[Depart] : ${addon.name} <p class="w--20 w-sm-30 me-2 mb-0"> ${addon.price} </p><small class="smaller">THB</small>`
        addon_list.appendChild(h6)
        route_addon_price += parseInt(addon.price)
    })
    addon_route.return.forEach((addon) => {
        let h6 = document.createElement('h6')
        h6.setAttribute('class', 'd-flex justify-content-end align-items-end addon-route-detail')
        h6.innerHTML = `[Return] : ${addon.name} <p class="w--20 w-sm-30 me-2 mb-0"> ${addon.price} </p><small class="smaller">THB</small>`
        addon_list.appendChild(h6)
        route_addon_price += parseInt(addon.price)
    })

    document.querySelector('.sum-amount').innerHTML = ((sum_depart + sum_return + premium_price + route_addon_price) - sum_discount).toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
}

function setPassengerDetail() {
    const passenger_detail = document.querySelector('#payment-passenger-detail')
    while (passenger_detail.firstChild) {
        passenger_detail.removeChild(passenger_detail.lastChild);
    }
    // let _passenger = Object.groupBy(payment.is_passenger, pass => { return pass._type })
    let _passenger = payment.is_passenger.reduce((acc, data) => {
        (acc[data['_type']] = acc[data['_type']] || []).push(data);
        return acc;
    }, {})

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

function setExtraDetail(type) {
    let is_extra = type === 'depart' ? payment.extra.depart : payment.extra.return
    let sum = 0
    const extra_service = document.querySelector('#payment-extra-service')
    const extra_type = extra_service.querySelector(`#${type}-extra`)
    const extra_meal = extra_type.querySelector('.payment-extra-meal')
    const extra_activity = extra_type.querySelector('.payment-extra-activity')
    const extra_shuttlebus = extra_type.querySelector('.payment-extra-shuttle-bus')
    const extra_longtailboat = extra_type.querySelector('.payment-extra-longtail-boat')

    while (extra_meal.firstChild) { extra_meal.removeChild(extra_meal.lastChild) }
    while (extra_activity.firstChild) { extra_activity.removeChild(extra_activity.lastChild) }
    while (extra_shuttlebus.firstChild) { extra_shuttlebus.removeChild(extra_shuttlebus.lastChild) }
    while (extra_longtailboat.firstChild) { extra_longtailboat.removeChild(extra_longtailboat.lastChild) }

    extra_longtailboat.classList.add('d-none')
    extra_shuttlebus.classList.add('d-none')
    extra_activity.classList.add('d-none')
    extra_meal.classList.add('d-none')

    // console.log(type, is_extra)

    if(is_extra.length === 0) extra_type.classList.add('d-none')
    else extra_type.classList.remove('d-none')

    // let _extra = Object.groupBy(is_extra, ex => { return ex.type })
    let _extra2 = is_extra.reduce((acc, data) => {
        (acc[data['type']] = acc[data['type']] || []).push(data);
        return acc;
    }, {})

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
        header.innerHTML = 'Shuttle Bus'

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

    return sum
}

function setIconAtPayment() {
    const depart_icon = document.querySelector('#depart-icon-payment')
    const return_icon = document.querySelector('#return-icon-payment')
    const d_icon_list = depart_icon.querySelectorAll('img')
    const r_icon_list = return_icon.querySelectorAll('img')

    d_icon_list.forEach((icon) => { icon.remove() })
    r_icon_list.forEach((icon) => { icon.remove() })

    icon_selected.depart.forEach((icon) => {
        let img = document.createElement('img')
        img.src = icon
        img.setAttribute('class', 'me-1 w-100')

        depart_icon.appendChild(img)
    })

    icon_selected.return.forEach((icon) => {
        let img = document.createElement('img')
        img.src = icon
        img.setAttribute('class', 'me-1 w-100')

        return_icon.appendChild(img)
    })
}

function setPassengerAmountPayment(type) {
    let _payment = type === 'depart' ? payment.passenger.depart : payment.passenger.return
    let adult_qty = document.querySelector(`#passenger-adult`)
    let adult_price = document.querySelector(`.${type}-payment-adult-price`)
    let child_price = document.querySelector(`.${type}-payment-child-price`)
    let child_qty = document.querySelector(`#passenger-child`)
    let infant_price = document.querySelector(`.${type}-payment-infant-price`)
    let infant_qty = document.querySelector(`#passenger-infant`)
    let sum_of_payment = 0

    if(adult_price) {
        adult_price.innerHTML = parseToNumber(_payment[0]).toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
        let adult_sum = parseToNumber(adult_qty.value)*parseToNumber(_payment[0])
        document.querySelector(`.${type}-sum-of-adult`).innerHTML = adult_sum.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
        sum_of_payment+= adult_sum
    }
    if(child_price) {
        child_price.innerHTML = parseToNumber(_payment[1]).toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
        let child_sum = parseToNumber(child_qty.value)*parseToNumber(_payment[1])
        document.querySelector(`.${type}-sum-of-child`).innerHTML = child_sum.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
        sum_of_payment+= child_sum
    }
    if(infant_price) {
        infant_price.innerHTML = parseToNumber(_payment[2]).toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
        let infant_sum = parseToNumber(infant_qty.value)*parseToNumber(_payment[2])
        document.querySelector(`.${type}-sum-of-infant`).innerHTML = infant_sum.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
        sum_of_payment+= infant_sum
    }

    document.querySelector(`.sum-of-${type}`).innerHTML = sum_of_payment.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
    return sum_of_payment
}


// Promotion controller
const promoSubmit = document.querySelector('#button-promocode-submit')
const current_price = { depart: [], return: [] }
let promo_active = { depart: [], return: [] }
if(promoSubmit) {
    const promocode = document.querySelector('.booking-promocode-input')
    const booking_date_depart = document.querySelector('.is-booking-date-depart')
    const booking_date_return = document.querySelector('.is-booking-date-return')
    const route_list_depart = booking_route.querySelectorAll('.booking-depart-list')
    const route_list_return = booking_route.querySelectorAll('.booking-return-list')

    promoSubmit.addEventListener('click', async () => {
        await promocodeProcess(promocode.value, booking_date_depart, booking_date_return, route_list_depart, route_list_return)
    })
}

async function promocodeProcess(promocode, booking_date_depart, booking_date_return, route_list_depart, route_list_return) {
    const _promocode = promocode
    const use_promocode = document.querySelector('[name="use_promocode"]')
    const booking_discount = document.querySelector('.your-booking-discount')
    const btn_promo = document.querySelector('#button-promocode-submit')
    const pflex_price = document.querySelector('.is-premium-price')
    promocode_premiumflex = 'N'

    if(_promocode !== '') {
        const _departdate = await dateFormatSet(booking_date_depart.innerText)
        const _returndate = await dateFormatSet(booking_date_return.innerText)
        await promoSetDiscount(_departdate, route_list_depart, use_promocode, _promocode, 'depart')
        await promoSetDiscount(_returndate, route_list_return, use_promocode, _promocode, 'return')

        if(promo !== null) {
            promocode_premiumflex = promo.isfreepremiumflex === 'Y' ? 'Y' : 'N'
            if(promo.isfreepremiumflex === 'Y') {
                // document.querySelector('.is-premium-price').innerHTML = '0'
                // document.querySelector('.your-booking-premium-flex-price').innerHTML = '0 <small class="smaller">THB</small>'
                updateSumPrice()
            }

            booking_discount.classList.remove('d-none')
            // document.querySelector('.your-booking-promocode').classList.add('d-none')
            btn_promo.classList.remove('promo-fail')
            btn_promo.classList.add('promo-success')

            let s_price = price.depart + price.return
            let new_pflex_price = numberFormat(s_price - (s_price*(100 - 10))/100).toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
            pflex_price.innerHTML = new_pflex_price

            $.SOW.core.toast.show('success', '', 'Promocode Active.', 'bottom-end', 3, true);
        }
        else {
            use_promocode.value = ''
            p_active = []

            booking_discount.classList.add('d-none')
            btn_promo.classList.add('promo-fail')
            btn_promo.classList.remove('promo-success')

            let s_price = price.depart + price.return
            let new_pflex_price = numberFormat(s_price - (s_price*(100 - 10))/100).toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
            pflex_price.innerHTML = new_pflex_price

            $.SOW.core.toast.show('danger', '', 'Invalid Coupon Code. Promotion code incorrect or unavailable.', 'bottom-end', 3, true);
        }

        // const btn_cancel = `<i class="fa-solid fa-pen-to-square text-primary cursor-pointer cancel-promocode" onClick="editPromotionCode()" title="Edit Promocode"></i>`
        // document.querySelector('.your-booking-promocode-discount').innerHTML = `[${_promocode}] ${btn_cancel}`
        // const discount_type = promo.discount_type === 'PERCENT' ? '%' : 'THB'
        // document.querySelector('.your-booking-promocode-discount-amount').innerHTML = `${parseInt(promo.discount)}${discount_type}`
    }
    else {
        document.querySelector('.booking-promocode-input').classList.add('border-danger')
        document.querySelector('.your-booking-discount').classList.add('d-none')
    }
}

function updateFreeAddon(type, status) {
    const _extra = document.querySelector('#booking-route-extra')
    const route_addon_list_depart = _extra.querySelectorAll('.route-addon-lists-depart')
    const route_addon_list_return = _extra.querySelectorAll('.route-addon-lists-return')
    const person_adult = document.querySelector('.person-adult-icon').innerText
    const person_child = document.querySelector('.person-child-icon').innerText
    const person_infant = document.querySelector('.person-infant-icon').innerText
    const person_all = parseInt(person_adult) + parseInt(person_child) + parseInt(person_infant)

    route_addon_list_depart.forEach((item) => {
        if(!item.classList.contains('d-none')) {
            const charge_from = item.querySelector(`.addon-service-charge-${type}-from`)
            const price_from = item.querySelector(`.${type}-is-service-charge-from`)
            const price_current_from = item.querySelector(`.${type}-is-service-charge-current-from`)
            const charge_to = item.querySelector(`.addon-service-charge-${type}-to`)
            const price_to = item.querySelector(`.${type}-is-service-charge-to`)
            const price_current_to = item.querySelector(`.${type}-is-service-charge-current-to`)

            if(charge_from && price_from && price_current_from) {
                setAddonPrice(price_current_from, charge_from, price_from, status, person_all)
            }
            if(charge_to, price_to, price_current_to) {
                setAddonPrice(price_current_to, charge_to, price_to, status, person_all)
            }
        }
    })

    route_addon_list_return.forEach((item) => {
        if(!item.classList.contains('d-none')) {
            const charge_from = item.querySelector(`.addon-service-charge-${type}-from`)
            const price_from = item.querySelector(`.${type}-is-service-charge-from`)
            const price_current_from = item.querySelector(`.${type}-is-service-charge-current-from`)
            const charge_to = item.querySelector(`.addon-service-charge-${type}-to`)
            const price_to = item.querySelector(`.${type}-is-service-charge-to`)
            const price_current_to = item.querySelector(`.${type}-is-service-charge-current-to`)

            if(charge_from && price_from && price_current_from) {
                setAddonPrice(price_current_from, charge_from, price_from, status, person_all)
            }
            if(charge_to && price_to && price_current_to) {

            }
        }
    })
}

function setAddonPrice(price_current, charge, price, status, person) {
    const _d = price_current.dataset
    if(status === 'Y') {
        charge.innerHTML = `<span class="text-second-color">Free By Promocode</span>`
        price.value = 0
        if(addon_route.depart.length > 0) {
            addon_route.depart.forEach((r, i) => {
                if(r.id === _d.addon) { addon_route.depart[i].price = '0' }
            })
        }
    }
    else {
        let set_price = price_current.value == '0' ? '0' : `${numberFormat(price_current.value * 1)} x ${person} = ${price_current.value * person} <span class="small">THB</span>`
        charge.innerHTML = `${set_price}`
        price.value = price_current.value
        addon_route.depart.forEach((r, i) => {
            if(r.id === _d.addon) { addon_route.depart[i].price = `${price_current.value}` }
        })
    }
}

async function promoSetDiscount(_date, route_list, use_promocode, _promocode, type) {
    const result = await getPromoCode(_promocode, _date)

    const c_price = type === 'depart' ? current_price.depart : current_price.return
    const r_index = type === 'depart' ? route_selected_index.depart : route_selected_index.return
    const p_active = type === 'depart' ? promo_active.depart : promo_active.return
    const p_select = type === 'depart' ? promocode_select.depart : promocode_select.return
    clearRouteToDefault(route_list, type)

    if(result.data !== null && result.data.result) {
        // edit button
        promocode_from = result.data.promo_line.from
        promocode_to = result.data.promo_line.to
        promocode_route = result.data.promo_line.route

        promo = result.data.data
        updateFreeAddon('shuttle_bus', promo.isfreeshuttlebus)
        updateFreeAddon('longtail_boat', promo.isfreelongtailboat)
        updateFreeAddon('private_taxi', promo.isfreeprivatetaxi)

        route_list.forEach((route, index) => {
            const station_from_id = route.querySelector(`.station-${type}-from-text`).dataset.id
            const station_to_id = route.querySelector(`.station-${type}-to-text`).dataset.id
            const route_id = route.dataset.id

            const route_ispromo = route.querySelector(`.route-status-${type}`).value
            const promo_price = route.querySelector('.route-price')
            if(c_price.length < route_list.length) c_price.push(promo_price.innerText)

            const route_promo_condition = promoCondition(route_id, station_from_id, station_to_id)
            if(route_promo_condition._route || route_promo_condition._from || route_promo_condition._to) {
                p_active[index] = true
                if(route_ispromo === 'Y') {
                    const scp = route.querySelector('.summary-current-price')
                    // const spa = route.querySelector('.summary-promo-avaliable')
                    scp.classList.remove('d-none')
                    // spa.classList.remove('d-none')
                    scp.querySelector('.current-price').innerHTML = c_price[index]
                    const discount = promotionPriceCal(c_price[index], promo.discount, promo.discount_type)
                    promo_price.innerHTML = numberFormat(discount)
                }
            }
            else {
                p_active[index] = false
            }
        })

        if(r_index !== null) {
            const discount = promotionPriceCal(c_price[r_index], promo.discount, promo.discount_type)
            const is_discount = parseInt(c_price[r_index].replace(/,/g, "")) - discount
            const discount_price = document.querySelector('.your-booking-discount-price')
            if(p_select === 'Y' && p_active[r_index]) {
                discount_price.innerHTML = `- ${numberFormat(is_discount)} <small class="smaller">THB</small>`
                if(type === 'depart') price.depart = discount
                if(type === 'return') price.return = discount
                updateSumPrice()
            }
            else
                discount_price.innerHTML =`0 <small class="smaller">THB</small>`
        }

        use_promocode.value = _promocode
        updateDiscountByBookingSummary(type)
    }
    else {
        if(c_price.length > 0) {
            route_list.forEach((route, index) => {
                const scp = route.querySelector('.summary-current-price')
                // const spa = route.querySelector('.summary-promo-avaliable')
                scp.classList.add('d-none')
                // spa.classList.add('d-none')

                const promo_price = route.querySelector('.route-price')
                promo_price.classList.remove('text-warning')
                promo_price.innerHTML = numberFormat(c_price[index])
            })
        }

        updateFreeAddon('shuttle_bus', 'N')
        updateFreeAddon('longtail_boat', 'N')
        updateFreeAddon('private_taxi', 'N')

        if(r_index !== null) {
            if(c_price.length > 0) {
                if(type === 'depart') price.depart = parseInt(c_price[r_index].replace(/,/g, ""))
                if(type === 'return') price.return = parseInt(c_price[r_index].replace(/,/g, ""))
                updateSumPrice()
            }
        }

        promo = null
    }

    document.querySelector('.booking-promocode-input').classList.remove('border-danger')
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

function clearRouteToDefault(route_list, type) {
    let c_price = type === 'depart' ? current_price.depart : current_price.return
    let route_index = type === 'depart' ? route_selected_index.depart : route_selected_index.return
    let route_price = type === 'depart' ? price.depart : price.return

    if(c_price.length > 0) {
        route_list.forEach((route, index) => {
            const scp = route.querySelector('.summary-current-price')
            // const spa = route.querySelector('.summary-promo-avaliable')
            scp.classList.add('d-none')
            // spa.classList.add('d-none')

            const promo_price = route.querySelector('.route-price')
            promo_price.innerHTML = numberFormat(c_price[index])
        })
    }

    if(route_index !== null) {
        if(c_price.length > 0) {
            route_price = parseInt(c_price[route_index].replace(/,/g, ""))
            updateSumPrice()
        }
    }
}

function editPromotionCode() {
    // document.querySelector('.your-booking-promocode').classList.remove('d-none')
}

let summary_discount = { depart: 0, return: 0 }
function updateDiscountByBookingSummary(type) {
    const p_select = type === 'depart' ? promocode_select.depart : promocode_select.return
    const c_price = type === 'depart' ? current_price.depart : current_price.return
    const r_select = type === 'depart' ? route_selected_index.depart : route_selected_index.return
    const p_active = type === 'depart' ? promo_active.depart : promo_active.return
    const booking_discount = document.querySelector('.your-booking-discount')
    if(p_select === 'Y' && p_active[r_select]) {
        booking_discount.classList.remove('d-none')
        const discount = promotionPriceCal(c_price[r_select], promo.discount, promo.discount_type)
        if(type === 'depart') summary_discount.depart = parseInt(c_price[r_select].replace(/,/g, "")) - discount
        if(type === 'return') summary_discount.return = parseInt(c_price[r_select].replace(/,/g, "")) - discount
        const summary = summary_discount.depart + summary_discount.return
        const neg = summary === 0 ? '' : '-'
        document.querySelector('.your-booking-discount-price').innerHTML = `${neg} ${numberFormat(summary)} <small class="smaller">THB</small>`
    }
    else {
        if(type === 'depart') summary_discount.depart = 0
        if(type === 'return') summary_discount.return = 0
        const summary = summary_discount.depart + summary_discount.return
        const neg = summary === 0 ? '' : '-'
        document.querySelector('.your-booking-discount-price').innerHTML = `${neg} ${numberFormat(summary)} <small class="smaller">THB</small>`
    }
}

let current_price_ = { depart: [], return: [] }
let _summary = { depart: 0, return: 0 }
function updateDiscountBySearchForm(type) {
    const _promocode = document.querySelector('[name="use_promocode"]').value

    if(_promocode !== '') {
        const p_select = type === 'depart' ? promocode_select.depart : promocode_select.return
        const c_price = type === 'depart' ? current_price_.depart : current_price_.return
        const r_select = type === 'depart' ? route_selected_index.depart : route_selected_index.return
        const route_price = type === 'depart' ? price.depart : price.return
        const s_promo = type === 'depart' ? selected_promo.depart : selected_promo.return

        const booking_discount = document.querySelector('.your-booking-discount')
        const booking_discount_price = document.querySelector('.your-booking-discount-price')

        current_price_.depart = []
        current_price_.return = []
        const _current_price = document.querySelectorAll(`.price-position-set-${type}`)
        _current_price.forEach((c, i) => {
            if(c.querySelector('.current-price')) c_price.push(c.querySelector('.current-price').innerText)
            else c_price.push(c.querySelector('.route-price').innerText)
        })

        if(p_select === 'Y' && s_promo) {
            booking_discount.classList.remove('d-none')
            const _promocode = document.querySelector('[name="use_promocode"]').value
            document.querySelector('.your-booking-promocode-discount').innerHTML = `[${_promocode}]`
            const discount = parseInt(c_price[r_select].replace(/,/g, ""))
            if(type === 'depart') _summary.depart = discount - route_price
            if(type === 'return') _summary.return = discount - route_price
            let summary = _summary.depart + _summary.return
            const neg = summary === 0 ? '' : '-'
            booking_discount_price.innerHTML = `${neg} ${numberFormat(summary)} <small class="smaller">THB</small>`
        }
        else {
            if(type === 'depart') _summary.depart = 0
            if(type === 'return') _summary.return = 0
            let summary = _summary.depart + _summary.return
            const neg = summary === 0 ? '' : '-'
            booking_discount_price.innerHTML = `${neg} ${numberFormat(summary)} <small class="smaller">THB</small>`
        }
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
    data.append('trip_type', 'round-trip')
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
