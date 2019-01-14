<div id="main">
  <div class="topBar">
    <div id="inboxToolsWrapper">
      <ul class="noList inboxTools">
        <li class="inbox"><a href="inbox" id="inbox" class="sectionLink tooltip" title="Inbox">Inbox</a></li>
        <li class="outbox"><a href="outbox" id="outbox" class="sectionLink tooltip" title="Outbox">Outbox</a></li>
        <li class="draft"><a href="draft" id="draft" class="sectionLink tooltip" title="Draft Box">Draft Box</a></li>
        <li class="starred"><a href="starred" id="starred" class="sectionLink tooltip" title="Starred">Starred</a></li>
        <li class="trash"><a href="trash" class="sectionLink tooltip" title="Trash Box">Trash Box</a></li>
        <li class="refresh"><a href="refresh" id="refresh" class="tooltip" title="Refresh">Refresh</a></li>
        <li class="compose"><a href="compose" id="compose" class="tooltip" title="Compose New Message">Compose New Message</a></li>
      </ul>
    </div>

    <!--<div id="searchfieldWrapper">
      <div class="searchField"><input name="q" type="text" class="textfield searchInput searchWhite" placeholder="Search messages"></div>
    </div>-->
    <div id="searchfieldWrapper">
    <form method="get" class="searchform" action="http://localhost/markaxis/">
        <input type="text" id="search_field" class="s" name="s" value="" title="Enter search term" placeholder="Search Message" data-validators="required" data-speech-enabled="" x-webkit-speech="x-webkit-speech" autocomplete="off">
        <div id="magnify"><img src="https://aurora.markaxis.com/www/themes/admin/aurora/core/img/classic/en_us/magnify.png" alt="magnify"></div>
        <input type="submit" class="searchsubmit" value="">
    </form>
    </div>
  </div>
    
  <?TPL_INBOX?>
  <input type="hidden" id="msgIDReq" value="<?TPLVAR_MSG_ID?>" />
  <input type="hidden" id="contentIDReq" value="<?TPLVAR_CONTENT_ID?>" />
</div>