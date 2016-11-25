<div id="app">
    <h2><?php echo $list->id > 0 ? $list->name : 'Create List'; ?></h2>
    <ol class="breadcrumb">
        <li><a>List</a></li>
        <li><a href="<?php echo base_url() . 'lists/category/' . $list_category->_id; ?>"><?php echo $list_category->name; ?></a></li>
        <li><a class="active"><?php echo $list->id > 0 ? $list->name : 'Create List'; ?></a></li>
    </ol>

    <div class="row" id="list-form">
        <div class="col-sm-12">
            <div class="notice"></div>
        </div>
        <div class="col-sm-12 panel-white">
            <div class="col-sm-6" style="padding: 0 !important;">
                <div class="form-group">
                    <label for="name">* List Name</label>
                     <input name="name" type="text" class="form-control required" required
                           title="List Name" v-model="list.name" />
                    <?php if (($list->id > 0 && $mc->_checkListPermission($list->id, 'update')) ||
                        ($list->id == 0 && $mc->_checkListCategoryPermission($list_category->_id, 'create'))): 
                    ?>
                   	<ul class="list-group" style="margin-top: 20px;">
					  <li class="list-group-item">
					    <label class="control control--checkbox pull-right" style="top: -2px">
                            <input type="checkbox" v-model="list.show_deceased" />
                            <div class="control__indicator"></div>
                        </label>
					    Deceased
					  </li>
					  <li class="list-group-item">
					    <label class="control control--checkbox pull-right" style="top: -2px">
                            <input type="checkbox" v-model="list.show_pr" />
                            <div class="control__indicator"></div>
                        </label>
					    PR
					  </li>
					  <li class="list-group-item">
					    <label class="control control--checkbox pull-right" style="top: -2px">
                            <input type="checkbox" v-model="list.show_attorney" />
                            <div class="control__indicator"></div>
                        </label>
					    Attorney
					  </li>
					  <li class="list-group-item">
					    <label class="control control--checkbox pull-right" style="top: -2px">
                            <input type="checkbox" v-model="list.show_mail" />
                            <div class="control__indicator"></div>
                        </label>
					    Mail
					  </li>
					</ul>
                    <button v-on:click="saveList" class="btn btn-xs btn-main" style="margin-top: 10px; width: 30%;">
                        <i class="fa fa-save"></i> Save
                    </button>
                     <?php endif; ?>
                     <?php if ($mc->_checkListPermission($list->id, 'delete')): ?>
                     <button v-on:click="deleteList" class="btn btn-xs" style="margin-top: 10px; width: 30%;">
                        <i class="fa fa-trash"></i> Delete
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>


    <?php if ($list->id > 0): ?>
    <div class="row" style="margin-top: 20px;">
        <div class="col-sm-12">
        <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#properties" aria-controls="properties" role="tab" data-toggle="tab"><i class="fa fa-home"></i> Properties</a></li>
          </ul>

          <!-- Tab panes -->
          <div class="tab-content">

            <!-- Properties -->
            <div role="tabpanel" class="tab-pane active" id="properties">
                <a href="<?php echo base_url() . 'lists/property/' . $list->id . '/new'; ?>" class="btn btn-xs btn-default" style="width: 30%;">
                    <i class="fa fa-plus-circle"></i> Add Property
                </a>
                <div class="table-responsive" style="width: 100%; margin-top: 20px;">
                    <table class="table table-bordered table-hover" width="100%">
                        <thead>
                        <tr>
                            <th width="6%">ID</th>
                            <th width="8%">Status</th>
                            <th width="17%">Deceased Name</th>
                            <th width="27%">Deceased Address</th>
                            <th width="15%">Mail Name</th>
                            <th width="27%">Mail Address</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
          </div>
        </div>
    </div>
<?php endif; ?>
</div>

<script>
    var dt;
    var actionUrl = "<?php echo base_url() . 'lists/info'; ?>";
    var sidebarListCategoryId = "<?php echo 'sidebar-list-category-' . $list_category->_id . '-link'; ?>";

    var data = {
        list_category : <?php echo json_encode($list_category); ?>,
        list : <?php echo json_encode($list); ?>
    };

    var vm = new Vue({
        el: "#app",
        data: data,
        methods: {
            /*
             * List Functions
             */
            saveList: function() {
                var form = $('#list-form');
                if (validator.validateForm(form)) {
                    loading('info', 'Saving list...');
                    var list = {
                        name : data.list.name,
                        list_category_id: data.list_category._id,
                        show_deceased: data.list.show_deceased ? 1 : 0,
                        show_pr: data.list.show_pr ? 1 : 0,
                        show_attorney: data.list.show_attorney ? 1 : 0,
                        show_mail: data.list.show_mail ? 1 : 0,
                    };
                    if (data.list.id > 0) {
                        list.id = data.list.id;
                    }
                    $.post(actionUrl, { 
                        action: 'save_list', 
                        list: list
                    }, function(res) {
                        if (res.success) {
                            loading('success', 'Save successful!');
                            window.location = baseUrl + 'lists/info/' + res.id;
                        } else {
                            validator.displayAlertError(form, true, res.message);
                        }
                    }, 'json');
                }
            },
            deleteList: function() {
                showConfirmModal({
                    title: 'Delete List',
                    body: 'Are you sure to delete this list?',
                    callback: function() {
                        loading("info", "Deleting list...");
                        $.post(actionUrl, { 
                            action: 'delete_list', 
                            list_id: data.list.id 
                        }, function(res) {
                            hideConfirmModal();
                            window.location = baseUrl + 'lists/category/' + data.list_category._id ;
                        }, 'json');
                    }
                });
            },
        }
    });

    $(function() {
        $('#sidebar-list-link').addClass('active');
        $('#' + sidebarListCategoryId).addClass('active');
        $('#sidebar-list').addClass('in');

        dt = $('table').dataTable({
            "order": [[ 0, "desc" ]],
            "bDestroy": true,
            "filter": true,
            "ajax": {
                "type": "POST",
                "url": actionUrl,
                "data":  {
                    action: "property_list",
                    list_id: <?php echo json_encode($list->id); ?>
                }
            },
            columns: [
                { data: "id" },
                { data: "status", render: function(data, type, row) {
                        if (data == "active") {
                            return "<span class='label label-success'>Active</span>";
                        } else if (data == "pending") {
                            return "<span class='label label-warning'>Pending</span>";
                        } else {
                            return "<span class='label label-default'>Inactive</span>";
                        }
                    } 
                },
                { data: "deceased_last_name", render:
                    function(data, type, row) {
                        return row.deceased_last_name + " " + row.deceased_first_name + ", " + row.deceased_middle_name;
                    }
                },
                { data: "deceased_address" },
                { data: "mail_last_name", render:
                    function(data, type, row) {
                        return row.mail_last_name + " " + row.mail_first_name;
                    }
                },
                { data: "mail_address" },
            ],
            "fnDrawCallback": function (oSettings) {
                var table = $("table").dataTable();
                $('table tbody tr').on('click', function () {
                    var pos = table.fnGetPosition(this);
                    var d = table.fnGetData(pos);
                    window.location = baseUrl + 'lists/property/' + data.list.id + '/info/' + d.id; 
                });
            },
            "language": {
                "emptyTable": "No property found for this list."
            }
        });
    });
</script>