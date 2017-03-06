<div id="app">
	<br />
    <div class="row">
        <div class="col-sm-12 panel-white">
            <?php if ($mc->_checkModulesChildPermission(MODULE_LIST_ID, null, 'create')): ?>
                <a href="<?php echo base_url() . 'lists/info/new'; ?>" class="btn btn-xs btn-default" style="margin-bottom: 20px;"><i class="fa fa-plus-circle"></i> Add a list</a>
            <?php endif; ?>
            <div class="table-responsive" style="width: 100%;">
                <table class="table table-bordered table-hover" width="100%">
                    <thead>
                    <tr>
                        <th width="10%">ID</th>
                        <th width="50%">Name</th>
                        <th width="40%">Created By</th>
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
    var actionUrl = "<?php echo base_url() . 'lists/index'; ?>";

    $(function() {
        $('#sidebar-list-link').addClass('active');
        $('#sidebar-list').addClass('in');

        dt = $('table').dataTable({
            "order": [[ 1, "asc" ]],
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
                { data: "id" },
                { data: "name" },
                { data: "created_by", render:
                    function(data, type, row) {
                        return row.first_name + " " + row.last_name;
                    }
                }
            ],
            "fnDrawCallback": function (oSettings) {
                var table = $("table").dataTable();
                $('table tbody tr').on('click', function () {
                    var pos = table.fnGetPosition(this);
                    var data = table.fnGetData(pos);
                    $.post(actionUrl, {action: 'check_list_permission', list_id: data.id}, function(res) {
                        if (res.success) {
                            window.location = baseUrl + "lists/info/" + data.id;
                        } else {
                            showModal('confirm', {
                                title: "Permission Denied",
                                body: "You don't have permission for this list."
                            });
                        }
                    }, 'json');
                });
            },
            "language": {
                "emptyTable": "No list available in this category."
            }
        });
    });
</script>