<style>
    p.comment_user {
        color: #BD3738 !important;
        font-size: 16px;
        font-weight: bold;
    }
    p.comment_date {
        font-size: 14px;
        color: gray;
        line-height: 10px;
    }
    input:disabled {
        background-color: lightgray !important;
    }
    p.history_date {
        font-size: 16px;
        color: gray;
        line-height: 10px;
    }
</style>
<div id="app">
    <h2>Property Details</h2>
    <ol class="breadcrumb">
        <li><a>List</a></li>
        <li><a href="<?php echo base_url() . 'lists/info/' . $list->id; ?>"><?php echo  $list->name; ?></a></li>
        <li><a class="active"><?php echo isset($property->id) ? $property->id : 'New Property'; ?></a></li>
    </ol>

    <?php if ($list->id > 0): ?>
    <div class="row" style="margin-top: 20px;">
        <div class="col-sm-12">

            <div class="alert alert-warning" v-show="property && property.status === 'pending'" style="display: none;">
                <i class="fa fa-info-circle"></i>
                This property is still pending for approval.
            </div>
            <div class="alert alert-warning" v-show="property && property.status === 'replacement'" style="display: none;">
                <i class="fa fa-info-circle"></i>
                This property is saved for replacement approval for property <a target="_blank" :href="property.pr_url">{{ property.target_property_id }}</a>.
            </div>

            <?php if ($this->session->flashdata('message')): ?>
                <div class="alert alert-success">
                    <i class="fa fa-check-circle"></i>
                    <?php echo $this->session->flashdata('message'); ?>
                </div>
            <?php endif; ?>

            <button v-on:click="saveProperty" class="btn btn-xs btn-main" style="margin-bottom: 20px;">
                <i class="fa fa-save"></i> Save Property
            </button>

            <button v-on:click="draftProperty" class="btn btn-xs" style="margin-bottom: 20px;">
                <i class="fa fa-save"></i> Save to Draft
            </button>

            <div style="margin-bottom: 15px;" class="pull-right">
                <span v-show="property.status == 'pending' || property.status == 'draft'" class="label label-warning" style="display: none; font-size: 20px;">{{ property.status | capitalize }}</span>
                <span v-show="property.status == 'active' || property.status == 'lead' || property.status == 'buy'" class="label label-success" style="display: none; font-size: 20px;">{{ property.status | capitalize }}</span>
                <span v-show="property.status == 'change'" class="label label-info" style="display: none; font-size: 20px;">{{ property.status | capitalize }}</span>
                <span v-show="property.status == 'stop'" class="label label-danger" style="display: none; font-size: 20px;">{{ property.status | capitalize }}</span>
                <span v-show="property.status == 'inactive'" class="label label-default" style="display: none; font-size: 20px;">{{ property.status | capitalize }}</span>
            </div>

            <!-- Nav tabs -->
              <ul class="nav nav-tabs nav-justified" role="tablist">
                <li role="presentation" class="active"><a href="#info" aria-controls="info" role="tab" data-toggle="tab">Information</a></li>
                <li role="presentation"><a href="#mailings" aria-controls="mailings" role="tab" data-toggle="tab">Mailings</a></li>
                <li v-show="data.property.id" role="presentation"><a href="#comments" aria-controls="comments" role="tab" data-toggle="tab">Comments</a></li>
                <li v-show="data.property.id" role="presentation"><a href="#history" aria-controls="history" role="tab" data-toggle="tab">History</a></li>
              </ul>

              <div class="tab-content">
                <!-- Information -->
                <div role="tabpanel" class="tab-pane active" id="info">
                    <div class="notice"></div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="resource">* Resource</label>
                                <input name="resource" type="text" class="form-control required" required
                                       title="Resource" v-model="property.resource" />
                            </div>
                            <div class="form-group">
                                 <div class="checkbox">
                                    <label>
                                        <input type="checkbox" v-model="property.skip_traced"> Skip Traced
                                    </label>
                                </div>
                            </div>
                        </div>
                        <?php if (isset($property) && (($property->status !== 'pending' && $property->status !== 'replacement') || $mc->_checkModulePermission(MODULE_APPROVAL_ID, 'update'))): ?>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" v-model="property.status">
                                    <option value="pending">Pending</option>
                                    <option value="active">Active</option>
                                    <option value="lead">Lead</option>
                                    <option value="buy">Buy</option>
                                    <option value="change">Change</option>
                                    <option value="stop">Stop</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="panel panel-default" v-if="list.show_property == 1">
                        <div class="panel-heading">Property</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="d_first_name">* First Name</label>
                                        <input name="d_first_name" type="text" class="form-control required" required
                                               title="First Name" v-model="property.property_first_name" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="d_middle_name">Middle Name</label>
                                        <input name="d_middle_name" type="text" class="form-control"
                                               title="Middle Name" v-model="property.property_middle_name" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="d_last_name">Last Name</label>
                                        <input name="d_last_name" type="text" class="form-control" required
                                               title="Last Name" v-model="property.property_last_name" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="d_address">* Address</label>
                                        <input name="d_address" type="text" class="form-control required" required
                                               title="Address" v-model="property.property_address"
                                               :disabled="property.status == 'replacement' ? true : false" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="d_city">* City</label>
                                        <input name="d_city" type="text" class="form-control required" required
                                               title="City" v-model="property.property_city" 
                                               :disabled="property.status == 'replacement' ? true : false" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="d_state">* State</label>
                                        <input name="d_state" type="text" class="form-control required" required
                                               title="State" v-model="property.property_state" 
                                               :disabled="property.status == 'replacement' ? true : false" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="d_zip_code">* Zip Code</label>
                                        <input name="d_zip_code" type="text" class="form-control required" required
                                               title="Zip Code" v-model="property.property_zipcode" 
                                               :disabled="property.status == 'replacement' ? true : false" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default" v-if="list.show_pr == 1">
                        <div class="panel-heading">PR</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="pr_first_name">* First Name</label>
                                        <input name="pr_first_name" type="text" class="form-control required" required
                                               title="First Name" v-model="property.pr_first_name" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="pr_middle_name">Middle Name</label>
                                        <input name="pr_middle_name" type="text" class="form-control"
                                               title="Middle Name" v-model="property.pr_middle_name" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="pr_last_name">* Last Name</label>
                                        <input name="pr_last_name" type="text" class="form-control required" required
                                               title="Last Name" v-model="property.pr_last_name" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="pr_address">* Address</label>
                                        <input name="pr_address" type="text" class="form-control required" required
                                               title="Address" v-model="property.pr_address" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="pr_city">* City</label>
                                        <input name="pr_city" type="text" class="form-control required" required
                                               title="City" v-model="property.pr_city" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="pr_state">* State</label>
                                        <input name="pr_state" type="text" class="form-control required" required
                                               title="State" v-model="property.pr_state" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="pr_zip_code">* Zip Code</label>
                                        <input name="pr_zip_code" type="text" class="form-control required" required
                                               title="Zip Code" v-model="property.pr_zipcode" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default" v-if="list.show_attorney == 1">
                        <div class="panel-heading">Attorney</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="a_name">* Name</label>
                                        <input name="a_name" type="text" class="form-control required" required
                                               title="Name" v-model="property.attorney_name" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="a_first_address">* First Address</label>
                                        <input name="a_first_address" type="text" class="form-control required" required
                                               title="Address" v-model="property.attorney_first_address" />
                                    </div>
                                </div>
                            </div>
                           <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="a_second_address">Second Address</label>
                                        <input name="a_second_address" type="text" class="form-control"
                                               title="Address" v-model="property.attorney_second_address" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="a_city">* City</label>
                                        <input name="a_city" type="text" class="form-control required" required
                                               title="City" v-model="property.attorney_city" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="a_state">* State</label>
                                        <input name="a_state" type="text" class="form-control required" required
                                               title="State" v-model="property.attorney_state" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="a_zip_code">* Zip Code</label>
                                        <input name="pr_zip_code" type="text" class="form-control required" required
                                               title="Zip Code" v-model="property.attorney_zipcode" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default" v-if="list.show_mail == 1">
                        <div class="panel-heading">Mail</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="m_first_name">* First Name</label>
                                        <input name="m_first_name" type="text" class="form-control required" required
                                               title="First Name" v-model="property.mail_first_name" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="m_last_name">* Last Name</label>
                                        <input name="m_last_name" type="text" class="form-control required" required
                                               title="Last Name" v-model="property.mail_last_name" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="m_address">* Address</label>
                                        <input name="m_address" type="text" class="form-control required" required
                                               title="Address" v-model="property.mail_address" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="m_city">* City</label>
                                        <input name="m_city" type="text" class="form-control required" required
                                               title="City" v-model="property.mail_city" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="m_state">* State</label>
                                        <input name="m_state" type="text" class="form-control required" required
                                               title="State" v-model="property.mail_state" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="m_zip_code">* Zip Code</label>
                                        <input name="m_zip_code" type="text" class="form-control required" required
                                               title="Zip Code" v-model="property.mail_zipcode" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Mailings -->
                <div role="tabpanel" class="tab-pane" id="mailings">
                    <div class="notice"></div>
                    <div class="row">
                        <div class="col-sm-12 col-lg-6" v-for="mailing in mailings">
                            <div class="form-group">
                                <label>Letter {{ mailing.letter_no }}</label>
                                <input type="text" class="form-control required mailing_date" required 
                                    v-model="mailing.mailing_date" readonly :disabled="checkDate(mailing.mailing_date)" />
                                <input type="hidden" v-model="mailing.letter_no" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comments -->
                <div role="tabpanel" class="tab-pane" id="comments">
                    <button class="btn btn-xs btn-default" style="margin-bottom: 20px;" data-toggle="modal" data-target="#comment-modal">
                    <i class="fa fa-plus-circle"></i> Add Comment
                    </button>
                    <section v-if="comments">
                        <div class="well" v-for="c in comments">
                            <p class="comment_user"><i class="fa fa-user"></i> {{ c.first_name + ' ' + c.last_name }}</p>
                            <p class="comment_date"><i class="fa fa-clock-o"></i> {{ c.date_created }}</p>
                            <p>{{ c.comment }}</p>
                        </div>
                    </section>
                    <section v-else>
                        <div class="well">No comments found.</div>
                    </section>
                </div>

                <!-- History -->
                <div role="tabpanel" class="tab-pane" id="history">
                    <section v-if="histories">
                        <div class="well" v-for="history in histories">
                            <p class="history_date"><i class="fa fa-clock-o"></i> {{ history.date_created }}</p>
                            <p style="font-size: 16px;">{{ history.message }}</p>
                        </div>
                    </section>
                    <section v-else>
                        <div class="well">No comments found.</div>
                    </section>
                </div>

            </div>

            <?php if (isset($property)): ?>
            <button v-on:click="deleteProperty" class="btn btn-xs" style="margin-bottom: 35px;"><i class="fa fa-trash"></i> Delete Property</button>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="modal fade" id="comment-modal" tabindex="-1" role="dialog" aria-labelledby="comment-modal-label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="comment-modal-label">Add Comment</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="notice"></div>
                            <div class="form-group">
                                <label for="comment">* Comment</label>
                                <textarea name="comment" class="form-control required" required
                                       title="Comment" v-model="comment"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    <button v-on:click="saveComment" type="button" class="btn btn-main btn-sm">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="property-exist-modal" tabindex="-1" role="dialog" aria-labelledby="property-exist-modal-label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="comment-modal-label">Existing Similar Property</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="alert alert-warning" v-if="similar_address.length == 1">
                                <i class="fa fa-exclamation-circle"></i>
                                An existing similar property address was detected.
                            </div>
                            <div class="alert alert-warning" v-else>
                                <i class="fa fa-exclamation-circle"></i>
                                A multiple similar address was detected, please contact administrator.
                            </div>
                            <div class="form-group">
                                <div class="list-group" v-for="addr in similar_address">
                                    <a target="_blank" v-bind:href="addr.url" class="list-group-item"> {{ addr.property_address }} 
                                    <code class="pull-right">{{ addr.id }}</code>
                                    </a>
                                </div>
                            </div>
                            <div class="form-group" v-if="similar_address.length == 1">
                                <label for="m_zip_code">* What action would you like to take?</label>
                                <select class="form-control required" v-model="similar_address_action">
                                    <option value="save">Save property for replacement approval.</option>
                                    <option v-show="similar_address[0].permission" value="2">Replace (Property Address only)</option>
                                    <option v-show="similar_address[0].permission" value="3">Replace (All except list info)</option>
                                    <option v-show="similar_address[0].permission" value="4">Replace (All)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-xs pull-left" data-dismiss="modal">Close</button>
                    <div v-if="similar_address.length == 1">
                        <button v-on:click="replaceConfirmAction" type="button" class="btn btn-main btn-xs">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var actionUrl = "<?php echo base_url() . 'lists/property'; ?>";

    var data = {
        similar_address: [],
        similar_address_action: 'save',
        list : <?php echo json_encode($list); ?>,
        property: {},
        comment: '',
        histories: [],
        mailings: <?php echo json_encode($mailings); ?>
    };

    <?php if (isset($property)): ?>
    data.property = <?php echo json_encode($property); ?>;
    data.comments = <?php echo json_encode($comments); ?>;
    data.histories = <?php echo json_encode($histories); ?>;
    <?php endif; ?>

    var vm = new Vue({
        el: "#app",
        data: data,
        filters: {
            capitalize: function (value) {
                if (!value) { 
                    return '';
                }
                value = value.toString()
                return value.charAt(0).toUpperCase() + value.slice(1)
            }
        },
        methods: {
            saveProperty: function() {
                var infoForm = $('#info');
                if (validator.validateForm(infoForm)) {
                    data.property.list_id = data.list.id;
                    loading("info", "Saving property...");
                    $.post(actionUrl, { action: 'save_property', form: data.property, mailings: data.mailings }, function(res) {
                        if (res.success && (undefined == data.property.id)) {
                            window.location = actionUrl + '/' + data.list.id + '/info/' + res.id;
                        }  else if (!res.success) {
                            if (res.exist) {
                                loading('warning', 'A similar existing property is detected.');
                                data.similar_address = res.properties;

                                var propertyExistModal = $('#property-exist-modal');
                                propertyExistModal.modal({
                                    show: true,
                                    backdrop: 'static',
                                    keyboard: false
                                });
                            }
                        } else {
                            loading('success', 'Save successful!');
                        }
                    }, 'json');
                }
            },
            draftProperty: function() {
                loading("info", "Saving to draft...");
                data.property.status = 'draft';
                data.property.list_id = data.list.id;
                $.post(actionUrl, { action: 'save_property', form: data.property, mailings: data.mailings }, function(res) {
                    if (res.success && (undefined == data.property.id)) {
                        window.location = actionUrl + '/' + data.list.id + '/info/' + res.id;
                    }  else if (!res.success) {
                        if (res.exist) {
                            loading('warning', 'A similar existing property is detected.');
                            data.similar_address = res.properties;

                            var propertyExistModal = $('#property-exist-modal');
                            propertyExistModal.modal({
                                show: true,
                                backdrop: 'static',
                                keyboard: false
                            });
                        }
                    } else {
                        loading('success', 'Save successful!');
                    }
                }, 'json');
            },
            replaceConfirmAction: function() {
                loading("info", "Taking action, please wait...");
                $.post(actionUrl, { action: 'replace_action', target_property_id: data.similar_address[0].id, property: data.property, replace_action: data.similar_address_action }, function(res) {
                    if (res.success && (undefined == data.property.id)) {
                        window.location = actionUrl + '/' + data.list.id + '/info/' + res.id;
                    } else if (!res.success) {
                        loading("danger", "Something went wrong.");
                    } else {
                        loading('success', 'Action complete.');
                        var propertyExistModal = $('#property-exist-modal');
                        propertyExistModal.modal('hide');
                        if (data.similar_address_action == 'save') {
                            data.property.status = 'replacement';
                            data.property.target_property_id = data.similar_address[0].id;
                        } else {
                             window.location = actionUrl + '/' + res.target_list_id + '/info/' + res.target_id;
                        }
                    }
                }, 'json');
            },
            deleteProperty: function() {
                showModal('confirm', {
                    title: 'Delete Property',
                    body: 'Are you sure to delete this property?',
                    callback: function() {
                        loading("info", "Deleting property...");
                        $.post(actionUrl, { action: 'delete_property', id: data.property.id, status: data.property.status }, function(res) {
                            if (res.success) {
                                hideModal();
                                window.location = baseUrl + 'lists/info/' + data.list.id;
                            } else {
                                loading('danger', res.message);
                            }
                        }, 'json');
                    }
                });
            },
            saveComment: function() {
                var commentForm = $('#comment-modal');
                if (validator.validateForm(commentForm)) {
                    loading("info", "Saving comment...");
                    $.post(actionUrl, { action: 'save_comment', comment: data.comment, property_id: data.property.id }, function(res) {
                        $.post(actionUrl, { action: 'get_comments', property_id: data.property.id }, function(res) {
                            loading("info", "Save sucessful!");
                            commentForm.modal('hide');
                            data.comments = res;                   
                        }, 'json');
                    }, 'json');
                }
            },
            checkDate(date) {
                return mydate = new Date(date) < new Date();
            }
        }
    });

    $(() => {
        $('#sidebar-list-link').addClass('active');
        $('#sidebar-list').addClass('in');

        $('.modal').on('hidden.bs.modal', function () {
            data.comment = '';
            validator.displayAlertError($(this), false);
            validator.displayInputError($(this).find('textarea'), false);
        })

        $('.mailing_date:enabled').datepicker({
            language: 'en',
            dateFormat: 'yyyy-mm-dd',
            onSelect: function(formattedDate, date, inst) {
                var letterNo = inst.$el.parent().find('input[type="hidden"]').val();
                for (var i = 0; i < data.mailings.length; i++) {
                    if (data.mailings[i].letter_no == letterNo) {
                        data.mailings[i].mailing_date = formattedDate;
                        break;
                    }
                }
            }
        });
    });
</script>