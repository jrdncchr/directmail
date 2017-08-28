<div id="app">
    <h2>Management</h2>
    <ol class="breadcrumb">
        <li><a>Management</a></li>
        <li><a class="active">Backup and Restore</a></li>
    </ol>

    <div class="row">
        <div class="col-sm-12 panel-white">
            <div class="well well-lg">
                <h1>Create backup now.</h1>
                <p>This will create backup of properties related tables only.</p>
                <button class="btn btn-main btn-lg" v-on:click="backup">Backup Now</button>
            </div>
            <br />
            <div class="alert alert-info">
                <i class="fa fa-info-circle"></i> If there are already a lot of backups, make sure to delete the old ones because this files consumes storage space in the server.
            </div>
            <h2>Backup List & Restore</h2>
            <table class="table table-bordered table-hover dt-responsive nowrap" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th width="15%">ID</th>
                    <th width="35%">Date of Backup</th>
                    <th width="35%">Backup By</th>
                    <th width="15%">Action</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<script>
    var dt;
    var actionUrl = "<?php echo base_url() . 'management/backup_and_restore'; ?>";

    var vm = new Vue({
        el: "#app",
        methods: {
            backup: function() {
                showModal('yesno', {
                    title: 'Confirmation',
                    body: 'Back up now?',
                    callback: function() {
                        loading('info', 'Backup in process...');
                        spinButton($('#global-modal-yes'), true, 'Backing up...');
                        $('#global-modal-no').hide();
                        $.post(actionUrl, { action: 'backup' }, function(res) {
                            if (res.success) {
                                loading('success', 'Backup successful!');
                                dt.fnReloadAjax();
                            } else {
                                loading('error', 'Backup failed, contact administrator.');
                            }
                            spinButton($('#global-modal-yes'), false, 'Yes');
                            $('#global-modal-no').show();
                            $('#global-modal').modal('hide');
                        }, 'json');
                    },
                    cancelCallback: function() {
                        $('#global-modal').modal('hide');
                    }
            });
            }
        }
    });

    $(function() {
        $('#sidebar-management-backup-link').addClass('active');
        $('#sidebar-management').addClass('in');
        setupDataTables();
    });

    function delete_backup(id) {
        showModal('yesno', {
            title: 'Confirmation',
            body: 'Are you sure to delete this backup?',
            callback: function() {
                loading('info', 'Deleting backup...');
                $.post(actionUrl, { action: 'delete', id: id }, function(res) {
                    if (res.success) {
                        loading('success', 'Delete complete!');
                        dt.fnReloadAjax();
                    } else {
                        loading('error', 'Action failed, contact administrator.');
                    }
                    $('#global-modal').modal('hide');
                }, 'json');
            },
            cancelCallback: function() {
                $('#global-modal').modal('hide');
            }
        });
    }

    function restore_backup(id) {
        showModal('yesno', {
            title: 'Confirmation',
            body: 'Make sure to backup first before restoring. Restore now?',
            callback: function() {
                loading('info', 'Restoring backup...');
                spinButton($('#global-modal-yes'), true, 'Restoring...');
                $('#global-modal-no').hide();
                $.post(actionUrl, { action: 'restore', id: id }, function(res) {
                    if (res.success) {
                        loading('success', 'Restore complete!');
                    } else {
                        loading('error', 'Action failed, contact administrator.');
                    }
                    spinButton($('#global-modal-yes'), false, 'Yes');
                    $('#global-modal-no').show();
                    $('#global-modal').modal('hide');
                }, 'json');

            },
            cancelCallback: function() {
                $('#global-modal').modal('hide');
            }
        });
    }

    function setupDataTables() {
        dt = $('table').dataTable({
            "order": [[ 1, 'desc' ]],
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
                { data: "id" },
                { data: "date_created" },
                { data: "user_name" },
                { data: "id", render:
                    function(data, type, row) {
                        return "<button class='btn btn-xs btn-main' onclick='restore_backup(" + data + ")'>Restore</buton>" +
                                "<button class='btn btn-xs' onclick='delete_backup(" + data + ")'>Delete</buton>";
                    }
                }
            ],
            "language": {
                "emptyTable": "No Backups found."
            }
        });
    }
</script>