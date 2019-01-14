        <div id="eduAnchor" class="titleBar title"><?LANG_EDUCATION?>
          <a href="education" class="addButton addSchool"><img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/core/img/<?TPLVAR_THEME?>/addIco.png" border="0" class="alignMiddle" /> <?LANG_ADD_A_SCHOOL?></a>
        </div>

        <div id="eduForm" style="float:left;"></div>

        <div id="eduSection">
        <ul id="eduUnSpecified" class="noList mainData">
          <li class="sideTitle">&nbsp;</li>
          <li class="workData">
            <div class="unspecified"><?LANG_NOT_SPECIFIED?></div>
          </li>
        </ul>

        <?TPL_EDUCATION_LIST?>
        </div>