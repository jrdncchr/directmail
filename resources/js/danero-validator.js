var Validator = function() {

    this.inputErrors = [];

    this.validateForm = function(form) {
        var _this = this;
        _this.refreshInputErrors();

        form.find('input, select, textarea').each(function() {
            var e = $(this);

            if(!e.val()) {
                // validate required field
                if(e.hasClass('required')) {
                    _this.inputErrors.required.push(e);
                }
            } else {
                // validate email
                if(e.hasClass('email')) {
                    if(!_this.validateEmail(e.val())) {
                        _this.inputErrors.email.push(e);
                    }
                }
                // validate url
                if(e.hasClass('url')) {
                    if(!_this.validateUrl(e.val())) {
                        _this.inputErrors.url.push(e);
                    }
                }
            }
            _this.displayInputError(e, false);
        });
        var result = _this.checkInputErrors(form);
        return result.success;

    };

    this.checkInputErrors = function(form) {
        var _this = this;
        var result = { success : true };
        var i = 0;
        if(_this.inputErrors.required.length > 0) {
            result.success = false;
            result.message = "A required field cannot be empty.";
            for(i = 0; i < _this.inputErrors.required.length; i++) {
                _this.displayInputError(_this.inputErrors.required[i], true);
            }
        } else if(_this.inputErrors.email.length > 0) {
            result.success = false;
            result.message = "Invalid email format.";
            for(i = 0; i < _this.inputErrors.email.length; i++) {
                _this.displayInputError(_this.inputErrors.email[i], true);
            }
        }  else if(_this.inputErrors.url.length > 0) {
            result.success = false;
            result.message = "Invalid url format.";
            for(i = 0; i < _this.inputErrors.url.length; i++) {
                _this.displayInputError(_this.inputErrors.url[i], true);
            }
        }
        _this.displayAlertError(form, !result.success, result.message);
        return result;
    };

    this.displayInputError = function(e, show) {
        if(show) {
            e.parents('.form-group').addClass('has-error');
        } else {
            e.parents('.form-group').removeClass('has-error');
        }
    };

    this.displayAlertError = function(form, show, message) {
        $('.notice').removeClass('alert alert-danger').html("").hide();
        if(show) {
            form.find('.notice').addClass('alert alert-danger alert-dismissible').html("<i class='fa fa-exclamation-circle'></i> " + message).show();
        } else {
            form.find('.notice').removeClass('alert alert-danger').html("").hide();
        }
    };

    this.displayAlertSuccess = function(form, show, message) {
        $('.notice').removeClass('alert alert-success').html("").hide();
        if(show) {
            form.find('.notice').addClass('alert alert-success alert-dismissible').html("<i class='fa fa-check-circle'></i> " + message).show();
        } else {
            form.find('.notice').removeClass('alert alert-success').html("").hide();
        }
    };

    this.validateEmail = function(email) {
        var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    };

    this.validateUrl = function(url) {
        var regex = /(http|https):\/\/(\w+:{0,1}\w*)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%!\-\/]))?/;
        if(!regex .test(url)) {
            return false;
        } else {
            return true;
        }
    };

    this.clearForm = function(form) {
        form.find('input, select, textarea').each(function() {
            $(this).val("");
        });
    };

    this.refreshInputErrors = function() {
        this.inputErrors = { required : [], email : [], url : [] }
    }

};

var validator = new Validator();