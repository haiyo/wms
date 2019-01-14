<script>
    $(document).ready( function( ) {
        $("#chgPwdForm").validate({
            rules: {
                password: { required: true },
                cPassword: { required: true }
            },
            messages: {
                password: Aurora.i18n.ForgotPasswordRes.LANG_PLEASE_ENTER_PASSWORD,
                cPassword: Aurora.i18n.ForgotPasswordRes.LANG_PLEASE_RE_ENTER_PASSWORD
            },
            submitHandler: function( ) {
                var password = $("#password").val( );
                var cPassword = $("#cPassword").val( );

                if( password != cPassword ) {
                    swal({
                        type: "error",
                        title: Aurora.i18n.ForgotPasswordRes.LANG_PASSWORD_MISMATCH,
                        text: Aurora.i18n.ForgotPasswordRes.LANG_PASSWORD_MISMATCH_DESCRIPTION,
                    })
                }
                else {
                    var data = {
                        bundle: {
                            auroraForgotPassword: 1,
                            laddaClass : ".btn",
                            token: $("#token").val( ),
                            password: password,
                            cPassword: cPassword
                        },
                        success: function( res, ladda ) {
                            ladda.stop( );

                            var obj = $.parseJSON( res );
                            if( obj.bool == 0 ) {
                                swal({
                                    type: "error",
                                    title: Aurora.i18n.ForgotPasswordRes.LANG_ERROR,
                                    text: obj.errMsg,
                                })
                                return;
                            }
                            else {
                                swal({
                                        type: "success",
                                        title: Aurora.i18n.ForgotPasswordRes.LANG_DONE,
                                        text: Aurora.i18n.ForgotPasswordRes.LANG_GO_TO_LOGIN
                                    },
                                    function( ) {
                                        window.location.href = Aurora.ROOT_URL + 'admin';
                                    });
                            }
                        }
                    };
                    Aurora.WebService.AJAX("admin/changePassword", data);
                }
            }
        });
    });
</script>


<div class="content login-content d-flex justify-content-center align-items-center">
    <form id="chgPwdForm" class="chgPwdForm" action="">
        <input type="hidden" id="token" value="<?TPLVAR_TOKEN?>" />
        <div class="card login-card mb-0    ">
            <div class="card-body">
                <div class="text-center mb-3">
                    <i class="icon-spinner11 icon-2x text-warning border-warning border-3 rounded-round p-3 mb-3 mt-1"></i>
                    <h5 class="mb-0"><?LANG_RESET_PASSWORD?></h5>
                    <span class="d-block text-muted"><?LANG_RESET_PASSWORD_DESCRIPTION?></span>
                </div>

                <div class="form-group form-group-feedback form-group-feedback-right">
                    <input type="password" id="password" name="password" class="form-control" placeholder="<?LANG_NEW_PASSWORD?>" />
                    <div class="form-control-feedback">
                        <i class="icon-lock2 text-muted"></i>
                    </div>
                </div>

                <div class="form-group form-group-feedback form-group-feedback-right">
                    <input type="password" id="cPassword" name="cPassword" class="form-control" placeholder="<?LANG_RE_ENTER_PASSWORD?>" />
                    <div class="form-control-feedback">
                        <i class="icon-lock2 text-muted"></i>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block btn-ladda">
                        <span class="ladda-label"><?LANG_RESET_PASSWORD?> <i class="icon-spinner11 mr-2"></i></span>
                    </button>
                </div>
                <div class="text-center">
                    <a href="<?TPLVAR_ROOT_URL?>admin"><?LANG_CANCEL?></a>
                </div>
            </div>
        </div>
    </form>
</div>