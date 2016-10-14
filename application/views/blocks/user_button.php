<div class="btn-group pull-right" style="margin-top: 20px;">
    <button type="button" class="btn dropdown-toggle btn-main btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php echo $user->first_name . ' ' . $user->last_name; ?> <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li><a href="<?php echo base_url() . 'logout'; ?>">Logout</a></li>
    </ul>
</div>