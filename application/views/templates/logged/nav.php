<div class="panel-group sidebar-nav" role="tablist" aria-multiselectable="true">
    <a class="sidebar-brand" href="<?php echo base_url() . 'dashboard'; ?>">
        Direct Mail
    </a>
    <?php foreach ($modules as $m): ?>
    <?php if ($sb_module_permissions[$m->id]->retrieve_action): ?>
    <div class="panel panel-sidebar" id="panel-sidebar">
        <?php if (sizeof($m->children) > 0 || $m->code == "list") { ?>
        <a role="button" data-toggle="collapse" data-parent="#panel-sidebar" href="#sidebar-<?php echo $m->code; ?>" aria-expanded="true" aria-controls="sidebar-<?php echo $m->code; ?>">
        <?php } else { ?>
        <a href="<?php echo base_url() . $m->link; ?>">
        <?php } ?>
            <div class="panel-heading" role="tab" id="sidebar-<?php echo $m->code; ?>-link">
                <h4 class="panel-title">
                    <?php echo $m->icon; ?> <?php echo $m->name; ?>
                    <?php if (sizeof($m->children) > 0 || $m->code == "list"): ?>
                        <i class="fa fa-angle-down pull-right"></i>
                    <?php endif; ?>
                </h4>
            </div>
        </a>
        <?php if (sizeof($m->children) > 0 || $m->code == "list"): ?>
        <div id="sidebar-<?php echo $m->code; ?>" class="panel-collapse collapse" role="tabpanel">
            <div class="panel-body">
                <?php if ($m->code == "list"): ?>
                    <?php foreach ($sb_list_category_permissions as $lcp): ?>
                        <?php if ($lcp->retrieve_action == 1): ?>
                            <a id="sidebar-list-category-<?php echo $lcp->id; ?>-link" href="<?php echo base_url() . 'lists/category/' . $lcp->id;?>"><?php echo $lcp->name; ?></a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php foreach ($m->children as $child): ?>
                        <?php if ($sb_module_permissions[$child->id]->retrieve_action): ?>
                        <a id="sidebar-<?php echo $child->code; ?>-link" href="<?php echo base_url() . $child->link; ?>"><?php echo $child->name; ?></a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <?php endforeach; ?>
</div>