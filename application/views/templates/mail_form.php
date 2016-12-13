<div id="app">
    <h2><?php echo isset($mail_template) ? 'Edit Mail Template' : 'Create Mail Template'; ?></h2>
    <ol class="breadcrumb">
        <li><a>Templates</a></li>
        <li><a href="<?php echo base_url() . 'templates/mail'; ?>">Mail Templates</a></li>
        <li><a class="active"><?php echo isset($mail_template) ? 'Edit Mail Template' : 'Create Mail Template'; ?></a></li>
    </ol>

    <div class="row">
        <div class="col-sm-12 panel-white">
            
        </div>
    </div>
</div>

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

    });
</script>