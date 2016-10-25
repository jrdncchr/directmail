<div id="app">
    <h2>List Categories</h2>
    <ol class="breadcrumb">
        <li><a>Management</a></li>
        <li><a class="active">List Categories</a></li>
    </ol>

    <div class="row">
        <div class="col-sm-12">
            <a href="<?php echo base_url() . 'management/list_categories/form'; ?>" class="btn btn-sm btn-default" style="margin-bottom: 20px;"><i class="fa fa-plus-circle"></i> Add a list Category</a>
            <div class="table-responsive" style="width: 100%;">
                <table class="table table-bordered table-hover" width="100%">
                    <thead>
                    <tr>
                        <th width="20%">Name</th>
                        <th width="70%">Description</th>
                        <th width="10%">Active</th>
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
    var actionUrl = "<?php echo base_url() . 'management/list_categories'; ?>";

    $(function() {
        $('#sidebar-management-link').addClass('active');
        $('#sidebar-management-list-categories-link').addClass('active');
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
                { data: "active", render:
                    function(data, type, row) {
                        return data == 1 ?
                        "<i class='fa fa-check text-success'></i>" :
                        "<i class='fa fa-times text-danger'></i>"
                    }
                },
                { data: "date_created", visible: false },
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
                "emptyTable": "No list categories yet."
            }
        });
    });
</script>