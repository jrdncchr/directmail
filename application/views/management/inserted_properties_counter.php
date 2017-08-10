<div id="app">
    <h2>Management</h2>
    <ol class="breadcrumb">
        <li><a>Management</a></li>
        <li><a class="active">Inserted Properties Counter</a></li>
    </ol>

    <div class="row">
        <div class="col-sm-12 panel-white">
            <div class="alert alert-info">
                <i class="fa fa-info-circle"></i> By default it will filter only those inserted on the current month if no date range filter is found.
            </div>

            <?php 
            $this->load->view('blocks/filter', [
                'filter_fields' => [
                    'date-range'
                ],
                'options' => [
                    'download' => false,
                    'clear' => false
                ]
            ]); 
            ?>

            <table class="table table-bordered table-hover dt-responsive nowrap" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th width="20%">List ID</th>
                    <th width="60%">List Name</th>
                    <th width="20%">Count</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<script>
    var dt;
    var actionUrl = "<?php echo base_url() . 'management/inserted_properties_counter'; ?>";

    var data = {
        filter : {
            date_range : '<?php echo $current_date_range; ?>'
        }
    };

    var vm = new Vue({
        el: "#app",
        data: data,
        methods: {
            filterList: function() {
                if (!data.filter.date_range) {
                    loading('danger', 'Date Range cannot be empty.');
                    return;
                }
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
                    date_range : ''
                }
            },
        }
    });

    $(function() {
        $('#sidebar-management-ipc-link').addClass('active');
        $('#sidebar-management').addClass('in');

        setupDatepickerFields();
        setupDataTables();
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
            "order": [[ 2, 'desc' ]],
            "bDestroy": true,
            "filter": true,
            "ajax": {
                "type": "POST",
                "url": actionUrl,
                "data":  {
                    action: "list",
                    filter: data.filter
                }
            },
            columns: [
                { data: "id" },
                { data: "name" },
                { data: "property_count" }
            ],
            "language": {
                "emptyTable": "No Properties inserted on selected date range."
            }
        });
    }
</script>