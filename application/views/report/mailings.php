<div id="app">
    <h2>Mailings</h2>
    <ol class="breadcrumb">
        <li><a>Reports</a></li>
        <li><a class="active">Mailings</a></li>
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
                                        <label for="date-to" class="control-label col-sm-2">Status</label>
                                        <div class="col-sm-10">
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <div class="button-group">
                                                        <button type="button" class="btn btn-dd btn-sm dropdown-toggle" data-toggle="dropdown"></span> <span class="fa fa-caret-down"></span></button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a class="small" data-value="Active" tabIndex="-1"><input type="checkbox" checked="true" />&nbsp;Active</a>
                                                                <a class="small" data-value="Lead" tabIndex="-1"><input type="checkbox" checked="true" />&nbsp;Lead</a>
                                                                <a class="small" data-value="Buy" tabIndex="-1"><input type="checkbox" checked="true" />&nbsp;Buy</a>
                                                                <a class="small" data-value="Pending" tabIndex="-1"><input type="checkbox" />&nbsp;Pending</a>
                                                                <a class="small" data-value="Change" tabIndex="-1"><input type="checkbox" />&nbsp;Change</a>
                                                                <a class="small" data-value="Replacement" tabIndex="-1"><input type="checkbox" />&nbsp;Replacement</a>
                                                                <a class="small" data-value="Stop" tabIndex="-1"><input type="checkbox" />&nbsp;Stop</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </span>
                                                <input type="text" class="form-control" v-model="statusText" disabled />
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="date-range" class="control-label col-sm-4">Date Range</label>
                                        <div class="col-sm-8">
                                            <input id="date-range" type="text" readonly="true" class="form-control" v-model="filter.date_range" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="letter-no" class="control-label col-sm-4">Letter No.</label>
                                        <div class="col-sm-8">
                                            <input id="letter-no" type="number" class="form-control" v-model="filter.letter_no" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <button v-on:click="clearFilter" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                                    <a target="_blank" href="<?php echo base_url() . 'download/properties/report_mailings'; ?>" class="btn btn-default btn-sm"><i class="fa fa-download"></i></a>
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
                        <th width="23%">Property Name</th>
                        <th width="31%">Property Address</th>
                        <th width="10%">Letter No</th>
                        <th width="10%">Mailing Date</th>
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
    var actionUrl = "<?php echo base_url() . 'report/mailings'; ?>";

    var data = {
        filter : {
            list : 'all',
            property_name : '',
            property_address : '',
            id: '',
            status_off: ['Pending', 'Change', 'Replacement', 'Stop'],
            status_on: ['Active', 'Lead', 'Buy'],
            date_range : '',
            letter_no: ''
        },
        statusText: 'Active, Lead, Buy'
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
                    property_name : '',
                    property_address : '',
                    today : false,
                    date_range : ''
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

        $('.dropdown-menu a').on('click', function( event ) {
            var $target = $(event.currentTarget),
                val = $target.attr('data-value'),
                $inp = $target.find('input'),
                idx;

            if ((idx = data.filter.status_on.indexOf(val)) > -1) {
                data.filter.status_off.push(val);
                data.filter.status_on.splice(idx, 1);
                setTimeout(function() {$inp.prop('checked', false)}, 0);
            } else {
                idx = data.filter.status_off.indexOf(val);
                data.filter.status_on.push(val);
                data.filter.status_off.splice(idx, 1);
                setTimeout(function() {$inp.prop('checked', true)}, 0);
            }

            $(event.target).blur();
            if (data.filter.status_off.length) {
                data.statusText = data.filter.status_on.join(', ');
            } else {
                data.statusText = "All";
            }
            return false;
        });

        dt = $('table').dataTable({
            "order": [[ 5, "asc" ]],
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
                { data: "letter_no" },
                { data: "mailing_date" }
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