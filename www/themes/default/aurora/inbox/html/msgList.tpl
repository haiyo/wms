<div id="<?TPLVAR_MSGID?>" class="msgRowDiv msgList">
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="msgRow">
  <tr>
    <td class="avatarColumn" valign="top">
      <?TPL_AVATAR?>
      <div style="float:left; height:1px;"><img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/inbox/img/<?TPLVAR_THEME?>/spacer.png" border="0" width="60" height="1" /></div>
    </td>
    <td class="column">
      <div id="subject<?TPLVAR_MSGID?>" class="msgSubject"><?TPLVAR_SUBJECT?></div>
      <div class="row msgListUser"><?TPLVAR_FNAME?> <?TPLVAR_LNAME?></div>
      <div class="msgDateTime"><?TPLVAR_DATE_TIME?></div>
      <div class="msgAttachment" dir="<?TPLVAR_ATT_COUNTER?>"></div>
      <div id="counter<?TPLVAR_MSGID?>" class="msgCounter"><?TPLVAR_COUNTER?></div>
      <div id="spinner<?TPLVAR_MSGID?>" class="msgSpinner"></div>
    </td>
  </tr>
</table>
</div>