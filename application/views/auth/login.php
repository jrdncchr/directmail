<div id="app">
    <div class="row">
        <div class="col-sm-4 col-sm-offset-4" style="padding-top: 50px;">
            <h1 class="logo" style="margin-bottom: 50px;">Direct Mail</h1>
            <div class="notice"><?php echo $this->session->flashdata('message'); ?></div>
            <form action="<?php echo base_url() . 'auth/login'?>" method="post" class="well">
                <div class="form-group">
                    <label for="email">* Company</label>
                    <input name="company" type="text" class="form-control" required
                           title="Please enter your company key." />
                </div>
                <div class="form-group">
                    <label for="email">* Email Address</label>
                    <input name="email" type="email" class="form-control" required
                           pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$"
                           title="Please enter your valid email address." />
                </div>
                <div class="form-group">
                    <label for="password">* Password</label>
                    <input id="password" name="password" type="password" class="form-control" required />
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-main btn-sm btn-block" style="margin-top: 10px;">Log in</button>
                </div>
            </form>
            <div class="text-center">
                <a href="#">Forgot Password</a>
            </div>
        </div>
    </div>
</div>