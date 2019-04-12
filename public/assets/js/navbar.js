$(document).ready(() => {
    checkWindowSize()
})

$(window).on('resize', () => {
    checkWindowSize()
})

$(window).scroll(() => {
    let height = $(window).scrollTop()

    if(height > 50) {
        $('#navbarMain').removeClass('navbar-transp').addClass('navbar-colored')
    }else{
        $('#navbarMain').removeClass('navbar-colored').addClass('navbar-transp')
    }

});


function checkWindowSize(){

    let width = $(window).width()

    if(width < 992){
        $('#navbarNav > ul > li').removeClass('nav-item-underline')
        $('#navbarMain').removeClass('navbar-transp').addClass('navbar-colored')
    }
    if(width >= 992){
        $('#navbarNav > ul > li').addClass('nav-item-underline')
        $('#navbarMain').removeClass('navbar-transp').addClass('navbar-transp')
    }

}
