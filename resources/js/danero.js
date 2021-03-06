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


// ex. 
//  showModal('yesno', {
//     title: 'Restore Backup Confirmation',
//     body: 'Make sure to backup first before restoring, continue?',
//     callback: function() {
//         $('#global-modal').modal('hide');
//         window.open(baseUrl + 'download/download/list/1', '_blank');
//     },
//     cancelCallback: function() {
//         $('#global-modal').modal('hide');
//         window.open(baseUrl + 'download/download/list', '_blank');
//     }
// });
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

function filterLoading(spin) {
    if (spin) {
        $('#filter-btn').html('<i class="fa fa-spinner fa-spin fa-fw"></i><span class="sr-only">Loading...</span>').prop('disabled', true);
    } else {
        $('#filter-btn').html('Filter').prop('disabled', false);
    }
}

function spinButton(btn, spin, text) {
    if (spin) {
        btn.html('<i class="fa fa-spinner fa-spin fa-fw"></i><span class="sr-only">Please wait...</span>').prop('disabled', true);
    } else {
        btn.html(text).prop('disabled', false);
    }
}