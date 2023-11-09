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

    let _child = child.value != 0 ? `| Child : ${child.value}` : ''
    let _infant = infant.value != 0 ? `| Infant : ${infant.value}` : ''

    const result = `Adult : ${adult.value} ${_child} ${_infant}`
    passenger.value = result
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