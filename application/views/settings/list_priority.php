<div id="app">
    <h2>List Priority</h2>
    <ol class="breadcrumb">
        <li><a>Settings</a></li>
        <li><a class="active">List Priority</a></li>
    </ol>

    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-info">
                <i class="fa fa-info-circle"></i> 
                Drag the list in order, prioritizing those that in top when a duplicate is found.
            </div>
            <button class="btn btn-sm btn-main" style="margin-bottom: 10px;" v-on:click="savePriorityOrder">Save Priority Order</button>
            <ul class="list-group sortable">
                <li class="list-group-item" v-for="list in lists" :data-list-id="list.id">{{ list.name }}</li>
            </ul>
        </div>
    </div>

</div>

<script>
    var actionUrl = "<?php echo base_url() . 'settings/list_priority'; ?>";

    var data = {
        lists : <?php echo json_encode($lists); ?>
    };

    var vm = new Vue({
        el: "#app",
        data: data,
        methods: {
            savePriorityOrder: function() {
                var order = [];
                var priority = 1;
                $('.list-group-item').each(function() {
                    order.push({ id: $(this).data('list-id'), priority: priority });
                    priority++;
                });
                loading('info', 'Saving list priority order...');
                $.post(actionUrl, { 
                    action: 'save', 
                    order: order
                }, function(res) {
                    if (res.success) {
                        loading('success', 'Save successful!');
                    }
                }, 'json');
            }
        }
    });

    $(function() {
        $('#sidebar-settings-link').addClass('active');
        $('#sidebar-settings-list-priority').addClass('active');
        $('#sidebar-settings').addClass('in');

        $('.sortable').sortable();
    });
</script>