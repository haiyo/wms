<div id="replyListWrapper<?TPLVAR_CONTENTID?>" class="replyListWrapper">
  <div class="replyList">
    <div class="replyHeader">
      <div class="replyHeaderWrapper">
        <div id="replyList<?TPLVAR_CONTENTID?>" class="column contentcolumn">
          <div class="msgListUser">
            <a href="<?TPLVAR_ROOT_URL?>admin/profile/<?TPLVAR_USERID?>" class="userprofile profileCard fromUserName"><?TPLVAR_FNAME?> <?TPLVAR_LNAME?></a>

            <div id="userExpand<?TPLVAR_CONTENTID?>" class="userExpand">
              <?LANG_TO_ME?>;
              <!-- BEGIN DYNAMIC BLOCK: toName -->
              <a href="<?TPLVAR_USERID?>" class="userprofile profileCard"><?TPLVAR_FNAME?> <?TPLVAR_LNAME?></a>;&nbsp;
              <!-- END DYNAMIC BLOCK: toName -->
              <div style="display:<?TPLVAR_CC_HIDE?>; color:#999; margin-top:3px;">Cc:&nbsp;
              <!-- BEGIN DYNAMIC BLOCK: ccName -->
              <a href="<?TPLVAR_USERID?>" class="userprofile profileCard"><?TPLVAR_FNAME?> <?TPLVAR_LNAME?></a>;&nbsp;
              <!-- END DYNAMIC BLOCK: ccName -->
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="column leftcolumn">
        <div class="starTools">
          <div id="star<?TPLVAR_CONTENTID?>" class="<?TPLVAR_STAR?>"><a href="<?TPLVAR_CONTENTID?>" class="markStar">Star</a></div>
        </div>
      </div>
      <div class="column rightcolumn">
        <div class="dateTime">
          <div>
            <!-- BEGIN DYNAMIC BLOCK: attachment -->
            <a href="<?TPLVAR_CONTENTID?>" class="attachment"><img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/inbox/img/<?TPLVAR_THEME?>/attachment_icon.png" border="0" class="alignMiddle" /></a>&nbsp;
            <!-- END DYNAMIC BLOCK: attachment -->
            <?TPLVAR_DATETIME?>
          </div>

          <div id="replyTool<?TPLVAR_CONTENTID?>" class="box">
            <ul class="noList">
              <li><a href="<?TPLVAR_CONTENTID?>" class="bt btleft reply" title="Reply"><img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/inbox/img/<?TPLVAR_THEME?>/reply_ico.png" width="22" height="14" border="0" class="alignMiddle" /></a></li>
              <li><a href="<?TPLVAR_CONTENTID?>" class="bt btmiddle replyAll" title="Reply All"><img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/inbox/img/<?TPLVAR_THEME?>/replyAll_ico.png" width="22" height="14" border="0" class="alignMiddle" /></a></li>
              <li class="dropdown"><a href="<?TPLVAR_CONTENTID?>" class="bt btright dropdownBtn"><span>&#9660;</span></a>
                <div id="dropdownMenu<?TPLVAR_CONTENTID?>" class="dropdownMenu">
                  <div><a href="<?TPLVAR_CONTENTID?>" class="reply">Reply</a></div>
                  <div><a href="<?TPLVAR_CONTENTID?>" class="replyAll">Reply All</a></div>
                  <div><a href="<?TPLVAR_CONTENTID?>" class="forward">Forward</a></div>
                  <div><a href="<?TPLVAR_CONTENTID?>" class="minimize">Minimize</a></div>
                  <div class="seperator"></div>
                  <div><a href="<?TPLVAR_CONTENTID?>" class="markUnread">Mark as Unread</a></div>
                  <div><a href="<?TPLVAR_CONTENTID?>" class="markStar" id="starLabel<?TPLVAR_CONTENTID?>"><?LANG_STAR_LABEL?></a></div>
                  <div class="seperator"></div>
                  <!-- BEGIN DYNAMIC BLOCK: saveAllAttachment -->
                  <div><a href="<?TPLVAR_CONTENTID?>" class="saveAllAtt">Save All Attachment</a></div>
                  <!-- END DYNAMIC BLOCK: saveAllAttachment -->
                  <div><a href="<?TPLVAR_CONTENTID?>" class="print">Print</a></div>
                  <div><a href="<?TPLVAR_CONTENTID?>" class="delete">Delete</a></div>
                </div>
              </li>
            </ul>
          </div>​
        </div>
      </div>

      <div id="shortContent<?TPLVAR_CONTENTID?>" class="shortContent <?TPLVAR_MARK_READ?>"><?TPLVAR_SHORT_CONTENT?></div>
    </div>
  </div>

  <div id="contentBody<?TPLVAR_CONTENTID?>" class="contentBody">
    <div class="content"><table><tr><td><?TPLVAR_CONTENT?></td></tr></table></div>
    <div id="attachment<?TPLVAR_CONTENTID?>" style="float:left; width:100%;"><?TPL_ATTACHMENT?></div>
    <!-- BEGIN DYNAMIC BLOCK: quoteExpand -->
    <div style="float:left; width:100%; margin-top:10px;">
      <div id="showQuote<?TPLVAR_CONTENTID?>" class="quoteExpand tooltip" title="<?LANG_SHOW_QUOTED_MESSAGE?>">
          <a href="<?TPLVAR_CONTENTID?>" class="openQuote">&#8230;</a>
      </div>
    </div>
    <!-- END DYNAMIC BLOCK: quoteExpand -->
    <div id="quote<?TPLVAR_CONTENTID?>" class="quoteWrapper"><?TPL_QUOTE_REPLY?></div>
  </div>
</div>