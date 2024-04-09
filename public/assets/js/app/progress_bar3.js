const booking_routes = document.querySelectorAll('.booking-route-select')
let route_selected = []
let _route_selected = []
let icon_selected = []
let price_all = []
let sum_price = []
let is_passenger = []
let route_price = 0
let premium_price = 0
let extra_price = 0
let addon_route = []
let payment_info = {
    route_selected: [],
    extra_selected: []
}
let route_promo = []
let selected_promo = []
let set_extra = 0
let promocode_from = []
let promocode_to = []
let promocode_route = []
let promocode_premiumflex = 'N'
let promocode_addon = 'N'
let promocode_select = []
let promo = null
let summary_discount = []
let is_current_price = []
let _summary = []
let promocode_active = false
let full_price = []

if(booking_routes) {
    const destination = document.querySelector('.popover-destinations')

    booking_routes.forEach((route, index) => {
        route_selected.push([])
        _route_selected.push([])
        promocode_select.push([])
        icon_selected.push([])
        addon_route.push([])
        route_promo.push([])
        selected_promo.push([])
        payment_info.extra_selected.push([])
        sum_price.push(0)
        full_price.push(0)
        let route_list = route.querySelectorAll('.booking-route-list')
        let btn_route_list = document.querySelectorAll(`.btn-route-list_${index}`)
        const route_addon_checked = route.querySelectorAll(`.route-addon-checked-${index}`)
        const route_addon_detail = document.querySelectorAll(`.route-addon-detail-${index}`)

        let _depart_name = document.querySelector(`.depart-station-name-${index}`).innerText
        let _arrive_name = document.querySelector(`.arrive-station-name-${index}`).innerText
        let _travel_date = document.querySelector(`.travel-date-${index}`).innerText
        route_list.forEach((route, key) => {
            _route_selected[index] = false
            promocode_select[index] = 'N'
            summary_discount[index] = 0
            is_current_price[index] = []
            _summary[index] = 0

            let btn_select = document.querySelector(`.btn-route-select-${index}_${key}`)
            btn_select.addEventListener('click', (e) => {
                // set route //////////////////////////////////////////
                route_list.forEach((item) => {
                    item.classList.remove('active')
                })
                btn_route_list.forEach((btn) => {
                    btn.disabled = false
                    btn.innerText = 'Select'
                })
                btn_select.disabled = true
                btn_select.innerText = 'Selected'

                let is_promo_selected = route.querySelector('.promo-avaliable')
                if(is_promo_selected) selected_promo[index] = true
                else selected_promo[index] = false

                if(document.querySelector('.promo-price')) route_promo[index] = true
                else route_promo[index] = false

                let route_active = document.querySelector(`.list-position_${route.dataset.list}_${route.dataset.key}`)
                route_active.classList.add('active')
                route_active.classList.remove('route-hover')
                route_selected[index] = key
                _route_selected[index] = true
                promocode_select[index] = route.querySelector('.route-status').value

                let selected_route = document.querySelector(`.selected-route-${index}_${key}`)
                let departdate = document.querySelector(`.travel-date-${index}`)

                document.querySelector(`[name="booking_route_selected[${index}]"]`).value = selected_route.value
                document.querySelector(`[name="departdate[${index}]"]`).value = departdate.innerText

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

                const set_price = route.querySelector('.price-position-set')
                const _crnt_pr = set_price.querySelector('.current-price')
                full_price[index] = parseInt(_crnt_pr.innerText.replace(/,/g, ""))

                let price_list = []
                price_list.push(route.querySelector('.selected-adult-price').value)
                price_list.push(route.querySelector('.selected-child-price').value)
                price_list.push(route.querySelector('.selected-infant-price').value)
                price_all[index] = price_list

                let total_price = sum_price.reduce((num1, num2) => { return num1+num2 })
                document.querySelector('#sum-price').innerHTML = `${total_price.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })}`
                // END set price ///////////////////////////////////

                let _full_price = full_price.reduce((num1, num2) => { return num1 + num2 })
                // set Yout Booking
                document.querySelector('.your-booking-summary').classList.remove('d-none')
                document.querySelector(`.your-booking-depart-time-${index}`).innerHTML = `<i class="fa-regular fa-clock"></i> ${route.querySelector('.depart-time').innerText}`
                document.querySelector(`.your-booking-destination-from-${index}`).innerHTML = '<i class="fa-solid fa-ship"></i> ' + route.querySelector(`.station-from-text-${index}-${key}`).innerText
                document.querySelector(`.your-booking-arrive-time-${index}`).innerHTML = `<i class="fa-regular fa-clock"></i> ${route.querySelector('.arrival-time').innerText}`
                document.querySelector(`.your-booking-destination-to-${index}`).innerHTML = '<i class="fa-solid fa-anchor"></i> ' + route.querySelector(`.station-to-text-${index}-${key}`).innerText
                document.querySelector('.your-booking-fare').innerHTML = `${_full_price.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} <small class="smaller">THB</small>`
                document.querySelector('.your-booking-amount').innerHTML = `${total_price.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} <small class="smaller">THB</small>`

                // save route to payment /////////////////////////////
                payment_info.route_selected[index] = {
                    'depart': _depart_name,
                    'arrive': _arrive_name,
                    'depart_time': route.querySelector('.depart-time').innerText,
                    'arrive_time': route.querySelector('.arrival-time').innerText,
                    'travel_date': _travel_date,
                    'route_price': parseToNumber(route.querySelector('.route-price').innerText),
                    'icons': icon_list
                }

                route_addon_checked.forEach((addon) => {
                    addon.checked = false
                    addon.name = ''
                    addon.disabled = true
                })
                route_addon_detail.forEach((detail) => { detail.name = '' })

                // END save route to payment /////////////////////////////

                let ch_r = route_selected.filter((r) => { return r.length === 0 })
                if(ch_r.length === 0)
                    document.querySelector('#progress-next').disabled = false

                updateDiscountByBookingSummary(index)
                // if(promo === null) updateDiscountBySearchForm(index)
                // else updateDiscountByBookingSummary(index)
            })
        })

        destination.dataset.bsContent += `<p class="popover-destination-list"><i class="fa-solid fa-location-dot me-2"></i> ${_depart_name} <i class="fa-solid fa-arrow-right mx-2"></i> ${_arrive_name} <br/><i class="fa-regular fa-calendar-days me-2 mb-2"></i> ${_travel_date}</p>`
    })

    const main_route = document.querySelector('#booking-multi-route-select')
    const booking_discount = document.querySelector('.your-booking-discount')
    const use_promocode = document.querySelector('[name="use_promocode"]')
    const promocode = document.querySelector('.booking-promocode-input')
    if(use_promocode.value !== '') {
        promocode.value = use_promocode.value
        promocodeProcess(use_promocode.value, main_route, booking_discount)
    }
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
        document.querySelector('#btn-back-to-home').classList.remove('d-none')
        document.querySelector('#progress-prev').classList.add('d-none')

        booking_routes.forEach((routes) => {
            let route_list = routes.querySelectorAll('.booking-route-list')
            route_list.forEach((route) => {
                if(route.classList.contains('active')) document.querySelector('#progress-next').disabled = false
            })
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
        let _selected_promo = selected_promo.find((s) => { return s === true })

        const txt_price = document.querySelector('.is-premium-price')
        const your_booking = document.querySelector('.your-booking-premium-flex')
        const ispremiumflex = document.querySelector('#is-premiumflex')
        const nonePremiumFlex = document.querySelector('#none-premiumflex')
        let _route_price = sum_price.reduce((num1, num2) => { return num1+num2 })
        let _premium_price = ((_route_price*110)/100) - _route_price
        // let _premium_price = promo_premiumflex === 'Y' ? 0 : ((_route_price*110)/100) - _route_price

        // console.log(select_promo)
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
    else if(step !== 'passenger') {
        progress_next.classList.remove('d-none')
        progress_payment.classList.add('d-none')
        progress_payment.disabled = true
    }

    if(step === 'extra') {
        const r_extra = document.querySelector('#booking-multi-route-extra')
        const ex_route = r_extra.querySelectorAll('.booking-route-extra')
        // extra_price = 0
        // addon_route = []
        ex_route.forEach((_extra, ex_index) => {
            let list_index = _extra.dataset.list
            // addon_route.push([])
            // const shuttlebus_list = _extra.querySelectorAll('.route-shuttle-bus')
            // const longtailboat_list = _extra.querySelectorAll('.route-longtail-boat')
            const meal_list = _extra.querySelectorAll(`.route-meal`)
            const activity_list = _extra.querySelectorAll('.route-activity')
            const route_addon_lists = _extra.querySelectorAll(`.route-addon-lists-${ex_index}`)
            const route_addon_checked = _extra.querySelectorAll(`.route-addon-checked-${ex_index} input`)

            if(set_extra === 0) {
                let route_addons = _extra.querySelectorAll(`.route-addon-index-${route_selected[list_index]}-${ex_index}`)
                route_addon_lists.forEach((item) => {
                    let uncheck = item.querySelectorAll(`input[type="checkbox"]`)
                    uncheck.forEach((uc) => {
                        // uc.checked = true
                        let type = uc.dataset.type
                        let subtype = uc.dataset.subtype
                        let routeindex = uc.dataset.routeindex
                        let addon_detail = document.querySelector(`.addon-detail-${type}-${subtype}-${routeindex}-${ex_index}`)
                        uc.name = ``
                        addon_detail.name = ``
                    })
                    item.classList.add('d-none')

                })
                route_addons.forEach((item) => {
                    // let check = item.querySelectorAll(`input[type="checkbox"]`)
                    // check.forEach((c) => {
                    //     c.checked = true
                    //     let type = c.dataset.type
                    //     let subtype = c.dataset.subtype
                    //     let routeindex = c.dataset.routeindex
                    //     let addon_name = document.querySelector(`.addon-name-${type}-${subtype}-${routeindex}-${ex_index}`)
                    //     let addon_price = document.querySelector(`.${type}-${subtype}-${routeindex}-${ex_index}`)
                    //     let addon_detail = document.querySelector(`.addon-detail-${type}-${subtype}-${routeindex}-${ex_index}`)
                    //     addon_route[ex_index].push({'name': addon_name.innerText, 'price': addon_price.value, 'type': `${type}-${subtype}-${routeindex}-${ex_index}`})
                    //     c.name = `route_addon[${ex_index}][]`
                    //     addon_detail.name = `route_addon_detail[${ex_index}][]`
                    //     extra_price += parseInt(addon_price.value)
                    // })
                    document.querySelector('.your-booking-extra').classList.remove('d-none')
                    item.classList.remove('d-none')
                    updateSumPrice()
                })
            }

            route_addon_checked.forEach((route_addon) => {
                route_addon.addEventListener('change', (e) => {
                    set_extra = 1
                    // let type = e.target.dataset.type
                    // let subtype = e.target.dataset.subtype
                    // let routeindex = e.target.dataset.routeindex
                    // let addon_name = document.querySelector(`.addon-name-${type}-${subtype}-${routeindex}-${ex_index}`)
                    // let addon_price = document.querySelector(`.${type}-${subtype}-${routeindex}-${ex_index}`)
                    // let addon_detail = document.querySelector(`.addon-detail-${type}-${subtype}-${routeindex}-${ex_index}`)
                    // if(e.target.checked) {
                    //     let addon_index = addon_route[ex_index].findIndex((addon) => { return addon.type === `${type}-${subtype}-${routeindex}-${ex_index}` })
                    //     if(addon_index < 0) addon_route[ex_index].push({'name': addon_name.innerText, 'price': addon_price.value, 'type': `${type}-${subtype}-${routeindex}-${ex_index}`})
                    //     extra_price += parseInt(addon_price.value)
                    //     e.target.name = `route_addon[${ex_index}][]`
                    //     addon_detail.name = `route_addon_detail[${ex_index}][]`
                    //     addon_detail.disabled = false
                    //     updateSumPrice()
                    // }
                    // else {
                    //     let addon_index = addon_route[ex_index].findIndex((addon) => { return addon.type === `${type}-${subtype}-${routeindex}-${ex_index}` })
                    //     if(addon_index >= 0) addon_route[ex_index].splice(addon_index, 1)
                    //     extra_price -= parseInt(addon_price.value)
                    //     e.target.name = ''
                    //     addon_detail.name = ''
                    //     addon_detail.value = ''
                    //     addon_detail.disabled = true
                    //     updateSumPrice()
                    // }
                })
            })

            // let shuttlebus_selected = _extra.querySelector(`#route-shuttle-bus-index-${list_index}_${route_selected[list_index]}`)
            // shuttlebus_list.forEach((item) => { item.classList.add('d-none') })
            // shuttlebus_selected.classList.remove('d-none')

            // let longtailboat_selected = _extra.querySelector(`#route-longtail-boat-index-${list_index}_${route_selected[list_index]}`)
            // longtailboat_list.forEach((item) => { item.classList.add('d-none') })
            // longtailboat_selected.classList.remove('d-none')

            let meal_select = _extra.querySelector(`#route-meal-index-${list_index}_${route_selected[list_index]}`)
            meal_list.forEach((item) => { item.classList.add('d-none') })
            meal_select.classList.remove('d-none')

            let activity_select = _extra.querySelector(`#route-activity-index-${list_index}_${route_selected[list_index]}`)
            activity_list.forEach((item) => { item.classList.add('d-none') })
            activity_select.classList.remove('d-none')
        })

        const passenger_next = document.querySelector('#progress-next-passenger')
        progress_next.classList.remove('d-none')
        passenger_next.classList.add('d-none')
        passenger_next.disabled = true
    }

    if(step === 'payment') {
        setLitineraryQue()
        setPassengerDetail()
        setExtraDetail()

        progress_next.classList.add('d-none')
        progress_payment.classList.remove('d-none')
        if(payment_selected) progress_payment.disabled = false
    }
}

function selectRouteAddon(e, ex_index) {
    let type = e.dataset.type
    let subtype = e.dataset.subtype
    let routeindex = e.dataset.routeindex
    let addon_id = e.dataset.addon
    let addon_name = document.querySelector(`.addon-name-${type}-${subtype}-${routeindex}-${ex_index}`)
    let addon_price = document.querySelector(`.${type}-${subtype}-${routeindex}-${ex_index}`)
    let addon_detail = document.querySelector(`.addon-detail-${type}-${subtype}-${routeindex}-${ex_index}`)
    if(e.checked) {
        let addon_index = addon_route[ex_index].findIndex((addon) => { return addon.type === `${type}-${subtype}-${routeindex}-${ex_index}` })
        if(addon_index < 0) addon_route[ex_index].push({'id': addon_id, 'name': addon_name.innerText, 'price': addon_price.value, 'type': `${type}-${subtype}-${routeindex}-${ex_index}`})
        extra_price += parseInt(addon_price.value)
        e.name = `route_addon[${ex_index}][]`
        addon_detail.name = `route_addon_detail[${ex_index}][]`
        addon_detail.disabled = false
        updateSumPrice()
    }
    else {
        let addon_index = addon_route[ex_index].findIndex((addon) => { return addon.type === `${type}-${subtype}-${routeindex}-${ex_index}` })
        if(addon_index >= 0) addon_route[ex_index].splice(addon_index, 1)
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

async function setLitineraryQue() {
    await setLitinerary()
    await setHeightChild()
}

function clearElementDiv(element) {
    const div_list = element.querySelectorAll('div')
    div_list.forEach((div) => { div.remove() })
}

function setHeightChild() {
    let _div_index = document.querySelector(`.div-index-0`)
    let is_height = _div_index.getBoundingClientRect()
    let childs = document.querySelectorAll(`.child-right`)
    childs.forEach((child) => {
        child.setAttribute('style', `height: ${is_height.height}px`)
    })
}

function setFullDate(date) {
    const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']
    const months = ["January", "February", "March", "April", "May", "June", "July", "August",
                    "September", "October", "November", "December"]

    let _format = date.split('/')
    let _date = `${_format[2]}-${_format[1]}-${_format[0]}`
    let n_date = new Date(_date)
    let dayName = days[n_date.getDay()]
    let monthName = months[n_date.getMonth()]
    return `${dayName} ${_format[0]} ${monthName} ${_format[2]}`
}

function setLitinerary() {
    let sum_of_payment = 0
    let sum_of_price = 0
    let promo_sum = document.querySelector('.sum-of-promocode')
    const set_litinerry = document.querySelector('#set-litinerary')
    // console.log(selected_promo)
    // console.log(route_promo)
    clearElementDiv(set_litinerry)
    payment_info.route_selected.forEach((route, index) => {
        let sum_price_loop = 0
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
        p_date.innerHTML = `<span class="badge bg-booking-select-depart fw-bold">Multiple trip</span> : ${setFullDate(route.travel_date)}`
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

        // console.log(price_all[index])
        let adult_price = document.querySelector(`.payment-adult-price-${index}`)
        let adult_qty = document.querySelector('#passenger-adult')
        let adult_sum = document.querySelector(`.sum-of-adult-${index}`)
        if(adult_price) adult_price.innerHTML = parseToNumber(price_all[index][0]).toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
        if(adult_sum) {
            let price = parseToNumber(adult_qty.value)*parseToNumber(price_all[index][0])
            sum_of_price += price
            sum_price_loop += price
            adult_sum.innerHTML = price.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
        }

        let child_price = document.querySelector(`.payment-child-price-${index}`)
        let child_qty = document.querySelector('#passenger-child')
        let child_sum = document.querySelector(`.sum-of-child-${index}`)
        if(child_price) child_price.innerHTML = parseToNumber(price_all[index][1]).toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
        if(child_sum) {
            let price = parseToNumber(child_qty.value)*parseToNumber(price_all[index][1])
            sum_of_price += price
            sum_price_loop += price
            child_sum.innerHTML = price.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
        }

        let infant_price = document.querySelector(`.payment-infant-price-${index}`)
        let infant_qty = document.querySelector('#passenger-infant')
        let infant_sum = document.querySelector(`.sum-of-infant-${index}`)
        if(infant_price) infant_price.innerHTML = parseToNumber(price_all[index][2]).toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
        if(infant_sum) {
            let price = parseToNumber(infant_qty.value)*parseToNumber(price_all[index][2])
            sum_of_price += price
            sum_price_loop += price
            infant_sum.innerHTML = price.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
        }

        document.querySelector(`.total-route-${index}`).innerHTML = sum_price_loop.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })

        sum_of_payment+= route.route_price
    })

    document.querySelector('.sum-of-payment').innerHTML = sum_of_price.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
    document.querySelector('.sum-of-premium').innerHTML = premium_price.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })

    const addon_list = document.querySelector('.amount-detail-list')
    const addon_lists = addon_list.querySelectorAll('.addon-route-detail')
    addon_lists.forEach((list) => { list.remove() })
    for(i = 0; i < addon_route.length; i++) {
        addon_route[i].forEach((addon) => {
            let h6 = document.createElement('h6')
            h6.setAttribute('class', 'd-flex justify-content-end align-items-end addon-route-detail')
            h6.innerHTML = `[Trip ${i+1}] ${addon.name} <p class="w--20 w-sm-30 me-2 mb-0"> ${addon.price} </p><small class="smaller">THB</small>`
            addon_list.appendChild(h6)
        })
    }

    for(i = 0; i < route_promo.length; i++) {
        if(selected_promo[i]) {
            let _discount = sum_of_payment - sum_of_price
            document.querySelector('.promocode-show').classList.remove('d-none')
            promo_sum.innerHTML = _discount.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
        }
        // else {
        //     document.querySelector('.promocode-show').classList.add('d-none')
        //     promo_sum.innerHTML = 0
        // }
    }

    document.querySelector('.sum-amount').innerHTML = (sum_of_payment + premium_price).toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
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
    const set_extra = extra_service.querySelector('#set-extra-service')
    clearElementDiv(set_extra)

    payment_info.extra_selected.forEach((extras, index) => {
        if(extras.length > 0) {
            let div_index = document.createElement('div')
            div_index.setAttribute('class', `div-index-${index} border-bottom border-warning pb-3 mb-3`)

            let h_route = document.createElement('h5')
            h_route.innerHTML = `${payment_info.route_selected[index].depart} - ${payment_info.route_selected[index].arrive}`
            div_index.appendChild(h_route)

            let col_12_loop = document.createElement('div')
            col_12_loop.setAttribute('class', `col-12 extra-service-${index} ps-3`)
            div_index.appendChild(col_12_loop)

            let set_extra_suttlebus = document.createElement('div')
            set_extra_suttlebus.setAttribute('class', 'row mb-3 d-none')
            col_12_loop.appendChild(set_extra_suttlebus)

            let set_extra_longtailboat = document.createElement('div')
            set_extra_longtailboat.setAttribute('class', 'row mb-3 d-none')
            col_12_loop.appendChild(set_extra_longtailboat)

            let set_extra_meal = document.createElement('div')
            set_extra_meal.setAttribute('class', 'row mb-3 d-none')
            col_12_loop.appendChild(set_extra_meal)

            let set_extra_activity = document.createElement('div')
            set_extra_activity.setAttribute('class', 'row mb-3 d-none')
            col_12_loop.appendChild(set_extra_activity)

            // let _extra = Object.groupBy(extras, ex => { return ex.type })
            let _extra2 = extras.reduce((acc, data) => {
                (acc[data['type']] = acc[data['type']] || []).push(data);
                return acc;
            }, {})

            if(_extra2['bus']) {
                set_extra_suttlebus.classList.remove('d-none')
                let row = document.createElement('div')
                let col_12 = document.createElement('div')
                let header = document.createElement('p')

                row.setAttribute('class', 'row')
                col_12.setAttribute('class', 'col-12')
                header.setAttribute('class', 'mb-1 fw-bold text-dark')
                header.innerHTML = 'Shuttle Bus'

                set_extra_suttlebus.appendChild(row)
                row.appendChild(col_12)
                col_12.appendChild(header)

                _extra2['bus'].forEach((bus) => {
                    sum += bus.qty*bus.amount
                    let p = document.createElement('p')
                    p.setAttribute('class', 'mb-2 ms-2 text-dark')
                    p.innerHTML = `<i class="fa-solid fa-van-shuttle fs-3 me-3"></i> ${bus.name} - [ <strong>Fare </strong> ${bus.qty} x ${bus.amount.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} ] : ${(bus.qty*bus.amount).toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} THB`
                    set_extra_suttlebus.appendChild(p)
                })
            }

            if(_extra2['boat']) {
                set_extra_longtailboat.classList.remove('d-none')
                let row = document.createElement('div')
                let col_12 = document.createElement('div')
                let header = document.createElement('p')

                row.setAttribute('class', 'row')
                col_12.setAttribute('class', 'col-12')
                header.setAttribute('class', 'mb-1 fw-bold text-dark')
                header.innerHTML = 'Longtail Boat'

                set_extra_longtailboat.appendChild(row)
                row.appendChild(col_12)
                col_12.appendChild(header)

                _extra2['boat'].forEach((boat) => {
                    sum += boat.qty*boat.amount
                    let p = document.createElement('p')
                    p.setAttribute('class', 'mb-2 ms-2 text-dark')
                    p.innerHTML = `<i class="fa-solid fa-sailboat fs-3 me-3"></i> ${boat.name} - [ <strong>Fare </strong> ${boat.qty} x ${boat.amount.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} ] : ${(boat.qty*boat.amount).toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} THB`
                    set_extra_longtailboat.appendChild(p)
                })
            }

            if(_extra2['meal']) {
                set_extra_meal.classList.remove('d-none')
                let row = document.createElement('div')
                let col_12 = document.createElement('div')
                let header = document.createElement('p')

                row.setAttribute('class', 'row')
                col_12.setAttribute('class', 'col-12')
                header.setAttribute('class', 'mb-1 fw-bold text-dark')
                header.innerHTML = 'Meal'

                set_extra_meal.appendChild(row)
                row.appendChild(col_12)
                col_12.appendChild(header)

                _extra2['meal'].forEach((meal) => {
                    sum += meal.qty*meal.amount
                    let p = document.createElement('p')
                    p.setAttribute('class', 'mb-2 ms-2 text-dark')
                    p.innerHTML = `<img src="${meal.icon}" class="me-3" width="40" height="auto"> ${meal.name} - [ <strong>Fare </strong> ${meal.qty} x ${meal.amount.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} ] : ${(meal.qty*meal.amount).toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} THB`
                    set_extra_meal.appendChild(p)
                })
            }

            if(_extra2['activity']) {
                set_extra_activity.classList.remove('d-none')
                let row = document.createElement('div')
                let col_12 = document.createElement('div')
                let header = document.createElement('p')

                row.setAttribute('class', 'row')
                col_12.setAttribute('class', 'col-12')
                header.setAttribute('class', 'mb-1 fw-bold text-dark')
                header.innerHTML = 'Activity'

                set_extra_activity.appendChild(row)
                row.appendChild(col_12)
                col_12.appendChild(header)

                _extra2['activity'].forEach((activity) => {
                    sum += activity.qty*activity.amount
                    let p = document.createElement('p')
                    p.setAttribute('class', 'mb-2 ms-2 text-dark')
                    p.innerHTML = `<img src="${activity.icon}" class="me-3" width="40" height="auto"> ${activity.name} - [ <strong>Fare </strong> ${activity.qty} x ${activity.amount.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} ] : ${(activity.qty*activity.amount).toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} THB`
                    set_extra_activity.appendChild(p)
                })
            }

            set_extra.appendChild(div_index)
        }
    })

    if(extra_price === 0) extra_service.classList.add('d-none')
    else {
        document.querySelector('#sum-of-extra').innerHTML = extra_price.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })
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
    const el = document.querySelector(`#extra-${element}-index-${index}_${route_index}`)
    const icon = document.querySelector(`#extra-${element}-img-${index}_${route_index}`)
    const name = document.querySelector(`#extra-${element}-name-${index}_${route_index}`)
    const amount = document.querySelector(`.extra-${element}-amount-${index}_${route_index}`)
    let qty = parseInt(el.value) + 1
    el.value = qty
    let _extra_amount = parseToNumber(amount.innerText)
    extra_price+= _extra_amount
    let ico_src = icon === null ? '' : icon.src
    setExtra(ico_src, name.innerText, _extra_amount, qty, element, route_index)
    updateSumPrice()
}

function dec(element, index, route_index) {
    const el = document.querySelector(`#extra-${element}-index-${index}_${route_index}`)
    const icon = document.querySelector(`#extra-${element}-img-${index}_${route_index}`)
    const name = document.querySelector(`#extra-${element}-name-${index}_${route_index}`)
    const amount = document.querySelector(`.extra-${element}-amount-${index}_${route_index}`)
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
    let result_extra = 0
    let result_premuim_price = 0
    let your_booking = {
        premium_flex: document.querySelector('.your-booking-premium-flex-price'),
        extra: document.querySelector('.your-booking-extra-price'),
        total: document.querySelector('.your-booking-amount')
    }
    const person_adult = document.querySelector('.person-adult-icon').innerText
    const person_child = document.querySelector('.person-child-icon').innerText
    const person_infant = document.querySelector('.person-infant-icon').innerText
    const person_all = parseInt(person_adult) + parseInt(person_child) + parseInt(person_infant)

    if(promocode_premiumflex === 'N') {
        result_premuim_price = premium_price
        let price_status = result_premuim_price > 0 ? '+ ' : ''
        your_booking.premium_flex.innerHTML = `${price_status}${result_premuim_price.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} <small class="smaller">THB</small>`
    }
    else {
        result_premuim_price = 0
        let price_status = premium_price > 0 ? '- ' : ''
        your_booking.premium_flex.innerHTML = `${price_status}${premium_price} <small class="smaller">THB</small>`
    }

    addon_route.forEach((item) => {
        if(item.length > 0) {
            item.forEach((a) => { result_extra += parseInt(a.price) })
        }
    })

    your_booking.extra.innerHTML = `${person_all} x ${result_extra.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} <small class="smaller">THB</small>`

    // console.log(is_current_price)
    let total_route = sum_price.reduce((num1, num2) => { return num1+num2 })
    let sum_amount = total_route + (person_all * result_extra) + result_premuim_price
    let sum_amount_digit = `${sum_amount.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })}`
    document.querySelector('#sum-price').innerHTML = sum_amount_digit
    your_booking.total.innerHTML = `${sum_amount_digit} <small class="smaller">THB</small>`
}

function setExtra(icon, name, amount, qty, type, route_index) {
    let _extra = {
        'type': type,
        'name': name,
        'icon': icon,
        'qty': qty,
        'amount': amount
    }

    if(qty > 0) {
        let index = payment_info.extra_selected[route_index].findIndex(extra => { return extra.name === name && extra.type === type })
        if(index >= 0) payment_info.extra_selected[route_index][index].qty = qty
        else payment_info.extra_selected[route_index].push(_extra)
    }
    else {
        let index = payment_info.extra_selected[route_index].findIndex(extra => { return extra.name === name && extra.type === type })
        payment_info.extra_selected[route_index].splice(index, 1)
    }

    // console.log(payment_info.extra_selected)
}


// promotion controller
const promoSubmit = document.querySelector('#button-promocode-submit')
const current_price = []
let promo_active = []
if(promoSubmit) {
    const promocode = document.querySelector('.booking-promocode-input')
    const main_route = document.querySelector('#booking-multi-route-select')
    // const booking_date = document.querySelector('.is-booking-date')
    // const route_list = booking_routes.querySelectorAll('.booking-route-list')
    promoSubmit.addEventListener('click', async () => {
        const _promocode = promocode.value
        const booking_discount = document.querySelector('.your-booking-discount')

        if(_promocode !== '') {
            await promocodeProcess(promocode.value, main_route, booking_discount)
        }
        else {
            document.querySelector('.booking-promocode-input').classList.add('border-danger')
            document.querySelector('.your-booking-discount').classList.add('d-none')
        }
    })
}

async function promocodeProcess(_promocode, main_route, booking_discount) {
    const use_promocode = document.querySelector('[name="use_promocode"]')
    const multi_route = main_route.querySelectorAll('.booking-multi-route')
    const last_route = multi_route.length
    promocode_active = false
    promocode_premiumflex = 'N'

    multi_route.forEach(async (sub_route, index) => {
        const booking_date = sub_route.querySelector('.is-booking-date')
        const _departdate = await dateFormatSet(booking_date.innerText)
        const result = await getPromoCode(_promocode, _departdate)
        current_price.push([])

        if(result.data !== null && result.data.result) {
            // edit button
            // const btn_cancel = `<i class="fa-solid fa-pen-to-square text-primary cursor-pointer cancel-promocode" onClick="editPromotionCode()" title="Edit Promocode"></i>`
            // document.querySelector('.your-booking-promocode-discount').innerHTML = `[${_promocode}] ${btn_cancel}`

            booking_discount.classList.remove('d-none')
            promocode_from = result.data.promo_line.from
            promocode_to = result.data.promo_line.to
            promocode_route = result.data.promo_line.route

            promo = await result.data.data
            promocode_active = true
            const discount_type = promo.discount_type === 'PERCENT' ? '%' : 'THB'
            document.querySelector('.your-booking-promocode-discount-amount').innerHTML = `${parseInt(promo.discount)}${discount_type}`

            if(index === 0) {
                promocode_premiumflex = promo.isfreepremiumflex === 'Y' ? 'Y' : 'N'
                if(promo.isfreepremiumflex === 'Y') {
                    document.querySelector('.is-premium-price').innerHTML = '0'
                    document.querySelector('.your-booking-premium-flex-price').innerHTML = '0 <small class="smaller">THB</small>'
                }
            }

            promo_active.push([])
            const route_list = sub_route.querySelectorAll('.booking-route-list')

            clearRouteToDefault(main_route, index)
            route_list.forEach((route, key) => {
                const station_from_id = route.querySelector(`.station-from-text-${index}-${key}`).dataset.id
                const station_to_id = route.querySelector(`.station-to-text-${index}-${key}`).dataset.id
                const route_id = route.dataset.id

                const route_ispromo = route.querySelector('.route-status').value
                const promo_price = route.querySelector('.route-price')
                if(current_price[index].length < route_list.length)
                    current_price[index].push(promo_price.innerText)

                const route_promo_condition = promoCondition(route_id, station_from_id, station_to_id)
                if(route_promo_condition._route || route_promo_condition._from || route_promo_condition._to) {
                    promo_active[index][key] = true
                    if(route_ispromo === 'Y') {
                        const scp = route.querySelector('.summary-current-price')
                        // const spa = route.querySelector('.summary-promo-avaliable')
                        scp.classList.remove('d-none')
                        // spa.classList.remove('d-none')
                        scp.querySelector('.current-price').innerHTML = current_price[index][key]
                        const discount = promotionPriceCal(current_price[index][key], promo.discount, promo.discount_type)
                        promo_price.innerHTML = numberFormat(discount)
                    }
                }
                else {
                    promo_active[index][key] = false
                }

                updateFreeAddon('shuttle_bus', index, key, promo.isfreeshuttlebus)
                updateFreeAddon('longtail_boat', index, key, promo.isfreelongtailboat)
                updateFreeAddon('private_taxi', index, key, promo.isfreeprivatetaxi)
            })

            if(_route_selected[index]) {
                const discount = promotionPriceCal(current_price[index][route_selected[index]], promo.discount, promo.discount_type)
                const is_discount = parseInt(current_price[index][route_selected[index]].replace(/,/g, "")) - discount
                const discount_price = document.querySelector('.your-booking-discount-price')
                if(promocode_select[index] === 'Y' && promo_active[index][route_selected[index]]) {
                    discount_price.innerHTML = `- ${numberFormat(is_discount)} <small class="smaller">THB</small>`
                    route_price = discount
                    sum_price[index] = route_price
                    updateSumPrice()
                }
                else
                    discount_price.innerHTML =`0 <small class="smaller">THB</small>`
            }

            use_promocode.value = _promocode
        }
        else {
            const route_list = sub_route.querySelectorAll('.booking-route-list')
            if(current_price[index].length > 0) {
                clearRouteToDefault(main_route, index)
                route_list.forEach((route, key) => {
                    const scp = route.querySelector('.summary-current-price')
                    // const spa = route.querySelector('.summary-promo-avaliable')
                    scp.classList.add('d-none')
                    // spa.classList.add('d-none')

                    const promo_price = route.querySelector('.route-price')
                    promo_price.innerHTML = numberFormat(current_price[index][key])

                    updateFreeAddon('shuttle_bus', index, key, 'N')
                    updateFreeAddon('longtail_boat', index, key, 'N')
                    updateFreeAddon('private_taxi', index, key, 'N')
                })
            }

            if(_route_selected[index]) {
                if(current_price[index].length > 0) {
                    route_price = parseInt(current_price[index][route_selected[index]].replace(/,/g, ""))
                    updateSumPrice()
                }
            }

            promo = null
            use_promocode.value = ''
            promo_active[index] = []
            booking_discount.classList.add('d-none')
        }

        updateDiscountByBookingSummary(index)
        document.querySelector('.booking-promocode-input').classList.remove('border-danger')

        if(index === last_route-1) {
            promoResponse()
        }
    })
}

function updateFreeAddon(type, index, key, status) {
    const route_addon_lists = document.querySelectorAll(`.route-addon-lists-${index}`)
    const person_adult = document.querySelector('.person-adult-icon').innerText
    const person_child = document.querySelector('.person-child-icon').innerText
    const person_infant = document.querySelector('.person-infant-icon').innerText
    const person_all = parseInt(person_adult) + parseInt(person_child) + parseInt(person_infant)

    route_addon_lists.forEach((item) => {
        if(!item.classList.contains('d-none')) {
            const charge_from = item.querySelector(`.addon-service-charge-${type}-from`)
            const price_from = item.querySelector(`.${type}-is-service-charge-from`)
            const price_current_from = item.querySelector(`.${type}-is-service-charge-current-from`)

            const charge_to = item.querySelector(`.addon-service-charge-${type}-to`)
            const price_to = item.querySelector(`.${type}-is-service-charge-to`)
            const price_current_to = item.querySelector(`.${type}-is-service-charge-current-to`)

            if(charge_from && price_from && price_current_from) {
                setAddonPrice(price_current_from, charge_from, price_from, status, person_all, index)
            }

            if(charge_to && price_to && price_current_to) {
                setAddonPrice(price_current_to, charge_to, price_to, status, person_all, index)
            }
        }
    })
}

function setAddonPrice(price_current, charge, price, status, person, index) {
    const _d = price_current.dataset

    if(status === 'Y') {
        charge.innerHTML = `<span class="text-second-color">Free By Promocode</span>`
        price.value = 0

        if(addon_route[index].length > 0) {
            addon_route[index].forEach((r, i) => {
                if(r.id === _d.addon) { addon_route[index][i].price = '0' }
            })
        }
    }
    else {
        let set_price = price_current.value == '0' ? '0' : `${numberFormat(price_current.value * 1)} x ${person} = ${price_current.value * person} <span class="small">THB</span>`
        charge.innerHTML = `${set_price}`
        price.value = price_current.value
        if(addon_route[index].length > 0) {
            addon_route[index].forEach((r, i) => {
                if(r.id === _d.addon) { addon_route[index][i].price = `${price_current.value}` }
            })
        }
    }
}

async function promoResponse() {
    setTimeout(() => {
        if(promocode_active) {
            // document.querySelector('.your-booking-promocode').classList.add('d-none')
            $.SOW.core.toast.show('success', '', 'Promocode Active.', 'bottom-end', 3, true);
        }
        else {
            // document.querySelector('.your-booking-promocode').classList.remove('d-none')
            $.SOW.core.toast.show('danger', '', 'Invalid Coupon Code. Promotion code incorrect or unavailable.', 'bottom-end', 3, true);
        }
    }, 100)
    getPromocodeLoaded()
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

function clearRouteToDefault(main_route, index) {
    const multi_route = main_route.querySelectorAll('.booking-multi-route')
    const route_list = multi_route[index].querySelectorAll('.booking-route-list')
    if(current_price[index].length > 0) {
        route_list.forEach((route, key) => {
            const scp = route.querySelector('.summary-current-price')
            // const spa = route.querySelector('.summary-promo-avaliable')
            scp.classList.add('d-none')
            // spa.classList.add('d-none')

            const promo_price = route.querySelector('.route-price')
            promo_price.innerHTML = numberFormat(current_price[index][key])
        })
    }

    if(_route_selected[index]) {
        if(current_price[index].length > 0) {
            sum_price[index] = parseInt(current_price[index][route_selected[index]].replace(/,/g, ""))
            updateSumPrice()
        }
    }
}

function editPromotionCode() {
    document.querySelector('.your-booking-promocode').classList.remove('d-none')
}

let is_discount = 0
function updateDiscountByBookingSummary(index) {
    const booking_discount = document.querySelector('.your-booking-discount')
    if(promo_active.length > 0) {
        if(promocode_select[index] === 'Y' && promo_active[index][route_selected[index]]) {

            booking_discount.classList.remove('d-none')
            const discount = promotionPriceCal(current_price[index][route_selected[index]], promo.discount, promo.discount_type)
            summary_discount[index] = parseInt(current_price[index][route_selected[index]].replace(/,/g, "")) - discount

            is_discount = 0
            is_discount = summary_discount.reduce((num1, num2) => { return num1+num2 })
            const neg = is_discount === 0 ? '' : '-'
            document.querySelector('.your-booking-discount-price').innerHTML = `${neg} ${numberFormat(is_discount)} <small class="smaller">THB</small>`
        }
        else {
            is_discount = 0
            summary_discount[index] = 0
            is_discount = summary_discount.reduce((num1, num2) => { return num1+num2 })
            const neg = is_discount === 0 ? '' : '-'
            document.querySelector('.your-booking-discount-price').innerHTML = `${neg} ${numberFormat(is_discount)} <small class="smaller">THB</small>`
        }
    }
}

let sum_discount = 0
function updateDiscountBySearchForm(index) {
    const _promocode = document.querySelector('[name="use_promocode"]').value
    const sub_route = document.querySelectorAll('.booking-route-select')

    if(_promocode !== '') {
        const booking_discount = document.querySelector('.your-booking-discount')
        const booking_discount_price = document.querySelector('.your-booking-discount-price')

        const _current_price = sub_route[index].querySelectorAll('.price-position-set')
        _current_price.forEach((c, i) => {
            if(c.querySelector('.current-price')) is_current_price[index].push(c.querySelector('.current-price').innerText)
            else is_current_price[index].push(c.querySelector('.route-price').innerText)
        })

        booking_discount.classList.remove('d-none')
        if(promocode_select[index] === 'Y' && promocode_select[index]) {
            const _promocode = document.querySelector('[name="use_promocode"]').value
            // document.querySelector('.your-booking-promocode-discount').innerHTML = `[${_promocode}]`

            const _is_current_price = is_current_price[index][route_selected[index]]
            const discount = _is_current_price ? parseInt(is_current_price[index][route_selected[index]].replace(/,/g, "")) : 0
            _summary[index] = discount !== 0 ? discount - sum_price[index] : 0
            sum_discount = 0
            sum_discount = _summary.reduce((num1, num2) => { return num1+num2 })
            const neg = sum_discount === 0 ? '' : '-'
            booking_discount_price.innerHTML = `${neg} ${numberFormat(sum_discount)} <small class="smaller">THB</small>`
        }
        else {
            _summary[index] = 0
            sum_discount = 0
            sum_discount = _summary.reduce((num1, num2) => { return num1+num2 })
            const neg = sum_discount === 0 ? '' : '-'
            booking_discount_price.innerHTML = `${neg} ${numberFormat(sum_discount)} <small class="smaller">THB</small>`
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
    data.append('trip_type', 'multi-trip')
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
