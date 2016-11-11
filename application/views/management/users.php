<div id="app">
    <h2>Users</h2>
    <ol class="breadcrumb">
        <li><a>Management</a></li>
        <li><a class="active">Users</a></li>
    </ol>

    <div class="row">
        <div class="col-sm-12">
            <a href="<?php echo base_url() . 'management/users/form'; ?>" class="btn btn-sm btn-default" style="margin-bottom: 20px;"><i class="fa fa-plus-circle"></i> Add User</a>
            <div class="table-responsive" style="width: 100%;">
                <table class="table table-bordered table-hover" width="100%">
                    <thead>
                    <tr>
                        <th width="15%">Role</th>
                        <th width="25%">Email</th>
                        <th width="25%">Name</th>
                        <th width="15%">Contact No.</th>
                        <th width="20%">Date Joined</th>
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
    var actionUrl = "<?php echo base_url() . 'management/users'; ?>";

    $(function() {
        $('#sidebar-management-link').addClass('active');
        $('#sidebar-management-users-link').addClass('active');
        $('#sidebar-management').addClass('in');

        dt = $('table').dataTable({
            "order": [[ 4, "asc" ]],
            "bDestroy": true,
            "filter": true,
            "ajax": {
                "type": "POST",
                "url": actionUrl,
                "data": {action: "list"}
            },
            columns: [
                { data: "role_name",
                    render: function(data, type, row) {
                        return data ? data : "No Role";
                    }
                },
                { data: "email" },
                { data: "name" },
                { data: "contact_no" },
                { data: "date_created" },
                { data: "id", visible: false }
            ],
            "fnDrawCallback": function (oSettings) {
                var table = $("table").dataTable();
                $('table tbody tr').on('click', function () {
                    var pos = table.fnGetPosition(this);
                    var data = table.fnGetData(pos);
                    window.location = actionUrl + '/form/' + data.id;
                });
            },
            "language": {
                "emptyTable": "There are no users, please contact Direct Mail"
            }
        });
    });
</script>