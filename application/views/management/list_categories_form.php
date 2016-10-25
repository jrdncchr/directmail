<div id="app">
    <h2><?php echo isset($list_category) ? 'Edit List Category' : 'Create New List Category'; ?></h2>
    <ol class="breadcrumb">
        <li><a>Management</a></li>
        <li><a href="<?php echo base_url() . 'management/list_categories'; ?>">List Category</a></li>
        <li><a class="active"><?php echo isset($list_category) ? 'Edit List Category' : 'Create New List Category'; ?></a></li>
    </ol>

    <div class="row">
        <div class="col-sm-12">
            <?php if (isset($list_category)): ?>
            <button class="btn btn-default btn-xs" style="margin-bottom: 10px;" v-on:click="deleteListCategory"><i class="fa fa-trash-o"></i> Delete List Category</button>
            <?php endif; ?>
            <div id="list-category-form">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        List Category Details
                        <button class="btn btn-default btn-xs pull-right" v-on:click="save"><i class="fa fa-save"></i> Save</button>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="notice"></div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="name">* Name</label>
                                    <input name="name" type="text" class="form-control" required
                                           title="List Category Name" v-model="list_category.name" />
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="description">* Description</label>
                                    <input name="description" type="text" class="form-control" required
                                           title="List Category Description" v-model="list_category.description" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="control control--checkbox">
                                    Active
                                    <input type="checkbox" v-model="list_category.active" />
                                    <div class="control__indicator"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var actionUrl = "<?php echo base_url() . 'management/list_categories'; ?>";

    var data = {
        list_category: {
            id: <?php echo isset($list_category) ?  json_encode($list_category->id) : json_encode(''); ?>,
            name: <?php echo isset($list_category) ?  json_encode($list_category->name) : json_encode(''); ?>,
            description: <?php echo isset($list_category) ?  json_encode($list_category->description) : json_encode(''); ?>,
            active: <?php echo isset($list_category) ?  json_encode($list_category->active) : json_encode(''); ?>
        }
    };

    var vm = new Vue({
        el: "#app",
        data: data,
        methods: {
            save: function() {
                var listCategoryForm = $('#list-category-form');
                if(validator.validateForm(listCategoryForm)) {
                    loading("info", "Saving list category...");
                    $.post(actionUrl, { action: 'save', form: data.list_category }, function(res) {
                        loading('success', 'Save successful!');
                        if (res.success && data.list_category.id == '') {
                            window.location = actionUrl + "/form/" + res.id;
                        }
                    }, 'json');
                }
            },
            deleteListCategory: function() {
                showConfirmModal({
                    title: 'Delete List Category',
                    body: 'Are you sure to delete this list category?',
                    callback: function() {
                        loading("info", "Deleting list category...");
                        $.post(actionUrl, { action: 'delete', id: data.list_category.id }, function(res) {
                            if (res.success) {
                                hideConfirmModal();
                                window.location = actionUrl;
                            } else {
                                loading('danger', res.message);
                            }
                        }, 'json');
                    }
                });
            }
        }
    });

    $(function() {
        $('#sidebar-management-link').addClass('active');
        $('#sidebar-management-list-categories-link').addClass('active');
        $('#sidebar-management').addClass('in');
    });
</script>