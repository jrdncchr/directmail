<style>
    th {
        background: cornsilk !important;
        color: #BD3738;
        padding-bottom: 22px !important;;
    }
    td {
        background: white;
    }
    tr.check-all td {
        background: cornsilk !important;
    }
</style>
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
            <button class="btn btn-default btn-xs" style="margin-bottom: 10px;" v-on:click="deleteRole"><i class="fa fa-trash-o"></i> Delete Role</button>
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
                    Page Permissions
                    <button class="btn btn-default btn-xs pull-right" v-on:click="saveModulePermissions"><i class="fa fa-save"></i> Save</button>
                </div>
                <div class="panel-body" style="padding-top: 0; padding-bottom: 0;">
                    <div class="row">
                        <div class="notice"></div>
                        <table class="table table-bordered table-hover" style="margin-bottom: 0;">
                            <thead>
                            <tr>
                                <th width="30%">Module</th>
                                <th width="15%">
                                    Retrieve
                                    <label class="control control--checkbox">
                                        <input type="checkbox" v-model="data.module_permissions_all.retrieve" v-on:change="checkAllModule('retrieve')" />
                                        <div class="control__indicator"></div>
                                    </label>
                                </th>
                                <th width="15%">
                                    Create
                                    <label class="control control--checkbox">
                                        <input type="checkbox" v-model="data.module_permissions_all.create" v-on:change="checkAllModule('create')" />
                                        <div class="control__indicator"></div>
                                    </label></th>
                                <th width="15%">
                                    Update
                                    <label class="control control--checkbox">
                                        <input type="checkbox" v-model="data.module_permissions_all.update" v-on:change="checkAllModule('update')" />
                                        <div class="control__indicator"></div>
                                    </label></th>
                                <th width="15%">
                                    Delete
                                    <label class="control control--checkbox">
                                        <input type="checkbox" v-model="data.module_permissions_all.remove" v-on:change="checkAllModule('remove')" />
                                        <div class="control__indicator"></div>
                                    </label></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="permission in module_permissions">
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

            <div class="panel panel-default">
                <div class="panel-heading">
                    List Category Permissions
                    <button class="btn btn-default btn-xs pull-right" v-on:click="saveListCategoryPermissions"><i class="fa fa-save"></i> Save</button>
                </div>
                <div class="panel-body" style="padding-top: 0; padding-bottom: 0;">
                    <div class="row">
                        <div style="margin: 10px;" class="notice alert alert-info"><i class="fa fa-infomration-circle"></i> Make sure to check the permissions for the "List" in the Page permission.</div>
                        <table class="table table-bordered table-hover" style="margin-bottom: 0;">
                            <thead>
                            <tr>
                                <th width="30%">List Category</th>
                                <th width="15%">
                                    Retrieve
                                    <label class="control control--checkbox">
                                        <input type="checkbox" v-model="data.list_category_permissions_all.retrieve" v-on:change="checkAllListCategory('retrieve')" />
                                        <div class="control__indicator"></div>
                                    </label>
                                </th>
                                <th width="15%">
                                    Create
                                    <label class="control control--checkbox">
                                        <input type="checkbox" v-model="data.list_category_permissions_all.create" v-on:change="checkAllListCategory('create')" />
                                        <div class="control__indicator"></div>
                                    </label></th>
                                <th width="15%">
                                    Update
                                    <label class="control control--checkbox">
                                        <input type="checkbox" v-model="data.list_category_permissions_all.update" v-on:change="checkAllListCategory('update')" />
                                        <div class="control__indicator"></div>
                                    </label></th>
                                <th width="15%">
                                    Delete
                                    <label class="control control--checkbox">
                                        <input type="checkbox" v-model="data.list_category_permissions_all.remove" v-on:change="checkAllListCategory('remove')" />
                                        <div class="control__indicator"></div>
                                    </label></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="permission in list_category_permissions">
                                <td>
                                    {{ permission.name }}
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
    <br />
    <br />
</div>

<script>
    var actionUrl = "<?php echo base_url() . 'management/roles'; ?>";

    var data = {
        role_details: {
            id: <?php echo isset($role) ?  json_encode($role->id) : json_encode(''); ?>,
            name: <?php echo isset($role) ?  json_encode($role->name) : json_encode(''); ?>,
            description: <?php echo isset($role) ?  json_encode($role->description) : json_encode(''); ?>
        },
        module_permissions_all : {
            retrieve: 0,
            remove: 0,
            insert: 0,
            update: 0
        },
        list_category_permissions_all : {
            retrieve: 0,
            remove: 0,
            insert: 0,
            update: 0
        },
        module_permissions: <?php echo isset($module_permissions) ?  json_encode($module_permissions) : json_encode(''); ?>,
        list_category_permissions: <?php echo isset($list_category_permissions) ?  json_encode($list_category_permissions) : json_encode(''); ?>
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
            },
            saveModulePermissions: function() {
                loading("info", "Saving role page permissions...");
                $.post(actionUrl, {
                    action: 'save_module_permissions',
                    role_id: data.role_details.id,
                    module_permissions: data.module_permissions
                }, function(res) {
                    loading('success', 'Save successful!');
                    if (res.success && data.role_details.id == '') {
                        window.location = actionUrl + "management/roles/form/" + res.id;
                    }
                }, 'json');
            },
            saveListCategoryPermissions: function() {
                loading("info", "Saving list category permissions...");
                $.post(actionUrl, {
                    action: 'save_list_category_permissions',
                    role_id: data.role_details.id,
                    list_category_permissions: data.list_category_permissions
                }, function(res) {
                    loading('success', 'Save successful!');
                    if (res.success && data.role_details.id == '') {
                        window.location = actionUrl + "management/roles/form/" + res.id;
                    }
                }, 'json');
            },
            deleteRole: function() {
                showConfirmModal({
                    title: 'Delete Role',
                    body: 'Are you sure to delete this role?',
                    callback: function() {
                        loading("info", "Deleting role...");
                        $.post(actionUrl, { action: 'delete', role_id: data.role_details.id }, function(res) {
                            if (res.success) {
                                hideConfirmModal();
                                window.location = actionUrl;
                            } else {
                                loading('danger', res.message);
                            }
                        }, 'json');
                    }
                });
            },
            checkAllModule: function(action) {
                for (var i in data.module_permissions) {
                    if (action == 'retrieve') {
                        data.module_permissions[i].retrieve_action = data.module_permissions_all.retrieve;
                    } else if (action == 'remove') {
                        data.module_permissions[i].delete_action = data.module_permissions_all.remove;
                    } else if (action == 'update') {
                        data.module_permissions[i].update_action = data.module_permissions_all.update;
                    } else if (action == 'create') {
                        data.module_permissions[i].create_action = data.module_permissions_all.create;
                    }

                }
            },
            checkAllListCategory: function(action) {
                for (var i in data.list_category_permissions) {
                    if (action == 'retrieve') {
                        data.list_category_permissions[i].retrieve_action = data.list_category_permissions_all.retrieve;
                    } else if (action == 'remove') {
                        data.list_category_permissions[i].delete_action = data.list_category_permissions_all.remove;
                    } else if (action == 'update') {
                        data.list_category_permissions[i].update_action = data.list_category_permissions_all.update;
                    } else if (action == 'create') {
                        data.list_category_permissions[i].create_action = data.list_category_permissions_all.create;
                    }

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