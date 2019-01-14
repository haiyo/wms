        <div id="contactWrapper">
          <div class="titleBar title"><?LANG_CONTACT_INFORMATION?>
            <a href="contact" class="editButton editContact"><img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/core/img/<?TPLVAR_THEME?>/editIco.png" border="0" class="alignMiddle" alt="<?LANG_EDIT?>" title="<?LANG_EDIT?>" /></a>
          </div>

          <div id="contactSection">
            <div id="contactData">
            <ul class="noList mainData">
              <li class="sideTitle">(<?LANG_PRIMARY?>)</li>
              <li class="data"><a href="mailto:<?TPLVAR_EMAIL?>"><?TPLVAR_EMAIL?></a></li>
            </ul>
            <!-- BEGIN DYNAMIC BLOCK: other_email -->
            <ul class="noList mainData">
              <li class="sideTitle">(<?TPLVAR_EMAIL_TYPE?>)</li>
              <li class="data"><a href="mailto:<?TPLVAR_EMAIL?>"><?TPLVAR_EMAIL?></a></li>
            </ul>
            <!-- END DYNAMIC BLOCK: other_email -->
            <div style="float:left; width:100%; height:10px;"></div>
            <!-- BEGIN DYNAMIC BLOCK: phone -->
            <ul class="noList mainData">
              <li class="sideTitle">(<?TPLVAR_PHONE_TYPE?>)</li>
              <li class="data"><?TPLVAR_PHONE?></li>
            </ul>
            <!-- END DYNAMIC BLOCK: phone -->
            <!-- BEGIN DYNAMIC BLOCK: other_phone -->
            <ul class="noList mainData">
              <li class="sideTitle">(<?TPLVAR_PHONE_TYPE?>)</li>
              <li class="data"><?TPLVAR_PHONE?></li>
            </ul>
            <!-- END DYNAMIC BLOCK: other_phone -->
            </div>
          </div>
        </div>