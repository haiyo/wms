
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: aurora.login.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

$(document).ready( function( ) {
    $("#username").focus( );

    $("#loginForm").validate({
        rules: {
            username: { required: true },
            password: "required"
        },
        messages: {
            username: Aurora.i18n.LoginRes.LANG_ENTER_VALID_USERNAME,
            password: Aurora.i18n.LoginRes.LANG_ENTER_PASSWORD
        },
        submitHandler: function( ) {
            var data = {
                bundle: {
                    auroraLogin: 1,
                    laddaClass : ".btn",
                    username: $("#username").val( ),
                    password: $("#password").val( )
                },
                success: function( res, ladda ) {
                    ladda.stop( );

                    var obj = $.parseJSON( res );
                    console.log(obj)
                    if( obj.error ) {
                        if( obj.error == 'loginError' ) {
                            swal({
                                type: "error",
                                title: Aurora.i18n.LoginRes.LANG_LOGIN_ERROR,
                                text: Aurora.i18n.LoginRes.LANG_INVALID_LOGIN,
                            })
                            return;
                        }
                        else if( obj.error == 'unavailable' ) {
                            swal({
                                type: "error",
                                title: Aurora.i18n.LoginRes.LANG_OOPS,
                                text: Aurora.i18n.LoginRes.LANG_SERVICE_UNAVAILABLE,
                            })
                            return;
                        }
                    }
                    else {
                        $("#loginForm").fadeOut("slow", function( ) {
                            window.location = Aurora.ROOT_URL + 'admin/dashboard/';
                            return;
                        });
                    }
                }
            };
            Aurora.WebService.AJAX( "admin/", data );
        }
    });

    $("#forgotForm").validate({
        rules: {
            email: { required: true }
        },
        messages: {
            email: Aurora.i18n.LoginRes.LANG_PLEASE_ENTER_EMAIL
        },
        submitHandler: function( ) {
            var data = {
                bundle: {
                    auroraForgotPassword: 1,
                    laddaClass : ".btn",
                    email: $("#email").val( )
                },
                success: function( res, ladda ) {
                    ladda.stop( );

                    var obj = $.parseJSON( res );
                    console.log(obj)
                    if( obj.error ) {
                        if( obj.bool == 0 ) {
                            swal({
                                type: "error",
                                title: Aurora.i18n.ForgotPasswordRes.LANG_ERROR,
                                text: obj.errMsg,
                            })
                            return;
                        }
                    }
                    else {
                        swal( Aurora.i18n.ForgotPasswordRes.LANG_SENT,
                              Aurora.i18n.ForgotPasswordRes.LANG_LINK_SEND_TO + $("#email").val( ) + "!", "success");
                    }
                }
            };
            Aurora.WebService.AJAX( "admin/forgotPassword", data );
        }
    });

    $("#forgotPassword").click(function( ) {
        $("#loginForm").fadeOut("slow", function( ) {
            $("#forgotForm").fadeIn("fast", function( ) {
                $("#email").focus( );
            });
        });
    });

    $("#loginFormBack").click(function( ) {
        $("#forgotForm").fadeOut("slow", function( ) {
            $("#loginForm").fadeIn("fast", function( ) {
                $("#username").focus( );
            });
        });
    });
});