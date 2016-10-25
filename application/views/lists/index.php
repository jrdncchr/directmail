<div id="app">
    <h2><?php echo $list_category->name; ?></h2>
    <ol class="breadcrumb">
        <li><a>List</a></li>
        <li><a class="active"><?php echo $list_category->name; ?></a></li>
    </ol>

    <div class="row">
        <div class="col-sm-12">
            <a href="<?php echo base_url() . 'lists/category/' . $list_category->id . '/add'; ?>" class="btn btn-sm btn-default" style="margin-bottom: 20px;"><i class="fa fa-plus-circle"></i> Add a list</a>
            <div class="table-responsive" style="width: 100%;">
                <table class="table table-bordered table-hover" width="100%">
                    <thead>
                    <tr>
                        <th width="60%">Name</th>
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
    var actionUrl = "<?php echo base_url() . 'lists/category'; ?>";
    var sidebarListCategoryId = "<?php echo 'sidebar-list-category-' . $list_category->id . '-link'; ?>";

    $(function() {
        $('#sidebar-list-link').addClass('active');
        $('#' + sidebarListCategoryId).addClass('active');
        $('#sidebar-list').addClass('in');

        dt = $('table').dataTable({
            "order": [[ 0, "asc" ]],
            "bDestroy": true,
            "filter": true,
            "ajax": {
                "type": "POST",
                "url": actionUrl,
                "data":  {
                    action: "list",
                    list_category_id: <?php echo json_encode($list_category->id); ?>
                }
            },
            columns: [
                { data: "name" },
                { data: "created_by", render:
                    function(data, type, row) {
                        return row.first_name + " " + row.last_name;
                    }
                },
                { data: "id", visible: false }
            ],
            "fnDrawCallback": function (oSettings) {
                var table = $("table").dataTable();
                $('table tbody tr').on('click', function () {
                    var pos = table.fnGetPosition(this);
                    var data = table.fnGetData(pos);
//                    window.location = baseUrl + 'lists/index/' + data.id;
                });
            },
            "language": {
                "emptyTable": "No list available in this category."
            }
        });
    });
</script>