<div class="dropdown-menu dropdown-content width-400">
  <div class="dropdownContentTitle">Notifications</div>
  <ul class="notifyWindow dropdown-content-body">
    <!-- BEGIN DYNAMIC BLOCK: noList -->
    <div class="noNotification"><?LANG_NO_NOTIFICATIONS?></div>
    <!-- END DYNAMIC BLOCK: noList -->
    <!-- BEGIN DYNAMIC BLOCK: list -->
    <div class="row mb-0 notifyList">
      <div onclick="<?TPLVAR_URL?>">
        <div class="col-md-2 notifyPhoto"><img src="<?TPLVAR_PHOTO?>" width="50" height="50" class="rounded-circle" /></div>
        <div class="col-md-10 notifyMessage">
          <?TPLVAR_MESSAGE?>
          <div class="dateTime"><?TPLVAR_DATE_TIME?></div>
        </div>
      </div>
    </div>
    <!-- END DYNAMIC BLOCK: list -->
  </ul>

  <!--<div class="dropdown-content-footer">
    <a href="#" data-popup="tooltip" title="" data-original-title="All messages"><i class="icon-menu display-block"></i></a>
  </div>-->
</div>