<div id="app">
    <h2><?php echo isset($company) ? 'Edit Company' : 'New Company'; ?></h2>
    <ol class="breadcrumb">
        <li><a>Management</a></li>
        <li><a href="<?php echo base_url() . 'management/companies'; ?>">Companies</a></li>
        <li><a class="active"><?php echo isset($company) ? $company['company']['name'] : 'New Company'; ?></a></li>
    </ol>

    <div class="row">
        <div class="col-sm-12">
            <button class="btn btn-xs btn-main" style="margin-bottom: 10px;" v-on:click="save"><i class="fa fa-trash-o"></i> Save Company</button>
            <?php if (isset($company)): ?>
            <button class="btn btn-xs" style="margin-bottom: 10px;" v-on:click="deleteCompany"><i class="fa fa-trash-o"></i> Delete Company</button>
            <?php else: ?>
            <div class="alert alert-info"><i class="fa fa-question-circle"></i> The user must confirm his email in order for this company to be activated.</div>
            <?php endif; ?>

            <div id="main-form">
                <div class="notice"></div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Company
                    </div>
                    <div class="panel-body" id="company-form">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="role">* Company Name</label>
                                    <input type="text" class="form-control required" v-model="form.company.name" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="role">* Company Key</label>
                                    <input type="text" class="form-control required" v-model="form.company.company_key" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        User
                    </div>
                    <div class="panel-body" id="user-form">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="role">* Email</label>
                                    <input type="text" class="form-control email required" v-model="form.user.email" v-bind:readonly="form.company.id" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="role">* First Name</label>
                                    <input type="text" class="form-control required" v-model="form.user.first_name" v-bind:readonly="form.company.id" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="role">* Last Name</label>
                                    <input type="text" class="form-control required" v-model="form.user.last_name" v-bind:readonly="form.company.id" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var actionUrl = "<?php echo base_url() . 'management/companies'; ?>";

    var data = {
        form : {
            company : {
                name : '',
                company_key : ''
            },
            user : {
                first_name : '',
                last_name : '',
                email : ''
            }
        }
    };

    <?php if (isset($company)): ?>
        data.form = <?php echo json_encode($company); ?>;
    <?php endif; ?>

    var vm = new Vue({
        el: "#app",
        data: data,
        methods: {
            save: function() {
                var mainForm = $('#main-form');
                if (validator.validateForm(mainForm)) {
                    loading("info", "Saving company and user...");
                    $.post(actionUrl, { action: 'save', form: data.form }, function(res) {
                        loading("success", "Save successful!");
                        if (res.success && res.company_id) {
                            window.location = actionUrl;
                        } else if(!res.success) {
                            validator.displayAlertError(mainForm, true, res.message);
                        }
                    }, 'json');
                }
            },
            deleteCompany: function() {
                showModal('confirm', {
                    title: 'Delete Company',
                    body: 'Are you sure to delete this company?',
                    callback: function() {
                        loading("info", "Deleting company...");
                        $.post(actionUrl, { action: 'delete', company_id: data.form.company.id }, function(res) {
                            hideModal();
                            window.location = actionUrl;
                        }, 'json');
                    }
                });
            }
        }
    });

    $(function() {
        $('#sidebar-management-link').addClass('active');
        $('#sidebar-management-companies-link').addClass('active');
        $('#sidebar-management').addClass('in');
    });
</script>