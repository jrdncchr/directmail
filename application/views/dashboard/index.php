<div id="app">
	<br />
    <div class="row">
    	<div class="col-sm-12 panel-white" style="margin-bottom: 20px;">
    		<h2>Notifications</h2>
    		<?php if ($properties_for_mailing_today > 0) : ?>
    			<div class="alert">
    				<p class="text-success">
    					There are <b><?php echo $properties_for_mailing_today; ?></b> properties that have mailing dates set for Today. <a class="btn btn-main pull-right" href="<?php echo base_url() . 'download/letters' ?>">Check Letter Mailings</a>
    				<p>
    			</div>
    				
			<?php endif; ?>
			<?php if ($last_backup_days > 6) : ?>
    			<div class="alert">
    				<p class="text-warning">
    					Your last backup was <b><?php echo $last_backup_days; ?></b> days ago. <a class="btn btn-main pull-right" href="<?php echo base_url() . 'management/backup_and_restor' ?>">Go to Backup Now</a> 
    				<p>
    			</div>
			<?php endif; ?>
			<?php if ($properties_for_mailing_today == 0 && $last_backup_days < 7): ?>
				<div class="alert">
    				<p>
    					No notifications for Today.
    				<p>
    			</div>
			<?php endif; ?>
    	</div>

        <div class="col-sm-12 panel-white">
        	<h2>List that needs Action</h2>
        	<div class="alert alert-info">List that have a property with status of duplicate or draft.</div>
            <div class="table-responsive" style="width: 100%;">
                <table class="table table-bordered table-hover" width="100%">
                    <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th width="25%">Name</th>
                        <th width="20%">Created By</th>
                        <th width="20%">Date Created</th>
                        <th width="15%">Duplicates</th>
                        <th width="15%">Draft</th>
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
    var actionUrl = "<?php echo base_url() . 'dashboard/index'; ?>";

    $(function() {
        $('#sidebar-dashboard-link').addClass('active');

        dt = $('table').dataTable({
            "order": [[ 0, "asc" ]],
            "bDestroy": true,
            "filter": true,
            "ajax": {
                "type": "POST",
                "url": actionUrl,
                "data":  {
                    action: "needs_action"
                }
            },
            columns: [
                { data: "id" },
                { data: "name" },
                { data: "created_by", render:
                    function(data, type, row) {
                        return row.first_name + " " + row.last_name;
                    }
                },
                { data: "date_created" },
                { data: "duplicate_count" },
                { data: "draft_count" },
            ],
            "fnDrawCallback": function (oSettings) {
                var table = $("table").dataTable();
                $('table tbody tr').on('click', function (e) {
                    if ($(e.target).attr('class') && $(e.target).attr('class').includes('dt-align-toggle')) {
                        return;
                    }
                    var pos = table.fnGetPosition(this);
                    var data = table.fnGetData(pos);
                    $.post(actionUrl, {action: 'check_list_permission', list_id: data.id}, function(res) {
                        if (res.success) {
                            window.location = baseUrl + "lists/info/" + data.id;
                        } else {
                            showModal('confirm', {
                                title: "Permission Denied",
                                body: "You don't have permission for this list."
                            });
                        }
                    }, 'json');
                });
            },
            "language": {
                "emptyTable": "No list have a duplicate or draft."
            }
        });
    });
</script>