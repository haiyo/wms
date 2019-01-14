<style>
.notifyList {
    cursor:pointer;
    padding:8px;
    line-height:normal;
    min-height:32px;
    font-size: 12px;
    font-weight:normal;
    text-transform:none;
    color:#333;
}
.notifyList:hover {
    background:#efefef;
}
.notifyList .message {
    margin-bottom:3px;
}
.notifyList .dateTime {
    color:#999;
}
.notifyList .isRead {
    color:#666;
}
.notifyList .unRead {
    font-weight:bold;
    color:#333;
}
.notifyHR {
    color: #ccc;
    background-color: #ccc;
    height:1px;
    border:0;
    width:100%;
    margin:0;
}
</style>
<!-- BEGIN DYNAMIC BLOCK: noList -->
<div><?LANG_NO_MAILS?></div>
<!-- END DYNAMIC BLOCK: noList -->
<!-- BEGIN DYNAMIC BLOCK: list -->
<div class="notifyList" onclick="Aurora.UI.showBox( 'inbox', '<?TPLVAR_ROOT_URL?>admin/inbox/messages/<?TPLVAR_MSG_ID?>/<?TPLVAR_CONTENT_ID?>', 900, 573 );">
    <div style="float:left; width:35px; margin-right:5px;"><?TPL_AVATAR?></div>
    <div style="text-align:left;">
      <div class="message"><strong><?TPLVAR_FNAME?> <?TPLVAR_LNAME?></strong><br />
        <div class="<?TPLVAR_IS_READ?>"><?TPLVAR_MESSAGE?></div>
      </div>
      <div class="dateTime"><?TPLVAR_DATE_TIME?></div>
    </div>
</div>
<hr size="1" class="notifyHR" />
<!-- END DYNAMIC BLOCK: list -->