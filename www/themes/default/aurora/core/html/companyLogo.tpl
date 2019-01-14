          <div id="companyLogo" class="companyLogo" style="display:<?TPLVAR_COMPANY_LOGO?>;">
            <div id="logoWrapper" style="display:<?TPLVAR_LOGO_DISPLAY?>"><img src="<?TPLVAR_LOGO_IMAGE?>" id="logoImage" border="0" /></div>
            <h1 class="logoField" style="display:<?TPLVAR_TEXT_DISPLAY?>"><?TPLVAR_LOGO_TEXT?></h1>
            <input type="hidden" id="usingLogo" value="<?TPLVAR_LOGO_IMAGE?>" />
            <!-- BEGIN DYNAMIC BLOCK: logoTools -->
            <ul class="logoTools">
              <li class="editTxt"></li>
              <li class="sep"></li>
              <li class="uploadLogo"><a href="<?TPLVAR_ROOT_URL?>admin/logo" id="logo">upload</a></li>
            </ul>
            <!-- END DYNAMIC BLOCK: logoTools -->
          </div>