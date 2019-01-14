    <div id="auroraBFLoginForm" class="config">
          <ul class="noList configList">
              <li class="columnDescript"><div class="formTitle"><?LANG_ENABLE_BF?></div>
              <span class="formDesc"><?LANG_ENABLE_BF_DESC?></span></li>
              <li class="formField formRadio"><?TPLVAR_ENABLE_BF?></li>
          </ul>
        
          <div style="float:left; border:1px solid #ff7200; background-color:#fffbf0; width:100%; margin-bottom:20px;">
            <div style="padding:5px;"><?LANG_BF_TIPS?></div>
          </div>

          <fieldset>
          <legend>Configure Protection Policy</legend>
          <ul class="noList configList">
              <li class="columnDescript" style="width:270px;"><div class="formTitle"><?LANG_SEND_EMAIL?></div>
              <span class="formDesc"><?LANG_SEND_EMAIL_DESC?></span></li>
              <li class="formField formRadio"><?TPLVAR_BF_ALERT?></li>
              
              <li class="columnDescript" style="width:280px;"><div class="formTitle"><?LANG_BF_NUM_OF_FAILED?></div>
              <span class="formDesc"><?LANG_BF_NUM_OF_FAILED_DESC?></span></li>
              <li class="formField"><?TPLVAR_BF_NUM_FAILED?></li>

              <li class="columnDescript" style="width:280px;"><div class="formTitle"><?LANG_ENFORCE_ACTION?></div>
              <span class="formDesc"><?LANG_ENFORCE_ACTION_DESC?></span></li>
              <li class="formField"><?TPLVAR_BF_ACTION?></li>
          </ul>
          </fieldset>
      </div>