        <div id="additionalForm">
        <form id="additionalFormData">
        <ul class="noList mainData">
          <li class="sideTitle">&nbsp;</li>
          <li class="data">
            <textarea id="notes" name="notes" rows="5" class="textfield"><?TPLVAR_NOTES?></textarea>
          </li>
        </ul>

        <ul class="noList mainData">
          <li class="sideTitle">&nbsp;</li>
          <li class="data">
            <div class="title formTitle"><?LANG_WEBSITE?></div>
            <input type="text" id="website" name="website" value="<?TPLVAR_WEBSITE?>" class="textfield" style="padding:3px;" />
          </li>
        </ul>

        <ul class="noList mainData">
          <li class="sideTitle">&nbsp;</li>
          <li class="data">
            <div class="buttons leftButton"><button type="submit" class="cancel" id="cancelAdditional"><?LANG_CANCEL?></button></div>
            <div class="buttons leftButton"><button type="submit" class="" id="saveAdditional"><?LANG_SAVE?></button></div>
          </li>
        </ul>
        </form>
        </div>