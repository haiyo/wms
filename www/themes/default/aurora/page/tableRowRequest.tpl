<tr id="group-<?TPLVAR_ID?>" class="active">
    <td colspan="3"><?LANG_ROW_GROUP?></td>
</tr>
<!-- BEGIN DYNAMIC BLOCK: list -->
<tr id="list-<?TPLVAR_ID?>" class="pendingList">
    <td style="width:25%">
        <div class="col-md-12">
            <div class="col-md-3 pl-0 pr-0" style="width:40px">
                <img src="http://localhost/wms/www/mars/user/photo/860ef6cb5f062bbea780dfbc99e4f316//3bf8e741d8688c5573d2854efaf9f62a.png" width="40"
                     height="40" style="padding:0;" class="rounded-circle">
            </div>
            <div class="col-md-9 pr-0">
                <span class="typeahead-name"><?TPLVAR_FNAME?> <?TPLVAR_LNAME?></span>
                <div class="text-muted text-size-small"><?TPLVAR_TIME_AGO?></div>
            </div>
        </div>
    </td>
    <td>
        <a href="#" class="text-default display-inline-block">
            <span class="text-semibold"><?TPLVAR_TITLE?></span>
            <span class="display-block text-muted"><?TPLVAR_DESCRIPTION?></span>
        </a>
    </td>
    <td class="text-center" style="width:80px">
        <ul class="icons-list">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="#"><i class="icon-undo"></i> Quick reply</a></li>
                    <li><a href="#"><i class="icon-history"></i> Full history</a></li>
                    <li class="divider"></li>
                    <li><a href="#" data-id="<?TPLVAR_ID?>" class="<?TPLVAR_CLASS?> approve"><i class="icon-checkmark3 text-success"></i> Approve</a></li>
                    <li><a href="#" data-id="<?TPLVAR_ID?>" class="<?TPLVAR_CLASS?> disapprove"><i class="icon-cross2 text-danger"></i> Disapprove</a></li>
                </ul>
            </li>
        </ul>
    </td>
</tr>
<!-- END DYNAMIC BLOCK: list -->