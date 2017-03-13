<div id="app">
    <h2>Replacement Properties</h2>
    <ol class="breadcrumb">
        <li><a>Approval</a></li>
        <li><a class="active">Replacement Properties</a></li>
    </ol>

    <div class="row">
        <div class="col-sm-12 panel-white">
            <div class="alert alert-info">
                <i class="fa fa-question-circle"></i>
                You can only reject if you don't have both permission for the property list its target property list.
            </div>
            <div class="table-responsive" style="width: 100%;">
                <table class="table table-bordered table-hover" width="100%">
                    <thead>
                    <tr>
                        <th width="10%">ID</th>
                        <th width="15%">List</th>
                        <th width="25%">Property Address</th>
                        <th width="10%">Target ID</th>
                        <th width="15%">Target List</th>
                        <th width="25%">Target Property Address</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Replacement Modal -->
    <div class="modal fade" id="replacement-modal" tabindex="-1" role="dialog" aria-labelledby="replacement-modal-label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="replacement-modal-label">Replacement Action [{{ selectedProperty.id }}]</h4>
                </div>
                <div class="modal-body">
                    <p>What action would you like to take with this property?</p>
                    <div class="form-group">
                        <label for="selected_property_action">{{ selectedProperty.property_address }}</label>
                        <select class="form-control" v-model="replacementAction">
                            <option v-show="selectedProperty.url && selectedProperty.target_url" value="2">Replace (Property Address only)</option>
                            <option v-show="selectedProperty.url && selectedProperty.target_url" value="3">Replace (All except list info)</option>
                            <option v-show="selectedProperty.url && selectedProperty.target_url" value="4">Replace (All)</option>
                        </select>
                    </div>
                     <div class="form-group">
                        <label for="comment">Comment</label>
                        <textarea class="form-control" v-model="comment"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-main btn-sm" v-on:click="confirmAction">Confirm</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var dt;
    var actionUrl = "<?php echo base_url() . 'approval/duplicates'; ?>";

    var data = {
        selectedProperty: {
            id: 0,
            property_address: ''
        },
        comment: '',
        replacementAction: '1'
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
                        return row.url ? "<a target='_blank' href='" + row.url + "'>" + data + "</a>" : "";
                    }
                },
                { data: "list_name" },
                { data: "property_address" },
                { data: "target_id", render: 
                    function(data, type, row) {
                        return row.target_url ? "<a target='_blank' href='" + row.target_url + "'>" + data + "</a>" : data;
                    }
                },
                { data: "target_list_name" },
                { data: "target_property_address" }
            ],
            "fnDrawCallback": function (oSettings) {
                var table = $("table").dataTable();
                $('table tbody tr').on('click', function () {
                    var pos = table.fnGetPosition(this);
                    var d = table.fnGetData(pos);
                    data.selectedProperty = d;
                    data.replacementAction = "1";
                    var modal = $('#replacement-modal');
                    modal.modal({
                        show: true,
                        keyboard: false,
                        backdrop: 'static'
                    });
                });
            },
            "language": {
                "emptyTable": "No property found for this list."
            }
        });
    });
</script>