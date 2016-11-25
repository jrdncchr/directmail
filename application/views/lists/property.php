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
</style>
<div id="app">
    <h2>Property Details</h2>
    <ol class="breadcrumb">
        <li><a>List</a></li>
        <li><a href="<?php echo base_url() . 'lists/category/' . $list_category->_id; ?>"><?php echo $list_category->name; ?></a></li>
        <li><a href="<?php echo base_url() . 'lists/info/' . $list->id; ?>"><?php echo  $list->name; ?></a></li>
        <li><a class="active"><?php echo isset($property->id) ? $property->id : 'New Property'; ?></a></li>
    </ol>

    <?php if ($list->id > 0): ?>
    <div class="row" style="margin-top: 20px;">
        <div class="col-sm-12">
        <?php if(isset($property)): ?>
        <button v-on:click="deleteProperty" class="btn btn-xs" style="margin-bottom: 15px;"><i class="fa fa-trash"></i> Delete Property</button>
        <?php endif; ?>

        <?php if (isset($property)): ?>
            <?php if ($property->status == 'pending'): ?>
            <div class="alert alert-warning">
                <i class="fa fa-info-circle"></i>
                This property is still pending for approval.
            </div>
            <?php endif ?>
        <?php endif; ?>

        <!-- Nav tabs -->
          <ul class="nav nav-tabs nav-justified" role="tablist">
            <li role="presentation" class="active"><a href="#info" aria-controls="info" role="tab" data-toggle="tab">Information</a></li>
            <li v-show="data.property.id" role="presentation"><a href="#comments" aria-controls="comments" role="tab" data-toggle="tab">Comments</a></li>
            <li v-show="data.property.id" role="presentation"><a href="#history" aria-controls="history" role="tab" data-toggle="tab">History</a></li>
          </ul>

          <div class="tab-content">
            <!-- Information -->
            <div role="tabpanel" class="tab-pane active" id="info">
                <button v-on:click="saveProperty" class="btn btn-xs btn-main" style="margin-bottom: 20px;">
                    <i class="fa fa-save"></i> Save Property</button>
                <div class="notice"></div>
                <div class="panel panel-default" v-if="list.show_deceased == 1">
                    <div class="panel-heading">Deceased</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="d_first_name">* First Name</label>
                                    <input name="d_first_name" type="text" class="form-control required" required
                                           title="First Name" v-model="property.deceased_first_name" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="d_middle_name">Middle Name</label>
                                    <input name="d_middle_name" type="text" class="form-control"
                                           title="Middle Name" v-model="property.deceased_middle_name" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="d_last_name">* Last Name</label>
                                    <input name="d_last_name" type="text" class="form-control required" required
                                           title="Last Name" v-model="property.deceased_last_name" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="d_address">* Address</label>
                                    <input name="d_address" type="text" class="form-control required" required
                                           title="Address" v-model="property.deceased_address" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="d_city">* City</label>
                                    <input name="d_city" type="text" class="form-control required" required
                                           title="City" v-model="property.deceased_city" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="d_state">* State</label>
                                    <input name="d_state" type="text" class="form-control required" required
                                           title="State" v-model="property.deceased_city" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="d_zip_code">* Zip Code</label>
                                    <input name="d_zip_code" type="text" class="form-control required" required
                                           title="Zip Code" v-model="property.deceased_zipcode" />
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
               
            </div>

          </div>
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
</div>

<script>
    var actionUrl = "<?php echo base_url() . 'lists/property'; ?>";
    var sidebarListCategoryId = "<?php echo 'sidebar-list-category-' . $list_category->_id . '-link'; ?>";

    var data = {
        list_category : <?php echo json_encode($list_category); ?>,
        list : <?php echo json_encode($list); ?>,
        property: {},
        comment: ''
    };

    <?php if (isset($property)): ?>
    data.property = <?php echo json_encode($property); ?>;
    data.comments = <?php echo json_encode($comments); ?>;
    <?php endif; ?>

    var vm = new Vue({
        el: "#app",
        data: data,
        methods: {
            saveProperty: function() {
                var infoForm = $('#info');
                if(validator.validateForm(infoForm)) {
                    data.property.list_id = data.list.id;
                    loading("info", "Saving property...");
                    $.post(actionUrl, { action: 'save_property', form: data.property }, function(res) {
                        loading('success', 'Save successful!');
                        if (res.success && (undefined == data.property.id)) {
                            window.location = actionUrl + '/' + data.list.id + '/info/' + res.id;
                        }
                    }, 'json');
                }
            },
            deleteProperty: function() {
                showConfirmModal({
                    title: 'Delete Property',
                    body: 'Are you sure to delete this property?',
                    callback: function() {
                        loading("info", "Deleting property...");
                        $.post(actionUrl, { action: 'delete_property', id: data.property.id }, function(res) {
                            if (res.success) {
                                hideConfirmModal();
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
            }
        }
    });

    $(function() {
        $('#sidebar-list-link').addClass('active');
        $('#' + sidebarListCategoryId).addClass('active');
        $('#sidebar-list').addClass('in');

        $('.modal').on('hidden.bs.modal', function () {
            data.comment = '';
            validator.displayAlertError($(this), false);
            validator.displayInputError($(this).find('textarea'), false);
        })
    });
</script>