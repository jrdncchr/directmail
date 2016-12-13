<div id="app">
    <h2>Similar Address Generator</h2>
    <ol class="breadcrumb">
        <li><a>Management</a></li>
        <li><a class="active">Similar Address Generator</a></li>
    </ol>

    <div class="row">
        <div class="col-sm-12 panel-white">
            <div class="form-group">
                <label for="name">* Enter Property Address</label>
                <input name="name" type="text" class="form-control" required
                       title="Address" v-model="address" v-on:blur="getSimilarAddress" />
            </div>
            <div class="form-group" v-if="similar_address.length">
                <label for="name">{{ similar_address.length }} similar address generated:</label>
                <ul class="list-group">
                    <li class="list-group-item" v-for="addr in similar_address">
                        <a href="#" class="list-group-item">{{ addr }}</a>
                    </li>
                    <a href="#" class="list-group-item">Dapibus ac facilisis in</a>
                </ul>
            </div>
            
        </div>
    </div>
</div>

<script>
    var actionUrl = "<?php echo base_url() . 'management/similar_address_generator'; ?>";

    var data = {
        address: '',
        similar_address: []
    };

    var vm = new Vue({
        el: "#app",
        data: data,
        methods: {
            getSimilarAddress: function() {
                if (data.address) {
                    $.post(actionUrl, { action: 'get_similar_addresses', addr: data.address }, function(res) {
                        var arr = [];
                        for (var prop in res) {
                            arr.push(res[prop]);
                        }
                        data.similar_address = arr;
                    }, 'json');
                }
            }
        }
    });

    $(function() {
        $('#sidebar-management-link').addClass('active');
        $('#sidebar-management-similar-address-checker').addClass('active');
        $('#sidebar-management').addClass('in');
    });
</script>