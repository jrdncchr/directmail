<div id="app">
    <h2>Replacement Properties</h2>
    <ol class="breadcrumb">
        <li><a>Approval</a></li>
        <li><a class="active">Replacement Properties</a></li>
    </ol>

    <div class="row">
        <div class="col-sm-12 panel-white">
            <table id="duplicates" class="table table-bordered table-hover" width="100%">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Status</th>
                        <th>Property ID</th>
                        <th>Property Address</th>
                        <th></th>
                        <th>Target List</th>
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
            list : 'all',
            property_name : '',
            resource: '',
            property_address : '',
            id: '',
            skip_traced: 0,
            status_off: [],
            status_on: ['Active', 'Lead', 'Pending', 'Change', 'Duplicate', 'Stop', 'Buy', 'Draft'],
        },
        statusText: 'All'
    };

    var vm = new Vue({
        el: "#app",
        data: data,
        methods: {
            confirmAction: function() {
                loading('info', 'Taking action, please wait...');
                $.post(actionUrl, {
                    action: 'confirm_replacement',
                    replacement_action: data.replacementAction,
                    property_id: data.selectedProperty.id,
                    target_property_id: data.selectedProperty.target_id,
                    comment: data.comment
                }, function(res) {
                    if (res.success) {
                        $('#replacement-modal').modal('hide');
                        loading('success', 'Replacement action complete.');
                        dt.fnReloadAjax();
                    }
                }, 'json');
            }
        }
    });

    $(function() {
        $('#sidebar-approval-link').addClass('active');
        $('#sidebar-approval-replacements-link').addClass('active');
        $('#sidebar-approval').addClass('in');

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
                { data: "id", render: function(data, type, row) {
                        return '<a href="' + row.url + '" target="_blank">' + data + '</a>';
                    }
                },
                { data: "property_address", render: function(data, type, row) {
                        return '<a href="' + row.url + '" target="_blank">' + data + '</a>';
                    }
                },
                { data: "target_id", render: function(data, type, row) {
                        return '<i class="fa fa-arrows-h fa-2x"></i>';
                    }
                },
                { data: "target_list_name", render: function(data, type, row) {
                        return '<a href="' + row.target_url + '" target="_blank">' + data + '</a>';
                    }
                },
                { data: "target_property_address", render: function(data, type, row) {
                        return '<a href="' + row.target_url + '" target="_blank">' + data + '</a>';
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