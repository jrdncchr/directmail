<div id="app">
    <h2><?php echo $list->name;?></h2>
    <ol class="breadcrumb">
        <li><a>Templates</a></li>
        <li><a class="active"><?php echo $list->name; ?></a></li>
    </ol>

    <div class="row" style="margin-top: 20px;">
        <div class="col-sm-12">
        <!-- Nav tabs -->
          <ul class="nav nav-tabs nav-justified" role="tablist">
            <li role="presentation" class="dropdown active"> 
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

            <!-- Paragraphs Intro -->
            <div role="tabpanel" class="tab-pane active" id="paragraphs-intro">
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
</div>

<script>
    var dt;
    var actionUrl = "<?php echo base_url() . 'templates/info'; ?>";

    $(function() {
        $('#sidebar-templates-link').addClass('active');
        $('#' + sidebarTemplatesCategoryId).addClass('active');
        $('#sidebar-templates').addClass('in');
    });

    var data = {
        list : <?php echo json_encode($list); ?>
    };
    data.paragraphs = <?php echo json_encode($paragraphs); ?>;
    data.bullet_points = <?php echo json_encode($bullet_points); ?>;
    data.testimonials = <?php echo json_encode($testimonials); ?>;

    var vm = new Vue({
        el: "#app",
        data: data,
        methods: {
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

</script>