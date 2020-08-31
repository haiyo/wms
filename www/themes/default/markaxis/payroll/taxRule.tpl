<div id="taxRow_<?TPLVAR_TRID?>" class="header-elements-inline taxRow" data-parent="<?TPLVAR_GID?>">
    <div class="list-group-item" data-toggle="collapse">
        <span id="taxRuleTitle_<?TPLVAR_TRID?>"><?TPLVAR_RULE_TITLE?></span><br />
        <!-- BEGIN DYNAMIC BLOCK: criteria -->
        <span class="badge badge-primary badge-criteria"><?TPLVAR_CRITERIA?></span>
        <!-- END DYNAMIC BLOCK: criteria -->
        <span class="badge badge-<?TPLVAR_BADGE?> applyAs"><?TPLVAR_APPLY_AS?></span>
    </div>
    <div class="header-elements">
        <div class="list-icons tax-icons">
            <a data-id="<?TPLVAR_TRID?>" class="list-icons-item" data-toggle="modal" data-target="#modalTaxRule"
               data-backdrop="static" data-keyboard="false"><i class="icon-pencil5"></i></a>
            <a data-id="<?TPLVAR_TRID?>" class="list-icons-item deleteTaxRule"><i class="icon-bin"></i></a>
        </div>
    </div>
</div>