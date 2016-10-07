<div id="app">
    <div class="row">
        <div class="col-sm-4 col-sm-offset-4" style="padding-top: 20px;">
            <h1 class="logo">Direct Mail</h1>
            <br />
            <div class="notice"><?php echo $this->session->flashdata('message'); ?></div>
            <form action="<?php echo base_url() . 'page/login'?>" method="post" class="well">
                <div class="form-group">
                    <label for="email">* Client</label>
                    <input name="client" type="text" class="form-control input-lg" required
                           title="Please enter your client id." />
                </div>
                <div class="form-group">
                    <label for="email">* Email Address</label>
                    <input name="email" type="email" class="form-control input-lg" required
                           pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$"
                           title="Please enter your valid email address." />
                </div>
                <div class="form-group">
                    <label for="password">* Password</label>
                    <input id="password" name="password" type="password" class="form-control input-lg" required />
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-main btn-lg btn-block" style="margin-top: 10px;">Log in</button>
                </div>
            </form>
            <div class="text-center">
                <a href="#">Forgot Password</a>
            </div>
        </div>
    </div>
</div>