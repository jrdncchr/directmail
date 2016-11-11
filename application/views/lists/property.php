<style>
#info .panel-heading {
    background: #BD3738;
    color: white;
}
</style>
<div id="app">
    <h2>Property Details</h2>
    <ol class="breadcrumb">
        <li><a>List</a></li>
        <li><a href="<?php echo base_url() . 'lists/category/' . $list_category->_id; ?>"><?php echo $list_category->name; ?></a></li>
        <li><a href="<?php echo base_url() . 'lists/info/' . $list->id; ?>"><?php echo  $list->name; ?></a></li>
        <li><a class="active"><?php echo  $property->id; ?></a></li>
    </ol>

    <?php if ($list->id > 0): ?>
    <div class="row" style="margin-top: 20px;">
        <div class="col-sm-12">
        <!-- Nav tabs -->
          <ul class="nav nav-tabs nav-justified" role="tablist">
            <li role="presentation" class="active"><a href="#info" aria-controls="info" role="tab" data-toggle="tab">Information</a></li>
            <li role="presentation"><a href="#comments" aria-controls="comments" role="tab" data-toggle="tab">Comments</a></li>
            <li role="presentation"><a href="#history" aria-controls="history" role="tab" data-toggle="tab">History</a></li>
          </ul>

          <div class="tab-content">

            <!-- Information -->
            <div role="tabpanel" class="tab-pane active" id="info">
                <div class="notice"></div>
                <div class="panel panel-default">
                    <div class="panel-heading">Deceased</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="d_first_name">* First Name</label>
                                    <input name="d_first_name" type="text" class="form-control" required
                                           title="First Name" v-model="property.deceased_first_name" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="d_middle_name">* Middle Name</label>
                                    <input name="d_middle_name" type="text" class="form-control" required
                                           title="Middle Name" v-model="property.deceased_middle_name" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="d_last_name">* Last Name</label>
                                    <input name="d_last_name" type="text" class="form-control" required
                                           title="Last Name" v-model="property.deceased_last_name" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="d_address">* Address</label>
                                    <input name="d_address" type="text" class="form-control" required
                                           title="Address" v-model="property.deceased_address" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="d_city">* City</label>
                                    <input name="d_city" type="text" class="form-control" required
                                           title="City" v-model="property.deceased_city" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="d_state">* State</label>
                                    <input name="d_state" type="text" class="form-control" required
                                           title="State" v-model="property.deceased_city" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="d_zip_code">* Zip Code</label>
                                    <input name="d_zip_code" type="text" class="form-control" required
                                           title="Zip Code" v-model="property.deceased_zipcode" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">PR</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="pr_first_name">* First Name</label>
                                    <input name="pr_first_name" type="text" class="form-control" required
                                           title="First Name" v-model="property.pr_first_name" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="pr_middle_name">* Middle Name</label>
                                    <input name="pr_middle_name" type="text" class="form-control" required
                                           title="Middle Name" v-model="property.pr_middle_name" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="pr_last_name">* Last Name</label>
                                    <input name="pr_last_name" type="text" class="form-control" required
                                           title="Last Name" v-model="property.pr_last_name" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="pr_address">* Address</label>
                                    <input name="pr_address" type="text" class="form-control" required
                                           title="Address" v-model="property.pr_address" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="pr_city">* City</label>
                                    <input name="pr_city" type="text" class="form-control" required
                                           title="City" v-model="property.pr_city" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="pr_state">* State</label>
                                    <input name="pr_state" type="text" class="form-control" required
                                           title="State" v-model="property.pr_state" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="pr_zip_code">* Zip Code</label>
                                    <input name="pr_zip_code" type="text" class="form-control" required
                                           title="Zip Code" v-model="property.pr_zipcode" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Attorney</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="a_name">* Name</label>
                                    <input name="a_name" type="text" class="form-control" required
                                           title="Name" v-model="property.attorney_name" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="a_first_address">* First Address</label>
                                    <input name="a_first_address" type="text" class="form-control" required
                                           title="Address" v-model="property.attorney_first_address" />
                                </div>
                            </div>
                        </div>
                       <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="a_second_address">* Second Address</label>
                                    <input name="a_second_address" type="text" class="form-control" required
                                           title="Address" v-model="property.attorney_second_address" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="a_city">* City</label>
                                    <input name="a_city" type="text" class="form-control" required
                                           title="City" v-model="property.attorney_city" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="a_state">* State</label>
                                    <input name="a_state" type="text" class="form-control" required
                                           title="State" v-model="property.attorney_state" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="a_zip_code">* Zip Code</label>
                                    <input name="pr_zip_code" type="text" class="form-control" required
                                           title="Zip Code" v-model="property.attorney_zipcode" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Mail</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="m_first_name">* First Name</label>
                                    <input name="m_first_name" type="text" class="form-control" required
                                           title="First Name" v-model="property.mail_first_name" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="m_last_name">* Last Name</label>
                                    <input name="m_last_name" type="text" class="form-control" required
                                           title="Last Name" v-model="property.mail_last_name" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="m_address">* Address</label>
                                    <input name="m_address" type="text" class="form-control" required
                                           title="Address" v-model="property.mail_address" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="m_city">* City</label>
                                    <input name="m_city" type="text" class="form-control" required
                                           title="City" v-model="property.mail_city" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="m_state">* State</label>
                                    <input name="m_state" type="text" class="form-control" required
                                           title="State" v-model="property.mail_state" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="m_zip_code">* Zip Code</label>
                                    <input name="m_zip_code" type="text" class="form-control" required
                                           title="Zip Code" v-model="property.mail_zipcode" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Comments -->
            <div role="tabpanel" class="tab-pane" id="comments">

            </div>

            <!-- History -->
            <div role="tabpanel" class="tab-pane" id="history">
               
            </div>

          </div>
        </div>
    </div>
<?php endif; ?>
</div>

<script>
    var actionUrl = "<?php echo base_url() . 'lists/property'; ?>";
    var sidebarListCategoryId = "<?php echo 'sidebar-list-category-' . $list_category->_id . '-link'; ?>";

    var data = {
        list_category : <?php echo json_encode($list_category); ?>,
        list : <?php echo json_encode($list); ?>,
        property : <?php echo json_encode($property) ?>
    };

    var vm = new Vue({
        el: "#app",
        data: data,
        methods: {
        }
    });

    $(function() {
        $('#sidebar-list-link').addClass('active');
        $('#' + sidebarListCategoryId).addClass('active');
        $('#sidebar-list').addClass('in');
    });
</script>