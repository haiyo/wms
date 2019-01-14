
  
  <!--<div class="loginFormWrapper">
    <div class="login">
    <h2><?LANG_LOGIN_TITLE?></h2>
    <div style="float:left; width:100%;"><?LANG_LOGIN_DESCRIPT?></div>
    <form id="loginForm" name="loginForm" method="post" action="">
    <input name="login" type="hidden" value="1" />
      <div class="field"><input type="text" name="email" id="email" class="textfield textFade" title="<?LANG_EMAIL_ADDRESS?>" value="<?LANG_EMAIL_ADDRESS?>" /></div>
      <div class="field"><input type="password" name="password" id="password" class="textfield textFade" title="Password" /></div>
      <div class="buttons field">
        <button type="submit"><?LANG_SIGN_IN?></button>
        <div class="forgotPwd"><a href=""><?LANG_FORGOT_PASSWORD?></a></div>
        <div class="loginSpinner"><images src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/core/images/<?TPLVAR_THEME?>/spinnerGrey16.gif" /></div>
      </div>
    </form>
    </div>
  </div>-->

  <!-- start: page -->
  <section class="body-sign body-locked">
    <div class="center-sign">

                <div class="panel panel-sign">
                    <div class="panel-body">


                        <form id="loginForm" name="loginForm" method="post" action="">

                                <div class="current-user text-center">
                                    <img src="http://preview.oklerthemes.com/porto-admin/1.7.0/assets/images/!logged-user.jpg" alt="John Doe" class="img-circle user-image">
                                    <h2 class="user-name text-dark m-none">John Doe</h2>
                                    <p class="user-email m-none">johndoe@okler.com</p>
                                </div>

                            <div class="form-group mb-lg">
                                <div class="input-group input-group-icon">
                                    <input name="username" id="username" type="text" class="form-control input-lg" placeholder="Username" />
                                        <span class="input-group-addon">
                                            <span class="icon icon-lg">
                                                <i class="fa fa-user"></i>
                                            </span>
                                        </span>
                                </div>
                                </div>

                                <div class="form-group mb-lg">
                                    <div class="input-group input-group-icon">
                                        <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" />
                                        <span class="input-group-addon">
                                            <span class="icon icon-lg">
                                                <i class="fa fa-lock"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-6">
                                        <p class="mt-xs mb-none">
                                            <a href="#">Not John Doe?</a>
                                        <div class="loginSpinner"><img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/core/img/<?TPLVAR_THEME?>/spinnerGrey16.gif" style="display:none;" /></div>
                                        </p>
                                    </div>
                                    <div class="col-xs-6 text-right">
                                        <button type="submit" class="btn btn-primary"><?LANG_SIGN_IN?></button>
                                    </div>
                                </div>
                        </form>


                    </div>
                </div>
                <p class="text-center text-muted mt-md mb-md">&copy; Copyright 2017 Markaxis. All Rights Reserved.</p>
    </div>
  </section>

