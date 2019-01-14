        <div id="additionalWrapper" style="float:left; margin-bottom:10px;">
          <div id="additionalAnchor" class="titleBar title"><?LANG_ADDITIONAL_NOTES?>
            <a href="additional" class="editButton editAdditional"><img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/core/img/<?TPLVAR_THEME?>/editIco.png" border="0" class="alignMiddle" alt="<?LANG_EDIT?>" title="<?LANG_EDIT?>" /></a>
          </div>

          <div id="additionalSection">
            <div id="additionalData">
            <ul class="noList mainData">
              <li class="sideTitle"><?LANG_NOTES?></li>
              <!-- BEGIN DYNAMIC BLOCK: no_notes -->
              <li class="data unspecified"><?LANG_NOT_SPECIFIED?></li>
              <!-- END DYNAMIC BLOCK: no_notes -->
              <li class="data" style="margin-bottom:10px;"><?TPLVAR_NOTES?></li>
            </ul>

            <!-- BEGIN DYNAMIC BLOCK: website -->
            <ul class="noList mainData">
              <li class="sideTitle"><?LANG_WEBSITE?></li>
              <li class="data"><a href="<?TPLVAR_WEBSITE?>" target="_blank"><?TPLVAR_WEBSITE?></a></li>
            </ul>
            <!-- END DYNAMIC BLOCK: website -->
            </div>
          </div>
        </div>