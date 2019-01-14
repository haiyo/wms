        <div id="hometownForm">
        <form id="hometownFormData">
        <ul class="noList mainData">
          <li class="sideTitle">&nbsp;</li>
          <li class="data">
            <span class="title formTitle"><?LANG_ADDRESS?></span> <input type="text" id="address" name="address" class="textfield" value="<?TPLVAR_ADDRESS?>" />
            <div style="float:left; width:50px; margin:10px 12px 0 0;"><span class="title formTitle"><?LANG_STATE?></span> <input type="text" id="state" name="state" class="textfield" value="<?TPLVAR_STATE?>" /></div>
            <div style="float:left; width:50px; margin:10px 12px 0 0;"><span class="title formTitle"><?LANG_CITY?></span> <input type="text" id="city" name="city" class="textfield" value="<?TPLVAR_CITY?>" /></div>
            <div style="float:left; width:50px; margin:10px 12px 0 0;"><span class="title formTitle"><?LANG_POSTAL?></span> <input type="text" id="postal" name="postal" class="textfield" value="<?TPLVAR_POSTAL?>" /></div>
            <div style="float:left; width:214px; margin-top:10px;"><span class="title formTitle"><?LANG_COUNTRY?></span> <?TPLVAR_COUNTRY_LIST?></div>
          </li>
        </ul>

        <ul class="noList mainData">
          <li class="sideTitle">&nbsp;</li>
          <li class="data">
            <div class="buttons leftButton"><button type="submit" class="cancel" id="cancelHometown"><?LANG_CANCEL?></button></div>
            <div class="buttons leftButton"><button type="submit" class="" id="saveHometown"><?LANG_SAVE?></button></div>
          </li>
        </ul>
        </form>
        </div>