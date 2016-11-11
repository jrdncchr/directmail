<style>
    input:disabled {
        background-color: #F1F1F1 !important;
        font-weight: bold !important;
    }
</style>
<div id="app">
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1" style="padding-top: 20px;">
            <h1 class="text-center logo">Direct Mail</h1>
            <h2 class="text-center">Registration</h2>
            <br />
            <h3>User Information</h3>
            <div class="notice"><?php echo $this->session->flashdata('message'); ?></div>
            <form id="register-form" action="<?php echo base_url() . 'auth/register/' . $company->company_key; ?>"
                  method="post" onsubmit="return validateRegisterForm();">
                <div class="notice"></div>
                <div class="well">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="company">* Company</label>
                                <input name="company" type="text" class="form-control" required disabled
                                       title="Company" value="<?php echo $company->name; ?>" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="email">* Email Address</label>
                                <input name="email" type="email" class="form-control email required"
                                       pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$"
                                       maxlength="100" title="Please enter your valid email address."
                                       value="<?php echo isset($info) ? $info['email'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="first_name">* First Name</label>
                                <input name="first_name" type="text" class="form-control required"
                                       maxlength="100" title="Enter your first name."
                                       value="<?php echo isset($info) ? $info['first_name'] : ''; ?>" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="last_name">* Last Name</label>
                                <input name="last_name" type="text" class="form-control required" required
                                       maxlength="100" title="Enter your last name."
                                       value="<?php echo isset($info) ? $info['last_name'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="contact_no">* Contact No.</label>
                                <input name="contact_no" type="text" class="form-control required" required
                                       maxlength="20" title="Enter your contact number."
                                       value="<?php echo isset($info) ? $info['contact_no'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <h3>Password</h3>
                <div class="well">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="password">* Password</label>
                                <input id="password" name="password" type="password" class="form-control" required
                                       maxlength="300" title="Enter your password." />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="confirm_password">* Confirm Password</label>
                                <input id="confirm-password" name="confirm_password" type="password" class="form-control" required
                                       maxlength="300" title="Confirm your password." />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <a href="<?php echo base_url() . 'login'?>">Return to Login</a>
                        <button class="btn btn-main btn-sm pull-right">Register</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function validateRegisterForm() {
        var form = $('#register-form');
        var valid = validator.validateForm(form);
        if (valid) {
            if ($('#password').val() == $('#confirm-password').val()) {
                return true;
            } else {
                validator.displayAlertError(form, true, "Passwords did not match.");
            }
        }
        return false;
    }
</script>