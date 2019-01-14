    <div id="user<?TPLVAR_USERID?>" class="userList">
      <div class="column avatar">
        <div class="smAvatar"><a href="<?TPLVAR_USERID?>" class="viewInfo"><?TPL_AVATAR?></a></div>
        <div class="status <?TPLVAR_ISONLINE?>" align="center"><?TPLVAR_ONLINE?></div>
      </div>
      <div class="column personalInfo">
        <span class="name"><a href="<?TPLVAR_USERID?>" class="viewInfo"><?TPLVAR_NAME?></a></span>
        <!-- BEGIN DYNAMIC BLOCK: jobTitle -->
        <div class="row"><a href="<?TPLVAR_USERID?>" class="viewOther"><?TPLVAR_JOB_TITLE?></a></div>
        <!-- END DYNAMIC BLOCK: jobTitle -->
        <div class="row"><?TPLVAR_EMAIL?></div>
        <div class="row"><a href="<?TPLVAR_USERID?>" class="viewRoles" title="<?TPLVAR_ROLE_TITLE?>"><?TPLVAR_ROLES?></a></div>
      </div>

      <div class="contactWrapper">
        <div class="column contactInfo">
          <div class="contactType">(Work)</div>
          <div class="contactNumber">(+65) 6698 6304</div>
        </div>
        <div class="column contactInfo">
          <div class="contactType">(Mobile)</div>
          <div class="contactNumber">(+65) 9655 5640</div>
        </div>
        <div class="column contactInfo">
          <div class="contactType"></div>
          <div class="contactNumber"><a href="">More Contacts...</a></div>
        </div>
      </div>
        
      <div class="requestType"><a href="<?TPLVAR_USERID?>" id="userID<?TPLVAR_USERID?>" class="<?TPLVAR_CONNECT_TYPE?>"><?LANG_CONNECT?></a></div>
    </div>