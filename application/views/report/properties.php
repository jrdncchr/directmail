<div id="app">
    <h2>Properties</h2>
    <ol class="breadcrumb">
        <li><a>Reports</a></li>
        <li><a class="active">Properties</a></li>
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
                                        <label for="date-to" class="control-label col-sm-4">List</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" v-model="filter.list">
                                                <option value="all">All</option>
                                                <?php foreach ($lists as $list): ?>
                                                    <option value="<?php echo $list->id ?>"><?php echo $list->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="deceased-name" class="control-label col-sm-4">Deceased Name</label>
                                        <div class="col-sm-8">
                                            <input id="deceased-name" type="text" class="form-control" v-model="filter.deceased_name" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="deceased-address" class="control-label col-sm-4">Deceased Address</label>
                                        <div class="col-sm-8">
                                            <input id="deceased-address" type="text" class="form-control" v-model="filter.deceased_address" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="date-to" class="control-label col-sm-4">Status</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" v-model="filter.status">
                                                <option value="all">All</option>
                                                <option value="active">Active</option>
                                                <option value="lead">Lead</option>
                                                <option value="change">Change</option>
                                                <option value="pending">Pending</option>
                                                <option value="replacement">Replacement</option>
                                                <option value="stop">Stop</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-4">ID</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" v-model="filter.id" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <button v-on:click="clearFilter" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                                    <a target="_blank" href="<?php echo base_url() . 'download/properties/report_properties'; ?>" class="btn btn-default btn-sm"><i class="fa fa-download"></i></a>
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
                        <th width="6%">ID</th>
                        <th width="20%">List</th>
                        <th width="20%">Deceased Name</th>
                        <th width="39%">Deceased Address</th>
                        <th width="15%">Status</th>
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
    var actionUrl = "<?php echo base_url() . 'report/properties'; ?>";

    var data = {
        filter : {
            list : 'all',
            deceased_name : '',
            deceased_address : '',
            status: 'all',
            id: ''
        }
    };

    var vm = new Vue({
        el: "#app",
        data: data,
        methods: {
            filterList: function() {
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
                    list : 'all',
                    deceased_name : '',
                    deceased_address : '',
                    status: 'all',
                    id: ''
                }
            }
        }
    });

    $(function() {
        $('#sidebar-reports-link').addClass('active');
        $('#sidebar-reports-properties-link').addClass('active');
        $('#sidebar-reports').addClass('in');

        dt = $('table').dataTable({
            "order": [[ 0, "asc" ]],
            "bDestroy": true,
            "filter": true,
            "ajax": {
                "type": "POST",
                "url": actionUrl,
                "data":  {
                    action: "list"
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
                { data: "deceased_last_name", render:
                    function(data, type, row) {
                        return row.deceased_last_name + " " + row.deceased_first_name + ", " + row.deceased_middle_name;
                    }
                },
                { data: "deceased_address" },
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
    });
</script>