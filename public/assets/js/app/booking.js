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

function inc(element) {
    const el = document.querySelector(`[name="${element}"]`)
    el.value = parseInt(el.value) + 1
    updatePassenger(element)
}

function dec(element) {
    const el = document.querySelector(`[name="${element}"]`)
    if(parseInt(el.value) > 0) {
        el.value = parseInt(el.value) -1
        updatePassenger(element)
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