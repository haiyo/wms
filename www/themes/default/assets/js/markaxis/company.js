/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: company.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisCompany = (function( ) {

    /**
     * MarkaxisCompany Constructor
     * @return void
     */
    MarkaxisCompany = function( ) {
        this.uploadCompany = false;
        this.uploadSlip = false;
        this.fileInput = null;
        this.uploadCompanySelected = false;
        this.uploadSlipSelected = false;
        this.validator = false;
        this.init( );
    };

    MarkaxisCompany.prototype = {
        constructor: MarkaxisCompany,

        /**
         * Initialize first onload setup
         * @return void
         */
        init: function( ) {
            this.initEvents( );
        },


        /**
         * Events Registration
         * @return void
         */
        initEvents: function( ) {
            var that = this;

            that.uploadCompany = that.initUpload( "upload-company" );
            that.uploadSlip = that.initUpload( "upload-slip" );

            $("#uploadCompany").on("change", function( ) { that.readFile( this, that.uploadCompany, "upload-company-wrap" ); });
            $("#uploadSlip").on("change", function( ) { that.readFile( this, that.uploadSlip, "upload-slip-wrap" ); });

            $(".deleteLogo").on("click", function( ) {
                that.deleteLogo( $(this).attr("data-text") );
                return false;
            });

            that.validator = $("#companyForm").validate({
                ignore: "",
                rules: {
                    regNumber: { required: true }
                },
                messages: {
                    regNumber: Aurora.i18n.GlobalRes.LANG_PROVIDE_ALL_REQUIRED
                },
                highlight: function(element, errorClass, validClass) {
                    var elem = $(element);
                    if( elem.hasClass("select2-hidden-accessible") ) {
                        $("#select2-" + elem.attr("id") + "-container").parent( ).addClass("border-danger");
                    }
                    else {
                        elem.addClass("border-danger");
                    }
                },
                unhighlight: function(element, errorClass, validClass) {
                    var elem = $(element);
                    if( elem.hasClass("select2-hidden-accessible") ) {
                        $("#select2-" + elem.attr("id") + "-container").parent( ).removeClass("border-danger");
                    }
                    else {
                        elem.removeClass("border-danger");
                    }
                },
                // Different components require proper error label placement
                errorPlacement: function(error, element) {
                    $("#error").append(error);
                    if( $("#error .error").length == 0 )
                        $("#error").append(error);
                },
                submitHandler: function( ) {
                    $("#expense-error").remove( );

                    var data = {
                        bundle: {
                            data: Aurora.WebService.serializePost("#companyForm")
                        },
                        success: function( res ) {
                            var obj = $.parseJSON( res );

                            if( obj.bool == 0 ) {
                                swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                                return;
                            }
                            else {
                                if( that.uploadCompanySelected ) {
                                    that.upload( "uploadCompany", that.uploadCompany );
                                }
                                else if( that.uploadSlipSelected ) {
                                    that.upload( "uploadSlip", that.uploadSlip );
                                }
                                else {
                                    that.updateAll( );
                                }

                            }
                        }
                    };
                    Aurora.WebService.AJAX( "admin/company/saveCompanySettings", data );
                }
            });
        },


        initUpload: function( id ) {
            return $("#" + id).croppie({
                viewport: {
                    width: 424,
                    height: 116,
                },
                enableExif: true
            });
        },


        readFile: function( input, uploader, wrapper ) {
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
                            that.uploadCompanySelected = true;
                        }
                        else {
                            $(".payslipLogoBG").removeClass("hide");
                            $(".defPayslipLogo").hide( );
                            that.uploadSlipSelected = true;
                        }
                    });
                }
                reader.readAsDataURL( input.files[0] );
            }
            else {
                swal("Sorry - your browser doesn't support the FileReader API");
            }
        },


        upload: function( id, uploader ) {
            var that = this;

            uploader.croppie("result", {
                type: "canvas",
                size: "viewport"
            }).then(function( respond ) {
                var data = {};

                if( id == "uploadCompany" ) {
                    data = {
                        bundle: {
                            companyLogo: encodeURIComponent( respond )
                        },
                        success: function( res, ladda ) {
                            if( that.uploadSlipSelected ) {
                                that.upload( "uploadSlip", that.uploadSlip );
                            }
                            else {
                                that.updateAll( );
                            }
                        }
                    };
                }
                else {
                    data = {
                        bundle: {
                            slipLogo: encodeURIComponent( respond )
                        },
                        success: function( res, ladda ) {
                            that.updateAll( );
                        }
                    };
                }
                Aurora.WebService.AJAX( "admin/company/saveCompanySettings", data );
            });
        },


        updateAll: function( ) {
            swal({
                title: Markaxis.i18n.CompanyRes.LANG_COMPANY_UPDATED_SUCCESSFULLY,
                text: Aurora.i18n.GlobalRes.LANG_PLEASE_HOLD_REFRESH,
                type: 'success'
            }, function( isConfirm ) {
                window.location.reload(false);
            });
        },


        deleteLogo: function( dataText ) {
            title = Markaxis.i18n.CompanyRes.LANG_CONFIRM_DELETE_LOGO.replace('{dataText}', dataText);
            text  = Markaxis.i18n.CompanyRes.LANG_CONFIRM_DELETE_LOGO_DESCRIPT;
            confirmButtonText = Aurora.i18n.GlobalRes.LANG_CONFIRM_DELETE;

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
                            swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            $(".photo-wrap-" + dataText).remove( );
                            $(".def" + dataText + "Logo img").removeClass("hide");
                            swal( Aurora.i18n.GlobalRes.LANG_DONE + "!", Markaxis.i18n.CompanyRes.LANG_LOGO_SUCCESSFULLY_DELETED.replace('{datatext}', datatext), "success");
                            return;
                        }
                    }
                };
                Aurora.WebService.AJAX( "admin/company/deleteLogo", data );
            });
        }
    }
    return MarkaxisCompany;
})();
var markaxisCompany = null;
$(document).ready( function( ) {
    markaxisCompany = new MarkaxisCompany( );
});