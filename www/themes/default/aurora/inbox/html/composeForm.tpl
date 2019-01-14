<div id="contentForm">
<div id="message" style="float:left; width:100%;">
  <form id="fileupload" action="" method="POST" enctype="multipart/form-data">
  <input id="msgID" name="msgID" type="hidden" value="<?TPLVAR_MSGID?>" />
  <input id="contentID" name="contentID" type="hidden" value="<?TPLVAR_CONTENTID?>" />
  <input type="hidden" id="isDraft" value='<?TPLVAR_IS_DRAFT?>' />
  <input type="hidden" id="newMsg" value='<?TPLVAR_NEW_MSG?>' />
  <input type="hidden" id="toJson" value='<?TPLVAR_TO_JSON?>' />
  <input type="hidden" id="ccJson" value='<?TPLVAR_CC_JSON?>' />
  <input type="hidden" id="bccJson" value='<?TPLVAR_BCC_JSON?>' />
  <input type="hidden" id="draftAtt" value='<?TPLVAR_DRAFT_ATT?>' />
  <input id="totalBytes" name="totalBytes" type="hidden" value="<?TPLVAR_TOTAL_B?>" />
  <input id="totalBytesTxt" name="totalBytesTxt" type="hidden" value="<?TPLVAR_TOTAL_TXT?>" />
  <input id="uploadBytes" name="uploadBytes" type="hidden" value="<?TPLVAR_UPLOAD_B?>" />
  <input id="uploadBytesTxt" name="uploadBytesTxt" type="hidden" value="<?TPLVAR_UPLOAD_TXT?>" />

  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableForm">
    <tr>
      <td width="80" valign="top" align="right" class="formTitle"><div style="margin-top:5px;"><a href="" class="showCCLink" alt="<?LANG_SHOW_CC?>" title="<?LANG_SHOW_CC?>">&#9658;</a> <?LANG_TO?>:&nbsp;</div></td>
      <td><div class="autoComplete"><input type="text" id="to" class="" style="font-size:14px; outline:none; padding:4px; width:97%; border:none;" /></div></td>
    </tr>
    <tr class="ccField">
      <td valign="top" align="right" class="formTitle"><div style="margin-top:5px;">Cc:&nbsp;</div></td>
      <td><div class="autoComplete"><input type="text" id="cc" class="" style="font-size:14px; outline:none; padding:4px; width:97%; border:none;" /></div></td>
    </tr>
    <tr class="ccField">
      <td valign="top" align="right" class="formTitle"><div style="margin-top:5px;">Bcc:&nbsp;</div></td>
      <td><div class="autoComplete"><input type="text" id="bcc" class="" style="font-size:14px; outline:none; padding:4px; width:97%; border:none;" /></div></td>
    </tr>
    <tr id="subjectRow">
      <td align="right" class="formTitle"><?LANG_SUBJECT?>:&nbsp;</td>
      <td><input type="text" id="subject" class="" tabindex="4" style="font-size:14px; outline:none; padding:4px; width:97%; border:none;" /></td>
    </tr>
    <tr id="attRow">
      <td>&nbsp;</td>
      <td><div id="attachment" class="attachmentWrapper"></div></td>
    </tr>
  </table>

  <div id="textAreaWrapper" style="position:relative; float:left; width:100%;">
    <textarea rows="7" id="textArea" name="textArea" class="textfield"><?TPLVAR_CONTENT?></textarea>
  </div>
  </form>
</div>
<div class="progressBarWrapper">
  <div class="progressContext">
    <div class="progressBarContainer">
      <div class="progressBar">
        <div class="bar" style="width:0%; height:3px; background-color:#99bb00;"></div>
      </div>
    </div>
    <div class="deleteAttachment">
      <a href="" class="cancelFile"><img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/form/img/<?TPLVAR_THEME?>/delete.gif" border="0" class="alignMiddle trash" alt="<?LANG_REMOVE?>" title="<?LANG_REMOVE?>" /></a>
    </div>
    <div class="uploadFileName"></div>
  </div>
</div>
</div>