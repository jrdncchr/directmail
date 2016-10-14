<div id="app">
    <h2><?php echo isset($role) ? 'Edit Role' : 'Create New Role'; ?></h2>
    <ol class="breadcrumb">
        <li><a>Management</a></li>
        <li><a href="<?php echo base_url() . 'management/roles'; ?>">Roles</a></li>
        <li><a class="active"><?php echo isset($role) ? 'Edit Role' : 'Create New Role'; ?></a></li>
    </ol>

    <div class="row">
        <div class="col-sm-12">
            <?php if (isset($role)): ?>
            <button class="btn btn-default btn-xs" style="margin-bottom: 10px;"><i class="fa fa-trash-o"></i> Delete Role</button>
            <?php else: ?>
            <div class="alert alert-info"><i class="fa fa-info-circle"></i> Save the Role Details first in order to modify the Role Permission.</div>
            <?php endif; ?>
            <div id="role-details-form">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Role Details
                        <button class="btn btn-default btn-xs pull-right" v-on:click="saveRoleDetails"><i class="fa fa-save"></i> Save</button>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="notice"></div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="name">* Name</label>
                                    <input name="name" type="text" class="form-control" required
                                           title="Role Name" v-model="role_details.name" />
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="description">* Description</label>
                                    <input name="description" type="text" class="form-control" required
                                           title="Role Description" v-model="role_details.description" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (isset($role)): ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Role Permissions
                    <button class="btn btn-default btn-xs pull-right"><i class="fa fa-save"></i> Save</button>
                </div>
                <div class="panel-body" style="padding-top: 0; padding-bottom: 0;">
                    <div class="row">
                        <div class="notice"></div>
                        <table class="table table-bordered" style="margin-bottom: 0;">
                            <thead>
                            <tr>
                                <th>Module</th>
                                <th>Retrieve</th>
                                <th>Create</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="permission in role_permissions">
                                <td>
                                    <div v-if="permission.parent_id == 0">
                                        {{ permission.name }}
                                    </div>
                                    <div v-else>
                                       <span style="padding-left: 50px;">&rightarrow; {{ permission.name }}</span>
                                    </div>
                                </td>
                                <td style="text-align: center !important;">
                                    <label class="control control--checkbox">
                                        <input type="checkbox" v-model="permission.retrieve_action" />
                                        <div class="control__indicator"></div>
                                    </label>
                                </td>
                                <td>
                                    <label class="control control--checkbox">
                                        <input type="checkbox" v-model="permission.create_action" />
                                        <div class="control__indicator"></div>
                                    </label>
                                </td>
                                <td>
                                    <label class="control control--checkbox">
                                        <input type="checkbox" v-model="permission.update_action" />
                                        <div class="control__indicator"></div>
                                    </label>
                                </td>
                                <td>
                                    <label class="control control--checkbox">
                                        <input type="checkbox" v-model="permission.delete_action" />
                                        <div class="control__indicator"></div>
                                    </label>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    var actionUrl = "<?php echo base_url() . 'management/roles'; ?>";

    var data = {
        role_details: {
            id: <?php echo isset($role) ?  json_encode($role->id) : json_encode(''); ?>,
            name: <?php echo isset($role) ?  json_encode($role->name) : json_encode(''); ?>,
            description: <?php echo isset($role) ?  json_encode($role->description) : json_encode(''); ?>
        },
        role_permissions: <?php echo isset($permission) ?  json_encode($permission) : json_encode(''); ?>
    };

    var vm = new Vue({
        el: "#app",
        data: data,
        methods: {
            saveRoleDetails: function() {
                var roleDetailsForm = $('#role-details-form');
                if(validator.validateForm(roleDetailsForm)) {
                    loading("info", "Saving role details...");
                    $.post(actionUrl, { action: 'save_role_details', form: data.role_details }, function(res) {
                        loading('success', 'Save successful!');
                        if (res.success && data.role_details.id == '') {
                            window.location = actionUrl + "management/roles/form/" + res.id;
                        }
                    }, 'json');
                }
            }
        }
    });

    $(function() {
        $('#sidebar-management-link').addClass('active');
        $('#sidebar-management-roles-link').addClass('active');
        $('#sidebar-management').addClass('in');
    });
</script>