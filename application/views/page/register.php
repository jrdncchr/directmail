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
            <br />
            <h3>Registration</h3>
            <div class="notice"><?php echo $this->session->flashdata('message'); ?></div>
            <form action="<?php echo base_url() . 'page/register/' . $client->client_key; ?>" method="post">
                <div class="well">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="client">* Client</label>
                                <input name="client" type="text" class="form-control input-lg" required disabled
                                       title="Client" value="<?php echo $client->name; ?>" />
                                <input type="hidden" name="client_id" value="<?php echo $client->id; ?>" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="email">* Email Address</label>
                                <input name="email" type="email" class="form-control input-lg" required
                                       pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$"
                                       maxlength="100" title="Please enter your valid email address." />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="first_name">* First Name</label>
                                <input name="first_name" type="text" class="form-control input-lg" required
                                       maxlength="100" title="Enter your first name." />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="last_name">* Last Name</label>
                                <input name="last_name" type="text" class="form-control input-lg" required
                                       maxlength="100" title="Enter your last name." />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="contact_no">* Contact No.</label>
                                <input name="contact_no" type="text" class="form-control input-lg" required
                                       maxlength="20" title="Enter your contact number." />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="birth_date">* Birth date</label>
                                <input name="birth_date" id="birth_date" type="text" class="form-control input-lg datepicker-here"
                                       required maxlength="45" title="Enter your birth date." data-language='en' data-date-format="yyyy-mm-dd"  />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="password">* Password</label>
                                <input name="password" type="password" class="form-control input-lg" required
                                       maxlength="300" title="Enter your password." />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="confirm_password">* Confirm Password</label>
                                <input name="confirm_password" type="password" class="form-control input-lg" required
                                       maxlength="300" title="Confirm your password." />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <a href="<?php echo base_url() . 'login'?>">Return to Login</a>
                        <button class="btn btn-main pull-right">Register</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>