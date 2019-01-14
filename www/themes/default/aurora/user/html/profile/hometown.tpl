        <div id="hometownWrapper">
          <div id="hometownAnchor" class="titleBar title"><?LANG_HOMETOWN?>
            <a href="hometown" class="editButton editHometown"><img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/core/img/<?TPLVAR_THEME?>/editIco.png" border="0" class="alignMiddle" alt="<?LANG_EDIT?>" title="<?LANG_EDIT?>" /></a>
          </div>

          <div id="hometownSection">
            <div id="hometownData">
            <ul class="noList mainData">
              <li class="sideTitle"><?LANG_ADDRESS?>:</li>
              <!-- BEGIN DYNAMIC BLOCK: address -->
              <li class="data"><?TPLVAR_ADDRESS?> <?TPLVAR_STATE?> <?TPLVAR_CITY?> <?TPLVAR_POSTAL?></li>
              <!-- END DYNAMIC BLOCK: address -->
              <!-- BEGIN DYNAMIC BLOCK: no_address -->
              <li class="data unspecified"><?LANG_NOT_SPECIFIED?></li>
              <!-- END DYNAMIC BLOCK: no_address -->
            </ul>
            <ul class="noList mainData">
              <li class="sideTitle"><?LANG_COUNTRY?>:</li>
              
              <!-- BEGIN DYNAMIC BLOCK: no_country -->
              <li class="data unspecified"><?LANG_NOT_SPECIFIED?></li>
              <!-- END DYNAMIC BLOCK: no_country -->
              <!-- BEGIN DYNAMIC BLOCK: country -->
              <li class="data"><?TPLVAR_COUNTRY?></li>
              <!-- END DYNAMIC BLOCK: country -->
            </ul>
            </div>
          </div>
        </div>