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
    tbody tr:hover td {
        color: #ffffff;
        background-color: grey;
    }
</style>
<div id="app">
    <h2>User Permission</h2>
    <ol class="breadcrumb">
        <li><a>Management</a></li>
        <li><a href="<?php echo base_url() . 'management/users'; ?>">Users</a></li>
        <li><a href="<?php echo base_url() . 'management/users/form/' . $user->id; ?>"><?php echo $user->first_name . ' ' . $user->last_name; ?></a></li>
        <li><a class="active">User Permission</a></li>
    </ol>

    <div class="row">
        <div class="col-sm-12">
            <h3><?php echo $user->first_name . ' ' . $user->last_name; ?></h3>
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
                            <tbody></tbody>
                        </table>
                        <table class="table" style="margin-bottom: 0 !important;" v-for="permission in module_permissions">
                            <tbody>
                            <tr>
                                <td width="30%">{{ permission.name }}</td>
                                <td width="15%">
                                    <label class="control control--checkbox">
                                        <input type="checkbox" v-model="permission.retrieve_action" />
                                        <div class="control__indicator"></div>
                                    </label>
                                </td>
                                <td width="15%">
                                    <label class="control control--checkbox">
                                        <input type="checkbox" v-model="permission.create_action" />
                                        <div class="control__indicator"></div>
                                    </label>
                                </td>
                                <td width="15%">
                                    <label class="control control--checkbox">
                                        <input type="checkbox" v-model="permission.update_action" />
                                        <div class="control__indicator"></div>
                                    </label>
                                </td>
                                <td width="15%">
                                    <label class="control control--checkbox">
                                        <input type="checkbox" v-model="permission.delete_action" />
                                        <div class="control__indicator"></div>
                                    </label>
                                </td>
                            </tr>
                            <tr v-if="permission.children.length" v-for="child in permission.children">
                                <td width="30%" style="padding-left: 50px !important;">&rightarrow; {{ child.name }}</td>
                                <td width="15%">
                                    <label class="control control--checkbox">
                                        <input type="checkbox" v-model="child.retrieve_action" />
                                        <div class="control__indicator"></div>
                                    </label>
                                </td>
                                <td width="15%">
                                    <label class="control control--checkbox">
                                        <input type="checkbox" v-model="child.create_action" />
                                        <div class="control__indicator"></div>
                                    </label>
                                </td>
                                <td width="15%">
                                    <label class="control control--checkbox">
                                        <input type="checkbox" v-model="child.update_action" />
                                        <div class="control__indicator"></div>
                                    </label>
                                </td>
                                <td width="15%">
                                    <label class="control control--checkbox">
                                        <input type="checkbox" v-model="child.delete_action" />
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
                    List Permissions
                    <button class="btn btn-default btn-xs pull-right" v-on:click="saveListPermissions"><i class="fa fa-save"></i> Save</button>
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
                                        <input type="checkbox" v-model="data.list_permissions_all.retrieve" v-on:change="checkAllList('retrieve')" />
                                        <div class="control__indicator"></div>
                                    </label>
                                </th>
                                <th width="15%">
                                    Create
                                    <label class="control control--checkbox">
                                        <input type="checkbox" v-model="data.list_permissions_all.create" v-on:change="checkAllList('create')" />
                                        <div class="control__indicator"></div>
                                    </label></th>
                                <th width="15%">
                                    Update
                                    <label class="control control--checkbox">
                                        <input type="checkbox" v-model="data.list_permissions_all.update" v-on:change="checkAllList('update')" />
                                        <div class="control__indicator"></div>
                                    </label></th>
                                <th width="15%">
                                    Delete
                                    <label class="control control--checkbox">
                                        <input type="checkbox" v-model="data.list_permissions_all.remove" v-on:change="checkAllList('remove')" />
                                        <div class="control__indicator"></div>
                                    </label></th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <table class="table" style="margin-bottom: 0 !important;" v-for="permission in list_permissions">
                            <tbody>
                            <tr>
                                <td width="30%">{{ permission.name }}</td>
                                <td width="15%">
                                    <label class="control control--checkbox">
                                        <input type="checkbox" v-model="permission.retrieve_action" />
                                        <div class="control__indicator"></div>
                                    </label>
                                </td>
                                <td width="15%">
                                    <label class="control control--checkbox">
                                        <input type="checkbox" v-model="permission.create_action" />
                                        <div class="control__indicator"></div>
                                    </label>
                                </td>
                                <td width="15%">
                                    <label class="control control--checkbox">
                                        <input type="checkbox" v-model="permission.update_action" />
                                        <div class="control__indicator"></div>
                                    </label>
                                </td>
                                <td width="15%">
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
        </div>
    </div>
    <br />
    <br />
</div>

<script>
    var actionUrl = "<?php echo base_url() . 'management/users'; ?>";

    var data = {
        user_id : <?php echo json_encode($user->id) ?>,
        module_permissions_all : {
            retrieve: 0,
            remove: 0,
            insert: 0,
            update: 0
        },
        list_permissions_all : {
            retrieve: 0,
            remove: 0,
            insert: 0,
            update: 0
        },
        module_permissions: <?php echo isset($module_permissions) ?  json_encode($module_permissions) : json_encode(''); ?>,
        list_permissions: <?php echo isset($list_permissions) ?  json_encode($list_permissions) : json_encode(''); ?>
    };

    var vm = new Vue({
        el: "#app",
        data: data,
        methods: {
            saveModulePermissions: function() {
                loading("info", "Saving role page permissions...");
                $.post(actionUrl, {
                    action: 'save_module_permissions',
                    user_id: data.user_id,
                    module_permissions: data.module_permissions
                }, function(res) {
                    if (res.success) {
                        loading('success', 'Save successful!');
                    }
                }, 'json');
            },
            saveListPermissions: function() {
                loading("info", "Saving list category permissions...");
                $.post(actionUrl, {
                    action: 'save_list_permissions',
                    user_id: data.user_id,
                    list_permissions: data.list_permissions
                }, function(res) {
                    if (res.success) {
                        loading('success', 'Save successful!');
                    }
                }, 'json');
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
                    if (data.module_permissions[i].children.length) {
                        for (var y in data.module_permissions[i].children) {
                            if (action == 'retrieve') {
                                data.module_permissions[i].children[y].retrieve_action = data.module_permissions_all.retrieve;
                            } else if (action == 'remove') {
                                data.module_permissions[i].children[y].delete_action = data.module_permissions_all.remove;
                            } else if (action == 'update') {
                                data.module_permissions[i].children[y].update_action = data.module_permissions_all.update;
                            } else if (action == 'create') {
                                data.module_permissions[i].children[y].create_action = data.module_permissions_all.create;
                            }
                        }
                    }
                }
            },
            checkAllList: function(action) {
                for (var i in data.list_permissions) {
                    if (action == 'retrieve') {
                        data.list_permissions[i].retrieve_action = data.list_permissions_all.retrieve;
                    } else if (action == 'remove') {
                        data.list_permissions[i].delete_action = data.list_permissions_all.remove;
                    } else if (action == 'update') {
                        data.list_permissions[i].update_action = data.list_permissions_all.update;
                    } else if (action == 'create') {
                        data.list_permissions[i].create_action = data.list_permissions_all.create;
                    }
                }
            }
        }
    });

    $(function() {
        $('#sidebar-management-link').addClass('active');
        $('#sidebar-management-users-link').addClass('active');
        $('#sidebar-management').addClass('in');
    });
</script>