$(document).ready(() => {
    checkWindowSize()
})

$(window).on('resize', () => {
    checkWindowSize()
})

$(window).scroll(() => {
    checkWindowSize()
})

function checkWindowSize(){

    let width = $(window).width()
    let scrollPos = $(window).scrollTop()
    let widthBreakpoint = 975
    let scrollTrigger = 100

    if(width >= widthBreakpoint && scrollPos <= scrollTrigger){
        $('#navbarNav > ul > li').addClass('nav-item-underline')
        $('#navbarMain').removeClass('navbar-transp').addClass('navbar-transp')
        $('#navbarMain').removeClass('box_shadow_toggle')
    }else{
        $('#navbarMain').removeClass('navbar-transp').addClass('navbar-colored')
        $('#navbarNav > ul > li').addClass('nav-item-underline')
        $('#navbarMain').addClass('box_shadow_toggle')
    }
    if(width < widthBreakpoint) {
        $('#navbarNav > ul > li').removeClass('nav-item-underline')
        $('#navbarMain').removeClass('navbar-transp').addClass('navbar-colored')
    }
}