<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="filterHeading">
        <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#filterBox" aria-expanded="true" aria-controls="filterBox" >
            <a role="button" style="font-size: 16px !important; font-weight: bold;">
                FILTER
            </a>
        </h4>
    </div>
    <div id="filterBox" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="filterHeading">
        <div class="panel-body">
            <div class="form-horizontal">
                <div class="row">
                    <?php if (in_array('status', $filter_fields)): ?>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="status" class="control-label col-sm-2">Status</label>
                            <div class="col-sm-10">
                                <select id="status" class="form-control" multiple="multiple">
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if (in_array('list', $filter_fields)): ?>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="list" class="control-label col-sm-2">List</label>
                            <div class="col-sm-10">
                                <select id="list" class="form-control" multiple="multiple">
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if (in_array('id', $filter_fields)): ?>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label col-sm-4">ID</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" v-model="filter.id" />
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if (in_array('skip-traced', $filter_fields)): ?>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="skip-traced" class="control-label col-sm-4">Skip Traced</label>
                            <div class="col-sm-8">
                                <div class="checkbox">
                                    <label><input id="skip-traced" type="checkbox" v-model="filter.skip_traced" /></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if (in_array('resource', $filter_fields)): ?>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="resource" class="control-label col-sm-4">Resource</label>
                            <div class="col-sm-8">
                                <input id="resource" type="text" class="form-control" v-model="filter.resource" />
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if (in_array('property-name', $filter_fields)): ?>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="property-name" class="control-label col-sm-4">Property Name</label>
                            <div class="col-sm-8">
                                <input id="property-name" type="text" class="form-control" v-model="filter.property_name" />
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if (in_array('property-address', $filter_fields)): ?>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="property-address" class="control-label col-sm-4">Property Address</label>
                            <div class="col-sm-8">
                                <input id="property-address" type="text" class="form-control" v-model="filter.property_address" />
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if (in_array('date-range', $filter_fields)): ?>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="date-range" class="control-label col-sm-4">Date Range</label>
                            <div class="col-sm-8">
                                <input id="date-range" type="text" readonly="true" class="form-control" v-model="filter.date_range" />
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if (in_array('letter-no', $filter_fields)): ?>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="letter-no" class="control-label col-sm-4">Letter No.</label>
                            <div class="col-sm-8">
                                <select id="letter-no" class="form-control" multiple="multiple">
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="col-sm-12">
                        <button v-on:click="clearFilter" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                        <a v-on:click="download" class="btn btn-default btn-sm"><i class="fa fa-download"></i></a>
                        <button v-on:click="filterList" class="btn btn-default btn-sm pull-right" style="width: 200px;">Filter</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
