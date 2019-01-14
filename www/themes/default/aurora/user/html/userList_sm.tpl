     <div id="userList<?TPLVAR_USERID?>" class="userList">
        <div class="column smavatar">
          <div id="avatar<?TPLVAR_USERID?>" class="smAvatar"><?TPL_AVATAR?></div>
          <!--<div class="status <?TPLVAR_ISONLINE?>" align="center"><?TPLVAR_ONLINE?></div>-->
        </div>
        <div id="personInfo<?TPLVAR_USERID?>" class="column personalInfo">
          <div id="name<?TPLVAR_USERID?>" class="row name"><a href="<?TPLVAR_ROOT_URL?>admin/profile/<?TPLVAR_USERID?>" class="userprofile <?TPLVAR_PROFILE_CARD?>"><?TPLVAR_NAME?></a></div>
          <!-- BEGIN DYNAMIC BLOCK: jobTitle -->
          <div id="jobTitle<?TPLVAR_USERID?>" class="row jobTitle"><?TPLVAR_JOB_TITLE?></div>
          <!-- END DYNAMIC BLOCK: jobTitle -->
        </div>
      </div>