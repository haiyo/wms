<style>
    .navbar-expand-md { background-color:#<?TPLVAR_MAIN_COLOR?> !important;}
    button {background-color:#<?TPLVAR_BUTTON_COLOR?> !important;border-color:#<?TPLVAR_BUTTON_COLOR?> !important;}
    @media (min-width: 576px) {
        .loginForm, .forgotForm {
            width:420px;
        }
        .login-content {
            margin-top: 100px;
        }
    }
</style>
<div class="content login-content d-flex justify-content-center align-items-center">
    <form id="loginForm" class="loginForm" method="post" action="">
        <div class="card login-card mb-0">
            <div class="card-body">
                <div class="text-center mb-3">
                    <i class="icon-reading icon-2x text-slate-300 border-slate-300 border-3 rounded-round p-3 mb-3 mt-1"></i>
                    <h5 class="mb-0"><?LANG_LOGIN_TO_ACCOUNT?></h5>
                    <span class="d-block text-muted"><?LANG_ENTER_CREDENTIALS?></span>
                </div>

                <div class="form-group form-group-feedback form-group-feedback-left">
                    <input name="username" id="username" type="text" class="form-control input-lg" placeholder="<?LANG_USERNAME?>" />
                    <div class="form-control-feedback">
                        <i class="icon-user text-muted"></i>
                    </div>
                </div>

                <div class="form-group form-group-feedback form-group-feedback-left">
                    <input type="password" name="password" id="password" class="form-control input-lg" placeholder="<?LANG_PASSWORD?>" />
                    <div class="form-control-feedback">
                        <i class="icon-lock2 text-muted"></i>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block btn-ladda">
                        <span class="ladda-label"><?LANG_SIGN_IN?> <i class="icon-circle-right2 ml-2"></i></span>
                    </button>
                </div>
                <div class="text-center">
                    <a id="forgotPassword"><?LANG_FORGOT_PASSWORD?></a>
                </div>
            </div>
        </div>
    </form>

    <form id="forgotForm" class="forgotForm" action="" style="display:none;">
        <div class="card login-card mb-0">
            <div class="card-body">
                <div class="text-center mb-3">
                    <i class="icon-spinner11 icon-2x text-warning border-warning border-3 rounded-round p-3 mb-3 mt-1"></i>
                    <h5 class="mb-0"><?LANG_PASSWORD_RECOVERY?></h5>
                    <span class="d-block text-muted"><?LANG_SEND_INSTRUCTIONS?></span>
                </div>

                <div class="form-group form-group-feedback form-group-feedback-right">
                    <input type="email" id="email" class="form-control" placeholder="<?LANG_YOUR_EMAIL?>" />
                    <div class="form-control-feedback">
                        <i class="icon-mail5 text-muted"></i>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block btn-ladda">
                        <span class="ladda-label"><?LANG_RESET_PASSWORD?> <i class="icon-spinner11 mr-2"></i></span>
                    </button>
                </div>
                <div class="text-center">
                    <a id="loginFormBack"><?LANG_BACK_TO_LOGIN?></a>
                </div>
            </div>
        </div>
    </form>
</div>