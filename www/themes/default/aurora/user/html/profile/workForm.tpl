        <div id="workForm<?TPLVAR_WORK_ID?>">
        <form id="workFormData<?TPLVAR_WORK_ID?>" class="formWrapper">
        <ul class="noList mainData">
          <li class="sideTitle">
            <div class="sideDateWrapper">
              <div class="currentCheck"><?TPLVAR_CURRENT?></div>

              <div class="fromDaySelector"><span class="title formTitle"><?LANG_FROM?></span><?TPLVAR_FROM_DAY?></div>
              <div class="fromMonthSelector"><span class="title formTitle"><?LANG_MONTH?></span><?TPLVAR_FROM_MONTH?></div>
              <div class="fromYearSelector"><span class="title formTitle"><?LANG_YEAR?></span> <input type="text" id="fromWorkYear_<?TPLVAR_WORK_ID?>" name="fromWorkYear_<?TPLVAR_WORK_ID?>" value="<?TPLVAR_FROM_YEAR?>" class="textfield" style="padding:3px;" /></div>

              <div id="toWorkDate_<?TPLVAR_WORK_ID?>" style="display:<?TPLVAR_DATE_DISPLAY?>">
                <div class="toDaySelector"><span class="title formTitle"><?LANG_TO?></span><?TPLVAR_TO_DAY?></div>
                <div class="toMonthSelector"><span class="title formTitle"><?LANG_MONTH?></span><?TPLVAR_TO_MONTH?></div>
                <div class="toYearSelector"><span class="title formTitle"><?LANG_YEAR?></span> <input type="text" id="toWorkYear_<?TPLVAR_WORK_ID?>" name="toWorkYear_<?TPLVAR_WORK_ID?>" value="<?TPLVAR_TO_YEAR?>" class="textfield" style="padding:3px;" /></div>
              </div>
            </div>
          </li>
          <li class="data">
            <div class="titleInput"><span class="title formTitle"><?LANG_COMPANY?></span> <input type="text" id="workCompany_<?TPLVAR_WORK_ID?>" name="workCompany_<?TPLVAR_WORK_ID?>" value="<?TPLVAR_COMPANY?>" class="textfield companyFocus" style="padding:3px;" /></div>
            <div class="descriptInput"><span class="title formTitle"><?LANG_POSITION?></span> <input type="text" id="workPosition_<?TPLVAR_WORK_ID?>" name="workPosition_<?TPLVAR_WORK_ID?>" value="<?TPLVAR_POSITION?>" class="textfield" style="padding:3px;" /></div>
            <div class="descriptInput"><span class="title formTitle"><?LANG_DESCRIPTION?></span> <textarea id="workDescript_<?TPLVAR_WORK_ID?>" name="workDescript_<?TPLVAR_WORK_ID?>" rows="5" class="textfield"><?TPLVAR_DESCRIPTION?></textarea></div>
          </li>
        </ul>

        <ul class="noList mainData">
          <li class="sideTitle">&nbsp;</li>
          <li class="data">
            <div class="buttons leftButton"><button type="submit" value="<?TPLVAR_WORK_ID?>" id="cancelWorkButton_<?TPLVAR_WORK_ID?>" class="cancel cancelWorkButton"><?LANG_CANCEL?></button></div>
            <div class="buttons leftButton"><button type="submit" value="<?TPLVAR_WORK_ID?>" id="saveWorkButton_<?TPLVAR_WORK_ID?>" class="saveWorkButton"><?LANG_SAVE?></button></div>
          </li>
        </ul>
        <input type="hidden" id="workID_<?TPLVAR_WORK_ID?>" name="workID_<?TPLVAR_WORK_ID?>" value="<?TPLVAR_WORK_ID?>" />
        </form>
        <div class="hr"></div>
        </div>