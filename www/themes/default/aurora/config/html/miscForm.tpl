        <div id="auroraMiscForm" class="config">
          <ul class="noList configList">
              <li class="columnDescript"><div class="formTitle"><?LANG_THEME?></div>
              <span class="formDesc"><?LANG_THEME_DESC?></span></li>
              <li class="formField"><?TPLVAR_THEME_LIST?></li>

              <li class="columnDescript"><div class="formTitle"><?LANG_DISPLAY_LOGO?></div>
              <span class="formDesc"><?LANG_DISPLAY_LOGO_DESC?></span></li>
              <li class="formField formRadio"><?TPLVAR_DISPLAY_LOGO?></li>

              <li class="columnDescript"><div class="formTitle"><?LANG_GRAPHIC?></div>
              <span class="formDesc"><?LANG_GRAPHIC_DESC?></span></li>
              <li class="formField"><?TPLVAR_IMGLIB_LIST?></li>
          </ul>
          <!-- BEGIN DYNAMIC BLOCK: iMagickDetected -->
          <div style="float:left; border:1px solid #ff7200; background-color:#fffbf0; width:98%; margin-bottom:15px;">
            <div style="padding:5px;"><?LANG_DETECT_IMAGICK?></div>
          </div>
          <!-- END DYNAMIC BLOCK: iMagickDetected -->
          <ul class="noList configList">
              <li class="columnDescript"><div class="formTitle"><?LANG_TIME_ZONE?></div>
              <span class="formDesc"><?LANG_TIME_ZONE_DESC?></span></li>
              <li class="formField"><?TPLVAR_ZONE_LIST?></li>

              <li class="columnDescript"><div class="formTitle"><?LANG_DEFAULT_LANGUAGE?></div>
              <span class="formDesc"><?LANG_DEFAULT_LANGUAGE_DESC?></span></li>
              <li class="formField"><?TPLVAR_LANG_LIST?></li>

              <li class="columnDescript"><div class="formTitle"><?LANG_REGION_DATE?></div>
              <span class="formDesc"><?LANG_REGION_DATE_DESC?></span></li>
              <li class="formField"><?TPLVAR_DATE_FORMAT?></li>

              <li class="columnDescript"><div class="formTitle"><?LANG_REGION_TIME?></div>
              <span class="formDesc"><?LANG_REGION_TIME_DESC?></span></li>
              <li class="formField"><?TPLVAR_TIME_FORMAT?></li>

              <li class="columnDescript"><div class="formTitle"><?LANG_CURRENCY?></div>
              <span class="formDesc"><?LANG_CURRENCY_DESC?></span></li>
              <li class="formField"><input type="text" name="currency" id="currency" class="textfield" value="<?TPLVAR_CURRENCY?>" /></li>
          </ul>
      </div>