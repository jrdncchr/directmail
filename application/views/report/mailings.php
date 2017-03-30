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
                        <form class="form-horizontal" action="<?php echo base_url() . 'report/mailings/download' ?>" method="post" onsubmit="return validateForm();">
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
                                        <label for="date-range" class="control-label col-sm-4">Date Range</label>
                                        <div class="col-sm-8">
                                            <input id="date-range" name="date_range" type="text" readonly="true" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <button v-on:click="clearFilter" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                                    <button class="btn btn-default btn-sm pull-right" style="width: 200px;"><i class="fa fa-download"></i> Download</button>
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
    var actionUrl = "<?php echo base_url() . 'report/mailings'; ?>";

    var data = {
        filter : {
            list : 'all',
            date_range : '',
            type: 'letter',
            report_type: 'Date Range'
        },
        statusText: 'Active'
    };

    var vm = new Vue({
        el: "#app",
        data: data,
        methods: {
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
        $('#date-range').datepicker({
            language: 'en',
            range: true,
            multipleDatesSeparator: ' - ',
            dateFormat: 'yyyy-mm-dd',
            onSelect: function(formattedDate, date, inst) {
                if (formattedDate.length > 11) {
                    data.filter.date_range = formattedDate;    
                } else {
                    data.filter.date_range = '';
                    $('#date-range').val('');
                }
            }
        });
    }

    $(function() {
        $('#sidebar-reports-link').addClass('active');
        $('#sidebar-reports-mailings-link').addClass('active');
        $('#sidebar-reports').addClass('in');

        setupFilterFields();
    });

    function validateForm() {
        if (!data.filter.list) {
            loading('danger', 'Please select a list.')
            return false;
        }
        if (data.filter.report_type === 'Date Range') {
            if (!data.filter.date_range) {
                loading('danger', 'Date range field is required on this report type.')
                return false;
            }
        }
        return true;
    }
</script>