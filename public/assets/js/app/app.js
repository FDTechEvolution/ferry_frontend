const _menu = document.querySelector('#navbar-menu')

_menu.addEventListener('click', (e) => {
    const _a = document.querySelectorAll('.nav-item a.nav-link')
    _a.forEach((a) => {
        //a.classList.remove('active')
    })

    //e.target.classList.add('active')
})