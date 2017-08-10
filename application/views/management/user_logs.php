<div id="app">
    <h2>Management</h2>
    <ol class="breadcrumb">
        <li><a>Management</a></li>
        <li><a class="active">User Logs</a></li>
    </ol>

    <div class="row">
        <div class="col-sm-12 panel-white">

            <?php 
            $this->load->view('blocks/filter', [
                'filter_fields' => [
                    'date-range',
                    'user_id'
                ],
                'options' => [
                    'download' => false
                ]
            ]); 
            ?>

            <table class="table table-bordered table-hover dt-responsive nowrap" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th width="20%">Date</th>
                    <th width="25%">User ID & Name</th>
                    <th width="45%">Log</th>
                    <th width="10%">Link</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<script>
    var dt;
    var actionUrl = "<?php echo base_url() . 'management/user_logs'; ?>";


    var data = {
        filter : {
            date_range : '',
            user_id: ''
        }
    };

    var vm = new Vue({
        el: "#app",
        data: data,
        methods: {
            filterList: function() {
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
                    date_range : '',
                    user_id : ''
                }
            },
        }
    });

    $(function() {
        $('#sidebar-management-user-logs-link').addClass('active');
        $('#sidebar-management').addClass('in');
        setupDataTables();
        setupDatepickerFields();
    });

    function setupDatepickerFields() {
        $('#date-range').datepicker({
            language: 'en',
            range: true,
            multipleDatesSeparator: ' - ',
            dateFormat: 'yyyy-mm-dd',
            onSelect: function(formattedDate, date, inst) {
                data.filter.date_range = formattedDate;
            }
        });
    }

    function setupDataTables() {
        dt = $('table').dataTable({
            "order": [[ 0, 'desc' ]],
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
                { data: "date_created" },
                { data: "name", render: function(data, type, row) {
                        return row.user_id + " - " + data;
                    } 
                },
                { data: "log" },
                { data: "link", render: function(data, type, row) {
                        return data ? "<a href='" + data + "' target='_blank' class='btn btn-xs btn-main'>View</>" : 'N/A';
                    } 
                }
            ],
            "language": {
                "emptyTable": "No data found."
            }
        });
    }
</script>