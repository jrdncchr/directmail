<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo $title; ?></title>
<meta name="description" content="<?php echo $description; ?>">
<meta name="author" content="<?php echo $author; ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSS Styles -->
<link rel="stylesheet" href="<?php echo base_url() . 'bower_components/bootstrap/dist/css/bootstrap.min.css'; ?>" />
<link rel="stylesheet" href="<?php echo base_url() . 'bower_components/font-awesome/css/font-awesome.min.css'; ?>" />
<link rel="stylesheet" href="<?php echo base_url() . 'bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css'; ?>" />
<link rel="stylesheet" href="<?php echo base_url() . 'bower_components/toastr/toastr.min.css'; ?>" />
<link rel="stylesheet" href="<?php echo base_url() . 'resources/css/custom-bootstrap.css'; ?>" />
<link rel="stylesheet" href="<?php echo base_url() . 'resources/css/custom.css'; ?>" />

<!-- Scripts -->
<script src="<?php echo base_url() . 'bower_components/jquery/dist/jquery.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'bower_components/datatables.net/js/jquery.dataTables.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'bower_components/vue/dist/vue.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'bower_components/bootstrap/dist/js/bootstrap.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'bower_components/toastr/toastr.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'resources/js/danero-validator.js'; ?>"></script>
<script src="<?php echo base_url() . 'resources/js/danero.js'; ?>"></script>
<script>
    var baseUrl = "<?php echo base_url(); ?>";
</script>

<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<style>
    body {
        background-color: white;
    }
</style>

<script>
    $(document).ajaxStart(function() {
        $('button').attr('disabled', 'disabled');
    });
    $(document).ajaxStop(function() {
        $('button').removeAttr('disabled');
    });
</script>