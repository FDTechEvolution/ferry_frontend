const booking_routes = document.querySelectorAll('.booking-route-select')
let route_selected = []
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

if(booking_routes) {
    const destination = document.querySelector('.popover-destinations')

    booking_routes.forEach((route, index) => {
        route_selected.push([])
        icon_selected.push([])
        addon_route.push([])
        route_promo.push([])
        selected_promo.push([])
        payment_info.extra_selected.push([])
        sum_price.push(0)
        let route_list = route.querySelectorAll('.booking-route-list')
        let btn_route_list = document.querySelectorAll(`.btn-route-list_${index}`)
        const route_addon_checked = route.querySelectorAll(`.route-addon-checked-${index}`)
        const route_addon_detail = document.querySelectorAll(`.route-addon-detail-${index}`)

        let _depart_name = document.querySelector(`.depart-station-name-${index}`).innerText
        let _arrive_name = document.querySelector(`.arrive-station-name-${index}`).innerText
        let _travel_date = document.querySelector(`.travel-date-${index}`).innerText
        route_list.forEach((route, key) => {
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

                let price_list = []
                price_list.push(route.querySelector('.selected-adult-price').value)
                price_list.push(route.querySelector('.selected-child-price').value)
                price_list.push(route.querySelector('.selected-infant-price').value)
                price_all[index] = price_list

                let total_price = sum_price.reduce((num1, num2) => { return num1+num2 })
                document.querySelector('#sum-price').innerHTML = `${total_price.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })}`
                // END set price ///////////////////////////////////

                // set Yout Booking
                document.querySelector('.your-booking-summary').classList.remove('d-none')
                document.querySelector(`.your-booking-depart-time-${index}`).innerHTML = `<i class="fa-regular fa-clock"></i> ${route.querySelector('.depart-time').innerText}`
                document.querySelector(`.your-booking-destination-from-${index}`).innerHTML = '<i class="fa-solid fa-ship"></i> ' + route.querySelector(`.station-from-text-${index}-${key}`).innerText
                document.querySelector(`.your-booking-arrive-time-${index}`).innerHTML = `<i class="fa-regular fa-clock"></i> ${route.querySelector('.arrival-time').innerText}`
                document.querySelector(`.your-booking-destination-to-${index}`).innerHTML = '<i class="fa-solid fa-anchor"></i> ' + route.querySelector(`.station-to-text-${index}-${key}`).innerText
                document.querySelector('.your-booking-fare').innerHTML = document.querySelector('.your-booking-amount').innerHTML = `${total_price.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} <small class="smaller">THB</small>`

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
            })
        })

        destination.dataset.bsContent += `<p class="popover-destination-list"><i class="fa-solid fa-location-dot me-2"></i> ${_depart_name} <i class="fa-solid fa-arrow-right mx-2"></i> ${_arrive_name} <br/><i class="fa-regular fa-calendar-days me-2 mb-2"></i> ${_travel_date}</p>`
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
        // let _premium_price = ((_route_price*110)/100) - _route_price
        let _premium_price = (promo_premiumflex === 'Y' && _selected_promo) ? 0 : ((_route_price*110)/100) - _route_price

        // console.log(select_promo)
        if(use_promocode.value !== '') {
            if(promo_premiumflex === 'Y' && _selected_promo) select_promo.classList.remove('d-none')
            if(!_selected_promo && select_promo) select_promo.classList.add('d-none')
        }

        your_booking.classList.remove('d-none')
        txt_price.innerHTML = _premium_price.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })

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
        const passenger_next = document.querySelector('#progress-next-passenger')
        progress_next.classList.remove('d-none')
        passenger_next.classList.add('d-none')
        passenger_next.disabled = true
    }

    if(step === 'extra') {
        const r_extra = document.querySelector('#booking-multi-route-extra')
        const ex_route = r_extra.querySelectorAll('.booking-route-extra')
        extra_price = 0
        addon_route = []
        ex_route.forEach((_extra, ex_index) => {
            let list_index = _extra.dataset.list
            addon_route.push([])
            // const shuttlebus_list = _extra.querySelectorAll('.route-shuttle-bus')
            // const longtailboat_list = _extra.querySelectorAll('.route-longtail-boat')
            const meal_list = _extra.querySelectorAll(`.route-meal`)
            const activity_list = _extra.querySelectorAll('.route-activity')
            const route_addon_lists = _extra.querySelectorAll(`.route-addon-lists-${ex_index}`)
            const route_addon_checked = _extra.querySelectorAll(`.route-addon-checked-${ex_index} input`)

            route_addon_checked.forEach((route_addon) => {
                if(route_addon.checked) {
                    let type = route_addon.dataset.type
                    let subtype = route_addon.dataset.subtype
                    let routeindex = route_addon.dataset.routeindex
                    let addon_name = document.querySelector(`.addon-name-${type}-${subtype}-${routeindex}-${ex_index}`)
                    let addon_price = document.querySelector(`.${type}-${subtype}-${routeindex}-${ex_index}`)
                    let addon_detail = document.querySelector(`.addon-detail-${type}-${subtype}-${routeindex}-${ex_index}`)
                    addon_route[ex_index].push({'name': addon_name.innerText, 'price': addon_price.value, 'type': `${type}-${subtype}-${routeindex}-${ex_index}`})
                    route_addon.name = `route_addon[${ex_index}][]`
                    addon_detail.name = `route_addon_detail[${ex_index}][]`
                    extra_price += parseInt(addon_price.value)
                    document.querySelector('.your-booking-extra').classList.remove('d-none')
                    route_addon.disabled = false
                    updateSumPrice()
                }
                else route_addon.disabled = true
                route_addon.addEventListener('change', (e) => {
                    let type = e.target.dataset.type
                    let subtype = e.target.dataset.subtype
                    let routeindex = e.target.dataset.routeindex
                    let addon_name = document.querySelector(`.addon-name-${type}-${subtype}-${routeindex}-${ex_index}`)
                    let addon_price = document.querySelector(`.${type}-${subtype}-${routeindex}-${ex_index}`)
                    let addon_detail = document.querySelector(`.addon-detail-${type}-${subtype}-${routeindex}-${ex_index}`)
                    if(e.target.checked) {
                        let addon_index = addon_route[ex_index].findIndex((addon) => { return addon.type === `${type}-${subtype}-${routeindex}-${ex_index}` })
                        if(addon_index < 0) addon_route[ex_index].push({'name': addon_name.innerText, 'price': addon_price.value, 'type': `${type}-${subtype}-${routeindex}-${ex_index}`})
                        extra_price += parseInt(addon_price.value)
                        e.target.name = `route_addon[${ex_index}][]`
                        addon_detail.name = `route_addon_detail[${ex_index}][]`
                        addon_detail.disabled = false
                        updateSumPrice()
                    }
                    else {
                        let addon_index = addon_route[ex_index].findIndex((addon) => { return addon.type === `${type}-${subtype}-${routeindex}-${ex_index}` })
                        if(addon_index >= 0) addon_route[ex_index].splice(addon_index, 1)
                        extra_price -= parseInt(addon_price.value)
                        e.target.name = ''
                        addon_detail.name = ''
                        addon_detail.disabled = true
                        updateSumPrice()
                    }
                })
            })

            let route_addons = _extra.querySelectorAll(`.route-addon-index-${route_selected[list_index]}-${ex_index}`)
            route_addon_lists.forEach((item) => { item.classList.add('d-none') })
            route_addons.forEach((item) => { item.classList.remove('d-none') })

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

        progress_next.classList.remove('d-none')
        progress_payment.classList.add('d-none')
        progress_payment.disabled = true
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
    let your_booking = {
        premium_flex: document.querySelector('.your-booking-premium-flex-price'),
        extra: document.querySelector('.your-booking-extra-price'),
        total: document.querySelector('.your-booking-amount')
    }
    your_booking.premium_flex.innerHTML = `${premium_price.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} <small class="smaller">THB</small>`
    your_booking.extra.innerHTML = `${extra_price.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 })} <small class="smaller">THB</small>`

    let total_route = sum_price.reduce((num1, num2) => { return num1+num2 })
    let sum_amount = total_route + extra_price + premium_price
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
