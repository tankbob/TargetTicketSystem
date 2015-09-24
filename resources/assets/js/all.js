function adaptMenu() {
    if ($(window).width() < 720) {
        $('.main-nav').removeClass('btn-group-justified');
        $('.main-nav').addClass('btn-group-vertical');
        $('.main-nav').addClass('btn-block');
    } else {
        $('.main-nav').addClass('btn-group-justified');
        $('.main-nav').removeClass('btn-group-vertical');
        $('.main-nav').removeClass('btn-block');
    }
}
$(window).resize(function() {
    adaptMenu();
});
adaptMenu();