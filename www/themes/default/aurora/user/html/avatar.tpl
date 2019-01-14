      <div id="avatarList<?TPLVAR_ID?>" class="avatar <?TPLVAR_CLASS?>">
        <!-- BEGIN DYNAMIC BLOCK: defaultAvatar -->
        <img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/user/img/<?TPLVAR_THEME?>/<?TPLVAR_IMAGE?>" id="avatar<?TPLVAR_USERID?>" class="avatarImg" border="0" alt="<?TPLVAR_NAME?>" title="<?TPLVAR_NAME?>" <?TPLVAR_SIZE?> />
        <!-- END DYNAMIC BLOCK: defaultAvatar -->
        <!-- BEGIN DYNAMIC BLOCK: customAvatar -->
        <img src="<?TPLVAR_ROOT_URL?><?TPLVAR_IMAGE?>" id="avatar<?TPLVAR_USERID?>" class="avatarImg" border="0" alt="<?TPLVAR_NAME?>" title="<?TPLVAR_NAME?>" <?TPLVAR_SIZE?> />
        <!-- END DYNAMIC BLOCK: customAvatar -->
      </div>