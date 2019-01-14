        <div id="eduForm<?TPLVAR_EDU_ID?>">
        <form id="eduFormData<?TPLVAR_EDU_ID?>" class="formWrapper">
        <ul class="noList mainData">
          <li class="sideTitle">
            <div class="sideDateWrapper">
              <div class="fromDaySelector"><span class="title formTitle"><?LANG_FROM?></span><?TPLVAR_FROM_DAY?></div>
              <div class="fromMonthSelector"><span class="title formTitle"><?LANG_MONTH?></span><?TPLVAR_FROM_MONTH?></div>
              <div class="fromYearSelector"><span class="title formTitle"><?LANG_YEAR?></span> <input type="text" id="fromEduYear_<?TPLVAR_EDU_ID?>" name="fromEduYear_<?TPLVAR_EDU_ID?>" value="<?TPLVAR_FROM_YEAR?>" class="textfield" style="padding:3px;" /></div>

              <div class="toDaySelector"><span class="title formTitle"><?LANG_TO?></span><?TPLVAR_TO_DAY?></div>
              <div class="toMonthSelector"><span class="title formTitle"><?LANG_MONTH?></span><?TPLVAR_TO_MONTH?></div>
              <div class="toYearSelector"><span class="title formTitle"><?LANG_YEAR?></span> <input type="text" id="toEduYear_<?TPLVAR_EDU_ID?>" name="toEduYear_<?TPLVAR_EDU_ID?>" value="<?TPLVAR_TO_YEAR?>" class="textfield" style="padding:3px;" /></div>
            </div>
          </li>
          <li class="data">
            <div class="titleInput"><span class="title formTitle"><?LANG_COLLEGE?></span> <input type="text" id="eduCollege_<?TPLVAR_EDU_ID?>" name="eduCollege_<?TPLVAR_EDU_ID?>" value="<?TPLVAR_COLLEGE?>" class="textfield collegeFocus" style="padding:3px;" /></div>
            <div class="descriptInput"><span class="title formTitle"><?LANG_CONCENTRATIONS?></span> <input type="text" id="eduConcentrations_<?TPLVAR_EDU_ID?>" name="eduConcentrations_<?TPLVAR_EDU_ID?>" value="<?TPLVAR_CONCENTRATIONS?>" class="textfield" style="padding:3px;" /></div>
            <div class="descriptInput"><span class="title formTitle"><?LANG_DESCRIPTION?></span> <textarea id="eduDescript_<?TPLVAR_EDU_ID?>" name="eduDescript_<?TPLVAR_EDU_ID?>" rows="5" class="textfield"><?TPLVAR_DESCRIPTION?></textarea></div>
          </li>
        </ul>

        <ul class="noList mainData">
          <li class="sideTitle">&nbsp;</li>
          <li class="data">
            <div class="buttons leftButton"><button type="submit" value="<?TPLVAR_EDU_ID?>" id="cancelEduButton_<?TPLVAR_EDU_ID?>" class="cancel cancelEduButton"><?LANG_CANCEL?></button></div>
            <div class="buttons leftButton"><button type="submit" value="<?TPLVAR_EDU_ID?>" id="saveEduButton_<?TPLVAR_EDU_ID?>" class="saveEduButton"><?LANG_SAVE?></button></div>
          </li>
        </ul>
        <input type="hidden" id="eduID_<?TPLVAR_EDU_ID?>" name="eduID_<?TPLVAR_EDU_ID?>" value="<?TPLVAR_EDU_ID?>" />
        </form>
        <div class="hr"></div>
        </div>