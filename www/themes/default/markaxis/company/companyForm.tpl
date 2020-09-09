<style>
    .defPhoto, .upload-demo-wrap    {
        width: 424px;
        height: 116px;
    }
    .card-slip {
        margin-top:20px;
    }
    #companyForm .p-10 {
        padding: 10px 0 !important;
    }
    #error,#saveCompanySettings {float:right;}
    #error{text-align:left;}
    #error .error{margin-top: 10px;}
</style>
<div class="tab-pane fade" id="company">

    <div class="d-md-flex">

        <div class="sidebar sidebar-light sidebar-component sidebar-component-left sidebar-expand-md mt-20 mr-0 companySidebar">

            <div class="sidebar-content">
                <div class="card company-card">
                    <div class="card-header bg-transparent header-elements-inline">
                        <span class="text-uppercase font-size-sm font-weight-semibold"><?LANG_UPLOAD_LOGO?></span>
                    </div>

                    <div class="card-body">
                        <div class="text-uppercase font-size-sm font-weight-semibold mb-10"><?LANG_MAIN_PORTAL_LOGO?></div>
                        <div id="thumb" class="thumb">
                            <div class="hide companyLogoBG">
                                <img src="<?TPLVAR_ROOT_URL?>themes/default/assets/images/logo-bg.png" />
                            </div>
                            <div class="defCompanyLogo">
                                <img src="<?TPLVAR_ROOT_URL?>themes/default/assets/images/logo.png" class="<?TPLVAR_DEF_COMPANY_LOGO?>" />
                            </div>
                            <div class="caption-overflow">
                                <span>
                                    <a href="" class="btn bg-success-400 btn-icon btn-xs file-btn">
                                        <i class="icon-plus2"></i>
                                        <input type="file" id="uploadCompany" value="<?LANG_CHOOSE_A_FILE?>" accept="image/*" />
                                    </a>
                                </span>
                            </div>
                            <!-- BEGIN DYNAMIC BLOCK: companyLogo -->
                            <div class="photo-wrap photo-wrap-Company">
                                <div class="photo company-logo checkered">
                                    <a href="#" data-text="<?LANG_COMPANY?>" class="deletePhoto deleteLogo"><i class="icon-bin"></i></a>
                                    <img src="<?TPLVAR_ROOT_URL?>admin/company/logo/main" />
                                </div>
                            </div>
                            <!-- END DYNAMIC BLOCK: companyLogo -->
                            <div class="upload-demo-wrap upload-company-wrap">
                                <a href="#" data-cancel="uploadCompany" class="upload-cancel">&times;</a>
                                <div id="upload-company">
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="card-body card-slip">
                        <div class="text-uppercase font-size-sm font-weight-semibold mb-10"> <?LANG_PAYSLIP_LOGO?></div>
                        <div id="thumb" class="thumb">
                            <div class="hide payslipLogoBG">
                                <img src="<?TPLVAR_ROOT_URL?>themes/default/assets/images/logo-bg.png" />
                            </div>
                            <div class="defPayslipLogo">
                                <img src="<?TPLVAR_ROOT_URL?>themes/default/assets/images/logo.png" class="<?TPLVAR_DEF_SLIP_LOGO?>" />
                            </div>
                            <div class="caption-overflow">
                                    <span>
                                        <a href="" class="btn bg-success-400 btn-icon btn-xs file-btn">
                                            <i class="icon-plus2"></i>
                                            <input type="file" id="uploadSlip" value="<?LANG_CHOOSE_A_FILE?>" accept="image/*" />
                                        </a>
                                    </span>
                            </div>
                            <!-- BEGIN DYNAMIC BLOCK: slipLogo -->
                            <div class="photo-wrap photo-wrap-Payslip">
                                <div class="photo payslip-logo checkered">
                                    <a href="#" data-text="<?LANG_PAYSLIP?>" class="deletePhoto deleteLogo"><i class="icon-bin"></i></a>
                                    <img src="<?TPLVAR_ROOT_URL?>admin/company/logo" />
                                </div>
                            </div>
                            <!-- END DYNAMIC BLOCK: slipLogo -->
                            <div class="upload-demo-wrap upload-slip-wrap">
                                <a href="#" data-cancel="uploadSlip" class="upload-cancel">&times;</a>
                                <div id="upload-slip">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="company-panel panel-flat">
            <div class="panel-body">
                <form id="companyForm" class="stepy" action="#">
                    <input type="hidden" id="companyLogoField" name="companyLogoField" />
                    <input type="hidden" id="slipLogoField" name="slipLogoField" />
                    <div class="row p-10 mb-0">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?LANG_COMPANY_REGISTRATION?>: <span class="text-danger-400">*</span></label>
                                <input type="text" name="regNumber" id="regNumber" placeholder="<?LANG_OFFICIAL_REGISTRATION?>"
                                       class="form-control" value="<?TPLVAR_REG_NUMBER?>" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?LANG_COMPANY_NAME?>:</label>
                                <input type="text" name="name" id="name" placeholder="Example Corporation"
                                       class="form-control" value="<?TPLVAR_NAME?>" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?LANG_COMPANY_ADDRESS?>:</label>
                                <input type="text" name="address" id="address" placeholder="111 San Francisco, CA 94110"
                                       class="form-control" value="<?TPLVAR_ADDRESS?>" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?LANG_COMPANY_EMAIL?>:</label>
                                <input type="text" name="email" id="email" placeholder="example@company.com"
                                       class="form-control" value="<?TPLVAR_EMAIL?>" />
                            </div>
                        </div>

                    </div>

                    <div class="row p-10 mb-0">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?LANG_COMPANY_PHONE?>:</label>
                                <input type="text" name="phone" id="phone" placeholder="+65 111 1111"
                                       class="form-control" value="<?TPLVAR_PHONE?>" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?LANG_COMPANY_WEBSITE?>:</label>
                                <input type="text" name="website" id="website" class="form-control"
                                       placeholder="http://www.example.com" value="<?TPLVAR_WEBSITE?>" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?LANG_COMPANY_TYPE?>:</label>
                                <?TPL_COMPANY_TYPE_LIST?>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?LANG_MAIN_OPERATION_COUNTRY?>:</label>
                                <?TPL_COUNTRY_LIST?>
                            </div>
                        </div>
                    </div>

                    <div class="row p-10 mb-0">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?LANG_MAIN_THEME_COLOR?>:</label>
                                <input type="text" id="mainColor" name="mainColor" class="form-control jscolor" value="<?TPLVAR_MAIN_COLOR?>" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?LANG_NAVIGATION_COLOR?>:</label>
                                <input type="text" id="navigationColor" name="navigationColor" class="form-control jscolor" value="<?TPLVAR_NAVIGATION_COLOR?>" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?LANG_NAVIGATION_TEXT_COLOR?>:</label>
                                <input type="text" id="navigationTextColor" name="navigationTextColor" class="form-control jscolor" value="<?TPLVAR_NAVIGATION_TEXT_COLOR?>" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?LANG_NAVIGATION_TEXT_HOVER_COLOR?>:</label>
                                <input type="text" id="navigationTextHoverColor" name="navigationTextHoverColor" class="form-control jscolor" value="<?TPLVAR_NAVIGATION_TEXT_HOVER_COLOR?>" />
                            </div>
                        </div>

                    </div>

                    <div class="row p-10 mb-0">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?LANG_DASHBOARD_BACKGROUND_COLOR?>:</label>
                                <input type="text" id="dashboardBgColor" name="dashboardBgColor" class="form-control jscolor" value="<?TPLVAR_DASHBG_COLOR?>" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?LANG_BUTTONS_COLOR?>:</label>
                                <input type="text" id="buttonColor" name="buttonColor" class="form-control jscolor" value="<?TPLVAR_BUTTON_COLOR?>" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?LANG_BUTTONS_HOVER_COLOR?>:</label>
                                <input type="text" id="buttonHoverColor" name="buttonHoverColor" class="form-control jscolor" value="<?TPLVAR_BUTTON_HOVER_COLOR?>" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?LANG_BUTTONS_FOCUS_COLOR?>:</label>
                                <input type="text" id="buttonFocusColor" name="buttonFocusColor" class="form-control jscolor" value="<?TPLVAR_BUTTON_FOCUS_COLOR?>" />
                            </div>
                        </div>
                    </div>

                    <div class="mb-0 mr-10 text-right">
                        <button id="saveCompanySettings" type="submit" class="btn bg-purple-400 btn-ladda" data-style="slide-right">
                            <span class="ladda-label"><?LANG_SAVE_SETTINGS?> <i class="icon-check position-right"></i></span>
                        </button>
                        <div id="error"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>