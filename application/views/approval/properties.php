<div id="app">
    <h2>Pending Properties</h2>
    <ol class="breadcrumb">
        <li><a>Approval</a></li>
        <li><a class="active">Properties</a></li>
    </ol>

    <div class="row">
        <div class="col-sm-12 panel-white">
            <div class="panel panel-default">

                <div class="panel-heading" role="tab" id="filterHeading">
                    <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#filterBox" 
                    aria-expanded="true" aria-controls="filterBox">
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
                                        <label for="list" class="control-label col-sm-2">List</label>
                                        <div class="col-sm-10">
                                            <select id="list" class="form-control" multiple="multiple">
                                            </select>
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
                                <div class="col-sm-12">
                                    <button v-on:click="clearFilter" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                                    <a target="_blank" href="<?php echo base_url() . 'download/properties/approval_properties'; ?>" class="btn btn-default btn-sm"><i class="fa fa-download"></i></a>
                                    <button v-on:click="filterList" class="btn btn-default btn-sm pull-right" style="width: 200px;">Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive" style="width: 100%;">
                <table class="table table-bordered table-hover" width="100%">
                    <thead>
                    <tr>
                        <th width="10%">ID</th>
                        <th width="20%">List</th>
                        <th width="20%">Property Name</th>
                        <th width="30%">Property Address</th>
                        <th width="20%">Date Created</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    var dt;
    var actionUrl = "<?php echo base_url() . 'approval/properties'; ?>";

    var data = {
        filter : {
            list : ['all'],
            property_name : '',
            property_address : '',
            id: ''
        },
        listAll: true
    };

    var vm = new Vue({
        el: "#app",
        data: data,
        methods: {
            filterList: function() {
                if (!data.filter.list) {
                    loading('danger', 'Please select a status and a list.')
                    return;
                }
                loading('info', 'Filtering, please wait...');
                $.post(actionUrl, { action: 'list', filter: data.filter }, function(res) {
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
                    list : ['all'],
                    property_name : '',
                    property_address : '',
                    id: ''
                }
                $("#list").val(null).trigger("change");
                $("#list").val('all').trigger("change");
            }
        }
    });

    $(function() {
        $('#sidebar-approval-link').addClass('active');
        $('#sidebar-approval-properties-link').addClass('active');
        $('#sidebar-approval').addClass('in');

        setupSelect2Fields();
        $('#list').val('all').trigger('change');

        setupDataTables();
    });

    function setupSelect2Fields() {
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

    function saveProperty(property) {
        $.post(actionUrl, { 
            action: 'save_property', 
            form: property
        }, function(res) {
            hideModal();
            loading('success', 'Done');
            dt.fnReloadAjax();
        }, 'json');
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
                    action: "property_list"
                }
            },
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
                    console.log(d);
                    showModal('approve', {
                        title: 'Approve Property',
                        body: 'Do you want to approve this property?',
                        callback: function() {
                            loading("info", "Approving Property");
                            saveProperty({
                                id: d.id,
                                status: 'active'
                            });
                        },
                        cancelCallback: function() {
                            loading("info", "Rejecting Property");
                            d.status = 'Active';
                            d.active = 0;
                            saveProperty({
                                id: d.id,
                                status: 'rejected',
                                active: 0
                            });
                        }
                    });
                });
            },
            "language": {
                "emptyTable": "No pending properties found."
            }
        });
    }
</script>