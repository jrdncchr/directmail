$(function() {
    /* Sticky Footer */
    setColumnSize();
    $(window).resize(function () { setColumnSize(); });

    /* Activate Tooltips */
    activateTooltips();

    toastr.options = {
        iconClasses: {
            error: 'alert-error',
            info: 'alert-info',
            success: 'alert-success',
            warning: 'alert-warning'
        },
        positionClass: "toast-bottom-right"
    };
});

function activateTooltips() {
    $('[data-toggle="tooltip"]').tooltip({
        placement: 'top'
    });
}

function setColumnSize() {
    $('.wrapper').css('min-height', $( window ).height() - 164);
}

function scrollTo(e) {
    $('html, body').animate({
        scrollTop: e.offset().top
    }, 1000);
}
function numberWithCommas(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}

var toast;
function loading(type, message) {
    toastr.clear(toast);
    if (type === "success") {
        toast = toastr.success(message);
    } else if (type === "info") {
        toast = toastr.info(message);
    } else if (type === "danger") {
        toast = toastr.error(message);
    }
}