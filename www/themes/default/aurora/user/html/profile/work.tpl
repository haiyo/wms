        <div class="titleBar title"><?LANG_WORK_EXPERIENCE?>
          <a href="work" class="addButton addWork"><img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/core/img/<?TPLVAR_THEME?>/addIco.png" border="0" class="alignMiddle" /> <?LANG_ADD_A_JOB?></a>
        </div>

        <div id="workForm"></div>

        <div id="workSection">
        <ul id="workUnSpecified" class="noList mainData">
          <li class="sideTitle">&nbsp;</li>
          <li class="workData">
            <div class="unspecified"><?LANG_NOT_SPECIFIED?></div>
          </li>
        </ul>

        <?TPL_WORK_LIST?>

        </div>