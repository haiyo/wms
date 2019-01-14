<div id="connections" class="tabContent">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="sideTitle sideConnection" valign="top"><div class="titleBar title connectionTitle">Search People</div>
        <div style="margin:auto; width:98%; margin-bottom:5px;"><input type="text" id="userField" name="userField" title="Enter Name or Email Address" value="Enter Name or Email Address" class="textfield textFade" style="padding:3px;" /></div>
        <div style="width:100%; margin-bottom:5px;"><?TPL_ROLE_LIST?></div>

        <div class="titleBar title connectionTitle">My Groups</div>
        <div class="connectionTags connectActive">All Connections (0)</div>
        <div class="connectionTags">Colleagues (0)</div>
        <div class="connectionTags">Partners (0)</div>
        <div class="connectionTags">Group Members (0)</div>
    </td>
    <td width="15">&nbsp;</td>
    <td class="connectionData"><div class="titleBar title peopleTitle">People You Are Connected With</div>
        <div id="userWrapper" class="userWrapper">
          <!-- BEGIN DYNAMIC BLOCK: noConnection -->
          <div class="noConnection">You have no connection with anyone.</div>
          <!-- END DYNAMIC BLOCK: noConnection -->
          <!-- BEGIN DYNAMIC BLOCK: connectedList -->
          <?TPL_CONNECTED_USER?>
          <!-- END DYNAMIC BLOCK: connectedList -->
        </div></td>
  </tr>
  </table>
</div>