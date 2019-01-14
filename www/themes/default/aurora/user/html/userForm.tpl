<form id="form">
  <div style="padding:20px;">
    <div class="sideLink">
      <div id="avatarWrapper">
        <div class="avatarTxt"><?LANG_CLICK_TO_UPLOAD?></div>
        <div class="progressBarWrapper">
          <div class="progressBar">
            <div class="bar" style="width:0%; height:5px; background-color:#99bb00;"></div>
          </div>
        </div>
        <div style="z-index:1;" class="avatarCancel"><img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/form/img/<?TPLVAR_THEME?>/delete.gif" width="16" height="16" border="0" /></div>
        <div style="z-index:2;"><input type="file" name="fileInput" id="fileInput" accept="image/*" tabindex="99" /></div>
        <img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/user/img/<?TPLVAR_THEME?>/male_medium.png" id="formAvatar" border="0" />
      </div>
      <div class="leftNav"><a href="fname" class="nav"><?LANG_PERSONAL_INFORMATION?></a></div>
      <div class="leftNav"><a href="company" class="nav"><?LANG_OTHER_INFORMATION?></a></div>
      <div class="leftNav"><a href="password" class="nav"><?LANG_SECURITY_ACCESS?></a></div>
      <div class="leftNav"><a href="notes" class="nav"><?LANG_ADDITIONAL_NOTES?></a></div>
      <div id="removeAvatarLink" class="leftNav" style="display:none;"><a href="removeAvatar" id="removeAvatar"><?LANG_REMOVE_PHOTO?></a></div>
    </div>
    <div class="wrapper">
      <input type="hidden" id="userID" name="userID" value="0" />
      <input type="hidden" id="image" name="image" value="" />
      <input type="hidden" id="medium_pic" name="image" value="" />
      <span id="firstTitle" class="title textFade" title="<?TPLVAR_TITLE?>"><?TPLVAR_TITLE?></span>
      <span id="lastTitle" class="title"></span>
      <span id="ageTitle" class="title age"></span>
      <div class="form" id="fnameForm">
      <ul class="noList">
        <li class="first"><?LANG_FIRST_NAME?>:<span class="require">*</span> <input type="text" id="fname" name="fname" class="textfield focus" /></li>
        <li><?LANG_LAST_NAME?>:<span class="require">*</span><input type="text" id="lname" name="lname" class="textfield focus" /></li>


        <li class="first"><?LANG_PRIMARY_EMAIL?>:<span class="require">*</span><input type="text" id="email" name="email" class="textfield focus" /></li>

        <li><div><?LANG_DATE_OF_BIRTH?>:</div>
          <div style="float:left; width:150px; margin-right:5px;"><?TPLVAR_DOB_MONTH?></div>
          <div style="float:left; width:50px; margin-right:5px;"><?TPLVAR_DOB_DAY?></div>
          <div style="float:left; width:75px;"><input type="text" id="dobYear" name="dobYear" class="textfield" style="padding:3px;" /></div>
        </li>
        <li class="first"><div><?LANG_PRIMARY_PHONE?>:</div>
          <div style="float:left; width:85px; margin-right:5px;"><?TPLVAR_PHONE_TYPE?></div>
          <div style="float:left; width:195px; margin-right:5px;"><input type="text" id="phone" name="phone" class="textfield" /></div>
        </li>
        <li><?LANG_GENDER?>:<?TPLVAR_GENDER_LIST?></li>
        <li class="first"><div><?LANG_JOIN_DATE?>:</div>
          <div style="float:left; width:150px; margin-right:5px;"><?TPLVAR_JOIN_MONTH?></div>
          <div style="float:left; width:50px; margin-right:5px;"><?TPLVAR_JOIN_DAY?></div>
          <div style="float:left; width:70px;"><input type="text" id="joinYear" name="joinYear" value="<?TPLVAR_JOIN_YEAR?>" class="textfield" style="padding:3px;" /></div></li>
        <li><?LANG_ACCOUNT_STATUS?>:<?TPLVAR_STATUS_LIST?></li>
      </ul>
      </div>
      <div class="form" id="companyForm" style="display:none;">
      <ul class="noList">
        <li class="first"><?LANG_COMPANY?>:<input type="text" id="company" name="company" class="textfield" value="<?TPLVAR_WEB_NAME?>" /></li>
        <li><?LANG_JOB_TITLE?>:<input type="text" id="jobTitle" name="jobTitle" class="textfield" /></li>
        <li class="first"><?LANG_STREET_ADDRESS?>:<input type="text" id="address" name="address" class="textfield" /></li>
        <li><?LANG_COUNTRY?>:<?TPLVAR_COUNTRY_LIST?></li>
        <li class="first"><?LANG_ZIP_CODE?>:<input type="text" id="postal" name="postal" class="textfield" /></li>
        <li><?LANG_CITY?>:<input type="text" id="city" name="city" class="textfield" /></li>
        <li class="first"><?LANG_STATE_PROVINCE?>:<input type="text" id="state" name="state" class="textfield" /></li>
        <li><?LANG_MARITAL_STATUS?>:<?TPLVAR_MARITAL_LIST?></li>
      </ul>
      </div>
      <div class="form" id="passwordForm" style="display:none;">
        <ul class="noList">
          <li class="first"><?LANG_PASSWORD?>:<input type="password" id="password" name="password" class="textfield focus" />
            <div style="margin-top:5px;"><input type="checkbox" id="emailPwd" name="emailPwd" value="1" class="alignMiddle" /> <label for="emailPwd"><?LANG_EMAIL_RANDOM_PASSWORD?></label></div></li>
          <li><?LANG_CONFIRMATION_PASSWORD?>:<input type="password" id="cpassword" name="cpassword" class="textfield focus" /></li>
        </ul>
        <div style="float:left;"><?LANG_ASSIGN_ROLES?>:<?TPLVAR_ROLE_LIST?></div>
        <div id="setDefaultRole">
          <div id="defRoleTitle"><?LANG_DEFAULT_ROLE?>:</div>
          <div id="defRoleList"><div id="none" class="defRole"><?LANG_NONE?></div></div>
          <input type="hidden" id="defaultRole" value="" />
        </div>
      </div>
      <div class="form" id="notesForm" style="display:none;">
        <?LANG_NOTES?>: <textarea rows="12" id="notes" name="notes" class="textfield"></textarea>
      </div>
      <div class="formButtons">
        <div style="float:left; margin-left:35%; margin-right:6px;" class="buttons"><button type="submit" class="delete" id="formCancel"><?LANG_CANCEL?></button></div>
        <div style="float:left;" class="buttons"><button type="submit" class="" id="save"><?LANG_SAVE?></button></div>
      </div>
    </div>
  </div>
  </form>