<div id="app">
    <h2><?php echo $page_title; ?></h2>
    <ol class="breadcrumb">
        <li><a>Settings</a></li>
        <li><a class="active">Abbreviations</a></li>
    </ol>

    <div class="row">
        <div class="col-sm-12 panel-white">
            <?php if ($mc->_checkModulesChildPermission(MODULE_SETTINGS_ID, MODULE_ABBREVIATIONS_ID, 'create')): ?>
                <button id="add-abbr-btn" class="btn btn-xs btn-default" style="margin-bottom: 20px;"><i class="fa fa-plus-circle"></i> Add an Abbreviation</button>
            <?php endif; ?>
            <div class="table-responsive" style="width: 100%;">
                <table class="table table-bordered table-hover" width="100%">
                    <thead>
                    <tr>
                        <th width="30%">Abbreviation</th>
                        <th width="70%">Value</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

	<div class="modal fade" id="abberviation-modal" tabindex="-1" role="dialog" aria-labelledby="abberviation-modal-label">
	    <div class="modal-dialog" role="document">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                <h4 class="modal-title" id="abberviation-modal-label"></h4>
	            </div>
	            <div class="modal-body">
	            	<div class="notice"></div>
	            	<div class="form-group">
                        <label for="name">* Abbreviation</label>
                        <input name="name" type="text" class="form-control" required
                               title="Abbreviation" v-model="abbr.abbr" />
                    </div>
                 	<div class="form-group">
                        <label for="name">* Value</label>
                        <input name="name" type="text" class="form-control" required
                               title="Value" v-model="abbr.value" />
                    </div>
	            </div>
	            <div class="modal-footer">
	            	<button v-show="data.id > 0" type="button" class="btn btn-sm pull-left" v-on:click="deleteAbbreviation">Delete</button>
	                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
	                <button type="button" class="btn btn-main btn-sm" v-on:click="saveAbbreviation">Save</button>
	            </div>
	        </div>
	    </div>
	</div>

</div>

<script>
    var dt;
    var actionUrl = "<?php echo base_url() . 'settings/abbreviations'; ?>";

	var data = {
		id : 0,
		abbr : {
			abbr : '',
			value : ''
		}
	};

    var vm = new Vue({
        el: "#app",
        data: data,
        methods: {
            saveAbbreviation: function() {
            	var modal = $('#abberviation-modal');
                if (validator.validateForm(modal)) {
                    loading('info', 'Saving abbreviation...');
                    var abbr = data.abbr;
                    if (data.id > 0) {
                        abbr.id = 0;
                    }
                    $.post(actionUrl, { 
                        action: 'save', 
                        abbr: abbr
                    }, function(res) {
                    	if (res.success) {
                    		loading('success', 'Save successful!');
                    		modal.modal('hide');
                    		dt.fnReloadAjax();
                    	}
                    }, 'json');
                }
            },
            deleteAbbreviation: function() {
            	var modal = $('#abberviation-modal');
                if (validator.validateForm(modal)) {
                    loading('info', 'Deleting abbreviation...');
                    $.post(actionUrl, { 
                        action: 'delete', 
                        id: data.id
                    }, function(res) {
                    	if (res.success) {
                    		loading('success', 'Delete successful!');
                    		modal.modal('hide');
                    		dt.fnReloadAjax();
                    		data.id = 0;
                    	}
                    }, 'json');
                }
            }
        }
    });

    $(function() {
        $('#sidebar-settings-link').addClass('active');
        $('#sidebar-settings-abbreviations').addClass('active');
        $('#sidebar-settings').addClass('in');

        $('#add-abbr-btn').on('click', function() {
        	data.id = 0;
        	data.abbr.abbr = '';
        	data.abbr.value = '';
        	var modal = $('#abberviation-modal');
        	modal.find('.modal-title').html('Add Abbreviation');
        	modal.modal({
        		show: true,
        		keyboard: false,
        		backdrop: 'static'
        	});
        });

        dt = $('table').dataTable({
            "order": [[ 0, "asc" ]],
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
                { data: "abbr" },
                { data: "value" },
                { data: "id", visible: false }
            ],
            "fnDrawCallback": function (oSettings) {
                var table = $("table").dataTable();
                $('table tbody tr').on('click', function () {
                    var pos = table.fnGetPosition(this);
                    var rowData = table.fnGetData(pos);
                	data.id = rowData.id;
                	data.abbr.abbr = rowData.abbr;
                	data.abbr.value = rowData.value;
                	var modal = $('#abberviation-modal');
		        	modal.find('.modal-title').html('Update Abbreviation');
		        	modal.modal({
		        		show: true,
		        		keyboard: false,
		        		backdrop: 'static'
		        	});
                });
            },
            "language": {
                "emptyTable": "No abbreviations yet."
            }
        });
    });
</script>