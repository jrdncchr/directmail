<div id="app">
    <h2>Bulk Import</h2>
    <ol class="breadcrumb">
        <li><a>List</a></li>
        <li><a href="<?php echo base_url() . 'lists/info/' . $list->id; ?>"><?php echo  $list->name; ?></a></li>
        <li><a class="active">Bulk Import</a></li>
    </ol>

    <div class="row">
        <div class="col-sm-12 panel-white">
            <div class="alert alert-warning">
                <p style="font-weight: bold;"><i class="fa fa-question-circle"></i> FORMAT</p>
                <p>Excel .xls, Excel 2007 (OfficeOpenXML) .xlsx, CSV, Libre/OpenOffice Calc .ods</p>
                <p><a href="<?php echo base_url() . 'resources/files/directmail_spreadsheet_format.ods'; ?>">Download Spreadsheet Format</a></p>
            </div>
            <div v-show="error != ''" class="alert alert-danger" style="display:none;">
                <i class="fa fa-exclamation-circle"></i> {{ error }}
            </div>
            <p>List ID: <b><?php echo $list->id; ?></b></p>
            <form action="<?php  echo base_url() . 'lists/info/' . $list->id . '/bulk_import_result'; ?>" method="post" enctype="multipart/form-data" onsubmit="return validate()"> 

                        <!-- <form action="<?php  // echo base_url() . 'download/upload'; ?>" method="post" enctype="multipart/form-data" onsubmit="return validate()">  -->
                <div class="form-group">
                    <label for="file">Select File</label>
                    <div class="input-group">
                        <label class="input-group-btn">
                            <span class="btn btn-default btn-sm">
                                Browse <input id="browse" name="file" type="file" style="display: none;" />
                            </span>
                        </label>
                        <input id="fileName" type="text" class="form-control" readonly style="height: 37px;" />
                    </div>
                </div>
                <button type="submit" class="btn btn-main btn-sm pull-right">Import</button>
            </form>
        </div>
    </div>
</div>

<script>
    var actionUrl = "<?php echo base_url() . 'list/info'; ?>";

    var data = {
        error: ''
    };

    var vm = new Vue({
        el: "#app",
        data: data,
        methods: {

        }
    });
    
    $(function() {
        $('#sidebar-list-link').addClass('active');
        $('#sidebar-list').addClass('in');

        $('#browse').on('change', function() {
            var file = $(this)[0].files[0];
            var input = $(this).parents('.input-group').find('input[type="text"]');
            input.val(file.name);
        });
    });

    function validate() {
        var browse = document.getElementById("browse");
        if (!browse.value.length) {
            data.error = "Please select a file before importing.";
            browse.focus();
            return false;
        }
        var fileName = document.getElementById("fileName").value;
        var ext = fileName.slice((fileName.lastIndexOf(".") - 1 >>> 0) + 2);
        if (ext != "xlsx" && ext != "ods" && ext != "ODS" && ext != "XLSX") {
            data.error = "Selected file is not a valid spreadsheet.";
            browse.focus();
            return false;
        }
        // var i = 0;
        // var x = setInterval(function() {
        //     i++;
        //     $.ajax({
        //         url: baseUrl + 'download/check',
        //         method: 'GET',
        //         async: true,
        //         success: function(res) {
        //             console.log(res);
        //         }
        //     });
        // }, 1000);
        // return true;
    }
</script>