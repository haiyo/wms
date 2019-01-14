        <div id="contactForm">
        <form id="contactFormData">
        <ul class="noList mainData">
          <li class="sideTitle"><div style="margin-top:8px;"><?LANG_PRIMARY_EMAIL?></div></li>
          <li class="data"><input type="text" id="email" name="email" class="textfield" value="<?TPLVAR_EMAIL?>" /></li>
        </ul>

        <div id="other_email_section">
        <!-- BEGIN DYNAMIC BLOCK: other_email -->
        <ul class="noList mainData other_email other_email_<?TPLVAR_INDEX?>">
          <li class="sideTitle"><div class="typeList"><?TPLVAR_EMAIL_TYPE?></div></li>
          <li class="data">
            <div class="contactInput"><input type="text" id="other_email" name="other_email[]" class="textfield" value="<?TPLVAR_EMAIL?>" placeholder="<?LANG_ENTER_EMAIL_ADDRESS?>" /></div>
            <div style="float:left; margin:7px 0 0 7px;"><a href="other_email_<?TPLVAR_INDEX?>" class="removeType"><img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/form/img/<?TPLVAR_THEME?>/delete.gif" border="0" class="alignMiddle trash" alt="<?LANG_REMOVE?>" title="<?LANG_REMOVE?>" /></a></div>
          </li>
        </ul>
        <!-- END DYNAMIC BLOCK: other_email -->
        </div>

        <ul class="noList mainData">
          <li class="sideTitle">&nbsp;</li>
          <li class="data textSmallUpper">&nbsp;&nbsp;<a href="" id="addEmail"><?LANG_ADD_EMAIL?></a></li>
        </ul>

        <div id="other_phone_section">

        <ul class="noList mainData phone phone_<?TPLVAR_INDEX?>">
          <li class="sideTitle"><div class="typeList"><?TPLVAR_PHONE_TYPE?></div></li>
          <li class="data">
            <div class="contactInput"><input type="text" id="phone" name="phone" class="textfield" value="<?TPLVAR_PHONE?>" placeholder="<?LANG_ENTER_PHONE_NUMBER?>" /></div>
          </li>
        </ul>

        <!-- BEGIN DYNAMIC BLOCK: other_phone -->
        <ul class="noList mainData phone other_phone_<?TPLVAR_INDEX?>">
          <li class="sideTitle"><div class="typeList"><?TPLVAR_PHONE_TYPE?></div></li>
          <li class="data">
            <div class="contactInput"><input type="text" id="other_phone" name="other_phone[]" class="textfield" value="<?TPLVAR_PHONE?>" placeholder="<?LANG_ENTER_PHONE_NUMBER?>" /></div>
            <div style="float:left; margin:7px 0 0 7px;"><a href="other_phone_<?TPLVAR_INDEX?>" class="removeType"><img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/form/img/<?TPLVAR_THEME?>/delete.gif" border="0" class="alignMiddle trash" alt="<?LANG_REMOVE?>" title="<?LANG_REMOVE?>" /></a></div>
          </li>
        </ul>
        <!-- END DYNAMIC BLOCK: other_phone -->
        </div>

        <ul class="noList mainData">
          <li class="sideTitle">&nbsp;</li>
          <li class="data textSmallUpper">&nbsp;&nbsp;<a href="" id="addPhone"><?LANG_ADD_PHONE?></a></li>
        </ul>

        <ul class="noList mainData">
          <li class="sideTitle">&nbsp;</li>
          <li class="data">
            <div class="buttons" style="float:left;"><button type="submit" class="cancel" id="cancelContact"><?LANG_CANCEL?></button></div>
            <div class="buttons" style="float:left;"><button type="submit" class="" id="saveContact"><?LANG_SAVE?></button></div>
          </li>
        </ul>
        </form>
        <div style="display:none;" class="phoneType"><?TPLVAR_PHONE_TYPE?></div>
        <div style="display:none;" class="emailType"><?TPLVAR_EMAIL_TYPE?></div>
        </div>