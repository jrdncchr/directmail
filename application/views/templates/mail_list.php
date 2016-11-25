<div id="app">
    <h2>Mail Templates</h2>
    <ol class="breadcrumb">
        <li><a>Templates</a></li>
        <li><a class="active">Mail Templates</a></li>
    </ol>

    <div class="row">
        <div class="col-sm-12 panel-white">
        	<a href="<?php echo base_url() . 'templates/mail/form'; ?>" class="btn btn-default btn-xs" style="margin-bottom: 20px;"><i class="fa fa-plus-circle"></i> Add Mail Template</a>

            <div class="table-responsive" style="width: 100%;">
                <table class="table table-bordered table-hover" width="100%">
                    <thead>
                    <tr>
                    	<th width="10%">ID</th>
                        <th width="60%">Name</th>
                        <th width="30%">Created By</th>
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
    var actionUrl = "<?php echo base_url() . 'templates/mail'; ?>";

    $(function() {
        $('#sidebar-templates-link').addClass('active');
        $('#sidebar-mail-templates-link').addClass('active');
        $('#sidebar-templates').addClass('in');

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
                            window.location = baseUrl + "templates/info/" + data.id;
                        } else {
                            showConfirmModal({
                                title: "Permission Denied",
                                body: "You don't have permission for this list."
                            });
                        }
                    }, 'json');
                });
            },
            "language": {
                "emptyTable": "No mail templates yet."
            }
        });
    });
</script>