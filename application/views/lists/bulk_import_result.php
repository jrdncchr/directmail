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
        <li><a class="active">Bulk Import Result</a></li>
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
                            <th>Spreadsheet Row</th>
                            <th>Property Address</th>
                            <th></th>
                            <th>Similar Property ID</th>
                            <th>Similar Property Address</th>
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
                                        <li><a href="#">Replace similar property.</a></li>
                                        <li><a href="#">Save property for replacement approval.</a></li>
                                    </ul>
                                </div>
                            </td>
                            <td>{{ similar.row }}</td>
                            <td>{{ similar.deceased_address }}</td>
                            <td><i class="fa fa-arrows-h fa-2x"></i></td>
                            <td v-if="similar.check.properties[0].permission">
                                <a style="font-size: 14px;" target="_blank" :href="similar.check.properties[0].url">{{ similar.check.properties[0].id }}</a>
                            </td>
                            <td v-else>{{ similar.check.properties[0].id }}</td>
                            <td>{{ similar.check.properties[0].deceased_address }}</td>
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
                            <td>{{ saved.deceased_address }}</td>
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
    var actionUrl = "<?php echo base_url() . 'list/info'; ?>";

    var data = {
        result : <?php echo json_encode($result); ?>
    };

    var vm = new Vue({
        el: "#app",
        data: data,
        methods: {

        }
    });

    var sidebarListCategoryId = "<?php echo 'sidebar-list-category-' . $list_category->_id . '-link'; ?>";
    $(function() {
        $('#sidebar-list-link').addClass('active');
        $('#' + sidebarListCategoryId).addClass('active');
        $('#sidebar-list').addClass('in');
    });
</script>