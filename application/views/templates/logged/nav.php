<div class="panel-group sidebar-nav" role="tablist" aria-multiselectable="true">
    <a class="sidebar-brand" href="<?php echo base_url() . 'dashboard'; ?>">
        Direct Mail
    </a>
    <?php foreach ($modules as $m): ?>
    <div class="panel panel-sidebar" id="panel-sidebar">
        <?php if (sizeof($m->children) > 0) { ?>
        <a role="button" data-toggle="collapse" data-parent="#panel-sidebar" href="#sidebar-<?php echo $m->code; ?>" aria-expanded="true" aria-controls="sidebar-<?php echo $m->code; ?>">
        <?php } else { ?>
        <a href="<?php echo base_url() . $m->link; ?>">
        <?php } ?>
            <div class="panel-heading" role="tab" id="sidebar-<?php echo $m->code; ?>-link">
                <h4 class="panel-title">
                    <?php echo $m->icon; ?> <?php echo $m->name; ?>
                    <?php if (sizeof($m->children) > 0): ?>
                        <i class="fa fa-angle-down pull-right"></i>
                    <?php endif; ?>
                </h4>
            </div>
        </a>
        <?php if (sizeof($m->children) > 0): ?>
        <div id="sidebar-<?php echo $m->code; ?>" class="panel-collapse collapse" role="tabpanel">
            <div class="panel-body">
                <?php foreach ($m->children as $child): ?>
                    <a id="sidebar-<?php echo $child->code; ?>-link" href="<?php echo base_url() . $child->link; ?>"><?php echo $child->name; ?></a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>