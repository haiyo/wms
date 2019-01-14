        <div id="edu<?TPLVAR_EDU_ID?>Anchor" style="float:left; margin:10px 0 10px 0;">
        <ul id="edu<?TPLVAR_EDU_ID?>" class="noList mainData education">
          <li class="sideTitle"><?TPLVAR_DATE_FROM?>
          <!-- BEGIN DYNAMIC BLOCK: todate -->
          <?LANG_TO_DATE?>
          <!-- END DYNAMIC BLOCK: todate -->
          <?TPLVAR_DATE_TO?></li>
          <li class="workData">
            <div id="eduTitle<?TPLVAR_EDU_ID?>" class="workTitle"><?TPLVAR_COLLEGE?></div>
            <!-- BEGIN DYNAMIC BLOCK: concentrations -->
            <div class="workPosition"><?TPLVAR_CONCENTRATIONS?></div>
            <!-- END DYNAMIC BLOCK: concentrations -->
            <!-- BEGIN DYNAMIC BLOCK: description -->
            <div id="workDescript<?TPLVAR_EDU_ID?>" class="description"><?TPLVAR_DESCRIPTION?></div>
            <!-- END DYNAMIC BLOCK: description -->
          </li>
          <li class="editWork"><a href="<?TPLVAR_EDU_ID?>" class="editButton editEdu"><img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/core/img/<?TPLVAR_THEME?>/editIco.png" border="0" class="alignMiddle" alt="<?LANG_EDIT?>" title="<?LANG_EDIT?>" /></a></li>
          <li class="deleteWork"><a href="<?TPLVAR_EDU_ID?>" class="deleteEdu"><img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/form/img/<?TPLVAR_THEME?>/delete.gif" border="0" class="alignMiddle trash" alt="<?LANG_REMOVE?>" title="<?LANG_REMOVE?>" /></a></li>
        </ul>
        </div>