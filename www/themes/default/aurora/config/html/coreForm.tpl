
        <div id="auroraCoreForm" class="config">
          <ul class="noList configList">
              <li class="columnDescript"><div class="formTitle"><?LANG_SYS_MAINTENANCE?></div>
              <span class="formDesc"><?LANG_SYS_MAINTENANCE_DESC?></span></li>
              <li class="formField formRadio"><?TPLVAR_MAINTENANCE?></li>

              <li class="columnDescript"><div class="formTitle"><?LANG_COMPANY_NAME?></div>
              <span class="formDesc"><?LANG_COMPANY_NAME_DESC?></span></li>
              <li class="formField"><input type="text" name="websiteName" id="websiteName" class="textfield" value="<?TPLVAR_WEBSITE_NAME?>" /></li>

              <li class="columnDescript"><div class="formTitle"><?LANG_COMPANY_ADDRESS?></div>
              <span class="formDesc"><?LANG_COMPANY_ADDRESS_DESC?></span></li>
              <li class="formField"><textarea rows="3" name="companyAddress" id="companyAddress" class="textfield"><?TPLVAR_COMPANY_ADDRESS?></textarea></li>

              <li class="columnDescript"><div class="formTitle"><?LANG_COMPANY_WEBSITE?></div>
              <span class="formDesc"><?LANG_COMPANY_WEBSITE_DESC?></span></li>
              <li class="formField"><input type="text" name="companyWebsite" id="companyWebsite" class="textfield" value="<?TPLVAR_COMPANY_WEBSITE?>" /></li>

              <li class="columnDescript"><div class="formTitle"><?LANG_COMPANY_PHONE?></div>
              <span class="formDesc"><?LANG_COMPANY_PHONE_DESC?></span></li>
              <li class="formField"><input type="text" name="companyPhone" id="companyPhone" class="textfield" value="<?TPLVAR_COMPANY_PHONE?>" /></li>

              <li class="columnDescript"><div class="formTitle"><?LANG_COMPANY_FAX?></div>
              <span class="formDesc"><?LANG_COMPANY_FAX_DESC?></span></li>
              <li class="formField"><input type="text" name="companyFax" id="companyFax" class="textfield" value="<?TPLVAR_COMPANY_FAX?>" /></li>

              <li class="columnDescript"><div class="formTitle"><?LANG_URL_PROTOCOL?></div>
              <span class="formDesc"><?LANG_URL_PROTOCOL_DESC?></span></li>
              <li class="formField"><?TPLVAR_PROTOCOL?></li>

              <li class="columnDescript"><div class="formTitle"><?LANG_DOMAIN_URL?></div>
              <span class="formDesc"><?LANG_DOMAIN_URL_DESC?></span></li>
              <li class="formField"><input type="text" name="domain" id="domain" class="textfield" value="<?TPLVAR_DOMAIN?>" /></li>

              <li class="columnDescript"><div class="formTitle"><?LANG_COOKIE_PATH?></div>
              <span class="formDesc"><?LANG_COOKIE_PATH_DESC?></span></li>
              <li class="formField"><input type="text" name="cookiePath" id="cookiePath" class="textfield" value="<?TPLVAR_COOKIE_PATH?>" /></li>

              <li class="columnDescript"><div class="formTitle"><?LANG_COOKIE_DOMAIN?></div>
              <span class="formDesc"><?LANG_COOKIE_DOMAIN_DESC?></span></li>
              <li class="formField"><input type="text" name="cookieDomain" id="cookieDomain" class="textfield" value="<?TPLVAR_COOKIE_DOMAIN?>" /></li>

              <li class="columnDescript"><div class="formTitle"><?LANG_MAIL_FROM_NAME?></div>
              <span class="formDesc"><?LANG_MAIL_FROM_NAME_DESC?></span></li>
              <li class="formField"><input type="text" name="mailFromName" id="mailFromName" class="textfield" value="<?TPLVAR_MAIL_FROM_NAME?>" /></li>

              <li class="columnDescript"><div class="formTitle"><?LANG_MAIL_FROM_EMAIL?></div>
              <span class="formDesc"><?LANG_MAIL_FROM_EMAIL_DESC?></span></li>
              <li class="formField"><input type="text" name="mailFromEmail" id="mailFromEmail" class="textfield" value="<?TPLVAR_MAIL_FROM_EMAIL?>" /></li>

              <li class="columnDescript"><div class="formTitle"><?LANG_SMTP_EMAIL?></div>
              <span class="formDesc"><?LANG_SMTP_EMAIL_DESC?></span></li>
              <li class="formField formRadio"><?TPLVAR_ENABLE_SMTP?></li>
          </ul>
          
          <div style="float:left;" id="auroraSMTPAnchor"></div>
          <fieldset id="auroraSMTPForm" style="display:<?TPLVAR_SMTP_SHOW?>;">
          <legend><?LANG_SMTP_CONFIG?></legend>
          <ul class="noList configList">
              <li class="columnDescript smtpDesc"><div class="formTitle"><?LANG_SMTP_ADDRESS?></div>
              <span class="formDesc"><?LANG_SMTP_ADDRESS_DESC?></span></li>
              <li class="formField"><input type="text" name="smtpAddress" id="smtpAddress" class="textfield" value="<?TPLVAR_SMTP_ADDRESS?>" /></li>

              <li class="columnDescript smtpDesc"><div class="formTitle"><?LANG_SMTP_SERVER_PORT?></div>
              <span class="formDesc"><?LANG_SMTP_SERVER_PORT_DESC?></span></li>
              <li class="formField"><input type="text" name="smtpPort" id="smtpPort" class="textfield" value="<?TPLVAR_SMTP_PORT?>" /></li>

              <li class="columnDescript smtpDesc"><div class="formTitle"><?LANG_SMTP_CONNECTION?></div>
              <span class="formDesc"><?LANG_SMTP_CONNECTION_DESC?></span></li>
              <li class="formField"><?TPLVAR_SMTP_CONNECT?></li>

              <li class="columnDescript smtpDesc"><div class="formTitle"><?LANG_SMTP_USERNAME?></div>
              <span class="formDesc"><?LANG_SMTP_USERNAME_DESC?></span></li>
              <li class="formField"><input type="text" name="smtpUsername" id="smtpUsername" class="textfield" value="<?TPLVAR_SMTP_USERNAME?>" /></li>

              <li class="columnDescript smtpDesc"><div class="formTitle"><?LANG_SMTP_PASSWORD?></div>
              <span class="formDesc"><?LANG_SMTP_PASSWORD_DESC?></span></li>
              <li class="formField"><input type="password" name="smtpPassword" id="smtpPassword" class="textfield" value="<?TPLVAR_SMTP_PASSWORD?>" />
              <input type="hidden" name="smtpPwdSet" id="smtpPwdSet" class="textfield" value="<?TPLVAR_SMTP_PWD_SET?>" /></li>
              
              <li class="columnDescript smtpDesc"><div class="formTitle"><?LANG_SMTP_SEND_TEST?></div>
              <span class="formDesc"><?LANG_SMTP_SEND_TEST_DESC?></span></li>
              <li class="formField" style="padding:10px 0 0 10px;"><a href="<?TPLVAR_ROOT_URL?>admin/smtp/test" id="smtpTest"><?LANG_LAUNCH_TEST?></a></li>
          </ul>
          </fieldset>

          <ul class="noList configList">
              <li class="columnDescript" style="margin-bottom:25px;"><div class="formTitle"><?LANG_WEBMASTER_EMAIL?></div>
              <span class="formDesc"><?LANG_WEBMASTER_EMAIL_DESC?></span></li>
              <li class="formField"><textarea name="webmaster" id="webmaster" rows="3" class="textfield"><?TPLVAR_WEBMASTER?></textarea></li>
          </ul>
      </div>