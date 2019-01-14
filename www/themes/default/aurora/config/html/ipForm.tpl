    <div id="auroraIPListForm" class="config">
        <ul class="noList configList">
          <li class="columnDescript"><div class="formTitle"><?LANG_ENABLE_IP?></div>
          <span class="formDesc"><?LANG_ENABLE_IP_DESC?></span></li>
          <li class="formField formRadio"><?TPLVAR_ENABLE_IP?></li>
        </ul>

        <fieldset style="margin-bottom:10px;">
          <legend><?LANG_CONFIG_RESTRICT_POLICY?></legend>
          <ul class="noList configList">
            <li class="columnDescript" style="width:270px;"><div class="formTitle"><?LANG_SEND_EMAIL?></div>
              <span class="formDesc"><?LANG_SEND_EMAIL_DESC?></span></li>
              <li class="formField formRadio"><?TPLVAR_IP_ALERT?></li>
              
            <li class="columnDescript" style="width:270px;"><div class="formTitle"><?LANG_RESTRICT_COUNTRY?></div>
              <span class="formDesc"><?LANG_RESTRICT_COUNTRY_DESC?></span></li>
             <li class="formField" style="margin-top:0px;"><?TPLVAR_COUNTRY_LIST?></li>
          </ul>
          <div style="float:left; margin-top:10px;">
            <div class="formTitle"><?LANG_RESTRICT_IP?></div>
            
            <div style="float:left; margin:5px 0 8px 0; border:1px solid #ff7200; background-color:#fffbf0; width:100%;">
            <div class="formDesc" style="padding:5px;"><?LANG_RESTRICT_IP_DESC?></div>
            </div>

            <div class="formDesc" style="margin-bottom:3px;"><?LANG_FOR_EXAMPLE?>:</div>
            <?LANG_IP_EXAMPLES?>
            <ul class="noList" style="margin-top:15px;">
              <li style="width:245px;"><strong><?LANG_WHITE_LIST?>:</strong><br />
                <span class="formDesc"><?LANG_ENTER_PER_LINE?></span>
                <textarea name="ipWhiteList" id="ipWhiteList" rows="7" class="textfield"></textarea></li>
              <li style="width:10px;">&nbsp;</li>
              <li style="width:245px;"><strong><?LANG_BLACK_LIST?>:</strong><br />
                <span class="formDesc"><?LANG_ENTER_PER_LINE?></span>
                <textarea name="ipBlackList" id="ipBlackList" rows="7" class="textfield"></textarea></li>
            </ul>
          </div>
        </fieldset>
      </div>