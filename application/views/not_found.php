<div id="app">
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 text-center" style="padding-top: 20px;">
            <h1 class="text-center logo">Direct Mail</h1>
            <br />
            <img src="<?php echo base_url() . 'resources/images/icon/browser.png'?>" class="img img-responsive center" width="200" />
            <p class="lead">
                Page not found!
            </p>
            <?php if (isset($logged_user)): ?>
            <a href="<?php echo base_url() . 'dashboard'?>">Return to Dashboard</a>
            <?php else: ?>
            <a href="<?php echo base_url() . 'login'?>">Return to Login</a>
            <?php endif; ?>
        </div>
    </div>
</div>