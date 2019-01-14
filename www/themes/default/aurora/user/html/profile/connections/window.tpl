      <div id="connectPanel" class="connectPanel">
        <div  id="connectionToggle" style="cursor:pointer; background:#ccc url(../../../../../../../www/themes/admin/aurora/core/img/classic/en_us/imageset.png); background-position: -1px -79px; -moz-border-top-left-radius:4px; -moz-border-top-right-radius:4px; -webkit-border-top-right-radius:4px; -webkit-border-top-left-radius:4px; width:100%; height:23px;">
          <div style="float:left; line-height:23px; text-indent:5px; margin-right:70px; font-weight:bold; color:#fff;">My Connections</div>
          <div style="float:left; width:13px; height:13px; margin-top:5px;"><a href=""><img id="connectToggleIcon" src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/core/img/<?TPLVAR_THEME?>/maximize.png" border="0" /></a></div>
        </div>
        <div id="connectionBody">
            <div style="background-color:#ccc; padding:2px 0 4px; 0; margin-bottom:3px;">
              <div style="width:92%; margin-left:6px;">
                <input type="text" id="srchField" class="textfield textFade" title="Type a Name or Email" value="Type a Name or Email" />
              </div>
            </div>
            <div>
              <div id="userWrapper" class="userWrapper">
                <!-- BEGIN DYNAMIC BLOCK: noConnection -->
                <div class="noConnection">You have no connection with anyone.</div>
                <!-- END DYNAMIC BLOCK: noConnection -->
                <!-- BEGIN DYNAMIC BLOCK: connectedList -->
                <?TPL_CONNECTED_USER?>
                <!-- END DYNAMIC BLOCK: connectedList -->
              </div>
            </div>
        </div>
      </div>