<div id="app">
    <h2>Roles</h2>
    <ol class="breadcrumb">
        <li><a>Management</a></li>
        <li><a class="active">Roles</a></li>
    </ol>

    <div class="row">
        <div class="col-sm-12 panel-white">
            <a href="<?php echo base_url() . 'management/roles/form'; ?>" class="btn btn-xs btn-default" style="margin-bottom: 20px;"><i class="fa fa-plus-circle"></i> Add Role</a>
            <div class="table-responsive" style="width: 100%;">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    var dt;
    var actionUrl = "<?php echo base_url() . 'management/roles'; ?>";

    $(function() {
        $('#sidebar-management-link').addClass('active');
        $('#sidebar-management-roles-link').addClass('active');
        $('#sidebar-management').addClass('in');

        dt = $('table').dataTable({
            "order": [[ 0, "asc" ]],
            "bDestroy": true,
            "filter": true,
            "ajax": {
                "type": "POST",
                "url": actionUrl,
                "data": {action: "list"}
            },
            columns: [
                { data: "name" },
                { data: "description" },
                { data: "id", visible: false }
            ],
            "fnDrawCallback": function (oSettings) {
                var table = $("table").dataTable();
                $('table tbody tr').on('click', function (e) {
                    if ($(e.target).attr('class') && $(e.target).attr('class').includes('dt-align-toggle')) {
                        return;
                    }
                    var pos = table.fnGetPosition(this);
                    var data = table.fnGetData(pos);
                    window.location = actionUrl + '/form/' + data.id;
                });
            },
            "language": {
                "emptyTable": "No roles yet."
            }
        });
    });
</script>