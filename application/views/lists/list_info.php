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
        <div class="col-sm-6">
            <div class="form-group">
                <label for="name">* List Name</label>
                 <input name="name" type="text" class="form-control required" required
                       title="List Name" v-model="list.name" />
                    <?php if (($list->id > 0 && $mc->_checkListPermission($list->id, 'update')) ||
                        ($list->id == 0 && $mc->_checkListCategoryPermission($list_category->_id, 'create'))): 
                    ?>
                    <button v-on:click="saveList" class="btn btn-xs btn-main" style="margin-top: 10px; width: 30%;">
                        <i class="fa fa-save"></i> Save
                    </button>
                     <?php endif; ?>
                     <?php if ($mc->_checkListPermission($list->id, 'delete')): ?>
                     <button v-on:click="deleteList" class="btn btn-xs btn-default" style="margin-top: 10px; width: 30%;">
                        <i class="fa fa-trash"></i> Delete
                    </button>
                    <?php endif; ?>
            </div>
        </div>
    </div>


    <?php if ($list->id > 0): ?>
    <div class="row" style="margin-top: 20px;">
        <div class="col-sm-12">
        <!-- Nav tabs -->
          <ul class="nav nav-tabs nav-justified" role="tablist">
            <li role="presentation" class="active"><a href="#properties" aria-controls="properties" role="tab" data-toggle="tab">Properties</a></li>
            <li role="presentation" class="dropdown"> 
                <a href="#" class="dropdown-toggle" id="paragraphs" data-toggle="dropdown" aria-controls="paragraphs" aria-expanded="false">Paragraphs <span class="caret"></span></a>
                <ul class="dropdown-menu" aria-labelledby="paragraphs" id="paragraphs-contents"> 
                    <li class=""><a href="#paragraphs-intro" role="tab" data-toggle="tab" aria-controls="dropdown1" aria-expanded="false">Intro</a></li> 
                    <li class=""><a href="#paragraphs-second" role="tab" data-toggle="tab" aria-controls="dropdown2" aria-expanded="false">Second</a></li> 
                    <li class=""><a href="#paragraphs-bbb" role="tab" data-toggle="tab" aria-controls="dropdown3" aria-expanded="false">BBB</a></li> 
                    <li class=""><a href="#paragraphs-kim" role="tab" data-toggle="tab" aria-controls="dropdown4" aria-expanded="false">Keep in Mind</a></li> 
                    <li class=""><a href="#paragraphs-cta" role="tab" data-toggle="tab" aria-controls="dropdown5" aria-expanded="false">Call to Action</a></li>
                    <li class=""><a href="#paragraphs-ps" role="tab" data-toggle="tab" aria-controls="dropdown6" aria-expanded="false">PS</a></li>  
                </ul> 
            </li>
            <li role="presentation"><a href="#bullet-points" aria-controls="bullet-points" role="tab" data-toggle="tab">Bullet Points</a></li>
            <li role="presentation"><a href="#testimonials" aria-controls="testimonials" role="tab" data-toggle="tab">Testimonials</a></li>
          </ul>

          <!-- Tab panes -->
          <div class="tab-content">

            <!-- Properties -->
            <div role="tabpanel" class="tab-pane active" id="properties">
                <div class="table-responsive" style="width: 100%;">
                    <table class="table table-bordered table-hover" width="100%">
                        <thead>
                        <tr>
                            <th width="6%">ID</th>
                            <th width="8%">Status</th>
                            <th width="27%">Deceased Address</th>
                            <th width="17%">Deceased Name</th>
                            <th width="27%">Mail Address</th>
                            <th width="15%">Mail Name</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <!-- Paragraphs Intro -->
            <div role="tabpanel" class="tab-pane" id="paragraphs-intro">
                <h4>Intro Paragraphs</h4>
                <div class="paragraph-list" v-if="paragraphs.intro.length">
                    <div class="row" v-for="p in paragraphs.intro" style="padding: 15px 0; border-bottom: 1px dotted lightgrey;">
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="2" v-model="p.content"></textarea>
                        </div>
                        <div class="col-sm-3 text-center">
                            <code>[paragraph-intro-{{ list.id }}-{{ p.number }}]</code>
                            <button v-on:click="removeParagraph('intro', p)" style="margin-top: 5px;" class="btn btn-default btn-xs btn-block"><i class="fa fa-minus-circle"></i> Remove</button>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <div class="alert alert-warning"><i class="fa fa-info-circle"></i> No intro paragraphs yet.</div>
                </div>
                <div class="row" style="margin-top: 15px;">
                    <div class="col-xs-3">
                        <button v-on:click="addParagraph('intro')" class="btn btn-default btn-xs btn-block"><i class="fa fa-plus-circle"></i> Add Paragraph</button>
                    </div>
                    <div class="col-xs-4 col-xs-offset-5">
                        <?php if ($mc->_checkListPermission($list->id, 'update')): ?>
                        <button v-on:click="saveParagraph('intro')" class="btn btn-main btn-xs btn-block pull-right"><i class="fa fa-save"></i> Save Intro Paragraphs</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Paragraphs 2nd -->
            <div role="tabpanel" class="tab-pane" id="paragraphs-second">
                <h4>Second Paragraphs</h4>
                <div class="paragraph-list" v-if="paragraphs.second.length">
                    <div class="row" v-for="p in paragraphs.second" style="padding: 15px 0; border-bottom: 1px dotted lightgrey;">
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="2" v-model="p.content"></textarea>
                        </div>
                        <div class="col-sm-3 text-center">
                            <code>[paragraph-second-{{ list.id }}-{{ p.number }}]</code>
                            <button v-on:click="removeParagraph('second', p)" style="margin-top: 5px;" class="btn btn-default btn-xs btn-block"><i class="fa fa-minus-circle"></i> Remove</button>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <div class="alert alert-warning"><i class="fa fa-info-circle"></i> No second paragraphs yet.</div>
                </div>
                <div class="row" style="margin-top: 15px;">
                    <div class="col-xs-3">
                        <button v-on:click="addParagraph('second')" class="btn btn-default btn-xs btn-block"><i class="fa fa-plus-circle"></i> Add Paragraph</button>
                    </div>
                    <div class="col-xs-4 col-xs-offset-5">
                        <?php if ($mc->_checkListPermission($list->id, 'update')): ?>
                        <button v-on:click="saveParagraph('second')" class="btn btn-main btn-xs btn-block pull-right"><i class="fa fa-save"></i> Save Second Paragraphs</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Paragraphs BBB -->
            <div role="tabpanel" class="tab-pane" id="paragraphs-bbb">
                <h4>BBB Paragraphs</h4>
                <div class="paragraph-list" v-if="paragraphs.bbb.length">
                    <div class="row" v-for="p in paragraphs.bbb" style="padding: 15px 0; border-bottom: 1px dotted lightgrey;">
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="2" v-model="p.content"></textarea>
                        </div>
                        <div class="col-sm-3 text-center">
                            <code>[paragraph-bbb-{{ list.id }}-{{ p.number }}]</code>
                            <button v-on:click="removeParagraph('bbb', p)" style="margin-top: 5px;" class="btn btn-default btn-xs btn-block"><i class="fa fa-minus-circle"></i> Remove</button>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <div class="alert alert-warning"><i class="fa fa-info-circle"></i> No bbb paragraphs yet.</div>
                </div>
                <div class="row" style="margin-top: 15px;">
                    <div class="col-xs-3">
                        <button v-on:click="addParagraph('bbb')" class="btn btn-default btn-xs btn-block"><i class="fa fa-plus-circle"></i> Add Paragraph</button>
                    </div>
                    <div class="col-xs-4 col-xs-offset-5">
                        <?php if ($mc->_checkListPermission($list->id, 'update')): ?>
                        <button v-on:click="saveParagraph('bbb')" class="btn btn-main btn-xs btn-block pull-right"><i class="fa fa-save"></i> Save BBB Paragraphs</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Paragraphs Keep in Mind -->
            <div role="tabpanel" class="tab-pane" id="paragraphs-kim">
                <h4>Keep in Mind Paragraphs</h4>
                <div class="paragraph-list" v-if="paragraphs.kim.length">
                    <div class="row" v-for="p in paragraphs.kim" style="padding: 15px 0; border-bottom: 1px dotted lightgrey;">
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="2" v-model="p.content"></textarea>
                        </div>
                        <div class="col-sm-3 text-center">
                            <code>[paragraph-kim-{{ list.id }}-{{ p.number }}]</code>
                            <button v-on:click="removeParagraph('kim', p)" style="margin-top: 5px;" class="btn btn-default btn-xs btn-block"><i class="fa fa-minus-circle"></i> Remove</button>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <div class="alert alert-warning"><i class="fa fa-info-circle"></i> No keep in mind paragraphs yet.</div>
                </div>
                <div class="row" style="margin-top: 15px;">
                    <div class="col-xs-3">
                        <button v-on:click="addParagraph('kim')" class="btn btn-default btn-xs btn-block"><i class="fa fa-plus-circle"></i> Add Paragraph</button>
                    </div>
                    <div class="col-xs-4 col-xs-offset-5">
                        <?php if ($mc->_checkListPermission($list->id, 'update')): ?>
                        <button v-on:click="saveParagraph('kim')" class="btn btn-main btn-xs btn-block pull-right"><i class="fa fa-save"></i> Save Keep in Mind Paragraphs</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Paragraphs Call to Action -->
            <div role="tabpanel" class="tab-pane" id="paragraphs-cta">
                <h4>Call to Action Paragraphs</h4>
                <div class="paragraph-list" v-if="paragraphs.cta.length">
                    <div class="row" v-for="p in paragraphs.cta" style="padding: 15px 0; border-bottom: 1px dotted lightgrey;">
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="2" v-model="p.content"></textarea>
                        </div>
                        <div class="col-sm-3 text-center">
                            <code>[paragraph-cta-{{ list.id }}-{{ p.number }}]</code>
                            <button v-on:click="removeParagraph('cta', p)" style="margin-top: 5px;" class="btn btn-default btn-xs btn-block"><i class="fa fa-minus-circle"></i> Remove</button>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <div class="alert alert-warning"><i class="fa fa-info-circle"></i> No call to action paragraphs yet.</div>
                </div>
                <div class="row" style="margin-top: 15px;">
                    <div class="col-xs-3">
                        <button v-on:click="addParagraph('cta')" class="btn btn-default btn-xs btn-block"><i class="fa fa-plus-circle"></i> Add Paragraph</button>
                    </div>
                    <div class="col-xs-4 col-xs-offset-5">
                        <?php if ($mc->_checkListPermission($list->id, 'update')): ?>
                        <button v-on:click="saveParagraph('cta')" class="btn btn-main btn-xs btn-block pull-right"><i class="fa fa-save"></i> Save Call to Action Paragraphs</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Paragraphs PS -->
            <div role="tabpanel" class="tab-pane" id="paragraphs-ps">
                <h4>PS Paragraphs</h4>
                <div class="paragraph-list" v-if="paragraphs.ps.length">
                    <div class="row" v-for="p in paragraphs.ps" style="padding: 15px 0; border-bottom: 1px dotted lightgrey;">
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="2" v-model="p.content"></textarea>
                        </div>
                        <div class="col-sm-3 text-center">
                            <code>[paragraph-ps-{{ list.id }}-{{ p.number }}]</code>
                            <button v-on:click="removeParagraph('ps', p)" style="margin-top: 5px;" class="btn btn-default btn-xs btn-block"><i class="fa fa-minus-circle"></i> Remove</button>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <div class="alert alert-warning"><i class="fa fa-info-circle"></i> No PS paragraphs yet.</div>
                </div>
                <div class="row" style="margin-top: 15px;">
                    <div class="col-xs-3">
                        <button v-on:click="addParagraph('ps')" class="btn btn-default btn-xs btn-block"><i class="fa fa-plus-circle"></i> Add Paragraph</button>
                    </div>
                    <div class="col-xs-4 col-xs-offset-5">
                        <?php if ($mc->_checkListPermission($list->id, 'update')): ?>
                        <button v-on:click="saveParagraph('ps')" class="btn btn-main btn-xs btn-block pull-right"><i class="fa fa-save"></i> Save Call to Action Paragraphs</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Bullet Points -->
            <div role="tabpanel" class="tab-pane" id="bullet-points">
                <h4>Bullet Points</h4>
                <div class="paragraph-list" v-if="bullet_points.length">
                    <div class="row" v-for="bp in bullet_points" style="padding: 15px 0; border-bottom: 1px dotted lightgrey;">
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="2" v-model="bp.content"></textarea>
                        </div>
                        <div class="col-sm-3 text-center">
                            <code>[bullet-point-{{ list.id }}-{{ bp.number }}]</code>
                            <button v-on:click="removeBulletPoint(bp)" style="margin-top: 5px;" class="btn btn-default btn-xs btn-block"><i class="fa fa-minus-circle"></i> Remove</button>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <div class="alert alert-warning"><i class="fa fa-info-circle"></i> No bullet points yet.</div>
                </div>
                <div class="row" style="margin-top: 15px;">
                    <div class="col-xs-3">
                        <button v-on:click="addBulletPoint" class="btn btn-default btn-xs btn-block"><i class="fa fa-plus-circle"></i> Add Bullet Point</button>
                    </div>
                    <div class="col-xs-4 col-xs-offset-5">
                        <?php if ($mc->_checkListPermission($list->id, 'update')): ?>
                        <button v-on:click="saveBulletPoints" class="btn btn-main btn-xs btn-block pull-right"><i class="fa fa-save"></i> Save Bullet Points</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Testimonials -->
            <div role="tabpanel" class="tab-pane" id="testimonials">
                <h4>Testimonials</h4>
                <div class="paragraph-list" v-if="testimonials.length">
                    <div class="row" v-for="t in testimonials" style="padding: 15px 0; border-bottom: 1px dotted lightgrey;">
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="2" v-model="t.content"></textarea>
                        </div>
                        <div class="col-sm-3 text-center">
                            <code>[testimonial-{{ list.id }}-{{ t.number }}]</code>
                            <button v-on:click="removeTestimonial(t)" style="margin-top: 5px;" class="btn btn-default btn-xs btn-block"><i class="fa fa-minus-circle"></i> Remove</button>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <div class="alert alert-warning"><i class="fa fa-info-circle"></i> No testimonials yet.</div>
                </div>
                <div class="row" style="margin-top: 15px;">
                    <div class="col-xs-3">
                        <button v-on:click="addTestimonial" class="btn btn-default btn-xs btn-block"><i class="fa fa-plus-circle"></i> Add Testimonial</button>
                    </div>
                    <div class="col-xs-4 col-xs-offset-5">
                        <?php if ($mc->_checkListPermission($list->id, 'update')): ?>
                        <button v-on:click="saveTestimonials" class="btn btn-main btn-xs btn-block pull-right"><i class="fa fa-save"></i> Save Testimonials</button>
                        <?php endif; ?>
                    </div>
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

    <?php if ($list->id > 0): ?>
        data.paragraphs = <?php echo json_encode($paragraphs); ?>;
        data.bullet_points = <?php echo json_encode($bullet_points); ?>;
        data.testimonials = <?php echo json_encode($testimonials); ?>;
    <?php endif; ?>

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
                        list_category_id: data.list_category._id
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
                            action: 'save_list', 
                            list: { 
                                id : data.list.id, 
                                deleted : 1 } 
                        }, function(res) {
                            hideConfirmModal();
                            window.location = baseUrl + 'lists/category/' + data.list_category._id ;
                        }, 'json');
                    }
                });
            },
            /*
             * Paragraph Functions
             */
            saveParagraph: function(type) {
                loading('info', 'Saving paragraph...');
                $.post(actionUrl, { 
                    action: 'save_paragraphs', 
                    list_id: data.list.id, 
                    type: type, 
                    paragraphs: data.paragraphs[type]
                }, function(res) {
                    if (res.success) {
                        loading('success', 'Save successful!');
                    }
                }, 'json');
            },
            addParagraph: function(type) {
                data.paragraphs[type].push({content : ''});
                this.updateParagraphNumber(type);
            },
            removeParagraph: function(type, p) {
                var index = data.paragraphs[type].indexOf(p);
                if (index > -1) {
                    data.paragraphs[type].splice(index, 1);
                }
                this.updateParagraphNumber(type);
            },
            updateParagraphNumber: function(type) {
                for (var i = 0; i < data.paragraphs[type].length; i++) {
                    data.paragraphs[type][i].number = (i+1);
                }
            },
            /*
             * Bullet Point Functions
             */
            saveBulletPoints: function() {
                loading('info', 'Saving bullet points...');
                $.post(actionUrl, { 
                    action: 'save_bullet_points', 
                    list_id: data.list.id, 
                    bullet_points: data.bullet_points
                }, function(res) {
                    if (res.success) {
                        loading('success', 'Save successful!');
                    }
                }, 'json');
            },
            addBulletPoint: function() {
                data.bullet_points.push({content : ''});
                this.updateBulletPointNumber();
            },
            removeBulletPoint: function(bp) {
                var index = data.bullet_points.indexOf(bp);
                if (index > -1) {
                    data.bullet_points.splice(index, 1);
                }
                this.updateBulletPointNumber();
            },
            updateBulletPointNumber: function() {
                for (var i = 0; i < data.bullet_points.length; i++) {
                    data.bullet_points[i].number = (i+1);
                }
            },
            /*
             * Testimonials Functions
             */
            saveTestimonials: function() {
                loading('info', 'Saving testimonials...');
                $.post(actionUrl, { 
                    action: 'save_testimonials', 
                    list_id: data.list.id, 
                    testimonials: data.testimonials
                }, function(res) {
                    if (res.success) {
                        loading('success', 'Save successful!');
                    }
                }, 'json');
            },
            addTestimonial: function() {
                data.testimonials.push({content : ''});
                this.updateTestimonialNumber();
            },
            removeTestimonial: function(t) {
                var index = data.testimonials.indexOf(t);
                if (index > -1) {
                    data.testimonials.splice(index, 1);
                }
                this.updateTestimonialNumber();
            },
            updateTestimonialNumber: function() {
                for (var i = 0; i < data.testimonials.length; i++) {
                    data.testimonials[i].number = (i+1);
                }
            }
        }
    });

    $(function() {
        $('#sidebar-list-link').addClass('active');
        $('#' + sidebarListCategoryId).addClass('active');
        $('#sidebar-list').addClass('in');

        dt = $('table').dataTable({
            "order": [[ 2, "asc" ]],
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
                            return "<span class='text-success'>Active</span>";
                        }
                    } 
                },
                { data: "deceased_address" },
                { data: "deceased_last_name", render:
                    function(data, type, row) {
                        return row.deceased_last_name + " " + row.deceased_first_name + ", " + row.deceased_middle_name;
                    }
                },
                { data: "mail_address" },
                { data: "mail_last_name", render:
                    function(data, type, row) {
                        return row.mail_last_name + " " + row.mail_first_name;
                    }
                }
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