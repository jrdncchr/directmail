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
                    <th width="20%">Downloaded By</th>
                    <th width="20%">Download Date</th>
                    <th width="20%">Variable</th>
                    <th width="10%">Cost</th>
                    <th width="10%">Propeties</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="history-modal" tabindex="-1" role="dialog" aria-labelledby="history-modal-label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="history-modal-label">History Action</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="variable">Variable</label>
                                <input id="variable" type="text" class="form-control" v-model="modalForm.variable" /> 
                            </div>
                            <div class="form-group">
                                <label for="cost">Cost</label>
                                <input id="cost" type="text" class="form-control" v-model="modalForm.cost" /> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" v-on:click="deleteDownloadHistory" class="btn btn-sm pull-left">Delete</button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" v-on:click="saveDownloadHistory" class="btn btn-main btn-sm">Save</button>
                </div>
            </div>
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
        modalForm : {
            cost: 1,
            variable: ''
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
            },
            saveDownloadHistory: function() {
                loading('info', 'Saving download history...');
                $.post(actionUrl, { action: 'update', history: data.modalForm }, function(res) {
                    console.log(res);
                    if (res.success) {
                        loading('success', 'Save successful.');
                        dt.fnReloadAjax();
                    }
                }, 'json');
            },
            deleteDownloadHistory: function() {
                loading('info', 'Deleting download history...');
                $.post(actionUrl, { action: 'delete', id: data.modalForm.id }, function(res) {
                    if (res.success) {
                        loading('success', 'Delete successful.');
                        dt.fnReloadAjax();
                        $('#history-modal').modal('hide');
                    }
                }, 'json');
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
                data.filter.download_date = formattedDate;
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
                { data: "variable" },
                { data: "cost" },
                { data: "property_count" },
                { data: "id", visible: false }
            ],
            "fnDrawCallback": function (oSettings) {
                var table = $("table").dataTable();
                $('table tbody tr').on('click', function (e) {
                    if ($(e.target).attr('class') && $(e.target).attr('class').includes('dt-align-toggle')) {
                        return;
                    }
                    var pos = table.fnGetPosition(this);
                    var d = table.fnGetData(pos);
                    data.modalForm.id = d.id;
                    data.modalForm.variable = d.variable;
                    data.modalForm.cost = d.cost;
                    $('#history-modal').modal({
                        show: true,
                        backdrop: 'static',
                        keyboard: false
                    });
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