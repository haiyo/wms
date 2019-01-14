<div id="<?TPLVAR_ID?>" class="notifyWindow">
<div class="caret"></div>
<div class="notifySubMenu">
  <div style="margin-left:10px; color:#fff;">
    <div style="float:left;"><?LANG_TITLE?></div>
    <div style="margin-top:0px; text-align:right; margin-right:15px; cursor:pointer;" onclick="Aurora.UI.showBox( 'composeForm', '<?TPLVAR_ROOT_URL?>admin/inbox/compose', 700, 500 );"><?LANG_RIGHT_TITLE?></div>
  </div>
  <div style="padding:0px 5px;">
    <div id="<?TPLVAR_PREFIX?>InnerSubMenu" class="notifyInnerSubMenu"></div>
    <div style="float:right; margin-right:10px; color:#fff; cursor:pointer;" onclick="Aurora.UI.showBox( 'inbox', '<?TPLVAR_ROOT_URL?>admin/inbox/message', 900, 573 );">
      <?LANG_BOTTOM_TEXT?>
    </div>
  </div>
</div>
</div>