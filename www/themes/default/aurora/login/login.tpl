<style>
    @media (min-width: 576px) {
        .loginForm, .forgotForm {
            width:370px;
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
                    <h5 class="mb-0">Login to your account</h5>
                    <span class="d-block text-muted">Enter your credentials below</span>
                </div>

                <div class="form-group form-group-feedback form-group-feedback-left">
                    <input name="username" id="username" type="text" class="form-control input-lg" placeholder="Username" />
                    <div class="form-control-feedback">
                        <i class="icon-user text-muted"></i>
                    </div>
                </div>

                <div class="form-group form-group-feedback form-group-feedback-left">
                    <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" />
                    <div class="form-control-feedback">
                        <i class="icon-lock2 text-muted"></i>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block btn-ladda">
                        <span class="ladda-label">Sign in <i class="icon-circle-right2 ml-2"></i></span>
                    </button>
                </div>
                <div class="text-center">
                    <a id="forgotPassword">Forgot password?</a>
                </div>
            </div>
        </div>
    </form>

    <form id="forgotForm" class="forgotForm" action="" style="display:none;">
        <div class="card login-card mb-0    ">
            <div class="card-body">
                <div class="text-center mb-3">
                    <i class="icon-spinner11 icon-2x text-warning border-warning border-3 rounded-round p-3 mb-3 mt-1"></i>
                    <h5 class="mb-0">Password recovery</h5>
                    <span class="d-block text-muted">We'll send you instructions in email</span>
                </div>

                <div class="form-group form-group-feedback form-group-feedback-right">
                    <input type="email" id="email" class="form-control" placeholder="Your email" />
                    <div class="form-control-feedback">
                        <i class="icon-mail5 text-muted"></i>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block btn-ladda">
                        <span class="ladda-label">Reset password <i class="icon-spinner11 mr-2"></i></span>
                    </button>
                </div>
                <div class="text-center">
                    <a id="loginFormBack">Back to Login</a>
                </div>
            </div>
        </div>
    </form>
</div>