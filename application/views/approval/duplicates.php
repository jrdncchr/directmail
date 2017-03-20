<div id="app">
    <h2>Replacement Properties</h2>
    <ol class="breadcrumb">
        <li><a>Approval</a></li>
        <li><a class="active">Replacement Properties</a></li>
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
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="property-address" class="control-label col-sm-4">Address</label>
                                        <div class="col-sm-8">
                                            <input id="property-address" type="text" class="form-control" v-model="filter.property_address" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="upload-by" class="control-label col-sm-4">Upload By</label>
                                        <div class="col-sm-8">
                                            <input id="upload-by" type="text" class="form-control" v-model="filter.upload_by" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="upload-date" class="control-label col-sm-4">Upload Date</label>
                                        <div class="col-sm-8">
                                            <input id="upload-date" type="text" class="form-control" v-model="filter.upload_date" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="date-to" class="control-label col-sm-4">Target Status</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <div class="button-group">
                                                        <button type="button" class="btn btn-dd btn-sm dropdown-toggle" data-toggle="dropdown"></span> <span class="fa fa-caret-down"></span></button>
                                                        <ul id="status" class="dropdown-menu">
                                                            <li>
                                                                <a class="small" data-value="Active" tabIndex="-1"><input type="checkbox" checked="true" />&nbsp;Active</a>
                                                                <a class="small" data-value="Lead" tabIndex="-1"><input type="checkbox" checked="true" />&nbsp;Lead</a>
                                                                <a class="small" data-value="Buy" tabIndex="-1"><input type="checkbox" checked="true" />&nbsp;Buy</a>
                                                                <a class="small" data-value="Pending" tabIndex="-1"><input type="checkbox" checked="true" />&nbsp;Pending</a>
                                                                <a class="small" data-value="Change" tabIndex="-1"><input type="checkbox" checked="true" />&nbsp;Change</a>
                                                                <a class="small" data-value="Stop" tabIndex="-1"><input type="checkbox" checked="true" />&nbsp;Stop</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </span>
                                                <input type="text" class="form-control" v-model="statusText" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="date-to" class="control-label col-sm-4">Target List</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" v-model="filter.target_list">
                                                <option value="all">All</option>
                                                <?php foreach ($target_lists as $list): ?>
                                                    <option value="<?php echo $list->id ?>"><?php echo $list->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="property-address" class="control-label col-sm-4">Target Address</label>
                                        <div class="col-sm-8">
                                            <input id="property-address" type="text" class="form-control" v-model="filter.target_address" />
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
            property_address : '',
            upload_date: '',
            upload_by: '',
            target_list : 'all',
            target_status_off: [],
            target_status_on: ['Active', 'Lead', 'Pending', 'Change', 'Stop', 'Buy']
        },
        statusText: 'All'
    };

    var vm = new Vue({
        el: "#app",
        data: data,
        methods: {
            filterList: function() {
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
                    property_address : '',
                    upload_date: '',
                    upload_by: '',
                    target_list : 'all',
                    target_status_off: [],
                    target_status_on: ['Active', 'Lead', 'Pending', 'Change', 'Stop', 'Buy']
                }
            }
        }
    });

    $(function() {
        $('#sidebar-approval-link').addClass('active');
        $('#sidebar-approval-replacements-link').addClass('active');
        $('#sidebar-approval').addClass('in');

        $('#status.dropdown-menu a').on( 'click', function( event ) {
            var $target = $(event.currentTarget),
                val = $target.attr('data-value'),
                $inp = $target.find('input'),
                idx;

            if ((idx = data.filter.target_status_on.indexOf(val)) > -1) {
                data.filter.target_status_off.push(val);
                data.filter.target_status_on.splice(idx, 1);
                setTimeout(function() {$inp.prop('checked', false)}, 0);
            } else {
                idx = data.filter.target_status_off.indexOf(val);
                data.filter.target_status_on.push(val);
                data.filter.target_status_off.splice(idx, 1);
                setTimeout(function() {$inp.prop('checked', true)}, 0);
            }

            $(event.target).blur();
            if (data.filter.target_status_off.length) {
                data.statusText = data.filter.target_status_on.join(', ');
            } else {
                data.statusText = "All";
            }
            return false;
        });

        $('#upload-date').datepicker({
            language: 'en',
            dateFormat: 'yyyy-mm-dd',
            onSelect: function(formattedDate, date, inst) {
                data.filter.upload_date = formattedDate;
            }
        });

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
                        } else if (data == "pending" || data == "duplicate" || data == "draft") {
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
                "targets": 3,
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

    });
</script>