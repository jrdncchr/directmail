<div id="app">
    <h2><?php echo $list->id > 0 ? $list->name : 'Create List'; ?></h2>
    <ol class="breadcrumb">
        <li><a>List</a></li>
        <li><a href="<?php echo base_url() . 'lists/category/' . $list_category->_id; ?>"><?php echo $list_category->name; ?></a></li>
        <li><a class="active"><?php echo $list->id > 0 ? $list->name : 'Create List'; ?></a></li>
    </ol>

    <div class="row" id="list-form">
        <div class="col-sm-12">
            <div class="notice"></div>
        </div>
        <div class="col-sm-12 panel-white">
            <div class="col-sm-6" style="padding: 0 !important;">
                <div class="form-group">
                    <label for="name">* List Name</label>
                     <input name="name" type="text" class="form-control required" required
                           title="List Name" v-model="list.name" />
                    <?php if (($list->id > 0 && $mc->_checkListPermission($list->id, 'update')) ||
                        ($list->id == 0 && $mc->_checkListCategoryPermission($list_category->_id, 'create'))): 
                    ?>
                   	<ul class="list-group" style="margin-top: 20px;">
					  <li class="list-group-item">
					    <label class="control control--checkbox pull-right" style="top: -2px">
                            <input type="checkbox" v-model="list.show_property" />
                            <div class="control__indicator"></div>
                        </label>
					    Property
					  </li>
					  <li class="list-group-item">
					    <label class="control control--checkbox pull-right" style="top: -2px">
                            <input type="checkbox" v-model="list.show_pr" />
                            <div class="control__indicator"></div>
                        </label>
					    PR
					  </li>
					  <li class="list-group-item">
					    <label class="control control--checkbox pull-right" style="top: -2px">
                            <input type="checkbox" v-model="list.show_attorney" />
                            <div class="control__indicator"></div>
                        </label>
					    Attorney
					  </li>
					  <li class="list-group-item">
					    <label class="control control--checkbox pull-right" style="top: -2px">
                            <input type="checkbox" v-model="list.show_mail" />
                            <div class="control__indicator"></div>
                        </label>
					    Mail
					  </li>
					</ul>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name">* Actions</label>
                    <button v-on:click="saveList" class="btn btn-sm btn-block btn-main">
                        <i class="fa fa-save"></i> Save
                    </button>
                    <?php endif; ?>
                    <?php if (($list->id > 0 && $mc->_checkListPermission($list->id, 'create'))):  ?>
                    <a href="<?php echo base_url() . 'lists/property/' . $list->id . '/new'; ?>" class="btn btn-sm btn-default btn-block">
                    <i class="fa fa-plus-circle"></i> Add Property
                    </a>
                    <a href="<?php echo base_url() . 'lists/info/' . $list->id . '/bulk_import'; ?>" class="btn btn-sm btn-default btn-block">
                        <i class="fa fa-upload"></i> Bulk Import
                    </a>
                    <?php endif; ?>
                    <?php if ($mc->_checkListPermission($list->id, 'delete')): ?>
                    <button v-on:click="deleteList" class="btn btn-block btn-sm">
                        <i class="fa fa-trash"></i> Delete List
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>


    <?php if ($list->id > 0): ?>
    <div class="row" style="margin-top: 20px;">
        <div class="col-sm-12" style="padding: 0;">
        <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#properties" aria-controls="properties" role="tab" data-toggle="tab"><i class="fa fa-home"></i> Properties</a></li>
            <li role="presentation"><a href="#mailing" aria-controls="mailing" role="tab" data-toggle="tab"><i class="fa fa-envelope"></i> Mailing</a></li>
          </ul>

          <!-- Tab panes -->
          <div class="tab-content">

            <!-- Properties -->
            <div role="tabpanel" class="tab-pane active" id="properties">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="filterHeading">
                        <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#filterBox" aria-expanded="true" aria-controls="filterBox" >
                            <a role="button" style="font-size: 16px !important; font-weight: bold;">
                                FILTER
                            </a>
                        </h4>
                    </div>
                    <div id="filterBox" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="filterHeading">
                        <div class="panel-body">
                            <div class="form-horizontal">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="date-to" class="control-label col-sm-2">Status</label>
                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <div class="button-group">
                                                            <button type="button" class="btn btn-dd btn-sm dropdown-toggle" data-toggle="dropdown"></span> <span class="fa fa-caret-down"></span></button>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a class="small" data-value="Active" tabIndex="-1"><input type="checkbox" checked="true" />&nbsp;Active</a>
                                                                    <a class="small" data-value="Lead" tabIndex="-1"><input type="checkbox" checked="true" />&nbsp;Lead</a>
                                                                    <a class="small" data-value="Pending" tabIndex="-1"><input type="checkbox" checked="true" />&nbsp;Pending</a>
                                                                    <a class="small" data-value="Change" tabIndex="-1"><input type="checkbox" checked="true" />&nbsp;Change</a>
                                                                    <a class="small" data-value="Replacement" tabIndex="-1"><input type="checkbox" checked="true" />&nbsp;Replacement</a>
                                                                    <a class="small" data-value="Stop" tabIndex="-1"><input type="checkbox" checked="true" />&nbsp;Stop</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </span>
                                                    <input type="text" class="form-control" v-model="statusText" disabled />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="property-name" class="control-label col-sm-4">Property Name</label>
                                            <div class="col-sm-8">
                                                <input id="property-name" type="text" class="form-control" v-model="filter.property_name" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="property-address" class="control-label col-sm-4">Property Address</label>
                                            <div class="col-sm-8">
                                                <input id="property-address" type="text" class="form-control" v-model="filter.property_address" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-sm-4">ID</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" v-model="filter.id" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <button v-on:click="clearFilter" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                                        <a target="_blank" href="<?php echo base_url() . 'download/properties/list_properties'; ?>" class="btn btn-default btn-sm"><i class="fa fa-download"></i></a>
                                        <button v-on:click="filterList" class="btn btn-default btn-sm pull-right" style="width: 200px;">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive" style="width: 100%; margin-top: 20px;">
                    <table class="table table-bordered table-hover" width="100%">
                        <thead>
                        <tr>
                            <th width="10%">ID</th>
                            <th width="10%">Status</th>
                            <th width="20%">Property Name</th>
                            <th width="35%">Property Address</th>
                            <th width="20%">Date Created</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <!-- Mailing -->
            <div role="tabpanel" class="tab-pane active" id="mailing">
                <div class="notice"></div>
                <div class="row">
                    <div class="col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label>Mailing Type</label>
                            <select class="form-control required" v-model="list.mailing_type">
                                <option value="">Select Mailing Type</option>
                                <option value="Bi-monthly">Bi-monthly</option>
                                <option value="Monthly">Monthly</option>
                                <option value="Quarterly">Quarterly</option>
                                <option value="Weekly">Weekly</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>No. of Letters</label>
                            <input type="number" class="form-control required" v-model="list.no_of_letters" />
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>
<?php endif; ?>
</div>

<script>
    var dt;
    var actionUrl = "<?php echo base_url() . 'lists/info'; ?>";
    var sidebarListCategoryId = "<?php echo 'sidebar-list-category-' . $list_category->_id . '-link'; ?>";

    var data = {
        list_category : <?php echo json_encode($list_category); ?>,
        list : <?php echo json_encode($list); ?>,
        filter : {
            property_name : '',
            property_address : '',
            id: '',
            status_off: [],
            status_on: ['Active', 'Lead', 'Pending', 'Change', 'Replacement', 'Stop'],
        },
        statusText: 'All'
    };

    var vm = new Vue({
        el: "#app",
        data: data,
        methods: {
            /*
             * List Functions
             */
            saveList: function() {
                var form = $('#list-form');
                if (validator.validateForm(form)) {
                    loading('info', 'Saving list...');
                    var list = {
                        name : data.list.name,
                        list_category_id: data.list_category._id,
                        show_property: data.list.show_property ? 1 : 0,
                        show_pr: data.list.show_pr ? 1 : 0,
                        show_attorney: data.list.show_attorney ? 1 : 0,
                        show_mail: data.list.show_mail ? 1 : 0,
                        mailing_type: data.list.mailing_type,
                        no_of_letters: data.list.no_of_letters
                    };
                    if (data.list.id > 0) {
                        list.id = data.list.id;
                    }
                    $.post(actionUrl, { 
                        action: 'save_list', 
                        list: list
                    }, function(res) {
                        if (res.success) {
                            loading('success', 'Save successful!');
                            window.location = baseUrl + 'lists/info/' + res.id;
                        } else {
                            validator.displayAlertError(form, true, res.message);
                        }
                    }, 'json');
                }
            },
            deleteList: function() {
                showConfirmModal({
                    title: 'Delete List',
                    body: 'Are you sure to delete this list?',
                    callback: function() {
                        loading("info", "Deleting list...");
                        $.post(actionUrl, { 
                            action: 'delete_list', 
                            list_id: data.list.id 
                        }, function(res) {
                            hideConfirmModal();
                            window.location = baseUrl + 'lists/category/' + data.list_category._id ;
                        }, 'json');
                    }
                });
            },
            filterList: function() {
                loading('info', 'Filtering, please wait...');
                $.post(actionUrl, { action: 'property_list', list_id: data.list.id, filter: data.filter }, function(res) {
                    dt.fnClearTable();
                    if (res.data.length) {
                        dt.fnAddData(res.data)   
                    }
                    dt.fnDraw();
                    loading('success', 'Filter Complete');
                }, 'json');
            },
            clearFilter: function() {
                data.filter = {
                    property_name : '',
                    property_address : '',
                    status: 'all',
                    id: ''
                }
            }
        }
    });

    $(function() {
        $('#sidebar-list-link').addClass('active');
        $('#' + sidebarListCategoryId).addClass('active');
        $('#sidebar-list').addClass('in');

        $('.dropdown-menu a').on( 'click', function( event ) {
            var $target = $(event.currentTarget),
                val = $target.attr('data-value'),
                $inp = $target.find('input'),
                idx;

            if ((idx = data.filter.status_on.indexOf(val)) > -1) {
                data.filter.status_off.push(val);
                data.filter.status_on.splice(idx, 1);
                setTimeout(function() {$inp.prop('checked', false)}, 0);
            } else {
                idx = data.filter.status_off.indexOf(val);
                data.filter.status_on.push(val);
                data.filter.status_off.splice(idx, 1);
                setTimeout(function() {$inp.prop('checked', true)}, 0);
            }

            $(event.target).blur();
            if (data.filter.status_off.length) {
                data.statusText = data.filter.status_on.join(', ');
            } else {
                data.statusText = "All";
            }
            return false;
        });

        dt = $('table').dataTable({
            "order": [[ 0, "desc" ]],
            "bDestroy": true,
            "filter": true,
            "ajax": {
                "type": "POST",
                "url": actionUrl,
                "data":  {
                    action: "property_list",
                    list_id: <?php echo json_encode($list->id); ?>
                }
            },
            columns: [
                { data: "id" },
                { data: "status", render: function(data, type, row) {
                        if (data == "active" || data == "lead") {
                            return "<span class='label label-success'>" + capitalize(data) + "</span>";
                        } else if (data == "pending" || data == "replacement") {
                            return "<span class='label label-warning'>" + capitalize(data) + "</span>";
                        } else if (data =="change") {
                            return "<span class='label label-info'>" + capitalize(data) + "</span>";
                        } else if (data =="inactive") {
                            return "<span class='label label-default'>" + capitalize(data) + "</span>";
                        } else if (data =="stop") {
                            return "<span class='label label-danger'>" + capitalize(data) + "</span>";
                        }
                    } 
                },
                { data: "property_last_name", render:
                    function(data, type, row) {
                        return row.property_last_name + " " + row.property_first_name + ", " + row.property_middle_name;
                    }
                },
                { data: "property_address" },
                { data: "date_created" }
            ],
            "fnDrawCallback": function (oSettings) {
                var table = $("table").dataTable();
                $('table tbody tr').on('click', function () {
                    var pos = table.fnGetPosition(this);
                    var d = table.fnGetData(pos);
                    window.location = baseUrl + 'lists/property/' + data.list.id + '/info/' + d.id; 
                });
            },
            "language": {
                "emptyTable": "No property found for this list."
            }
        });
    });
</script>