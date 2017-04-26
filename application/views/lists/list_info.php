<div id="app">
    <h2><?php echo $list->id > 0 ? $list->name : 'Create List'; ?></h2>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url() . 'lists'; ?>">Lists</a></li>
        <li><a class="active"><?php echo $list->id > 0 ? $list->name : 'Create List'; ?></a></li>
    </ol>

    <div class="row" id="list-form">
        <div class="col-sm-12">
            <div class="notice"></div>
            <?php echo $this->session->flashdata('message'); ?>
        </div>
        <div class="col-sm-12 panel-white">
            <div class="col-sm-6" style="padding: 0 !important;">
                <div class="form-group">
                    <label for="name">* List Name</label>
                     <input name="name" type="text" class="form-control required" required
                           title="List Name" v-model="list.name" />

                    <?php if ($mc->_checkModulePermission(MODULE_LIST_ID, 'update') || 
                    ($list->id > 0 && $mc->_checkListPermission($list->id, 'update'))): ?>
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
                    <?php if (($list->id > 0 && $mc->_checkListPermission($list->id, 'update')) || $list->id === 0):  ?>
                    <button v-on:click="saveList" class="btn btn-sm btn-block btn-main">
                        <i class="fa fa-save"></i> Save
                    </button>
                    <?php endif; ?>
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

    <div class="row" style="margin-top: 20px;">
        <div class="col-sm-12" style="padding: 0;">
        <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active" v-show="list.id > 0"><a href="#properties" aria-controls="properties" role="tab" data-toggle="tab"><i class="fa fa-home"></i> Properties</a></li>
            <li role="presentation" v-bind:class="{ active: list.id == 0 }"><a href="#mailing" aria-controls="mailing" role="tab" data-toggle="tab"><i class="fa fa-envelope"></i> Mailing</a></li>
          </ul>

          <!-- Tab panes -->
          <div class="tab-content">

            <!-- Properties -->
            <div role="tabpanel" class="tab-pane active" id="properties" v-show="list.id > 0">
                <?php 
                $this->load->view('blocks/filter', [
                    'filter_fields' => [
                        'status',
                        'id',
                        'skip-traced',
                        'resource',
                        'property-name',
                        'property-address'
                    ]
                ]); 
                ?>

                <?php $this->load->view('blocks/bulk_action'); ?>

                <div style="margin-top: 20px;">
                    <table class="table table-bordered table-hover dt-responsive nowrap" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th width="15%" class="td-col-first">ID</th>
                            <th width="15%">Status</th>
                            <th width="25%">Property Name</th>
                            <th width="25%">Property Address</th>
                            <th width="20%">Date Created</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <!-- Mailing -->
            <div role="tabpanel" class="tab-pane" id="mailing" v-bind:class="{ active: list.id == 0 }">
                <div class="notice"></div>
                <div class="row">
                    <div class="col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label>Mailing Interval</label>
                            <select class="form-control required" v-model="list.mailing_type">
                                <option value="">Select Mailing Interval</option>
                                <option value="1 week">1 week</option>
                                <option value="2 weeks">2 weeks</option>
                                <option value="3 weeks">3 weeks</option>
                                <option value="1 month">1 month</option>
                                <option value="2 months">2 months</option>
                                <option value="3 months">3 months</option>
                                <option value="4 months">4 months</option>
                                <option value="5 months">5 months</option>
                                <option value="6 months">6 months</option>
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
</div>

<script>
    var dt;
    var actionUrl = "<?php echo base_url() . 'lists/info'; ?>";

    var data = {
        list : <?php echo json_encode($list); ?>,
        filter : {
            status: ['all'],
            resource: '',
            property_name : '',
            property_address : '',
            id: '',
            skip_traced: 0
        },
        bulkStatus: ''
    };

    var oldMailingType = data.list.mailing_type;
    var oldNoLetters = data.list.no_of_letters;

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
                    var list = {
                        name : data.list.name,
                        show_property: data.list.show_property == "1" && data.list.show_property ? 1 : 0,
                        show_pr: data.list.show_pr == "1" &&  data.list.show_pr ? 1 : 0,
                        show_attorney: data.list.show_attorney == "1" && data.list.show_pr ? 1 : 0,
                        show_mail: data.list.show_mail == "1" && data.list.show_pr ? 1 : 0,
                        mailing_type: data.list.mailing_type,
                        no_of_letters: data.list.no_of_letters
                    };
                    if (data.list.id > 0) {
                        list.id = data.list.id;
                    }
                    var adjust = false;
                    if ((oldMailingType !== list.mailing_type || oldNoLetters !== list.no_of_letters) && data.list.id > 0) {
                        showModal('yesno', {
                            title: 'Auto Adjust',
                            body: 'You have changed the mailing interval or no. of letters, do you want to adjust all existing properties with this setup?',
                            callback: function() {
                                adjust = true;
                                vm.saveNow(list, adjust);
                                hideModal();
                            },
                            cancelCallback: function() {
                                vm.saveNow(list, adjust);
                            }
                        });
                    } else {
                        vm.saveNow(list, adjust);
                    }
                }
            },
            saveNow: function(list, adjust) {
                loading('info', 'Saving list...');
                $.post(actionUrl, { 
                    action: 'save_list', 
                    list: list,
                    adjust: adjust
                }, function(res) {
                    if (res.success) {
                        loading('success', 'Save successful!');
                        window.location = baseUrl + 'lists/info/' + res.id;
                    } else {
                        validator.displayAlertError($('#list-form'), true, res.message);
                    }
                }, 'json');
            },
            deleteList: function() {
                showModal('confirm', {
                    title: 'Delete List',
                    body: '<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> WARNING: This action cannot be undone.</span><br /> Are you sure to delete this list?',
                    callback: function() {
                        loading("info", "Deleting list...");
                        $.post(actionUrl, { 
                            action: 'delete_list', 
                            list_id: data.list.id 
                        }, function(res) {
                            hideModal();
                            window.location = baseUrl + 'lists/';
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
                    status: ['all'],
                    resource: '',
                    property_name : '',
                    property_address : '',
                    id: '',
                    skip_traced: 0
                };
                $("#status").val(null).trigger("change");
                $("#status").val('all').trigger("change");
            },
            download: function() {
                showModal('yesno', {
                    title: 'Save Download History',
                    body: 'Do you want this download to be saved in the download history?',
                    callback: function() {
                        $('#global-modal').modal('hide');
                        window.open(baseUrl + 'download/download/list/1', '_blank');
                    },
                    cancelCallback: function() {
                        $('#global-modal').modal('hide');
                        window.open(baseUrl + 'download/download/list', '_blank');
                    }
                });
            },
            bulkDelete: function() {
                showModal('confirm', {
                    title: 'Bulk Delete Property',
                    body: 'Are you sure to delete this properties?',
                    callback: function() {
                        loading('info', 'Deleting properties, please wait...');
                        $.post(baseUrl + 'property/bulk_action', { 
                            action: 'bulk_action', 
                            filter: data.filter, 
                            bulk_action: 'delete' 
                        }, function(res) {
                            if (res.success) {
                                loading('success', 'Action Complete');
                                hideModal();
                                vm.filterList();
                                
                            }
                        }, 'json');
                    }
                });
            },
            bulkChangeStatus: function() {
                loading('info', 'Updating Status of properties, please wait...');
                $.post(baseUrl + 'property/bulk_action', { 
                    action: 'bulk_action', 
                    filter: data.filter, 
                    bulk_action: 'change_status', 
                    status: data.bulkStatus 
                }, function(res) {
                    if (res.success) {
                        loading('success', 'Action Complete');
                        vm.filterList();
                        $('#bulk-change-status-modal').modal('hide');
                    }
                }, 'json');
            }
        }
    });

    $(function() {
        $('#sidebar-list-link').addClass('active');
        $('#sidebar-list').addClass('in');

        setupSelect2Fields();
        $("#status").val(null).trigger("change");
        $("#status").val('all').trigger("change");

        setupDataTables();
    });

    function setupSelect2Fields() {
        $('#status').select2({
            allowClear: true,
            data: <?php echo json_encode($statuses); ?>,
            closeOnSelect: false,
            placeholder: {
                id: "",
                placeholder: "Select a status"
            }
        }).on('change', function() {
            if ($.inArray('all', $(this).val()) > -1 && $(this).val().length > 1 && data.statusAll) {
                var selected = $(this).val();
                $("#status").val(null).trigger("change");
                $("#status").val(selected[1]).trigger("change");
                data.statusAll = false;
            }
            if ($.inArray('all', $(this).val()) > -1 && $(this).val().length > 1 && !data.statusAll) {
                $("#status").val(null).trigger("change");
                $("#status").val('all').trigger("change");
                data.statusAll = true;
            }
            data.filter.status = $(this).val();
        });
    }

    function setupDataTables() {
        dt = $('table').dataTable({
            "order": [[ 0, "desc" ]],
            "bDestroy": true,
            "filter": true,
            "ajax": {
                "type": "POST",
                "url": actionUrl,
                "data":  {
                    action: "property_list",
                    list_id: <?php echo json_encode($list->id); ?>,
                    filter: data.filter
                }
            },
            columns: [
                { data: "id" },
                { data: "status", render: function(data, type, row) {
                        if (data.toLowerCase() == "active" || data.toLowerCase() == "lead" || data.toLowerCase() == "buy") {
                            return "<span class='label label-success'>" + capitalize(data) + "</span>";
                        } else if (data.toLowerCase() == "duplicate" || data.toLowerCase() == "draft") {
                            return "<span class='label label-warning'>" + capitalize(data) + "</span>";
                        } else if (data.toLowerCase() =="change") {
                            return "<span class='label label-info'>" + capitalize(data) + "</span>";
                        } else if (data.toLowerCase() =="inactive") {
                            return "<span class='label label-default'>" + capitalize(data) + "</span>";
                        } else if (data.toLowerCase() =="stop") {
                            return "<span class='label label-danger'>" + capitalize(data) + "</span>";
                        } else {
                            return data.toLowerCase();
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
                $('table tbody tr').on('click', function (e) {
                    if (undefined !== e) {
                        if ($(e.target).attr('class') && $(e.target).attr('class').includes('dt-align-toggle')) {
                            return;
                        }  
                    }
                    var pos = table.fnGetPosition(this);
                    var d = table.fnGetData(pos);
                    window.location = baseUrl + 'lists/property/' + data.list.id + '/info/' + d.id; 
                });
            },
            "language": {
                "emptyTable": "No property found for this list."
            },
            "columnDefs": [
                { className: "dt-align-toggle", "targets": [0] }
            ]
        });
    }
</script>