<div id="app">
    <h2>Companies</h2>
    <ol class="breadcrumb">
        <li><a>Management</a></li>
        <li><a class="active">Companies</a></li>
    </ol>

    <div class="row">
        <div class="col-sm-12 panel-white">
            <a href="<?php echo base_url() . 'management/companies/form'; ?>" class="btn btn-xs btn-default" style="margin-bottom: 20px;"><i class="fa fa-plus-circle"></i> New Company</a>
            <div class="notice"><?php echo $this->session->flashdata('message'); ?></div>
            <div class="table-responsive" style="width: 100%;">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Admin</th>
                        <th>Status</th>
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
    var actionUrl = "<?php echo base_url() . 'management/companies'; ?>";

    $(function() {
        $('#sidebar-management-link').addClass('active');
        $('#sidebar-management-companies-link').addClass('active');
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
                { data: "email", render: 
                    function(data, type, row) {
                        return row.first_name + " " + row.last_name + "<br />" + "<small>" +  data + "</small>";
                    }
                },
                { data: "status", render: 
                    function(data, type, row) {
                        var labelStyle = 'label-warning';
                        if (data == 'active') {
                            labelStyle = 'label-success';
                        }
                        if (row.deleted == 1) {
                            labelStyle = 'label-default';
                            data = 'Deleted';
                        }
                        return "<span class='label " + labelStyle + "'>" + capitalize(data) +  "</span>";
                    }
                },
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