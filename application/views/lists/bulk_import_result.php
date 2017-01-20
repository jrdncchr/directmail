<style>
    th, tr {
        text-align: center !important;
    }
    a {
        font-size: 14px;
    }
</style>
<div id="app">
    <h2>Bulk Import Result</h2>
    <ol class="breadcrumb">
        <li><a>List</a></li>
        <li><a href="<?php echo base_url() . 'lists/category/' . $list_category->_id; ?>"><?php echo $list_category->name; ?></a></li>
        <li><a href="<?php echo base_url() . 'lists/info/' . $list->id; ?>"><?php echo  $list->name; ?></a></li>
        <li><a href="<?php echo base_url() . 'lists/info/' . $list->id . '/bulk_import'; ?>">Bulk Import</a></li>
        <li><a class="active">Result</a></li>
    </ol>

    <div class="row">
        <div class="col-sm-12 panel-white">
            <h2 class="text-center" style="margin-top: 0; margin-bottom: 30px;">Import Complete</h2>
            <section v-show="result.similars.length > 0" style="display: none;">
                <h4><b>{{ result.similars.length }}</b> Similar/Duplicate Properties</h4>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Status</th>
                            <th>Spreadsheet Row</th>
                            <th>Property Address</th>
                            <th></th>
                            <th>Target Status</th>
                            <th>Taraget Property ID</th>
                            <th>Target Property Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="danger" v-for="similar in result.similars">
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-xs btn-default btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" v-on:click="replaceAction('save', similar)">Save property for replacement approval.</a></li>
                                        <li><a href="#" v-on:click="replaceAction(2, similar)">Replace (Property Address only)</a></li>
                                        <li><a href="#" v-on:click="replaceAction(3, similar)">Replace (All except list info)</a></li>
                                        <li><a href="#" v-on:click="replaceAction(4, similar)">Replace (All)</a></li>
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <span class="label label-success" v-show="similar.status == 'active' || similar.status == 'lead'">{{ similar.status }}</span>
                                <span class="label label-warning" v-show="similar.status == 'pending'">{{ similar.status }}</span>
                                <span class="label label-info" v-show="similar.status == 'change'">{{ similar.status }}</span>
                                <span class="label label-danger" v-show="similar.status == 'stop'">{{ similar.status }}</span>
                                <span class="label label-default" v-show="similar.status == 'inactive'">{{ similar.status }}</span>
                            </td>
                            <td>{{ similar.row }}</td>
                            <td>{{ similar.property_address }}</td>
                            <td><i class="fa fa-arrows-h fa-2x"></i></td>
                            <td>
                                <span class="label label-success" v-show="similar.check.properties[0].status == 'active' || similar.check.properties[0].status == 'lead'">{{ similar.check.properties[0].status }}</span>
                                <span class="label label-warning" v-show="similar.check.properties[0].status == 'pending'">{{ similar.check.properties[0].status }}</span>
                                <span class="label label-info" v-show="similar.check.properties[0].status == 'change'">{{ similar.check.properties[0].status }}</span>
                                <span class="label label-danger" v-show="similar.check.properties[0].status == 'stop'">{{ similar.check.properties[0].status }}</span>
                                <span class="label label-default" v-show="similar.check.properties[0].status == 'inactive'">{{ similar.check.properties[0].status }}</span>
                            </td>
                            <td v-if="similar.check.properties[0].permission">
                                <a style="font-size: 14px;" target="_blank" :href="similar.check.properties[0].url">{{ similar.check.properties[0].id }}</a>
                            </td>
                            <td v-else>{{ similar.check.properties[0].id }}</td>
                            <td>{{ similar.check.properties[0].property_address }}</td>
                        </tr>
                    </tbody>
                </table>
            </section>
            <section v-show="result.saved.length > 0" style="display: none;">
                <h4><b>{{ result.saved.length }}</b> Successfully Saved Properties</h4>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="20%">Spreadsheet Row</th>
                            <th width="60%">Saved Property Address</th>
                            <th width="20%">Saved Property ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="success" v-for="saved in result.saved">
                            <td>{{ saved.row }}</td>
                            <td>{{ saved.property_address }}</td>
                            <td>{{ saved.id }}</td>
                        </tr>
                    </tbody>
                </table>
            </section>
            <section v-show="result.saved.length == 0 && result.similars.length == 0" style="display: none;">
                <div class="alert alert-warning">
                    <i class="fa fa-exclamation-circle"></i> No properties to save or duplicates were detected.
                </div>
            </section>
            <a href="<?php echo base_url() . 'lists/info/' . $list->id . '/bulk_import'; ?>">
                &larr; Return to Bulk Import
            </a>
        </div>
    </div>
</div>

<script>
    var actionUrl = "<?php echo base_url() . 'lists/info'; ?>";

    var data = {
        result : <?php echo json_encode($result); ?>
    };

    var vm = new Vue({
        el: "#app",
        data: data,
        methods: {
            replaceAction: function(action, property) {
                loading('info', 'Taking action, please wait...');
                $.post(actionUrl, {
                    action: 'replace_action',
                    replace_action: action,
                    property: property,
                    target_property_id: property.check.properties[0].id
                }, function(res) {
                    if (res.success) {
                        for (var i = 0; i < data.result.similars.length; i++) {
                            if (data.result.similars[i].row == property.row) {
                                data.result.similars.splice(i, 1);
                                break;
                            }
                        }
                        loading('success', 'Replacement action complete.');
                    }
                }, 'json');
            }
        }
    });

    var sidebarListCategoryId = "<?php echo 'sidebar-list-category-' . $list_category->_id . '-link'; ?>";
    $(function() {
        $('#sidebar-list-link').addClass('active');
        $('#' + sidebarListCategoryId).addClass('active');
        $('#sidebar-list').addClass('in');
    });
</script>