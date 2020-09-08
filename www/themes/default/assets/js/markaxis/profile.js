/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: profile.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisProfile = (function( ) {


    /**
     * MarkaxisProfile Constructor
     * @return void
     */
    MarkaxisProfile = function( ) {
        this.uploadCrop = false;
        this.init( );
    };

    MarkaxisProfile.prototype = {
        constructor: MarkaxisProfile,

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

            $.validator.addMethod("validChildren", function(value, element) {
                if( $("#children1").is(":checked") ) {
                    var error = false;

                    if( $("#haveChildren .childName").length > 0 ) {
                        $("#haveChildren .childRow").each(function( ) {
                            if( $.trim( $(this).find(".childName").val( ) ) == "" ) {
                                error = true;
                                return false;
                            }
                            if( $(this).find(".childCountry").val( ) == "" ) {
                                error = true;
                                return false;
                            }
                            if( $(this).find(".childDobDay").val( ) == "" ) {
                                error = true;
                                return false;
                            }
                            if( $(this).find(".childDobMonth").val( ) == "" ) {
                                error = true;
                                return false;
                            }
                            if( $.trim( $(this).find(".childDobYear").val( ) ) == "" ) {
                                error = true;
                                return false;
                            }
                        });
                    }
                    if( !error )
                        return true;
                }
                else
                    return true;

            }, Markaxis.i18n.EmployeeRes.LANG_ENTER_VALID_CHILD);


            $.validator.addMethod("validEmail", function(value, element) {
                if( value == '' ) return true;

                var ind  = value.indexOf('@');
                var str2 = value.substr(ind+1);
                var str3 = str2.substr(0,str2.indexOf('.'));
                if( str3.lastIndexOf('-') === (str3.length-1) ||
                    (str3.indexOf('-') !== str3.lastIndexOf('-')) )
                    return false;

                var str1 = value.substr(0,ind );
                if( (str1.lastIndexOf('_') === (str1.length-1)) ||
                    (str1.lastIndexOf('.') === (str1.length-1)) ||
                    (str1.lastIndexOf('-') === (str1.length-1)) )
                    return false;
                str = /(^[a-zA-Z0-9]+[\._-]{0,1})+([a-zA-Z0-9]+[_]{0,1})*@([a-zA-Z0-9]+[-]{0,1})+(\.[a-zA-Z0-9]+)*(\.[a-zA-Z]{2,3})$/;
                temp1 = str.test(value);
                return temp1;
            }, "Please enter valid email address.");


            $("#employeeForm").validate({
                ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
                successClass: 'validation-valid-label',
                highlight: function( element, errorClass ) {
                    $(element).addClass("border-danger");
                },
                unhighlight: function( element, errorClass ) {
                    $(element).removeClass("border-danger");
                },
                // Different components require proper error label placement
                errorPlacement: function( error, element ) {
                    $("#buttonWrapper .error").remove( );
                    $("#buttonWrapper").prepend(error);
                },
                rules: {
                    fname : "required",
                    lname : "required",
                    idnumber : "required",
                    email1: {
                        validEmail: true,
                        required: true
                    },
                    children: {
                        validChildren: true
                    }
                },
                submitHandler: function( ) {
                    $("#buttonWrapper .error").remove( );
                    that.saveEmployeeForm( );
                }
            });

            $("#dobMonth").select2({minimumResultsForSearch: -1});
            $("#dobDay").select2({minimumResultsForSearch: -1});
            $("#nationality").select2( );
            $("#country").select2( );
            $("#state").select2( );
            $("#city").select2( );
            $(".relationship").select2( );
            $("#language").select2({minimumResultsForSearch: -1});
            $(".raceList").select2({minimumResultsForSearch: -1});
            $(".maritalList").select2({minimumResultsForSearch: -1});
            $(".salaryTypeList").select2({minimumResultsForSearch: -1});
            $(".paymentMethodList").select2({minimumResultsForSearch: -1});
            $("#pcID").select2({minimumResultsForSearch: -1});
            $("#tgID").multiselect({includeSelectAllOption: true});
            $("#ltID").multiselect({includeSelectAllOption: true});

            $(".styled").uniform({
                radioClass: 'choice'
            });

            $(".file-styled").uniform({
                fileButtonClass: 'action btn bg-blue'
            });

            $("#autoGenPwd").on("click", function ( ) {
                that.autoGenPwd();
                return false;
            });

            $("#showPwd").on("click", function() {
                if( $("#loginPassword").attr("type") == "text" ) {
                    $("#loginPassword").attr("type", "password");
                }
                else {
                    $("#loginPassword").attr("type", "text");
                }
            });

            // Editing with existing children
            if( $("#children1").is(":checked") ) {
                $("#haveChildren").removeClass("hide");
            }

            $('input:radio[name="children"]').change(function( ) {
                if( $(this).val( ) == 1 ) {
                    $("#haveChildren").removeClass("hide");

                    if( $("#childWrapper .childRow").length == 0 ) {
                        that.addChildren();
                    }
                }
                else {
                    if( !$("#haveChildren").hasClass("hide") ) {
                        $("#haveChildren").addClass("hide");
                    }
                }
            });

            if( $(".childRow").length > 0 ) {
                $(".childSelect").select2( );
            }

            $(document).on("click", ".addChildren", function ( ) {
                that.addChildren( );
                return false;
            });

            $(document).on("click", ".removeChildren", function ( ) {
                var id = $(this).attr("href");
                $("#childRowWrapper_" + id).html("").hide();

                if( $("#childWrapper .childRow").length == 0 ) {
                    $("#children2").click( );
                    $.uniform.update( );
                }
                return false;
            });

            $("#loginPassword").keypress(function(e) {
                var s = String.fromCharCode( e.which );

                if((s.toUpperCase() === s && s.toLowerCase() !== s && !e.shiftKey) ||
                    (s.toUpperCase() !== s && s.toLowerCase() === s && e.shiftKey)) {
                    $("#capsLockWarn").removeClass("hide");
                }
                else {
                    $("#capsLockWarn").addClass("hide");
                }
            });

            this.uploadCrop = $("#upload-demo").croppie({
                viewport: {
                    width: 306,
                    height: 306,
                    //type: "circle"
                },
                enableExif: true
            });
            $("#upload").on("change", function( ) { that.readFile(this); });

            $(".form-check-input-styled").uniform();

            $(".deletePhoto").on("click", function( ) {
                title = Markaxis.i18n.EmployeeRes.LANG_CONFIRM_DELETE_PHOTO.replace('{name}', $("#employeeName").text());
                text  = Markaxis.i18n.EmployeeRes.LANG_PHOTO_DELETED_UNDONE;
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

                    $(".icon-bin").removeClass("icon-bin").addClass("icon-spinner2 spinner");

                    var data = {
                        bundle: {
                            userID : $("#userID").val( )
                        },
                        success: function( res ) {
                            var obj = $.parseJSON( res );
                            if( obj.bool == 0 ) {
                                swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                                return;
                            }
                            else {
                                $(".photo-wrap").remove( );
                                $(".defPhoto").removeClass("hide");
                                swal( Aurora.i18n.GlobalRes.LANG_DONE + "!", Markaxis.i18n.EmployeeRes.LANG_PHOTO_SUCCESSFULLY_DELETED.replace('{name}', $("#employeeName").text()), "success");
                                return;
                            }
                        }
                    };
                    Aurora.WebService.AJAX( "admin/user/deletePhoto", data );
                });
            });

            $(".upload-cancel").on("click", function( ev ) {
                $(".upload-demo-wrap").removeClass('ready');
                $(".caption").removeClass("mt-30");
                $("#upload").val("");

                that.uploadCrop.croppie('bind', {
                    url : ''
                }).then(function () {
                    console.log('reset complete');
                });
                return false;
            });
        },

        addChildren: function( ) {
            var length = $("#childWrapper .childRow").length;
            var child = $("#childTemplate").html( );
            child = child.replace(/\{id\}/g, length );
            $("#addChildren").append( '<div id="childRowWrapper_' + length + '">' + child + "</div>" );

            $("#childRowWrapper_" + length).find(".select2").remove( );

            $("#childCountry_" + length).select2( );
            $("#childDobMonth_" + length).select2( );
            $("#childDobDay_" + length).select2( );

            var id = $("#childWrapper .childRow").length-2;
            $("#plus_" + id).attr( "class", "icon-minus-circle2" );
            $("#plus_" + id).parent().attr( "class", "removeChildren" );
        },

        /**
         * Auto Generate Random Password
         * @return void
         */
        autoGenPwd: function( ) {
            let low = "abcdefghjkmnpqrstuvwxyz";
            let mid = "@#$%&_";
            let hig = "ABCDEFGHJKLMNPQRSTUVWXYZ";
            let num = "123456789";
            let pass = "";

            for( var x=0; x<2; x++ ) {
                let i = Math.floor( Math.random( ) * low.length );
                pass += low.charAt( i );

                i = Math.floor( Math.random( ) * mid.length );
                pass += mid.charAt( i );

                i = Math.floor( Math.random( ) * hig.length );
                pass += hig.charAt( i );

                i = Math.floor( Math.random( ) * num.length );
                pass += num.charAt( i );
            }
            $("#loginPassword").val( pass );
        },

        readFile: function( input ) {
            var that = this;

            if( input.files && input.files[0] ) {
                var reader = new FileReader( );
                reader.onload = function (e) {
                    $(".upload-demo-wrap").addClass('ready');
                    $(".caption").addClass("mt-30");

                    that.uploadCrop.croppie('bind', {
                        url: e.target.result
                    }).then(function(){
                        console.log('jQuery bind complete');
                    });
                }
                reader.readAsDataURL(input.files[0]);
            }
            else {
                swal("Sorry - your browser doesn't support the FileReader API");
            }
        },


        /**
         * Save Employee Data
         * @return void
         */
        saveEmployeeForm: function( ) {
            this.uploadCrop.croppie("result", {
                type: "canvas",
                size: "viewport"
            }).then(function( resp ) {
                var formData = Aurora.WebService.serializePost("#employeeForm");

                var data = {
                    bundle: {
                        laddaClass: ".btn-ladda",
                        data: formData,
                        image: encodeURIComponent( resp )
                    },
                    success: function( res, ladda ) {
                        ladda.stop( );

                        var obj = $.parseJSON( res );
                        if( obj.bool == 0 ) {
                            swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            swal({
                                title: Markaxis.i18n.EmployeeRes.LANG_PROFILE_UPDATED,
                                text: Aurora.i18n.GlobalRes.LANG_PLEASE_HOLD_REFRESH,
                                type: 'success'
                            }, function( isConfirm ) {
                                window.location.reload(false);
                            });
                        }
                    }
                };
                Aurora.WebService.AJAX( "admin/user/saveProfile", data );
            });
        }
    }
    return MarkaxisProfile;
})();
var markaxisProfile = null;
$(document).ready( function( ) {
    markaxisProfile = new MarkaxisProfile( );
});