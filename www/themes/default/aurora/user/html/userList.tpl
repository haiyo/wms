<div class="header">
  <div class="headerWrapper">
    <div class="headLeft dropdown"><a href="#" id="moreActions"><?LANG_MORE_ACTIONS?></a>
        <div class="menu">
          <div><a href="importExport" id="importExport"><?LANG_IMPORT_EXPORT_CONTACTS?></a></div>
        </div>
    </div>
    <div class="headMid"><?LANG_TOTAL_RECORDS?>: <span id="total"><?TPLVAR_TOTAL?></span> &nbsp;|&nbsp; <?LANG_PAGE?> <span id="page">1</span> <?LANG_OF?> <span id="pages"><?TPLVAR_PAGES?></span></div>
    <div class="headerRight">
      <div id="userfieldWrapper">
          <input name="q" id="userField" type="text" class="textfield searchInput searchWhite" placeholder="<?LANG_SEARCH_BY_NAME?>">
      </div>
      <div id="filterList"><?TPLVAR_ROLE_FILTER?></div>
    </div>
  </div>
</div>
<div class="importExportPanel">
    <div style="padding:20px;">
      <?LANG_CHOOSE_ACTION?>:
    </div>
</div>
<div class="slidePanel">
  <?TPL_USER_FORM?>
</div>
<div class="userList">
  <ul class="noList" id="list">
    <?TPLVAR_USER_LIST?>
  </ul>
</div>