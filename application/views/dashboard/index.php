<div id="app">
    <div class="row">
        <div class="col-sm-12">
        <br />
            Welcome back, <?php echo $logged_user->first_name . ' ' . $logged_user->last_name; ?>!
        </div>
    </div>
</div>

<script>
    $(function() {
        $('#sidebar-dashboard-link').addClass('active');
    });
</script>
