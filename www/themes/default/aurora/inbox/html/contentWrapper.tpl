<div id="contentForm" style="display:none;">
  <div id="contentHeaderCompose" style="float:left; width:100%; padding:3px 0 5px 10px; background-color:#efefef; border-bottom:1px solid #ccc;">
    <div class="mailUser recipientWrapper placeholderWrapper"><?TPL_AVATAR?></div>
    <div style="float:left; width:100%;">
      <div class="dateTime" style="float:left; font-size:11px; color:#666; margin-top:3px; margin-left:5px; font-weight:bold;">Drag and Drop Recipient(s) Here</div>
    </div>
  </div>
  <div id="contentMessageCompose" class="content contentForm">
    <div id="message" style="float:left; padding:10px 20px;">
      <form id="fileupload" action="" method="POST" enctype="multipart/form-data">
      <input id="totalBytes" name="totalBytes" type="hidden" value="<?TPLVAR_TOTAL_B?>" />
      <input id="totalBytesTxt" name="totalBytesTxt" type="hidden" value="<?TPLVAR_TOTAL_TXT?>" />
      <input id="uploadBytes" name="uploadBytes" type="hidden" value="<?TPLVAR_UPLOAD_B?>" />
      <input id="uploadBytesTxt" name="uploadBytesTxt" type="hidden" value="<?TPLVAR_UPLOAD_TXT?>" />
      <div style="float:left; width:100%; font-size:11px; font-weight:bold; margin-bottom:10px;">Enter a Subject:
        <input type="text" id="subject" class="textfield" title="Enter a Subject" />
      </div>

      <div id="attachmentCompose" class="attachmentWrapper"></div>

      <div style="float:left; width:100%; height:300px;">
        <textarea rows="7" id="textAreaCompose" name="textAreaCompose" class="textfield"></textarea>
        <div class="formButtons">
          <div style="float:left;" class="buttons"><button type="submit" class="cancel">Cancel</button></div>
          <div style="float:left;" class="buttons"><button type="submit" class="sendMessage">Send Message</button></div>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>
<?TPL_CONTENT?>