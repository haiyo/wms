<div id="group_<?TPLVAR_GID?>">
    <div class="header-elements-inline">
        <div href="#item-<?TPLVAR_GID?>" class="list-group-item" data-toggle="collapse">
            <i class="glyphicon glyphicon-chevron-down" id="expandIcon_<?TPLVAR_GID?>"></i>
            <span id="groupTitle_<?TPLVAR_GID?>" class="title"><?TPLVAR_GROUP_TITLE?></span>
            <div id="groupDescription_<?TPLVAR_GID?>" class="description text-muted"><?TPLVAR_DESCRIPTION?></div>
        </div>
        <div class="header-elements">
            <div class="list-icons tax-icons">
                <a data-id="<?TPLVAR_GID?>" class="list-icons-item" data-toggle="modal" data-target="#modalTaxGroup"><i class="icon-pencil5"></i></a>
                <a data-id="<?TPLVAR_GID?>" class="list-icons-item"><i class="icon-bin"></i></a>
            </div>
        </div>
    </div>

    <div id="item-<?TPLVAR_GID?>" class="list-group collapse show">
        <?TPL_GROUP_CHILD?>
    </div>

</div>