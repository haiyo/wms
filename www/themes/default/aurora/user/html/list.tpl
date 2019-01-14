    <li id="user<?TPLVAR_USERID?>" class="<?TPLVAR_ONLINE?>">
      <div class="column avatar">
        <div class="smAvatar"><a href="<?TPLVAR_ROOT_URL?>admin/profile/<?TPLVAR_USERID?>" class="viewInfo userprofile"><?TPL_AVATAR?></a></div>
        <div class="status <?TPLVAR_ISONLINE?>" align="center"><?TPLVAR_ONLINE?></div>
      </div>
      <div class="column" style="width:165px;">
        <span class="name"><a href="<?TPLVAR_USERID?>" class="viewInfo"><?TPLVAR_NAME?></a></span>
        <!-- BEGIN DYNAMIC BLOCK: jobTitle -->
        <div class="row"><a href="<?TPLVAR_USERID?>" class="viewOther"><?TPLVAR_JOB_TITLE?></a></div>
        <!-- END DYNAMIC BLOCK: jobTitle -->
        <div class="row"><?TPLVAR_EMAIL?></div>
        <div class="row"><a href="<?TPLVAR_USERID?>" class="viewRoles" title="<?TPLVAR_ROLE_TITLE?>"><?TPLVAR_ROLES?></a></div>
      </div>

      <div class="label"><a href="<?TPLVAR_USERID?>" class="viewInfo">More</a></div>
      <div class="checkbox checkbox<?TPLVAR_ONLINE?>"><input type="checkbox" name="user[]" class="userCheckbox" value="<?TPLVAR_USERID?>" /></div>
    </li>