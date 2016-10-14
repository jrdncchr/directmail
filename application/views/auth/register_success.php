<div id="app">
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 text-center" style="padding-top: 20px;">
            <h1 class="text-center logo">Direct Mail</h1>
            <br />
            <img src="<?php echo base_url() . 'resources/images/icon/handshake.png'?>" class="img img-responsive center" width="200" />
            <p class="lead">
                You have successfully registered with company <span class="bold"><?php echo $company->name; ?></span>.
                Please confirm your email and wait for your account to be activated by your company.
            </p>
            <a href="<?php echo base_url() . 'login'?>">Return to Login</a>
        </div>
    </div>
</div>