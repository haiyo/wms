    <div id="auroraUsageForm" class="config">
      <ul class="noList configList">
          <li class="columnDescript"><div class="formTitle"><?LANG_AUTO_TIMEOUT?></div>
          <span class="formDesc"><?LANG_AUTO_TIMEOUT_DESC?></span></li>
          <li class="formField"><?TPLVAR_SESS_TIMEOUT?></li>
      </ul>

      <ul class="noList configList">
          <li class="columnDescript"><div class="formTitle"><?LANG_STRONG_PASSWORD?></div>
          <span class="formDesc"><?LANG_STRONG_PASSWORD_DESC?></span></li>
          <li class="formField formRadio"><?TPLVAR_STRONG_PASSWORD?></li>

          <li class="columnDescript"><div class="formTitle"><?LANG_ENABLE_FORGOT_PASSWORD?></div>
          <span class="formDesc"><?LANG_ENABLE_FORGOT_PASSWORD_DESC?></span></li>
          <li class="formField formRadio"><?TPLVAR_FORGOT_PASSWORD?></li>

          <li class="columnDescript"><div class="formTitle"><?LANG_PASSWORD_EXPIRY?></div>
          <span class="formDesc"><?LANG_PASSWORD_EXPIRY_DESC?></span></li>
          <li class="formField"><div style="float:left;" id="pwdExpiryEmailAnchor"></div>
              <?TPLVAR_PASSWORD_EXPIRY?>
              <div style="margin-top:15px;"><?TPLVAR_PWD_EMAIL?></div>
          </li>
      </ul>


      <ul class="noList configList" id="pwdExpiryEmailMsg" style="display:none;">
          <li class="columnDescript"><div class="formTitle"><?LANG_EXPIRY_PWD_MSG?></div>
          <span class="formDesc"><?LANG_EXPIRY_PWD_MSG_DESC?></span></li>
          <li class="formField"><textarea name="customPwdMsg" id="pwdExpiryEmailField" rows="3" class="textfield" value=""></textarea></li>
      </ul>

      <ul class="noList configList">
          <li class="columnDescript"><div class="formTitle"><?LANG_INACTIVE_EXPIRY?></div>
          <span class="formDesc"><?LANG_INACTIVE_EXPIRY_DESC?></span></li>
          <li class="formField"><div style="float:left;" id="inactiveExpiryEmailAnchor"></div>
              <?TPLVAR_INACTIVE_EXPIRY?>
              <div style="margin-top:15px;"><?TPLVAR_INACTIVE_EMAIL?></div>
          </li>
      </ul>

      <ul class="noList configList" id="inactiveExpiryEmailMsg" style="display:none;">
          <li class="columnDescript"><div class="formTitle"><?LANG_INACTIVE_MSG?></div>
          <span class="formDesc"><?LANG_INACTIVE_MSG_DESC?></span></li>
          <li class="formField"><textarea name="customInactiveMsg" id="inactiveExpiryEmailField" rows="3" class="textfield" value=""></textarea></li>
      </ul>
    </div>