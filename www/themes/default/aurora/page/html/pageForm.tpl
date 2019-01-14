  <div class="addPageFormWrapper">
	<div class="addPageFormCol">
      <div class="addPageFormIco"><img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/page/img/<?TPLVAR_THEME?>/addpage_ico.png" /></div>
    </div>

    <div class="addPageForm">
      <div class="title"><?LANG_ENTER_PAGE_TITLE?></div>
      <div class="field"><input type="text" name="pageTitle" id="pageTitle" class="textfield bigTextField focus" value="<?TPLVAR_PAGE_TITLE?>" /></div>
      
      <div class="title"><?LANG_WHO_CAN_VIEW?></div>
      <!-- BEGIN DYNAMIC BLOCK: dashboard -->
	  <div style="margin-bottom:10px; color:#999;"><?LANG_UNIVERSAL_PAGE?></div>
      <!-- END DYNAMIC BLOCK: dashboard -->
      
      <!-- BEGIN DYNAMIC BLOCK: permList -->
      <div class="field whoCanView"><?TPLVAR_PERM_LIST?>
        <div id="roleList"><?TPLVAR_PAGE_ROLES?></div>
      </div>
      <!-- END DYNAMIC BLOCK: permList -->
      
      <div class="title"><?LANG_CHOOSE_LAYOUT?></div>
      <div class="layoutWrapper">
        <div id="left" class="layoutIco <?TPLVAR_LEFT?>"><a href="#" class="layout" title="left"><img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/page/img/<?TPLVAR_THEME?>/left_layout.gif" border="0" alt="Left Layout" title="Left Layout" /></a></div>
        <div id="right" class="layoutIco <?TPLVAR_RIGHT?>"><a href="#" class="layout" title="right"><img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/page/img/<?TPLVAR_THEME?>/right_layout.gif" border="0" alt="Right Layout" title="Right Layout" /></a></div>
        <div id="full" class="layoutIco <?TPLVAR_FULL?>"><a href="#" class="layout" title="full"><img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/page/img/<?TPLVAR_THEME?>/full_layout.gif" border="0" alt="Full Layout" title="Full Column Layout" /></a></div>
        <div id="two" class="layoutIco <?TPLVAR_TWO?>"><a href="#" class="layout" title="two"><img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/page/img/<?TPLVAR_THEME?>/two_layout.gif" border="0" alt="Two Layout" title="Two Columns Layout" /></a></div>
        <div id="three" class="layoutIco <?TPLVAR_THREE?>"><a href="#" class="layout" title="three"><img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/page/img/<?TPLVAR_THEME?>/three_layout.gif" border="0" alt="Three Layout" title="Three Columns Layout" /></a></div>
        <div id="half" class="layoutIco layout2Ico <?TPLVAR_HALF?>"><a href="#" class="layout" title="half"><img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/page/img/<?TPLVAR_THEME?>/half_layout.gif" border="0" alt="Half Layout" title="Half Layout" /></a></div>
        <div id="left3" class="layoutIco layout2Ico <?TPLVAR_LEFT3?>"><a href="#" class="layout" title="left3"><img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/page/img/<?TPLVAR_THEME?>/left3_layout.gif" border="0" alt="Left 3 Layout" title="Left 3 Layout" /></a></div>
        <div id="right3" class="layoutIco layout2Ico <?TPLVAR_RIGHT3?>"><a href="#" class="layout" title="right3"><img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/page/img/<?TPLVAR_THEME?>/right3_layout.gif" border="0" alt="Right 3 Layout" title="Right 3 Layout" /></a></div>
        <div id="left4" class="layoutIco layout2Ico <?TPLVAR_LEFT4?>"><a href="#" class="layout" title="left4"><img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/page/img/<?TPLVAR_THEME?>/left4_layout.gif" border="0" alt="Left 4 Layout" title="Left 4 Layout" /></a></div>
        <div id="right4" class="layoutIco layout2Ico <?TPLVAR_RIGHT4?>"><a href="#" class="layout" title="right4"><img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/page/img/<?TPLVAR_THEME?>/right4_layout.gif" border="0" alt="Right 4 Layout" title="Right 4 Layout" /></a></div>
      </div>

      <input name="layout" id="layout" type="hidden" value="<?TPLVAR_PAGE_LAYOUT?>" />
      <input name="pageID" id="pageID" type="hidden" value="<?TPLVAR_PAGE_ID?>" />
      <input name="droplets" id="droplets" type="hidden" value="<?TPLVAR_DROPLETS?>" />
    </div>
  </div>