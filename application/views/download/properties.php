<div id="app">
    <h2>Properties</h2>
    <ol class="breadcrumb">
        <li><a>Downloads</a></li>
        <li><a class="active">Properties</a></li>
    </ol>

    <div class="row">
        <div class="col-sm-12 panel-white">
        
            <?php 
            $this->load->view('blocks/filter', [
                'filter_fields' => [
                    'status',
                    'list',
                    'id',
                    'skip-traced',
                    'resource',
                    'property-name',
                    'property-address'
                ]
            ]); 
            ?>

            <?php $this->load->view('blocks/bulk_action'); ?>

            <table class="table table-bordered table-hover dt-responsive nowrap" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th width="15%" class="td-col-first">ID</th>
                    <th width="20%">List</th>
                    <th width="15%">Resource</th>
                    <th width="20%">Property Name</th>
                    <th width="20%">Property Address</th>
                    <th width="15%">Status</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<script>
    var dt;
    var actionUrl = "<?php echo base_url() . 'download/properties'; ?>";

    var data = {
        filter : {
            status: ['all'],
            list : ['all'],
            property_name : '',
            resource: '',
            property_address : '',
            id: '',
            skip_traced: 0
        },
        bulkStatus: '',
        statusAll: false,
        listAll: true
    };

    var vm = new Vue({
        el: "#app",
        data: data,
        methods: {
            filterList: function() {
                if (!data.filter.status || !data.filter.list) {
                    loading('danger', 'Please select a status and a list.')
                    return;
                }
                loading('info', 'Filtering, please wait...');
                $.post(actionUrl, { action: 'list', filter: data.filter }, function(res) {
                    dt.fnClearTable();
                    if (res.data.length) {
                        dt.fnAddData(res.data);
                    }
                    dt.fnDraw();
                    loading('success', 'Filter Complete');
                }, 'json');
            },
            clearFilter: function() {
                data.filter = {
                    status: ['all'],
                    list : ['all'],
                    property_name : '',
                    resource: '',
                    property_address : '',
                    id: '',
                    skip_traced: 0
                };
                $("#status").val(null).trigger("change");
                $("#status").val('all').trigger("change");

                $("#list").val(null).trigger("change");
                $("#list").val('all').trigger("change");
            },
            download: function() {
                showModal('yesno', {
                    title: 'Save Download History',
                    body: 'Do you want this download to be saved in the download history?',
                    callback: function() {
                        $('#global-modal').modal('hide');
                        window.open(baseUrl + 'download/download/downloads_properties/1', '_blank');
                    },
                    cancelCallback: function() {
                        $('#global-modal').modal('hide');
                        window.open(baseUrl + 'download/download/downloads_properties', '_blank');
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
        $('#sidebar-downloads-link').addClass('active');
        $('#sidebar-downloads-properties-link').addClass('active');
        $('#sidebar-downloads').addClass('in');

        setupSelect2Fields();
        $('#list').val('all').trigger('change');
        $('#status').val('all').trigger('change');

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

        $('#list').select2({
            allowClear: true,
            data: <?php echo json_encode($lists); ?>,
            closeOnSelect: false,
            placeholder: {
                id: "",
                placeholder: "Select a list"
            }
        }).on('change', function() {
            if ($.inArray('all', $(this).val()) > -1 && $(this).val().length > 1 && data.listAll) {
                var selected = $(this).val();
                $("#list").val(null).trigger("change");
                $("#list").val(selected[1]).trigger("change");
                data.listAll  = false;
            }
            if ($.inArray('all', $(this).val()) > -1 && $(this).val().length > 1 && !data.listAll) {
                $("#list").val(null).trigger("change");
                $("#list").val('all').trigger("change");
                data.listAll  = true;
            }
            data.filter.list = $(this).val();
        });
    }

    function setupDataTables() {
        dt = $('table').dataTable({
            "order": [[ 0, "asc" ]],
            "bDestroy": true,
            "filter": true,
            columns: [
                { data: "id", render: 
                    function(data, type, row) {
                        return row.url ? "<a target='_blank' href='" + row.url + "'>" + data + "</a>" : data;
                    }
                },
                { data: "list_name", render:
                    function(data, type, row) {
                        return row.list_url ? "<a target='_blank' href='" + row.list_url + "'>" + data + "</a>" : data;
                    }
                },
                { data: "resource" },
                { data: "property_last_name", render:
                    function(data, type, row) {
                        return row.property_last_name + " " + row.property_first_name + ", " + row.property_middle_name;
                    }
                },
                { data: "property_address" },
                { data: "status", render: function(data, type, row) {
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
            ],
            "fnDrawCallback": function (oSettings) {
                var table = $("table").dataTable();
                $('table tbody tr').on('click', function (e) {
                    if ($(e.target).attr('class') && $(e.target).attr('class').includes('dt-align-toggle')) {
                        return;
                    }
                    var pos = table.fnGetPosition(this);
                    var d = table.fnGetData(pos);
                });
            },
            "language": {
                "emptyTable": "Setup your filter options and click the filter button to show properties."
            },
            "columnDefs": [
                { className: "dt-align-toggle", "targets": [0] }
            ]
        });
    }
</script>