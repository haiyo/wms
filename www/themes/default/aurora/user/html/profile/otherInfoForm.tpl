        <div id="otherInfoForm">
        <form id="otherInfoFormData">
        <ul class="noList mainData">
          <li class="sideTitle">&nbsp;</li>
          <li class="data">
            <div style="float:left; width:193px; margin-right:10px;"><span class="title formTitle"><?LANG_FIRST_NAME?></span> <input type="text" id="fname" name="fname" value="<?TPLVAR_FNAME?>" class="textfield" style="padding:3px;" /></div>
            <div style="float:left; width:193px;"><span class="title formTitle"><?LANG_LAST_NAME?></span> <input type="text" id="lname" name="lname" value="<?TPLVAR_LNAME?>" class="textfield" style="padding:3px;" /></div>
            <div style="float:left; width:80px; margin:10px 8px 0 0;"><span class="title formTitle"><?LANG_GENDER?></span> <?TPLVAR_GENDER_LIST?></div>
            <div style="float:left; width:100px; margin:10px 8px 0 0;"><span class="title formTitle"><?LANG_MARITAL_STATUS?></span> <?TPLVAR_MARITAL_LIST?></div>

            <div style="float:left; margin-top:10px;">
              <div class="title formTitle"><?LANG_BIRTHDAY?></div>
              <div style="float:left; width:100px; margin-right:5px;"><?TPLVAR_BDAY_MONTH?></div>
              <div style="float:left; width:50px; margin-right:5px;"><?TPLVAR_BDAY_DAY?></div>
              <div style="float:left; width:35px;"><input type="text" id="bdayYear" name="bdayYear" value="<?TPLVAR_BDAY_YEAR?>" class="textfield" style="padding:3px;" /></div>
            </div>
          </li>
        </ul>

        <ul class="noList mainData">
          <li class="sideTitle">&nbsp;</li>
          <li class="data">
            <div class="buttons leftButton"><button type="submit" class="cancel" id="cancelOtherInfo"><?LANG_CANCEL?></button></div>
            <div class="buttons leftButton"><button type="submit" class="" id="saveOtherInfo"><?LANG_SAVE?></button></div>
          </li>
        </ul>
        </form>
        </div>