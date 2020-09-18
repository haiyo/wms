/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: support.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var AuroraSupport = (function( ) {

    /**
     * AuroraSupport Constructor
     * @return void
     */
    AuroraSupport = function( ) {
        this.validator = false;
        this.rules = false;
        this.fileSelected = false;
        this.init( );
    };

    AuroraSupport.prototype = {
        constructor: AuroraSupport,

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

            $("#modalSupport").on("shown.bs.modal", function(e) {
                $("#supportSubject").focus( );
            });

            $("#sendSupport").on("click", function ( ) {
                that.validator = $("#supportForm").validate( that.rules );

                if( $("#supportForm").valid( ) ) {
                    that.sendSupport( );
                }
                return false;
            });

            that.rules = {
                ignore: "",
                rules: {
                    supportSubject: { required: true },
                    supportDescript: { required: true }
                },
                messages: {
                    supportSubject: Aurora.i18n.GlobalRes.LANG_PROVIDE_ALL_REQUIRED,
                    supportDescript: Aurora.i18n.GlobalRes.LANG_PROVIDE_ALL_REQUIRED
                },
                highlight: function(element, errorClass, validClass) {
                    var elem = $(element);
                    elem.addClass("border-danger");
                },
                unhighlight: function(element, errorClass, validClass) {
                    var elem = $(element);
                    elem.removeClass("border-danger");
                },
                // Different components require proper error label placement
                errorPlacement: function(error, element) {
                    if( $("#supportForm .modal-footer .error").length > 0 ) {
                        $("#supportForm .modal-footer .error").remove( );
                    }
                    $("#supportForm .modal-footer").append( error );
                }
            };

            $(".fileSupportInput").fileinput({
                uploadUrl: Aurora.ROOT_URL + "admin/support/upload",
                uploadAsync: false,
                showUpload: false,
                maxFileCount: 1,
                allowedFileExtensions: ['jpg', 'png', 'pdf', 'doc', 'docx'],
                showPreview: false,
                uploadExtraData: function(previewId, index) {
                    var data = {
                        csrfToken: Aurora.CSRF_TOKEN
                    };
                    return data;
                }
            }).on('fileuploaderror', function(event, data, msg) {
                that.fileSelected = false;
                console.log('File uploaded', data, msg);

            }).on('filebatchuploadsuccess', function(event, data) {
                that.sendForm( data.response.uID );
            });

            $(".fileSupportInput").change(function () {
                that.fileSelected = true;
            });
        },


        sendSupport: function( ) {
            if( this.fileSelected ) {
                $(".fileSupportInput").fileinput("upload");
            }
            else {
                this.sendForm( 0 );
            }
        },


        sendForm: function( uID ) {
            var formData = Aurora.WebService.serializePost("#supportForm");

            var data = {
                bundle: {
                    laddaClass: "#sendSupport",
                    data: formData,
                    uID: uID
                },
                success: function( res, ladda ) {
                    ladda.stop( );

                    var obj = $.parseJSON( res );
                    if( obj.bool == 0 ) {
                        swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                        return;
                    }
                    else {
                        swal( Aurora.i18n.GlobalRes.LANG_DONE + "!", "Your Message Has Been Sent!", "success");
                        $("#modalSupport").modal("hide");
                        $("#supportSubject").val("");
                        $("#supportDescript").val("");
                        return;
                    }
                }
            };
            Aurora.WebService.AJAX( "admin/support/send", data );
        }
    }
    return AuroraSupport;
})();
var auroraSupport = null;
$(document).ready( function( ) {
    auroraSupport = new AuroraSupport( );
});