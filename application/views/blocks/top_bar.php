<div id="top-bar">
	<span><?php echo $page_title; ?></span>
	
	<div class="btn-group pull-right">
	    <button type="button" class="btn dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	        <?php echo $logged_user->first_name . ' ' . $logged_user->last_name; ?> <span class="caret"></span>
	    </button>
	    <ul class="dropdown-menu">
	        <li><a href="<?php echo base_url() . 'logout'; ?>">Logout</a></li>
	    </ul>
	</div>
</div>