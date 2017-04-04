<div id="app">
    <h2>History</h2>
    <ol class="breadcrumb">
        <li><a>Downloads</a></li>
        <li><a class="active">History</a></li>
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
<!--                             <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="property-name" class="control-label col-sm-4">Property Name</label>
                                    <div class="col-sm-8">
                                        <input id="property-name" type="text" class="form-control" v-model="filter.property_name" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="property-address" class="control-label col-sm-4">Property Address</label>
                                    <div class="col-sm-8">
                                        <input id="property-address" type="text" class="form-control" v-model="filter.property_address" />
                                    </div>
                                </div>
                            </div> -->
                            <div class="col-sm-12">
                                <button v-on:click="clearFilter" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                                <button v-on:click="filterList" class="btn btn-default btn-sm pull-right" style="width: 200px;">Filter</button>
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
                        <th width="30%">Uploaded By</th>
                        <th width="30%">Upload Date</th>
                        <th width="10%">Propeties Count</th>
                        <th width="20%">Filters</th>
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
    var actionUrl = "<?php echo base_url() . 'download/history'; ?>";

    var data = {
        filter : {

        }
    };

    var vm = new Vue({
        el: "#app",
        data: data,
        methods: {
            filterList: function() {
                if (!data.filter.status || !data.filter.list) {
                    loading('danger', 'Please select a status and a list.');
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
                    status: ['active', 'lead', 'buy'],
                    list : ['all'],
                    property_name : '',
                    property_address : '',
                    id: ''
                }
                $("#status").val(null).trigger("change");
                $("#status").val('active').trigger("change");

                $("#list").val(null).trigger("change");
                $("#list").val('all').trigger("change");
            }
        }
    });

    $(function() {
        $('#sidebar-downloads-link').addClass('active');
        $('#sidebar-downloads-history-link').addClass('active');
        $('#sidebar-downloads').addClass('in');

        setupDataTables();
    });

    function setupDataTables() {
        dt = $('table').dataTable({
            "order": [[ 2, 'desc' ]],
            "bDestroy": true,
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
                { data: "type" },
                { data: "full_name" },
                { data: "upload_date" },
                { data: "property_count" },
                { data: "filters", render:
                    function(data, type, row) {
                        return '<button class="btn btn-xs">View Filters</>';
                    }
                 }
            ],
            "fnDrawCallback": function (oSettings) {
                var table = $("table").dataTable();
                $('table tbody tr').on('click', function () {
                    var pos = table.fnGetPosition(this);
                    var d = table.fnGetData(pos);
                });
            },
            "language": {
                "emptyTable": "No property found."
            }
        });
    }
</script>