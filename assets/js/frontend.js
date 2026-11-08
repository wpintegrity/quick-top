jQuery(document).ready(function($) {
    var quickTop = $('#quick-top');
    if (!quickTop.length) {
        return;
    }

    var distance = parseInt(quickTop.data('scroll-distance'), 10);
    if (isNaN(distance)) {
        distance = 100;
    }

    function toggleQuickTop() {
        if ($(window).scrollTop() > distance) {
            quickTop.addClass('show');
        } else {
            quickTop.removeClass('show');
        }
    }

    $(window).on('scroll', toggleQuickTop);
    toggleQuickTop();

    quickTop.on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({ scrollTop: 0 }, 600);
    });
});
