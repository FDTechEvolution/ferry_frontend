// const is_return = document.querySelector('.is-type-return')
// if(is_return) {
//     is_return.querySelector('[name="to[]"]').disabled = true
//     is_return.querySelector('[name="from[]"]').disabled = true
    
//     const is_depart = document.querySelector('.is-type-depart')
//     const from = is_depart.querySelector('[name="from[]"]')
//     const to = is_depart.querySelector('[name="to[]"]')
//     from.addEventListener('change', (e) => {
//         let _to = is_return.querySelector('[name="to[]"]')
//         let _options = _to.querySelectorAll('option')
//         _options.forEach((option) => { if(option.value === e.target.value) option.selected = true })
//     })

//     to.addEventListener('change', (e) => {
//         let _from = is_return.querySelector('[name="from[]"]')
//         let _options = _from.querySelectorAll('option')
//         _options.forEach((option) => { if(option.value === e.target.value) option.selected = true })
//     })
// }

function inc(element, e) {
    let is_type = e.getAttribute('data-type')
    if(is_type === 'adult') {
        let undis = document.querySelectorAll('[data-inc="disabled"]')
        undis.forEach((item) => { item.disabled = false })
    }
    const el = document.querySelector(`[name="${element}"]`)
    el.value = parseInt(el.value) + 1
    updatePassenger(element)
}

function dec(element, e) {
    let is_type = e.getAttribute('data-type')
    const el = document.querySelector(`[name="${element}"]`)
    if(parseInt(el.value) > 0) {
        if(is_type === 'adult') {
            if(el.value > 1) {
                el.value = parseInt(el.value) -1
                updatePassenger(element)
            }
        }else{
            el.value = parseInt(el.value) -1
            updatePassenger(element)
        }
    }
}

function updatePassenger(type) {
    let _type = type.split('_')[0]
    const adult = document.querySelector(`[name="${_type}_adult[]"]`)
    const child = document.querySelector(`[name="${_type}_child[]"]`)
    const infant = document.querySelector(`[name="${_type}_infant[]"]`)
    const passenger = document.querySelector(`[data-id="${_type}"]`)
    const passenger_return = document.querySelector('[data-id="passenger-return-input"]')

    let _child = child.value != 0 ? `| Child : ${child.value}` : ''
    let _infant = infant.value != 0 ? `| Infant : ${infant.value}` : ''

    const result = `Adult : ${adult.value} ${_child} ${_infant}`
    passenger.value = result
    if(passenger_return) passenger_return.value = result
}

function addPromotionCode(e, type) {
    const input_promo = document.querySelector(`.input-promotioncode-${type}`)
    const div_promo = document.querySelector(`.div-promotioncode-${type}`)

    e.classList.add('d-none')
    input_promo.type = 'text'
    div_promo.classList.remove('d-none')
}

function clearPromotionCode(type) {
    const add_promo = document.querySelector(`.add-promotioncode-${type}`)
    const input_promo = document.querySelector(`.input-promotioncode-${type}`)
    const div_promo = document.querySelector(`.div-promotioncode-${type}`)

    add_promo.classList.remove('d-none')
    input_promo.type = 'hidden'
    div_promo.classList.add('d-none')
}

const view_booking = document.querySelector('#view-your-booking')
if(view_booking) {
    const b_search = document.querySelector('#booking-record')
    const search_b = document.querySelector('#booking-record-back')
    view_booking.addEventListener('click', () => {
        b_search.classList.remove('d-none')
        view_booking.classList.add('d-none')
    })
    search_b.addEventListener('click', () => {
        b_search.classList.add('d-none')
        view_booking.classList.remove('d-none')
    })
}

const add_trip = document.querySelector('#add-another-trip')
if(add_trip) {
    add_trip.addEventListener('click', () => {
        const station_from = document.querySelector('.from-multi-depart-selected')
        const station_to = document.querySelector('.input-to-multi-depart')
        const station_to_selected = document.querySelector(`.to-1-selected`)
        const travel_date = document.querySelector('.date-multi-depart-selected')
        const station_id = document.querySelector('#to-selected_multi-depart')

        // setFromValue('0', station_from.value)
        setFromValue('1', station_id.value)

        // document.querySelector(`.to-0-input`).value = station_to.value
        document.querySelector(`.date-0-input`).value = travel_date.value

        if(station_to.value !== '' && travel_date.value !== '') {
            const travel_date_selected = document.querySelector('.date-1-selected')
            travel_date_selected.value = ''
            let setdate = travel_date.value.split('/')
            $('.date-1-selected').datepicker()
            $('.date-1-selected').datepicker('setStartDate', new Date(`${setdate[2]}-${setdate[1]}-${setdate[0]}`))

            travel_date_selected.setAttribute('required', true)
            station_to_selected.setAttribute('required', true)

            station_to.classList.remove('border-danger')
            travel_date.classList.remove('border-danger')
            const multi_form = document.querySelector('.multi-search-form-0')
            const station_from_selected = document.querySelector('.from-1-selected')
            document.querySelector('.multi-check-0').checked = true

            
            setMultiFromOption(station_to, station_from_selected)

            let element = `.to-1-selected`
            let result = getMultiStations(station_id.value, element)
            if(result) {
                station_from.disabled = true
                station_to.disabled = true
                travel_date.disabled = true
            }

            multi_form.classList.remove('d-none')
            add_trip.classList.add('d-none')
        }
        else {
            if(station_to.value === '') station_to.classList.add('border-danger')
            else if(travel_date.value === '') travel_date.classList.add('border-danger')
        }
    })
}

function setFromValue(number, value) {
    document.querySelector(`.from-${number}-input`).value = value
}

function updateToDataValue(e, number) {
    document.querySelector(`.to-${number}-input`).value = e.value
}

function updateDateValue(e, number) {
    document.querySelector(`.date-${number}-input`).value = e.value
}

function setMultiFromOption(station_to, station_from) {
    // console.log(station_to.value)
    // let option = document.createElement('option')
    // option.value = station_to.value
    // option.text = station_to.options[station_to.selectedIndex].text
    // option.setAttribute('selected', true)
    station_from.value = station_to.value
    station_from.disabled = true
}

async function getMultiStations(id, element) {
    let destination_loading = document.querySelector(`.loading-destination-1`)
    destination_loading.classList.remove('d-none')
    let result = await getDataAnotherSelected(id, 'from')
    let _result = updateDestinationSelect(result, element)
    // let _element = document.querySelector(`${element}`)
    let _element = document.querySelector(`.input-to-1-selected`)
    if(_result) {
        destination_loading.classList.add('d-none')
        _element.disabled = false
        return _result
    }
}

async function getMultiStationsAnother(id, element_input, element_list, number) {
    let destination_loading = document.querySelector(`.loading-destination-${number}`)
    destination_loading.classList.remove('d-none')

    let result = await getDataAnotherSelected(id, 'from')
    let _result = updateDestinationSelect(result, element_list, number)
    let _element = document.querySelector(`${element_input}`)
    if(_result) {
        destination_loading.classList.add('d-none')
        _element.disabled = false
        return _result
    }
}

function addAmotherTrip(action_id, number) {
    let _number = parseInt(number) + 1
    const multi_form = document.querySelector(`.multi-search-form-${number}`)
    const action = document.querySelector(`#a-${action_id}`)
    const station_from_selected = document.querySelector(`.from-${_number}-selected`)
    const station_to_selected = document.querySelector(`.to-${number}-input`)
    const station_from = document.querySelector(`.from-${number}-selected`)
    const station_to = document.querySelector(`.input-to-${number}-selected`)
    const travel_date = document.querySelector(`.date-${number}-selected`)

    setFromValue(_number, station_to_selected.value)

    if(station_to.value !== '' && travel_date.value !== '') {
        const travel_date_selected = document.querySelector(`.date-${_number}-selected`)
        travel_date_selected.value = ''
        let setdate = travel_date.value.split('/')
        $(`.date-${_number}-selected`).datepicker()
        $(`.date-${_number}-selected`).datepicker('setStartDate', new Date(`${setdate[2]}-${setdate[1]}-${setdate[0]}`))

        travel_date_selected.setAttribute('required', true)
        station_to_selected.setAttribute('required', true)

        station_to.classList.remove('border-danger')
        travel_date.classList.remove('border-danger')
        multi_form.classList.remove('d-none')
        action.classList.add('d-none')
        document.querySelector(`.multi-check-${number}`).checked = true

        setMultiFromOption(station_to, station_from_selected)

        document.querySelector(`.date-${number}-selected`).setAttribute('required', true)
        station_from.disabled = true
        
        let element_input = `.input-to-${_number}-selected`
        let element_list = `.to-${_number}-selected`
        let result = getMultiStationsAnother(station_to_selected.value, element_input, element_list, _number)
        if(result) {
            station_to.disabled = true
            travel_date.disabled = true
        }
    }
    else {
        if(station_to.value === '') station_to.classList.add('border-danger')
        else if(travel_date.value === '') travel_date.classList.add('border-danger')
    }
    
}

function removeThisTrip(action_id, number) {
    let _number = parseInt(number)-1
    let _number_before = _number-1

    if(number == 1) {
        document.querySelector('#add-another-trip').classList.remove('d-none')
        document.querySelector('.from-multi-depart-selected').disabled = false
        document.querySelector('.input-to-multi-depart').disabled = false
        document.querySelector('.date-multi-depart-selected').disabled = false
    }
    else {
        document.querySelector(`.input-to-${_number}-selected`).disabled = false
        document.querySelector(`.input-to-${number}-selected`).required = false

        document.querySelector(`.date-${_number}-selected`).disabled = false
        document.querySelector(`.date-${number}-selected`).required = false
    }
    document.querySelector(`.from-${number}-input`).value = ''
    document.querySelector(`.to-${number}-input`).value = ''
    document.querySelector(`.date-${number}-input`).value = ''

    const multi_form = document.querySelector(`.multi-search-form-${_number}`)
    multi_form.classList.add('d-none')
    multi_form.disabled = true

    const all_form = document.querySelectorAll(`.multi-search-form-${_number_before}`)
    all_form.forEach((form) => {
        let _is_type = form.querySelector('.is-type-multi')
        let _action = _is_type.querySelector('.is-action')
        _action.classList.remove('d-none')
    })
}

async function fromOriginalSelected(e, type, form_type) {
    let destination = document.querySelector(`.to-${type}-${form_type}-selected`)
    let destination_loading = document.querySelector(`.loading-destination-${type}-${form_type}`)
    destination.disabled = true
    destination_loading.classList.remove('d-none')

    let result = await getDataAnotherSelected(e.value, 'from')
    let element = `.to-${type}-${form_type}-selected`
    let _result = updateDestinationSelect(result, element)
    if(_result) {
        destination_loading.classList.add('d-none')
        destination.disabled = false
    }
    
}

// function toDestinationSelected(e, type, form_type) {
//     let original = document.querySelector(`.from-${type}-${form_type}-selected`)
//     if(original.value === '') {
//         getDataAnotherSelected(type, e.value, 'to')
//     }
// }

function updateDestinationSelect(result, element, number = null) {
    let destination_optgroup = document.querySelectorAll(`${element} .group-list`)
    destination_optgroup.forEach((o) => { o.remove() })
    const stations = Map.groupBy(result.data, station => {return station.section})

    let destination = document.querySelector(`${element}`)
    let _number = number === null ? '1' : number
    stations.forEach((section, section_key) => {
        let group_list = document.createElement('div')
        group_list.setAttribute('class', 'col-12 col-lg-4 group-list')
        let optgroup = document.createElement('p')
        optgroup.setAttribute('class', 'text-main-color-2 mb-1 fw-bold group-name')
        optgroup.innerHTML = section_key
        group_list.appendChild(optgroup)
        let ul = document.createElement('ul')
        ul.setAttribute('class', `section-key-${section_key}`)
        section.forEach((station, station_key) => {
            let name = station.name
            let pier = station.piername === null ? '' : ` (${station.piername})`
            let li = document.createElement('li')
            li.setAttribute('class', 'station-to-selected cursor-pointer mb-2')
            li.setAttribute('data-id', station.id)
            li.setAttribute('onClick', `toDestinationSelectedAnother(this, '${_number}')`)
            li.innerHTML = name + pier
            ul.appendChild(li)
        })
        group_list.appendChild(ul)
        destination.appendChild(group_list)
    })
    return true

    // let destination = document.querySelector(`${element}`)
    // stations.forEach((section, section_key) => {
    //     let optgroup = document.createElement('optgroup')
    //     optgroup.setAttribute('label', section_key)
    //     destination.add(optgroup)
    //     section.forEach((station) => {
    //         let name = station.name
    //         let pier = station.piername === null ? '' : `(${station.piername})`
    //         let option = document.createElement('option')
    //         option.value = station.id
    //         option.text = name + pier
    //         optgroup.appendChild(option)
    //     })
    // })
    // return true
}

function toDestinationSelectedAnother(e, number) {
    document.querySelector(`.to-${number}-input`).value = e.dataset.id
    document.querySelector(`.input-to-${number}-selected`).value = e.innerText
}

async function getDataAnotherSelected(_id, select) {
    if(select === 'from') {
        let data = new FormData()
        data.append('station_id', _id)

        let response = await fetch('/ajax/station/to', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            body: data
                        })
        let res = await response.json()
        return res
    }
}

async function fromOriginalSelected2(e, type, form_type) {
    document.querySelector(`#from-selected_${type}-${form_type}`).value = e.dataset.id
    document.querySelector(`.from-${type}-${form_type}-selected`).value = e.innerText

    let destination = document.querySelector(`.input-to-${type}-${form_type}`)
    let destination_loading = document.querySelector(`.loading-destination-${type}-${form_type}`)
    destination.disabled = true
    destination_loading.classList.remove('d-none')

    let result = await getDataAnotherSelected(e.dataset.id, 'from')
    let element = `.to-${type}-${form_type}-selected`
    let _result = updateDestinationSelectFirst(result, element, type, form_type)
    if(_result) {
        destination_loading.classList.add('d-none')
        destination.disabled = false
    }
}

function updateDestinationSelectFirst(result, element, type, form_type) {
    let destination_optgroup = document.querySelectorAll(`${element} .group-list`)
    destination_optgroup.forEach((o) => { o.remove() })
    const stations = Map.groupBy(result.data, station => {return station.section})

    let destination = document.querySelector(`${element}`)
    stations.forEach((section, section_key) => {
        let group_list = document.createElement('div')
        group_list.setAttribute('class', 'col-12 col-lg-4 group-list')
        let optgroup = document.createElement('p')
        optgroup.setAttribute('class', 'text-main-color-2 mb-1 fw-bold group-name')
        optgroup.innerHTML = section_key
        group_list.appendChild(optgroup)
        let ul = document.createElement('ul')
        ul.setAttribute('class', `section-key-${section_key}`)
        section.forEach((station, station_key) => {
            let name = station.name
            let pier = station.piername === null ? '' : ` (${station.piername})`
            let li = document.createElement('li')
            li.setAttribute('class', 'station-to-selected cursor-pointer mb-2')
            li.setAttribute('data-id', station.id)
            li.setAttribute('onClick', `toDestinationSelectedFirst(this, '${type}', '${form_type}')`)
            li.innerHTML = name + pier
            ul.appendChild(li)
        })
        group_list.appendChild(ul)
        destination.appendChild(group_list)
    })
    return true
}

function toDestinationSelectedFirst(e, type, form_type) {
    document.querySelector(`#to-selected_${type}-${form_type}`).value = e.dataset.id
    document.querySelector(`.input-to-${type}-${form_type}`).value = e.innerText
}