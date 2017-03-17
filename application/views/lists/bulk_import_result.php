<style>
    th, tr {
        text-align: center !important;
    }
    a {
        font-size: 14px;
    }
</style>
<div id="app">
    <h2>Bulk Import Result</h2>
    <ol class="breadcrumb">
        <li><a>List</a></li>
        <li><a href="<?php echo base_url() . 'lists/info/' . $list->id; ?>"><?php echo  $list->name; ?></a></li>
        <li><a href="<?php echo base_url() . 'lists/info/' . $list->id . '/bulk_import'; ?>">Bulk Import</a></li>
        <li><a class="active">Result</a></li>
    </ol>

    <div class="row">
        <div class="col-sm-12 panel-white">
            <h2 class="text-center" style="margin-top: 0; margin-bottom: 30px;">Import Complete</h2>
            <section v-show="result.duplicates.length > 0" style="display: none;">
                <h4><b>{{ result.duplicates.length }}</b> Similar/Duplicate Properties</h4>
                <table id="duplicates" class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Status</th>
                            <th>Spreadsheet Row</th>
                            <th>Property Address</th>
                            <th></th>
                            <th>Target List</th>
                            <th>Detected Similar Property</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </section>
            <h4><b>{{ result.saved.length }}</b> Successfully Saved Properties</h4>
            <section v-show="result.saved.length > 0" style="display: none;">
               
                <div class="table-responsive" style="width: 100%; margin-top: 20px;">
                    <table id="saved" class="table table-bordered table-hover" width="100%">
                        <thead>
                        <tr>
                            <th width="10%">ID</th>
                            <th width="10%">Status</th>
                            <th width="30%">Property Name</th>
                            <th width="45%">Property Address</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </section>
            <section v-show="result.saved.length == 0 && result.similars.length == 0" style="display: none;">
                <div class="alert alert-warning">
                    <i class="fa fa-exclamation-circle"></i> No properties to save or duplicates were detected.
                </div>
            </section>
            <a href="<?php echo base_url() . 'lists/info/' . $list->id . '/bulk_import'; ?>">
                &larr; Return to Bulk Import
            </a>
        </div>
    </div>
</div>

<script>
    var actionUrl = "<?php echo base_url() . 'lists/info'; ?>";
    var dt, duplicateDt;

    var data = {
        result : <?php echo json_encode($result); ?>
    };

    var vm = new Vue({
        el: "#app",
        data: data
    });

    function replaceAction(action, id) {
        var property = null;
        for (var i = 0; i < data.result.duplicates.length; i++) {
            if (data.result.duplicates[i].id == id) {
                property = data.result.duplicates[i];
                break;
            }
        }
        loading('info', 'Taking action, please wait...');
        $.post(actionUrl, {
            action: 'replace_action',
            replace_action: action,
            property: property
        }, function(res) {
            if (res.success) {
                for (var i = 0; i < data.result.duplicates.length; i++) {
                    if (data.result.duplicates[i].id == id) {
                        data.result.duplicates.splice(i, 1);
                        duplicateDt.fnClearTable();
                        duplicateDt.fnAddData(data.result.duplicates);
                        break;
                    }
                }
                loading('success', 'Replacement action complete.');
            }
        }, 'json');
    }

    $(function() {
        $('#sidebar-list-link').addClass('active');
        $('#sidebar-list').addClass('in');

        duplicateDt = $('table#duplicates').dataTable({
            "order": [[ 0, "desc" ]],
            "filter": true,
            "data": data.result.duplicates,
            columns: [
                { data: "id", render: function(data, type, row) {
                        return '<div class="btn-group">' +
                                    '<button type="button" class="btn btn-xs btn-default btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                                        'Action <span class="caret"></span>' +
                                    '</button>' +
                                    '<ul class="dropdown-menu">' +
                                        '<li><a href="#" onClick="replaceAction(1, ' + data + ')">Remove</a></li>' +
                                        '<li><a href="#" onClick="replaceAction(2, '+ data +')">Replace (Property Address only)</a></li>' +
                                        '<li><a href="#" onClick="replaceAction(3, '+ data +')">Replace (Property info only)</a></li>' +
                                        '<li><a href="#" onClick="replaceAction(4, '+ data +')">Replace (All including list, mailing, and comments)</a></li>' +
                                        '<li><a href="#" onClick="replaceAction(5, ' + data + ')">Keep (Duplicate will be saved as active.)</a></li>' +
                                    '</ul>' +
                                '</div>' +
                            '</td>';
                    } 
                },
                { data: "status", render: function(data, type, row) {
                        return "<span class='label label-warning'>" + capitalize(data) + "</span>"; 
                    }
                },
                { data: "row" },
                { data: "property_address", render: function(data, type, row) {
                        return '<a href="' + row.property_link + '" target="_blank">' + data + '</a>';
                    }
                },
                { data: "id", render: function(data, type, row) {
                        return '<i class="fa fa-arrows-h fa-2x"></i>';
                    }
                },
                { data: "similar", render: function(data, type, row) {
                        return '<a href="' + data.list.url + '" target="_blank">' + data.list.name + '</a>';
                    }
                },
                { data: "similar", render: function(data, type, row) {
                        return '<a href="' + data.url + '" target="_blank">' + data.property_address + '</a>';
                    }
                }
            ], 
            "columnDefs": [ {
                "targets": 4,
                "orderable": false
            }],
            "language": {
                "emptyTable": "No property found for this list."
            }
        });

        dt = $('table#saved').dataTable({
            "order": [[ 0, "desc" ]],
            "bDestroy": true,
            "filter": true,
            "data": data.result.saved,
            columns: [
                { data: "id" },
                { data: "status", render: function(data, type, row) {
                        if (data.toLowerCase() == "active" || data.toLowerCase() == "lead" || data.toLowerCase() == "buy") {
                            return "<span class='label label-success'>" + capitalize(data) + "</span>";
                        } else if (data.toLowerCase() == "pending" || data.toLowerCase() == "replacement") {
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
                { data: "property_address" }
            ],
            "fnDrawCallback": function (oSettings) {
                var table = $("table#saved").dataTable();
                $('table#saved tbody tr').on('click', function () {
                    var pos = table.fnGetPosition(this);
                    var d = table.fnGetData(pos);
                    window.open(baseUrl + 'lists/property/' + data.list_id + '/info/' + d.id, '_blank');
                });
            },
            "language": {
                "emptyTable": "No property found for this list."
            }
        });

    });
</script>