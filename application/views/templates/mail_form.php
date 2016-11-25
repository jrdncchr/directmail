<div id="app">
    <h2><?php echo isset($mail_template) ? 'Edit Mail Template' : 'Create Mail Template'; ?></h2>
    <ol class="breadcrumb">
        <li><a>Templates</a></li>
        <li><a href="<?php echo base_url() . 'templates/mail'; ?>">Mail Templates</a></li>
        <li><a class="active"><?php echo isset($mail_template) ? 'Edit Mail Template' : 'Create Mail Template'; ?></a></li>
    </ol>

    <div class="row">
        <div class="col-sm-12 panel-white">
            <button class="btn btn-xs btn-main" style="margin-bottom: 10px;" v-on:click="saveMailTemplate"><i class="fa fa-save"></i> Save Mail Template</button>
            <?php if (isset($mail_template)): ?>
            <button class="btn btn-xs" style="margin-bottom: 10px;" v-on:click="deleteMailTemplate"><i class="fa fa-trash-o"></i> Delete Mail Template</button>
            <?php endif; ?>
            <div id="mail-template-form" style="margin-top: 10px;">
            	<div class="notice"></div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="name">* Name</label>
                        <input name="name" type="text" class="form-control" required
                               title="Mail Template Name" v-model="mail_template.name" />
                    </div>
                </div>
                <div class="col-sm-12">
                	<div class="form-group">
                        <label for="template">* Template</label>
                        <textarea name="editor1" id="editor1" rows="10" cols="80" v-model="mail_template.content">
		                    Loading editor please wait...
		                </textarea>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<script src="//cdn.ckeditor.com/4.6.0/full/ckeditor.js"></script>
<script>
    var actionUrl = "<?php echo base_url() . 'templates/mail'; ?>";

    var data = {
        mail_template: {
        	name: '',
        	content: ''
        }
    };

    var vm = new Vue({
        el: "#app",
        data: data,
        methods: {
            saveMailTemplate: function() {
                var content = CKEDITOR.instances.editor1.getData();
                data.mail_template.content = content;
                $.post(actionUrl, {action: 'save_mail_template', mail_template: data.mail_template}, function(res) {
                	console.log(res);
                }, 'json');
            }
        }
    });

    $(function() {
        $('#sidebar-templates-link').addClass('active');
        $('#sidebar-templates-mail-templates').addClass('active');
        $('#sidebar-templates').addClass('in');

        CKEDITOR.replace('editor1', {
            // http://docs.ckeditor.com/#!/api/CKEDITOR.config
            // http://ckeditor.com/latest/samples/toolbarconfigurator/index.html#advanced
            height: 500
        });
        

    });
</script>