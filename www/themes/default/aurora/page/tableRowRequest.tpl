<tr id="group-<?TPLVAR_GROUP_NAME?>" class="active">
    <td colspan="5"><?LANG_PENDING_ROW_GROUP?></td>
</tr>
<!-- BEGIN DYNAMIC BLOCK: list -->
<tr id="list-<?TPLVAR_ID?>" class="requestList">
    <td>
        <span class="text-semibold"><?TPLVAR_TITLE?></span>
        <div class="display-block text-muted text-ellipsis"><?TPLVAR_ATTACHMENT?></div>
        <span class="display-block text-muted"><?TPLVAR_DESCRIPTION?></span>
        <div class="text-muted text-size-small"><?TPLVAR_TIME_AGO?></div>
    </td>
    <td style="width:15%" class="text-center">
        <span class="label label-<?TPLVAR_LABEL?>"><?LANG_STATUS?></span>
    </td>
    <td style="width:15%">
        <span class="text-semibold">
            <?TPLVAR_MANAGER?>
        </span>
    </td>
    <td style="width:15%" class="text-center">
        <span class="text-semibold"><?TPLVAR_VALUE?></span>
    </td>
    <td class="text-center" style="width:80px">
        <ul class="icons-list">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="#" data-id="<?TPLVAR_ID?>" class="<?TPLVAR_CLASS?>"><i class="icon-cross2"></i> Cancel Apply</a></li>
                </ul>
            </li>
        </ul>
    </td>
</tr>
<!-- END DYNAMIC BLOCK: list -->