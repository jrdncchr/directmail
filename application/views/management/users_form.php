<div id="app">
    <h2><?php echo isset($user) ? 'Edit User' : 'Create User'; ?></h2>
    <ol class="breadcrumb">
        <li><a>Management</a></li>
        <li><a href="<?php echo base_url() . 'management/users'; ?>">Users</a></li>
        <li><a class="active"><?php echo isset($user) ? $user->first_name . ' ' . $user->last_name : 'Create New User'; ?></a></li>
    </ol>

    <div class="row">
        <div class="col-sm-12">
            <?php if (isset($user)): ?>
            <button class="btn btn-xs" style="margin-bottom: 10px;" v-on:click="deleteUser"><i class="fa fa-trash-o"></i> Delete User</button>
            <?php else: ?>
            <div class="alert alert-info"><i class="fa fa-question-circle"></i> Password will be sent to the email address after saving.</div>
            <?php endif; ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    User Details
                    <button class="btn btn-main btn-xs pull-right" v-on:click="saveUserDetails"><i class="fa fa-save"></i> Save</button>
                </div>
                <div class="panel-body" id="user-form">
                    <div class="notice"></div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="role">* Role</label>
                                <select class="form-control" id="role" v-model="form.user_details.role_id">
                                    <option value="0">No Role</option>
                                    <?php foreach ($roles as $role): ?>
                                        <option value="<?php echo $role->id; ?>"><?php echo $role->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <?php if (isset($user)): ?>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>User Permission</label>
                                <a href="<?php echo base_url() . 'management/users/form/' . $user->id . '/permissions'; ?>" class="btn btn-default btn-block btn-xs">
                                    <i class="fa fa-key"></i>
                                    Manage User Permission
                                </a>
                            </div>

                        </div>
                        <?php else: ?>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>User Permission</label>
                                    <p class="text-info" style="font-size: 14px;">
                                        <i class="fa fa-key"></i>
                                        Save the user first to manage user permission.
                                    </p>
                                </div>

                            </div>
                        <?php endif; ?>

                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="email">* Email Address</label>
                                <input name="email" type="email" v-model="form.user_details.email"
                                       class="form-control email required"
                                       pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" maxlength="100"
                                       title="Please enter your valid email address." />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="contact_no">* Contact No.</label>
                                <input name="contact_no" type="text" v-model="form.user_details.contact_no"
                                       class="form-control required" required maxlength="20"
                                       title="Enter your contact number." />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="first_name">* First Name</label>
                                <input name="first_name" type="text" v-model="form.user_details.first_name"
                                       class="form-control required" maxlength="100"
                                       title="Enter your first name." />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="last_name">* Last Name</label>
                                <input name="last_name" type="text" v-model="form.user_details.last_name"
                                       class="form-control required" required
                                       maxlength="100" title="Enter your last name."/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <?php if (isset($user)): ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Change Password
                    <button class="btn btn-main btn-xs pull-right" v-on:click="changePassword"><i class="fa fa-save"></i> Save</button>
                </div>
                <div class="panel-body" id="password-form">
                    <div class="notice"></div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="email">* New Password</label>
                                <input name="email" type="password" class="form-control required"
                                       maxlength="26" v-model="form.password.new_password"
                                       title="Enter a new password for this user." />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="first_name">* Confirm Password</label>
                                <input name="first_name" type="password" class="form-control required"
                                       maxlength="26" v-model="form.password.confirm_password"
                                       title="Confirm your password." />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<script>
    var actionUrl = "<?php echo base_url() . 'management/users'; ?>";

    var data = {
        form: {
            user_details: {
                id: <?php echo isset($user) ? json_encode($user->id) : json_encode(''); ?>,
                email: <?php echo isset($user) ? json_encode($user->email) : json_encode(''); ?>,
                first_name: <?php echo isset($user) ? json_encode($user->first_name) : json_encode(''); ?>,
                last_name: <?php echo isset($user) ? json_encode($user->last_name) : json_encode(''); ?>,
                contact_no: <?php echo isset($user) ? json_encode($user->contact_no) : json_encode(''); ?>,
                role_id: <?php echo isset($user) ? json_encode($user->role_id) : json_encode(''); ?>
            },
            password: {
                new_password: '',
                confirm_password: ''
            }
        }
    };

    var vm = new Vue({
        el: "#app",
        data: data,
        methods: {
            saveUserDetails: function() {
                var userForm = $('#user-form');
                if (validator.validateForm(userForm)) {
                    data.form.user_details.birth_date = $('#birth_date').val();
                    loading("info", "Saving user...");
                    $.post(actionUrl, { action: 'save', form: data.form.user_details }, function(res) {
                        validator.displayAlertSuccess(userForm, true, 'Saving user details successful!');
                        if (res.success && data.form.user_details.id == '') {
                            window.location = actionUrl + "/form/" + res.user_id;
                        } else if(!res.success) {
                            validator.displayAlertError(userForm, true, res.message);
                        }
                    }, 'json');
                }
            },
            changePassword: function() {
                var passwordForm = $('#password-form');
                if (validator.validateForm(passwordForm)) {
                    if (data.form.password.new_password == data.form.password.confirm_password) {
                        loading("info", "Changing password...");
                        $.post(actionUrl, { 
                            action: 'change_password', 
                            user_id: data.form.user_details.id,
                            new_password: data.form.password.new_password 
                        }, function(res) {
                            if (res.success) {
                                validator.displayAlertSuccess(passwordForm, true, 'Change password successful!');
                                data.form.password.new_password = '';
                                data.form.password.confirm_password = '';
                            } else {
                                validator.displayAlertError(passwordForm, true, res.message);
                            }
                        }, 'json');
                    } else {
                        validator.displayAlertError(passwordForm, true, "Password did not match!");
                    }
                }
            },
            deleteUser: function() {
                showConfirmModal({
                    title: 'Delete User',
                    body: 'Are you sure to delete this user?',
                    callback: function() {
                        loading("info", "Deleting user...");
                        $.post(actionUrl, { action: 'delete', user_id: data.form.user_details.id }, function(res) {
                            hideConfirmModal();
                            window.location = actionUrl;
                        }, 'json');
                    }
                });
            }
        }
    });

    $(function() {
        $('#sidebar-management-link').addClass('active');
        $('#sidebar-management-users-link').addClass('active');
        $('#sidebar-management').addClass('in');
    });
</script>