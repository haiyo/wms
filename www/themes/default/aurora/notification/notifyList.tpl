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
<div><?LANG_NO_NOTIFICATIONS?></div>
<!-- END DYNAMIC BLOCK: noList -->
<!-- BEGIN DYNAMIC BLOCK: list -->
<div class="notifyList" onclick="<?TPLVAR_URL?>">
    <div style="float:left; width:35px; margin-right:5px;"><?TPL_AVATAR?></div>
    <div style="text-align:left;">
      <div class="message"><?TPLVAR_MESSAGE?></div>
      <div class="dateTime"><?TPLVAR_DATE_TIME?></div>
    </div>
</div>
<hr size="1" class="notifyHR" />
<!-- END DYNAMIC BLOCK: list -->