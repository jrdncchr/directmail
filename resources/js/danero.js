$(function() {
    /* Sticky Footer */
    setColumnSize();
    $(window).resize(function () { setColumnSize(); });

    /* Activate Tooltips */
    activateTooltips();

    toastr.options = {
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
    var modal = $('#global-confirm-modal');
    if (type === 'yesno') {
        modal = $('#global-yesno-modal');
    }
    
    modal.find('.modal-title').html(config.title);
    modal.find('.modal-body').html(config.body);
    if (undefined !== config.callback) {
        modal.find('.btn-main').on('click', config.callback);
    } else {
        modal.find('.btn-main').hide();
    }
    if (undefined !== config.cancelCallback) {
        modal.on('hidden.bs.modal', config.cancelCallback);
    }
    modal.modal({
        show: true,
        backdrop: 'static',
        keyboard: false
    });
}

function hideModal() {
    $('#global-confirm-modal').hide();
    $('#global-yesno-modal').hide();
}

function capitalize(str) {
    return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
}