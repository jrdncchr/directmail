<div class="btn-group" style="margin-bottom: 10px;">
    <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Bulk Action <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li><a href="#" id="bulk-delete" v-on:click="bulkDelete">Delete</a></li>
        <li><a href="#bulk-change-status-modal" data-toggle="modal" data-target="#bulk-change-status-modal">Change Status</a></li>
    </ul>
</div>

<!-- Global Confirm Modal -->
<div class="modal fade" id="bulk-change-status-modal" tabindex="-1" role="dialog" aria-labelledby="bulk-change-status-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="bulk-change-status-modal-label">Bulk Action - Change Status</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Change Status</label>
                            <select id="bulk-status" class="form-control" v-model="bulkStatus">
                                <option value="">Select a status</option>
                                <?php foreach($statuses as $status): ?>
                                    <?php if ($status['text'] !== 'All'): ?>
                                        <option value="<?php echo $status['id']; ?>"><?php echo $status['text']; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-main" v-on:click="bulkChangeStatus">Save</button>
            </div>
        </div>
    </div>
</div>
