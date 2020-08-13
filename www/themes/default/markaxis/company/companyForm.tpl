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
</style>
<script>
    $(function() {
        var uploadPortal = initUpload( "upload-company" );
        var uploadSlip = initUpload( "upload-slip" );

        function initUpload( id ) {
            return $("#" + id).croppie({
                viewport: {
                    width: 424,
                    height: 116,
                },
                enableExif: true
            });
        }

        $("#uploadCompany").on("change", function( ) { readFile( this, uploadPortal, "upload-company-wrap" ); });
        $("#uploadSlip").on("change", function( ) { readFile( this, uploadSlip, "upload-slip-wrap" ); });

        function readFile( input, uploader, wrapper ) {
            var that = this;

            if( input.files && input.files[0] ) {
                var reader = new FileReader( );
                reader.onload = function (e) {
                    $("." + wrapper).addClass("ready");
                    $(".caption").addClass("mt-30");

                    if( wrapper == "upload-slip-wrap" ) {
                        $(".d-md-flex .sidebar").css("height", "440px");
                    }
                    uploader.croppie("bind", {
                        url: e.target.result
                    }).then(function(){
                        if( wrapper == "upload-company-wrap" ) {
                            $(".companyLogoBG").removeClass("hide");
                            $(".defCompanyLogo").hide( );
                        }
                        else {
                            $(".payslipLogoBG").removeClass("hide");
                            $(".defPayslipLogo").hide( );
                        }
                    });
                }
                reader.readAsDataURL( input.files[0] );
            }
            else {
                swal("Sorry - your browser doesn't support the FileReader API");
            }
        }

        $(".upload-cancel").on("click", function( ev ) {
            var wrapper  = $(this).parent( );
            var uploader = $(this).attr("data-cancel");

            $(wrapper).removeClass('ready');
            $(".caption").removeClass("mt-30");
            $("#" + uploader).val("");

            if( uploader == "uploadCompany" ) {
                uploader = uploadPortal;
                $(".companyLogoBG").addClass("hide");
                $(".defCompanyLogo").show( );
            }
            else {
                uploader = uploadSlip;
                $(".d-md-flex .sidebar").css("height", "");
                $(".payslipLogoBG").addClass("hide");
                $(".defPayslipLogo").show( );
            }

            uploader.croppie("bind", {
                url : ""
            }).then(function () {
                //console.log('reset complete');
            });
            return false;
        });

        $("#saveCompanySettings").on("click", function( ) {
            if( $("#uploadCompany").val( ) != "" ) {
                uploadPortal.croppie("result", {
                    type: "canvas",
                    size: "viewport"
                }).then(function( respond ) {
                    var data = {
                        bundle: {
                            companyLogo: encodeURIComponent( respond )
                        },
                        success: function( res, ladda ) {
                            //
                        }
                    };
                    Aurora.WebService.AJAX( "admin/company/saveCompanySettings", data );
                });
            }

            if( $("#uploadSlip").val( ) != "" ) {
                uploadSlip.croppie("result", {
                    type: "canvas",
                    size: "viewport"
                }).then(function( respond ) {
                    var data = {
                        bundle: {
                            slipLogo: encodeURIComponent( respond )
                        },
                        success: function( res, ladda ) {
                            //
                        }
                    };
                    Aurora.WebService.AJAX( "admin/company/saveCompanySettings", data );
                });
            }

            var formData = Aurora.WebService.serializePost("#companyForm");

            var data = {
                bundle: {
                    data: formData
                },
                success: function( res, ladda ) {
                    var obj = $.parseJSON( res );
                    if( obj.bool == 0 ) {
                        swal("Error!", obj.errMsg, "error");
                        return;
                    }
                    else {
                        swal({
                            title: "Company Updated Successfully",
                            text: "Please hold while the page is being refresh.",
                            type: 'success'
                        }, function( isConfirm ) {
                            window.location.href = Aurora.ROOT_URL + "admin/company/settings";
                        });
                    }
                }
            };
            Aurora.WebService.AJAX( "admin/company/saveCompanySettings", data );
        });

        $(".deleteLogo").on("click", function( ) {
            var dataText = $(this).attr("data-text");
            title = "Are you sure you want to delete " + dataText + " logo?";
            text  = "Logo deleted will not be able to recover back.";
            confirmButtonText = "Confirm Delete";

            swal({
                title: title,
                text: text,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: confirmButtonText,
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function (isConfirm) {
                if (isConfirm === false) return;

                $("." + dataText + " .icon-bin").removeClass("icon-bin").addClass("icon-spinner2 spinner");

                var data = {
                    bundle: {
                        logo : dataText
                    },
                    success: function( res ) {
                        var obj = $.parseJSON( res );
                        if( obj.bool == 0 ) {
                            swal("error", obj.errMsg);
                            return;
                        }
                        else {
                            $(".photo-wrap-" + dataText).remove( );
                            $(".def" + dataText + "Logo img").removeClass("hide");
                            swal("Done!", dataText + " logo has been successfully deleted!", "success");
                            return;
                        }
                    }
                };
                Aurora.WebService.AJAX( "admin/company/deleteLogo", data );
            });
        });
    });
</script>

<div class="tab-pane fade" id="company">

    <div class="d-md-flex">

        <div class="sidebar sidebar-light sidebar-component sidebar-component-left sidebar-expand-md mt-20 mr-0 companySidebar">

            <div class="sidebar-content">
                <div class="card company-card">
                    <div class="card-header bg-transparent header-elements-inline">
                        <span class="text-uppercase font-size-sm font-weight-semibold">Upload Logo</span>
                    </div>

                    <div class="card-body">
                        <div class="text-uppercase font-size-sm font-weight-semibold mb-10">Main Portal Logo (425px by 116px Preferred)</div>
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
                                        <input type="file" id="uploadCompany" value="Choose a file" accept="image/*" />
                                    </a>
                                </span>
                            </div>
                            <!-- BEGIN DYNAMIC BLOCK: companyLogo -->
                            <div class="photo-wrap photo-wrap-Company">
                                <div class="photo company-logo checkered">
                                    <a href="#" data-text="Company" class="deletePhoto deleteLogo"><i class="icon-bin"></i></a>
                                    <img src="<?TPLVAR_ROOT_URL?>admin/company/logo/main" />
                                </div>
                            </div>
                            <!-- END DYNAMIC BLOCK: companyLogo -->
                            <div class="upload-demo-wrap upload-company-wrap">
                                <a href="#" data-cancel="uploadCompany" class="upload-cancel">X</a>
                                <div id="upload-company">
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="card-body card-slip">
                        <div class="text-uppercase font-size-sm font-weight-semibold mb-10"> Payslip Logo (425px by 116px Preferred)</div>
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
                                            <input type="file" id="uploadSlip" value="Choose a file" accept="image/*" />
                                        </a>
                                    </span>
                            </div>
                            <!-- BEGIN DYNAMIC BLOCK: slipLogo -->
                            <div class="photo-wrap photo-wrap-Payslip">
                                <div class="photo payslip-logo checkered">
                                    <a href="#" data-text="Payslip" class="deletePhoto deleteLogo"><i class="icon-bin"></i></a>
                                    <img src="<?TPLVAR_ROOT_URL?>admin/company/logo" />
                                </div>
                            </div>
                            <!-- END DYNAMIC BLOCK: slipLogo -->
                            <div class="upload-demo-wrap upload-slip-wrap">
                                <a href="#" data-cancel="uploadSlip" class="upload-cancel">X</a>
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
                                <label>Company Registration Number: <span class="text-danger-400">*</span></label>
                                <input type="text" name="regNumber" id="regNumber" placeholder="Official registration number"
                                       class="form-control" value="<?TPLVAR_REG_NUMBER?>" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Company Name:</label>
                                <input type="text" name="name" id="name" placeholder="Example Corporation"
                                       class="form-control" value="<?TPLVAR_NAME?>" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Company Address:</label>
                                <input type="text" name="address" id="address" placeholder="111 San Francisco, CA 94110"
                                       class="form-control" value="<?TPLVAR_ADDRESS?>" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Company Email:</label>
                                <input type="text" name="email" id="email" placeholder="example@company.com"
                                       class="form-control" value="<?TPLVAR_EMAIL?>" />
                            </div>
                        </div>

                    </div>

                    <div class="row p-10 mb-0">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Company Phone:</label>
                                <input type="text" name="phone" id="phone" placeholder="+65 111 1111"
                                       class="form-control" value="<?TPLVAR_PHONE?>" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Company Website:</label>
                                <input type="text" name="website" id="website" class="form-control"
                                       placeholder="http://www.example.com" value="<?TPLVAR_WEBSITE?>" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Company Type:</label>
                                <?TPL_COMPANY_TYPE_LIST?>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Main Operation Country:</label>
                                <?TPL_COUNTRY_LIST?>
                            </div>
                        </div>
                    </div>

                    <div class="row p-10 mb-0">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Main Theme Color:</label>
                                <input type="text" id="mainColor" name="mainColor" class="form-control jscolor" value="<?TPLVAR_MAIN_COLOR?>" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Navigation Color:</label>
                                <input type="text" id="navigationColor" name="navigationColor" class="form-control jscolor" value="<?TPLVAR_NAVIGATION_COLOR?>" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Navigation Text Color:</label>
                                <input type="text" id="navigationTextColor" name="navigationTextColor" class="form-control jscolor" value="<?TPLVAR_NAVIGATION_TEXT_COLOR?>" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Navigation Text Hover Color:</label>
                                <input type="text" id="navigationTextHoverColor" name="navigationTextHoverColor" class="form-control jscolor" value="<?TPLVAR_NAVIGATION_TEXT_HOVER_COLOR?>" />
                            </div>
                        </div>

                    </div>

                    <div class="row p-10 mb-0">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Dashboard Background Color:</label>
                                <input type="text" id="dashboardBgColor" name="dashboardBgColor" class="form-control jscolor" value="<?TPLVAR_DASHBG_COLOR?>" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Buttons Color:</label>
                                <input type="text" id="buttonColor" name="buttonColor" class="form-control jscolor" value="<?TPLVAR_BUTTON_COLOR?>" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Buttons Hover Color:</label>
                                <input type="text" id="buttonHoverColor" name="buttonHoverColor" class="form-control jscolor" value="<?TPLVAR_BUTTON_HOVER_COLOR?>" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Buttons Focus Color:</label>
                                <input type="text" id="buttonFocusColor" name="buttonFocusColor" class="form-control jscolor" value="<?TPLVAR_BUTTON_FOCUS_COLOR?>" />
                            </div>
                        </div>
                    </div>

                    <div class="mb-0 mr-10 text-right">
                        <button id="saveCompanySettings" type="button" class="btn bg-purple-400 btn-ladda" data-style="slide-right">
                            <span class="ladda-label">Save Settings <i class="icon-check position-right"></i></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>