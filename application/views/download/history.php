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
                            <div class="row">
                                <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="from-module" class="control-label col-sm-2">From Module</label>
                                            <div class="col-sm-10">
                                                <select id="from-module" class="form-control" multiple="multiple">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="downloaded-by" class="control-label col-sm-4">Downloaded By</label>
                                        <div class="col-sm-8">
                                            <select id="downloaded-by" class="form-control">
                                                <option value="all">All</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="download-date" class="control-label col-sm-4">Download Date</label>
                                        <div class="col-sm-8">
                                            <input id="download-date" type="text" readonly="true" class="form-control" v-model="filter.download_date" />
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

            <table class="table table-bordered table-hover dt-responsive nowrap" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th width="20%" class="td-col-first">From Module</th>
                    <th width="30%">Downloaded By</th>
                    <th width="30%">Download Date</th>
                    <th width="20%">Propeties</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<script>
    var dt;
    var actionUrl = "<?php echo base_url() . 'download/history'; ?>";

    var data = {
        filter : {
            from_module : ['all'],
            downloaded_by : 'all',
            download_date : ''
        },
        users: <?php echo json_encode($users); ?>,
        fromModuleAll: true
    };

    var vm = new Vue({
        el: "#app",
        data: data,
        methods: {
            filterList: function() {
                if (!data.filter.from_module) {
                    loading('danger', 'From module cannot be empty.');
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
                    from_module : ['all'],
                    downloaded_by : 'all',
                    download_date : ''
                }
                $("#from-module").val(null).trigger("change");
                $("#from-module").val('all').trigger("change");
            }
        }
    });

    $(function() {
        $('#sidebar-downloads-link').addClass('active');
        $('#sidebar-downloads-history-link').addClass('active');
        $('#sidebar-downloads').addClass('in');

        setupDataTables();
        setupSelect2Fields();
        setupDatepickerFields();

        $("#from-module").val(null).trigger("change");
        $("#from-module").val('all').trigger("change");
    });

    function setupSelect2Fields() {
        $("#downloaded-by").select2({
          data: data.users
        }).on('change', function() {
            data.filter.downloaded_by = $(this).val();
        });

        $('#from-module').select2({
            allowClear: true,
            data: <?php echo json_encode($from_modules); ?>,
            closeOnSelect: false,
            placeholder: {
                id: "",
                placeholder: "From module"
            }
        }).on('change', function() {
            if ($.inArray('all', $(this).val()) > -1 && $(this).val().length > 1 && data.fromModuleAll) {
                var selected = $(this).val();
                $("#from-module").val(null).trigger("change");
                $("#from-module").val(selected[1]).trigger("change");
                data.fromModuleAll = false;
            }
            if ($.inArray('all', $(this).val()) > -1 && $(this).val().length > 1 && !data.fromModuleAll) {
                $("#from-module").val(null).trigger("change");
                $("#from-module").val('all').trigger("change");
                data.fromModuleAll = true;
            }
            data.filter.from_module = $(this).val();
        });
    }

    function setupDatepickerFields() {
        $('#download-date').datepicker({
            language: 'en',
            range: true,
            multipleDatesSeparator: ' - ',
            dateFormat: 'yyyy-mm-dd',
            onSelect: function(formattedDate, date, inst) {
                if (formattedDate.length > 11) {
                    data.filter.download_date = formattedDate;    
                } else {
                    data.filter.download_date = '';
                    $('#download-date').val('');
                }
            }
        });
    }

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
                { data: "download_date" },
                { data: "property_count" }
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
            },
            "columnDefs": [
                { className: "dt-align-toggle", "targets": [0] }
            ]
        });
    }
</script>