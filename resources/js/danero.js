$(function() {
    /* Sticky Footer */
    setColumnSize();
    $(window).resize(function () { setColumnSize(); });

    /* Activate Tooltips */
    activateTooltips();

    toastr.options = {
        positionClass: "toast-bottom-right"
    };

    $('span#toggleNav').on('click', function() {
        $('#wrapper').toggleClass('toggled');
    });
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
    if (toast) {
        toast.remove();
    }
    if (type === "success") {
        toast = toastr.success(message);
    } else if (type === "info") {
        toast = toastr.info(message);
    } else if (type === "danger") {
        toast = toastr.error(message);
    }
}

function showModal(type, config) {
    var modal = $('#global-modal');
    if (type === 'yesno') {
        $('#global-modal-yes').html('Yes');
        $('#global-modal-no').html('No');
    } else if (type === 'approve') {
        $('#global-modal-yes').html('Approve');
        $('#global-modal-no').html('Reject');
    } else {
        $('#global-modal-yes').html('Confirm');
        $('#global-modal-no').html('Close');
    }
    
    modal.find('.modal-title').html(config.title);
    modal.find('.modal-body').html(config.body);
    if (undefined !== config.callback) {
        $('#global-modal-yes').show();
        $('#global-modal-yes').off('click').on('click', config.callback);
    } else {
        $('#global-modal-yes').hide();
    }
    if (undefined !== config.cancelCallback) {
        $('#global-modal-no').off('click').on('click', config.cancelCallback);
    }
    modal.modal({
        show: true,
        backdrop: 'static',
        keyboard: false
    });
}

function hideModal() {
    $('#global-modal').modal('hide');
}

function capitalize(str) {
    return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
}