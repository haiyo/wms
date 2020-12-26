<tr id="group-<?TPLVAR_GROUP_NAME?>" class="active">
    <td colspan="4"><?LANG_PENDING_ROW_GROUP?></td>
</tr>
<!-- BEGIN DYNAMIC BLOCK: list -->
<tr id="list-<?TPLVAR_ID?>" class="pendingList">
    <td>
        <div class="col-md-12">
            <div class="col-md-3 pl-0 pr-0" style="width:40px">
                <img src="<?TPLVAR_PHOTO?>" width="40"
                     height="40" style="padding:0;" class="rounded-circle">
            </div>
            <div class="col-md-9 pr-0 pending-text">
                <span class="typeahead-name"><?TPLVAR_FNAME?> <?TPLVAR_LNAME?></span>
                <div class="text-muted text-size-small"><?TPLVAR_TIME_AGO?></div>
            </div>
        </div>
    </td>
    <td>
        <span class="text-semibold"><?TPLVAR_TITLE?></span>
        <div class="display-block text-muted text-ellipsis"><?TPLVAR_ATTACHMENT?></div>
        <span class="display-block text-muted"><?TPLVAR_DESCRIPTION?></span>
    </td>
    <td style="width:15%">
        <span class="text-semibold"><?TPLVAR_VALUE?></span>
    </td>
    <td class="text-center" style="width:80px">
        <ul class="icons-list">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="#" data-id="<?TPLVAR_ID?>" class="<?TPLVAR_CLASS?> approve"><i class="icon-checkmark3 text-success"></i> Approve</a></li>
                    <li><a href="#" data-id="<?TPLVAR_ID?>" class="<?TPLVAR_CLASS?> disapprove"><i class="icon-cross2 text-danger"></i> Disapprove</a></li>
                </ul>
            </li>
        </ul>
    </td>
</tr>
<!-- END DYNAMIC BLOCK: list -->