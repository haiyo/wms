        <div id="work<?TPLVAR_WORK_ID?>Anchor" style="float:left; margin:10px 0 10px 0;">
        <ul id="work<?TPLVAR_WORK_ID?>" class="noList mainData work">
          <li class="sideTitle"><?TPLVAR_DATE_FROM?> <?LANG_TO_DATE?> <?TPLVAR_DATE_TO?></li>
          <li class="workData">
            <div id="workTitle<?TPLVAR_WORK_ID?>" class="workTitle"><?TPLVAR_COMPANY?></div>
            <!-- BEGIN DYNAMIC BLOCK: position -->
            <div class="workPosition"><?TPLVAR_POSITION?></div>
            <!-- END DYNAMIC BLOCK: position -->
            <!-- BEGIN DYNAMIC BLOCK: description -->
            <div id="workDescript<?TPLVAR_WORK_ID?>" class="description"><?TPLVAR_DESCRIPTION?></div>
            <!-- END DYNAMIC BLOCK: description -->
          </li>
          <li class="editWork"><a href="<?TPLVAR_WORK_ID?>" class="editButton editWork"><img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/core/img/<?TPLVAR_THEME?>/editIco.png" border="0" class="alignMiddle" alt="<?LANG_EDIT?>" title="<?LANG_EDIT?>" /></a></li>
          <li class="deleteWork"><a href="<?TPLVAR_WORK_ID?>" class="deleteWork"><img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/form/img/<?TPLVAR_THEME?>/delete.gif" border="0" class="alignMiddle trash" alt="<?LANG_REMOVE?>" title="<?LANG_REMOVE?>" /></a></li>
        </ul>
        </div>