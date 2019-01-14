            <div id="droplet<?TPLVAR_DROPLET_ID?>" class="droplet <?TPLVAR_DROPLET_STYLES?>">
              <!--<div class="dropletWrapper">-->
              <div class="dropletTitleBar"><h2 id="droplet<?TPLVAR_DROPLET_ID?>Title"><?TPLVAR_DROPLET_TITLE?></h2></div>
              <div class="dropletTools">
                <!-- BEGIN DYNAMIC BLOCK: edit -->
                <div id="droplet<?TPLVAR_DROPLET_ID?>Edit" class="dropletEdit"><a href="#" onclick="return false;">Edit</a></div>
                <div id="droplet<?TPLVAR_DROPLET_ID?>Handle" class="dropletHandle"></div>
                <div id="droplet<?TPLVAR_DROPLET_ID?>Close" class="dropletClose"><a href="#" onclick="return false;">Close</a></div>
                <!-- END DYNAMIC BLOCK: edit -->
              </div>

              <div id="droplet<?TPLVAR_DROPLET_ID?>Content">
                <div class="loadingDroplet"><img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/core/img/<?TPLVAR_THEME?>/spinner16.gif" border="0" class="alignMiddle" /> <?LANG_LOADING_DROPLET?></div>
                <div title="<?TPLVAR_DROPLET_ID?>" class="<?TPLVAR_DROPLET_CALLBACK?>"></div>
              </div>
              <!--</div>-->
            </div>