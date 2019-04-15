,<div id="taxRow_<?TPLVAR_TRID?>" class="header-elements-inline taxRow" data-parent="<?TPLVAR_GID?>">
    <div class="list-group-item" data-toggle="collapse">
        <span><?TPLVAR_RULE_TITLE?></span><br />
        <!-- BEGIN DYNAMIC BLOCK: criteria -->
        <span class="badge badge-primary badge-criteria"><?TPLVAR_CRITERIA?></span>
        <!-- END DYNAMIC BLOCK: criteria -->
        <span class="badge badge-<?TPLVAR_BADGE?> applyAs"><?TPLVAR_APPLY_AS?></span>
    </div>
    <div class="header-elements">
        <div class="list-icons tax-icons">
            <a data-id="<?TPLVAR_TRID?>" class="list-icons-item" data-toggle="modal" data-target="#modalTaxRule"><i class="icon-pencil5"></i></a>
            <a data-id="<?TPLVAR_TRID?>" class="list-icons-item"><i class="icon-bin"></i></a>
        </div>
    </div>
</div>