<form id="form<?TPLVAR_MSGID?>" style="display:none;">
        <!-- BEGIN DYNAMIC BLOCK: notification -->
        <div style="float:left; margin-bottom:3px; width:100%;"><?TPLVAR_NOTIFICATION?></div>
        <!-- END DYNAMIC BLOCK: notification -->

        <div id="buttonSet<?TPLVAR_MSGID?>">
          <!-- BEGIN DYNAMIC BLOCK: button -->
          <div style="float:left; margin-bottom:5px;"><div class="buttons"><button type="submit" id="<?TPLVAR_MSGID?>" class="notification <?TPLVAR_BTN_CLASS?>" value="<?TPLVAR_BTN_VALUE?>"><?TPLVAR_BTN_NAME?></button></div></div>
          <!-- END DYNAMIC BLOCK: button -->
          <div id="spinner<?TPLVAR_MSGID?>" style="float:left; margin-top:10px;"></div>
        </div>

        <!-- BEGIN DYNAMIC BLOCK: hidden -->
        <input type="hidden" id="<?TPLVAR_NAME?>" name="<?TPLVAR_NAME?>" value="<?TPLVAR_VALUE?>" />
        <!-- END DYNAMIC BLOCK: hidden -->

        <!-- BEGIN DYNAMIC BLOCK: url -->
        <input type="hidden" id="url<?TPLVAR_MSGID?>" value="<?TPLVAR_URL?>" />
        <!-- END DYNAMIC BLOCK: url -->
      </form>