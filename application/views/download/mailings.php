<div id="app">
    <h2>Mailings</h2>
    <ol class="breadcrumb">
        <li><a>Reports</a></li>
        <li><a class="active">Mailings</a></li>
    </ol>

    <div class="row">
        <div class="col-sm-12 panel-white">
            <div class="panel panel-default">
                <?php echo $this->session->flashdata('message'); ?>
                <div class="panel-heading" role="tab" id="filterHeading">
                    <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#filterBox" aria-expanded="true" aria-controls="filterBox" >
                        <a role="button" style="font-size: 16px !important; font-weight: bold;">
                            FILTER
                        </a>
                    </h4>
                </div>
                <div id="filterBox" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="filterHeading">
                    <div class="panel-body">
                        <form class="form-horizontal" action="<?php echo base_url() . 'download/mailings/download' ?>" method="post">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="date-to" class="control-label col-sm-4">List</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" v-model="filter.list" name="list">
                                                <option value="all">All</option>
                                                <?php foreach ($lists as $list): ?>
                                                    <option value="<?php echo $list->id ?>"><?php echo $list->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="type" class="control-label col-sm-4">Type</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" v-model="filter.type" name="type">
                                                <option value="letter">Letter</option>
                                                <option value="postcard">Postcard</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="type" class="control-label col-sm-4">Report Type</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" v-model="filter.report_type" name="report_type">
                                                <option value="Date Range">Date Range</option>
                                                <option value="Last 4 Months">Last 4 Months</option>
                                                <option value="Last 12 Months">Last 12 Months</option>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="form-group" v-show="filter.report_type === 'Date Range'">
                                        <label for="date-from" class="control-label col-sm-4">Date From</label>
                                        <div class="col-sm-8">
                                            <input id="date-from" name="from" type="text" readonly="true" class="form-control" v-model="filter.date_from" />
                                        </div>
                                    </div>
                                    <div class="form-group" v-show="filter.report_type === 'Date Range'">
                                        <label for="date-to" class="control-label col-sm-4">Date To</label>
                                        <div class="col-sm-8">
                                            <input id="date-to" name="to" type="text" readonly="true" class="form-control" v-model="filter.date_to" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <button v-on:click="clearFilter" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                                    <button v-on:click="download" class="btn btn-default btn-sm pull-right" style="width: 200px;"><i class="fa fa-download"></i> Download</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var dt;
    var actionUrl = "<?php echo base_url() . 'report/downloads'; ?>";

    var data = {
        filter : {
            list : 'all',
            date_from : '',
            date_to : '',
            type: 'letter',
            report_type: 'Date Range'
        },
        statusText: 'Active'
    };

    var vm = new Vue({
        el: "#app",
        data: data,
        methods: {
            download: function() {
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
                    date_range : '',
                    type: 'letter',
                    report_type: 'Date Range'
                }
            }
        }
    });

    function setupFilterFields() {
        $('#date-from').datepicker({
            language: 'en',
            dateFormat: 'yyyy-mm-dd',
            onSelect: function(formattedDate, date, inst) {
                data.filter.date_from = formattedDate;
            }
        });
        $('#date-to').datepicker({
            language: 'en',
            dateFormat: 'yyyy-mm-dd',
            onSelect: function(formattedDate, date, inst) {
                data.filter.date_to = formattedDate;
            }
        });
    }

    $(function() {
        $('#sidebar-downloads-link').addClass('active');
        $('#sidebar-downloads-mailings-link').addClass('active');
        $('#sidebar-downloads').addClass('in');

        setupFilterFields();
    });
</script>