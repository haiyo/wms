        <div id="otherInfoWrapper">
          <div id="otherInfoAnchor" class="titleBar title"><?LANG_MAIN_PERSONAL_INFO?>
            <a href="otherInfo" class="editButton editOtherInfo"><img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/core/img/<?TPLVAR_THEME?>/editIco.png" border="0" class="alignMiddle" alt="<?LANG_EDIT?>" title="<?LANG_EDIT?>" /></a>
          </div>

          <div id="otherInfoSection">
            <div id="otherInfoData">
            <ul class="noList mainData">
              <li class="sideTitle"><?LANG_DISPLAY_NAME?></li>
              <li class="data"><?TPLVAR_FNAME?> <?TPLVAR_LNAME?></li>
            </ul>

            <!-- BEGIN DYNAMIC BLOCK: birthday -->
            <ul class="noList mainData">
              <li class="sideTitle"><?LANG_BIRTHDAY?></li>
              <li class="data"><?TPLVAR_BDAY?></li>
            </ul>
            <!-- END DYNAMIC BLOCK: birthday -->

            <ul class="noList mainData">
              <li class="sideTitle"><?LANG_GENDER?></li>
              <li class="data"><?TPLVAR_GENDER?></li>
            </ul>

            <!-- BEGIN DYNAMIC BLOCK: marital -->
            <ul class="noList mainData">
              <li class="sideTitle"><?LANG_MARITAL_STATUS?></li>
              <li class="data"><?TPLVAR_MARITAL?></li>
            </ul>
            <!-- END DYNAMIC BLOCK: marital -->
            </div>
          </div>
        </div>