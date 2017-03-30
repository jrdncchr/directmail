<div id="app">
    <h2>Duplicates</h2>
    <ol class="breadcrumb">
        <li><a>Approval</a></li>
        <li><a class="active">Duplicates</a></li>
    </ol>

    <div class="row">
        <div class="col-sm-12 panel-white">
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
                                        <label for="status" class="control-label col-sm-2">Target Status</label>
                                        <div class="col-sm-10">
                                            <select id="target-status" class="form-control" multiple="multiple">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="list" class="control-label col-sm-2">Target List</label>
                                        <div class="col-sm-10">
                                            <select id="target-list" class="form-control" multiple="multiple">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="property-address" class="control-label col-sm-4">Target Address</label>
                                        <div class="col-sm-8">
                                            <input id="property-address" type="text" class="form-control" v-model="filter.target_address" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="upload-by" class="control-label col-sm-4">Upload By</label>
                                        <div class="col-sm-8">
                                            <select id="upload-by" class="form-control">
                                                <option value="all">All</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="property-address" class="control-label col-sm-4">Address</label>
                                        <div class="col-sm-8">
                                            <input id="property-address" type="text" class="form-control" v-model="filter.property_address" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="upload-date" class="control-label col-sm-4">Upload Date</label>
                                        <div class="col-sm-8">
                                            <input id="upload-date" type="text" class="form-control" v-model="filter.upload_date" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <button v-on:click="clearFilter" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                                    <button v-on:click="filterList" class="btn btn-default btn-sm pull-right" style="width: 200px;">Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <table id="duplicates" class="table table-bordered table-hover" width="100%">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Status</th>
                        <th>Property Address</th>
                        <th>Upload By</th>
                        <th>Upload Date</th>
                        <th></th>
                        <th>Target List</th>
                        <th>Target Status</th>
                        <th>Detected Similar Property</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<script>
    var duplicateDt;
    var actionUrl = "<?php echo base_url() . 'approval/duplicates'; ?>";

    var data = {
        filter : {
            target_status: ['all'],
            target_list : ['all'],
            target_address: '',
            property_address : '',
            upload_date: '',
            upload_by: ''
        },
        users: <?php echo json_encode($users); ?>,
        targetStatusAll: true,
        targetListAll: true
    };

    var vm = new Vue({
        el: "#app",
        data: data,
        methods: {
            filterList: function() {
                if (!data.filter.target_status || !data.filter.target_list) {
                    loading('danger', 'Please select a status and a list.')
                    return;
                }
                loading('info', 'Filtering, please wait...');
                $.post(actionUrl, { action: 'list', filter: data.filter }, function(res) {
                    duplicateDt.fnClearTable();
                    if (res.data.length) {
                        duplicateDt.fnAddData(res.data)   
                    }
                    duplicateDt.fnDraw();
                    loading('success', 'Filter Complete');
                }, 'json');
            },
            clearFilter: function() {
                data.filter = {
                    target_status: ['all'],
                    target_list: ['all'],
                    target_address: '',
                    property_address : '',
                    upload_date: '',
                    upload_by: ''
                };
                $("#target-status").val(null).trigger("change");
                $("#target-status").val('all').trigger("change");

                $("#target-list").val(null).trigger("change");
                $("#target-list").val('all').trigger("change");

                $("#upload-by").val('all').trigger("change");
            }
        }
    });

    $(function() {
        $('#sidebar-approval-link').addClass('active');
        $('#sidebar-approval-duplicates-link').addClass('active');
        $('#sidebar-approval').addClass('in');

        $('#upload-date').datepicker({
            language: 'en',
            dateFormat: 'yyyy-mm-dd',
            onSelect: function(formattedDate, date, inst) {
                data.filter.upload_date = formattedDate;
            }
        });

        setupSelect2Fields();
        $('#target-list').val('all').trigger('change');
        $('#target-status').val('all').trigger('change');

        setupDataTables();
    });

    function replaceAction(action, property) {
        loading('info', 'Taking action, please wait...');
        $.post(actionUrl, {
            action: 'replace_action',
            replace_action: action,
            property: property
        }, function(res) {
            if (res.success) {
                duplicateDt.fnReloadAjax();
                loading('success', 'Replacement action complete.');
            }
        }, 'json');
    }

    function setupSelect2Fields() {
         $("#upload-by").select2({
          data: data.users
        }).on('change', function() {
            data.filter.upload_by = $(this).val();
        });

        $('#target-status').select2({
            allowClear: true,
            data: <?php echo json_encode($statuses); ?>,
            closeOnSelect: false,
            placeholder: {
                id: "",
                placeholder: "Select a status"
            }
        }).on('change', function() {
            if ($.inArray('all', $(this).val()) > -1 && $(this).val().length > 1 && data.targetStatusAll) {
                var selected = $(this).val();
                $("#target-status").val(null).trigger("change");
                $("#target-status").val(selected[1]).trigger("change");
                data.targetStatusAll = false;
            }
            if ($.inArray('all', $(this).val()) > -1 && $(this).val().length > 1 && !data.targetStatusAll) {
                $("#target-status").val(null).trigger("change");
                $("#target-status").val('all').trigger("change");
                data.targetStatusAll = true;
            }
            data.filter.target_status = $(this).val();
        });

        $('#target-list').select2({
            allowClear: true,
            data: <?php echo json_encode($lists); ?>,
            closeOnSelect: false,
            placeholder: {
                id: "",
                placeholder: "Select a list"
            }
        }).on('change', function() {
            if ($.inArray('all', $(this).val()) > -1 && $(this).val().length > 1 && data.targetListAll) {
                var selected = $(this).val();
                $("#target-list").val(null).trigger("change");
                $("#target-list").val(selected[1]).trigger("change");
                data.targetListAll  = false;
            }
            if ($.inArray('all', $(this).val()) > -1 && $(this).val().length > 1 && !data.targetListAll) {
                $("#target-list").val(null).trigger("change");
                $("#target-list").val('all').trigger("change");
                data.targetListAll  = true;
            }
            data.filter.target_list = $(this).val();
        });
    }

    function setupDataTables() {
        duplicateDt = $('table#duplicates').dataTable({
            "order": [[ 0, "desc" ]],
            "filter": true,
            "ajax": {
                "type": "POST",
                "url": actionUrl,
                "data":  {
                    action: "list",
                    filter: data.filter
                }
            },
            columns: [
                { data: "id", render: function(data, type, row) {
                        return '<div class="btn-group">' +
                                    '<button type="button" class="btn btn-xs btn-default btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                                        'Action <span class="caret"></span>' +
                                    '</button>' +
                                    '<ul class="dropdown-menu">' +
                                        '<li><a data-source="1" href="#">Remove</a></li>' +
                                        '<li><a data-source="2" href="#">Replace (Property Address only)</a></li>' +
                                        '<li><a data-source="3" href="#"">Replace (Property info only)</a></li>' +
                                        '<li><a data-source="4" href="#">Replace (All including list, mailing, and comments)</a></li>' +
                                        '<li><a data-source="5" href="#">Keep (Duplicate will be saved as active.)</a></li>' +
                                    '</ul>' +
                                '</div>' +
                            '</td>';
                    } 
                },
                { data: "status", render: function(data, type, row) {
                        return "<span class='label label-warning'>" + capitalize(data) + "</span>"; 
                    }
                },
                { data: "property_address", render: function(data, type, row) {
                        return '<a href="' + row.url + '" target="_blank">' + data + '</a>';
                    }
                },
                { data: "upload_by" },
                { data: "upload_date" },
                { data: "target_id", render: function(data, type, row) {
                        return '<i class="fa fa-arrows-h fa-2x"></i>';
                    }
                },
                { data: "target_list_name", render: function(data, type, row) {
                        return '<a href="' + row.target_url + '" target="_blank">' + data + '</a>';
                    }
                },
                { data: "target_status", render: function(data, type, row) {
                        if (data == "active" || data == "lead" || data == "buy") {
                            return "<span class='label label-success'>" + capitalize(data) + "</span>";
                        } else if (data == "duplicate" || data == "draft") {
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
                { data: "target_property_address", render: function(data, type, row) {
                        return '<a href="' + row.target_url + '" target="_blank">' + data + '</a>';
                    }
                }
            ], 
            "columnDefs": [ {
                "targets": 5,
                "orderable": false
            }],
            "language": {
                "emptyTable": "No property found for this list."
            }
        });

        var table = $('table#duplicates').DataTable();
        $('table#duplicates tbody').on('click', 'tr ul.dropdown-menu a', function () {
            var property = table.row( $(this).closest('tr') ).data();
            replaceAction($(this).data('source'), property);
        });
    }
</script>