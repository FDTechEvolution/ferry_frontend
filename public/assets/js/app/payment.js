function inc(element, index) {
    const el = document.querySelector(`#extra-${element}-index-${index}`)
    const icon = document.querySelector(`#extra-${element}-img-${index}`)
    const name = document.querySelector(`#extra-${element}-name-${index}`)
    const amount = document.querySelector(`.extra-${element}-amount-${index}`)
    let qty = parseInt(el.value) + 1
    el.value = qty
    let _extra_amount = parseToNumber(amount.innerText)
    let ico_src = icon === null ? '' : icon.src
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
        let ico_src = icon === null ? '' : icon.src
    }
}

function parseToNumber(str) {
    return parseFloat(str.split(',').join(''));
}

const btn_person = document.querySelector('#button-person')
if(btn_person) {
    btn_person.addEventListener('click', () => {
        const bookingno = document.querySelector('.person-number-booking')
        if(bookingno.value === '') bookingno.classList.add('border-danger')
        else {
            bookingno.classList.remove('border-danger')
            getperson(bookingno.value)
        }
    })
}

let _booking_current = ''
async function getperson(bookingno) {
    _booking_current = bookingno
    const loading = document.querySelector('.person-loading')
    const row_detail = document.querySelector('.person-detail')
    const row_notice = document.querySelector('.person-notice')
    const row_route = document.querySelector('.person-route')
    loading.classList.remove('d-none')
    row_detail.classList.add('d-none')
    row_notice.classList.add('d-none')
    row_route.classList.add('d-none')
    const person_notice = document.querySelector('.person-notice')
    const content_notice = document.querySelector('.notice-content')

    let data = new FormData()
    data.append('booking_number', bookingno)
    data.append('booking_current', booking_current)

    let response = await fetch(`/ajax/booking/check-booking`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            body: data
                        })
    let res = await response.json()
    let resData = res.data
    loading.classList.add('d-none')

    if(resData !== null) {
        person_notice.classList.add('d-none')
        content_notice.innerHTML = ''
        if(resData.result) addPersonData(resData)
        else showErrorData(resData.status)
    }
    else {
        person_notice.classList.remove('d-none')
        content_notice.innerHTML = 'No Booking.'
    }
}

function addPersonData(res) {
    if(res.status !== '') {
        showErrorData(res.status)
        document.querySelector('.btn-add-person').disabled = true
        if(res.data != '') createCustomerData(res.data)
    }
    else {
        document.querySelector('.btn-add-person').disabled = false
        document.querySelector('.person-notice').classList.remove('d-none')
        createCustomerData(res.data)
    }
}

function createCustomerData(data) {
    // console.log(data)
    setDataCustomer(data.booking_customers)
    setDataRoute(data.booking_routes, data.departdate)
}

function setDataCustomer(booking_customers) {
    const row_customer = document.querySelector('.person-detail')
    row_customer.classList.remove('d-none')
    while (row_customer.firstChild) { row_customer.removeChild(row_customer.lastChild) }
    
    booking_customers.forEach((item) => {
        let col_12_customer = document.createElement('div')
        col_12_customer.setAttribute('class', 'col-12 customer-detail')
        let p_customer = document.createElement('p')
        p_customer.setAttribute('class', 'mb-0')
        row_customer.appendChild(col_12_customer)

        let fullname = `<span class="fw-bold">[${item.type}]</span> ${item.fullname}`
        let birthday = `<span class="fw-bold">Date of birth : </span>xxxxxx`
        let email = item.email === null ? '' : `<span class="fw-bold"> | Email : </span> ${item.email} <span class="badge bg-primary-soft">Lead passenger</span>`
        p_customer.innerHTML = `${fullname} | ${birthday} ${email}`
        col_12_customer.appendChild(p_customer)
    })
}

function setDataRoute(booking_routes, departdate) {
    const row_route = document.querySelector('.person-route')
    row_route.classList.remove('d-none')
    while (row_route.firstChild) { row_route.removeChild(row_route.lastChild) }

    let col_12_route = document.createElement('div')
    col_12_route.setAttribute('class', 'col-12 route-detail')
    let p_route = document.createElement('p')
    p_route.setAttribute('class', 'mb-0')
    let h_from = document.createElement('h5')
    h_from.innerHTML = 'From'
    let h_to = document.createElement('h5')
    h_to.innerHTML = 'To'
    let row_route_2 = document.createElement('div')
    row_route_2.setAttribute('class', 'row')
    let col_4_1 = document.createElement('div')
    col_4_1.setAttribute('class', 'col-4')
    let col_4_2 = document.createElement('div')
    col_4_2.setAttribute('class', 'col-4')
    let p_from = document.createElement('p')
    p_from.setAttribute('class', 'mb-1')
    let p_to = document.createElement('p')
    p_to.setAttribute('class', 'mb-1')
    let p_depart_date = document.createElement('p')
    p_depart_date.setAttribute('class', 'small mb-0')
    let p_arrive_date = document.createElement('p')
    p_arrive_date.setAttribute('class', 'small mb-0')
    let p_depart_time = document.createElement('p')
    p_depart_time.setAttribute('class', 'small mb-0')
    let p_arrive_time = document.createElement('p')
    p_arrive_time.setAttribute('class', 'small mb-0')

    row_route.appendChild(col_12_route)
    booking_routes.forEach((item) => {
        let from_name = item.station_from.name
        let from_pier = item.station_from.piername === null ? '' : `(${item.station_from.piername})`
        let station_from = `${from_name} ${from_pier}`
        let to_name = item.station_to.name
        let to_pier = item.station_to.piername === null ? '' : `(${item.station_to.piername})`
        let station_to = `${to_name} ${to_pier}`
        p_from.innerHTML = station_from
        p_to.innerHTML = station_to
        p_depart_date.innerHTML = setTHdate(departdate)
        p_arrive_date.innerHTML = setTHdate(departdate)
        p_depart_time.innerHTML = setTime(item.depart_time)
        p_arrive_time.innerHTML = setTime(item.arrive_time)

        col_4_1.appendChild(h_from)
        col_4_1.appendChild(p_from)
        col_4_1.appendChild(p_depart_date)
        col_4_1.appendChild(p_depart_time)
        row_route_2.appendChild(col_4_1)

        col_4_2.appendChild(h_to)
        col_4_2.appendChild(p_to)
        col_4_2.appendChild(p_arrive_date)
        col_4_2.appendChild(p_arrive_time)
        row_route_2.appendChild(col_4_2)

        col_12_route.appendChild(row_route_2)
    })
}

function setTHdate(date) {
    let ex = date.split('-')
    return `${ex[2]}/${ex[1]}/${ex[0]}`
}

function setTime(time) {
    let ex = time.split(':')
    return `${ex[0]}:${ex[1]}`
}

function showErrorData(status) {
    const person_notice = document.querySelector('.person-notice')
    const content_notice = document.querySelector('.notice-content')

    person_notice.classList.remove('d-none')
    if(status === 'unpay') content_notice.innerHTML = 'Please payment before add person.'
    else if(status === 'uncurrect') content_notice.innerHTML = 'Destination not match.'
    else if(status === 'not match') content_notice.innerHTML = 'Depart date or depart time not match.'
    else {
        content_notice.innerHTML = ''
        person_notice.classList.add('d-none')
    }
}

const btn_add_person = document.querySelector('.btn-add-person')
if(btn_add_person) {
    btn_add_person.addEventListener('click', () => {
        const form_merge = document.querySelector('#form-confirm-merge')
        const booking_new = document.querySelector('#booking-number-new')
        booking_new.value = _booking_current
        form_merge.submit()
    })
}

const depart_date = document.querySelector('.add-multi-trip-depart')
const return_date = document.querySelector('.add-multi-trip-return')

const add_multi_depart = document.querySelector('#to-select')
if(add_multi_depart) {
    add_multi_depart.addEventListener('change', (e) => {
        const all_depart = document.querySelectorAll('.depart-last-date')
        let last_depart = all_depart[all_depart.length - 1];
        let ex_depart = last_depart.innerText.split('/')
        $('.add-multi-trip-depart').datepicker()
        $('.add-multi-trip-depart').datepicker('setStartDate', new Date(`${ex_depart[2]}-${ex_depart[1]}-${ex_depart[0]}`))
        depart_date.disabled = false

        // show depart time
        let depart_all = document.querySelectorAll('.station-depart-hide')
        depart_all.forEach((d) => { d.classList.add('d-none') })
        let depart_index = document.querySelector(`.station-index-${e.target.value}`)
        depart_index.classList.remove('d-none')
    })
}

$('.add-multi-trip-depart').on('change', function(e) {
    return_date.value = ''
    let ex_return = e.target.value.split('/')
    $('.add-multi-trip-return').datepicker()
    $('.add-multi-trip-return').datepicker('setStartDate', new Date(`${ex_return[2]}-${ex_return[1]}-${ex_return[0]}`))
    return_date.disabled = false
})