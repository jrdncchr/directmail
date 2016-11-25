<div id="app">
    <h2>Pending Properties</h2>
    <ol class="breadcrumb">
        <li><a>Approval</a></li>
        <li><a class="active">Properties</a></li>
    </ol>

    <div class="row">
        <div class="col-sm-12 panel-white">
            <div class="table-responsive" style="width: 100%; margin-top: 20px;">
                <table class="table table-bordered table-hover" width="100%">
                    <thead>
                    <tr>
                        <th width="6%">ID</th>
                        <th width="10%">List</th>
                        <th width="15%">Deceased Name</th>
                        <th width="27%">Deceased Address</th>
                        <th width="15%">Mail Name</th>
                        <th width="27%">Mail Address</th>
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
    var actionUrl = "<?php echo base_url() . 'approval/properties'; ?>";

    var data = {

    };

    var vm = new Vue({
        el: "#app",
        data: data,
        methods: {}
    });

    $(function() {
        $('#sidebar-approval-link').addClass('active');
        $('#sidebar-approval-properties-link').addClass('active');
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
                { data: "id" },
                { data: "list_name" },
                { data: "deceased_last_name", render:
                    function(data, type, row) {
                        return row.deceased_last_name + " " + row.deceased_first_name + ", " + row.deceased_middle_name;
                    }
                },
                { data: "deceased_address" },
                { data: "mail_last_name", render:
                    function(data, type, row) {
                        return row.mail_last_name + " " + row.mail_first_name;
                    }
                },
                { data: "mail_address" }
            ],
            "fnDrawCallback": function (oSettings) {
                var table = $("table").dataTable();
                $('table tbody tr').on('click', function () {
                    var pos = table.fnGetPosition(this);
                    var d = table.fnGetData(pos);
                    window.location = baseUrl + 'lists/property/' + data.list.id + '/info/' + d.id; 
                });
            },
            "language": {
                "emptyTable": "No property found for this list."
            }
        });
    });
</script>