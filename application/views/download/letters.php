<div id="app">
    <h2>Mailings</h2>
    <ol class="breadcrumb">
        <li><a>Downloads</a></li>
        <li><a class="active">Letters</a></li>
    </ol>

    <div class="row">
        <div class="col-sm-12 panel-white">
        
            <?php 
            $this->load->view('blocks/filter', [
                'filter_fields' => [
                    'status',
                    'list',
                    'property-name',
                    'property-address',
                    'date-range',
                    'letter-no'
                ]
            ]); 
            ?>

            <table class="table table-bordered table-hover dt-responsive nowrap" width="100%" cellspacing="0">
                <thead>
                <tr>
                <th width="20%" class="td-col-first">ID</th>
                    <th width="20%">List</th>
                    <th width="23%">Property Name</th>
                    <th width="31%">Property Address</th>
                    <th width="10%">Letter No</th>
                    <th width="10%">Mailing Date</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<script>
    var dt;
    var actionUrl = "<?php echo base_url() . 'download/letters'; ?>";

    var data = {
        filter : {
            status: ['all'],
            list : ['all'],
            property_name : '',
            property_address : '',
            id: '',
            date_range : '',
            letter_no: ['all']
        },
        statusAll: false,
        listAll: true,
        letterNoAll: true
    };

    var vm = new Vue({
        el: "#app",
        data: data,
        methods: {
            filterList: function() {
                if (!data.filter.status || !data.filter.list || !data.filter.letter_no) {
                    loading('danger', 'Please select a status, list and a letter no.');
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
                    status: ['all'],
                    list : ['all'],
                    property_name : '',
                    property_address : '',
                    id: '',
                    date_range : '',
                    letter_no: ['all']
                }
                $("#status").val(null).trigger("change");
                $("#status").val('all').trigger("change");

                $("#list").val(null).trigger("change");
                $("#list").val('all').trigger("change");

                $("#letter-no").val(null).trigger("change");
                $("#letter-no").val('all').trigger("change");
            },
            download: function() {
                showModal('yesno', {
                    title: 'Save Download History',
                    body: 'Do you want this download to be saved in the download history?',
                    callback: function() {
                        $('#global-modal').modal('hide');
                        window.open(baseUrl + 'download/download/downloads_letters/1', '_blank');
                    },
                    cancelCallback: function() {
                        $('#global-modal').modal('hide');
                        window.open(baseUrl + 'download/download/downloads_letters', '_blank');
                    }
                });
            }
        }
    });

    $(function() {
        $('#sidebar-downloads-link').addClass('active');
        $('#sidebar-downloads-letters-link').addClass('active');
        $('#sidebar-downloads').addClass('in');

        setupDataTables();
        setupSelect2Fields();
        $('#list').val('all').trigger('change');
        $('#status').val(data.filter.status).trigger('change');
        $('#letter-no').val('all').trigger('change');

        setupDatepickerFields();
    });

    function setupSelect2Fields() {
        $('#status').select2({
            allowClear: true,
            data: <?php echo json_encode($statuses); ?>,
            closeOnSelect: false,
            placeholder: {
                id: "",
                placeholder: "Select a status"
            }
        }).on('change', function() {
            if ($.inArray('all', $(this).val()) > -1 && $(this).val().length > 1 && data.statusAll) {
                var selected = $(this).val();
                $("#status").val(null).trigger("change");
                $("#status").val(selected[1]).trigger("change");
                data.statusAll = false;
            }
            if ($.inArray('all', $(this).val()) > -1 && $(this).val().length > 1 && !data.statusAll) {
                $("#status").val(null).trigger("change");
                $("#status").val('all').trigger("change");
                data.statusAll = true;
            }
            data.filter.status = $(this).val();
        });

        $('#list').select2({
            allowClear: true,
            data: <?php echo json_encode($lists); ?>,
            closeOnSelect: false,
            placeholder: {
                id: "",
                placeholder: "Select a list"
            }
        }).on('change', function() {
            if ($.inArray('all', $(this).val()) > -1 && $(this).val().length > 1 && data.listAll) {
                var selected = $(this).val();
                $("#list").val(null).trigger("change");
                $("#list").val(selected[1]).trigger("change");
                data.listAll  = false;
            }
            if ($.inArray('all', $(this).val()) > -1 && $(this).val().length > 1 && !data.listAll) {
                $("#list").val(null).trigger("change");
                $("#list").val('all').trigger("change");
                data.listAll  = true;
            }
            data.filter.list = $(this).val();
        });

        $('#letter-no').select2({
            allowClear: true,
            data: ['all', 1, 2, 3, 4, 5, 6, 7, 8, 9 ,10],
            closeOnSelect: false,
            placeholder: {
                id: "",
                placeholder: "Select a letter no"
            }
        }).on('change', function() {
            if ($.inArray('all', $(this).val()) > -1 && $(this).val().length > 1 && data.letterNoAll) {
                var selected = $(this).val();
                $("#letter-no").val(null).trigger("change");
                $("#letter-no").val(selected[1]).trigger("change");
                data.letterNoAll = false;
            }
            if ($.inArray('all', $(this).val()) > -1 && $(this).val().length > 1 && !data.letterNoAll) {
                $("#letter-no").val(null).trigger("change");
                $("#letter-no").val('all').trigger("change");
                data.letterNoAll = true;
            }
            data.filter.letter_no = $(this).val();
        });
    }

    function setupDatepickerFields() {
        $('#date-range').datepicker({
            language: 'en',
            range: true,
            multipleDatesSeparator: ' - ',
            dateFormat: 'yyyy-mm-dd',
            onSelect: function(formattedDate, date, inst) {
                if (formattedDate.length > 11) {
                    data.filter.date_range = formattedDate;    
                } else {
                    data.filter.date_range = '';
                    $('#date-range').val('');
                }
            }
        });
    }

    function setupDataTables() {
        dt = $('table').dataTable({
            "order": [[ 5, "asc" ]],
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
                { data: "id", render: 
                    function(data, type, row) {
                        return row.url ? "<a target='_blank' href='" + row.url + "'>" + data + "</a>" : data;
                    }
                },
                { data: "list_name", render:
                    function(data, type, row) {
                        return row.list_url ? "<a target='_blank' href='" + row.list_url + "'>" + data + "</a>" : data;
                    }
                },
                { data: "property_last_name", render:
                    function(data, type, row) {
                        return row.property_last_name + " " + row.property_first_name + ", " + row.property_middle_name;
                    }
                },
                { data: "property_address" },
                { data: "letter_no" },
                { data: "mailing_date" }
            ],
            "fnDrawCallback": function (oSettings) {
                var table = $("table").dataTable();
                $('table tbody tr').on('click', function (e) {
                    if ($(e.target).attr('class') && $(e.target).attr('class').includes('dt-align-toggle')) {
                        return;
                    }
                    var pos = table.fnGetPosition(this);
                    var d = table.fnGetData(pos);
                });
            },
            "columnDefs": [
                { className: "dt-align-toggle", "targets": [0] }
            ]
        });
    }
</script>