<style>
    .bg-info{background-color:#<?TPLVAR_MAIN_COLOR?> !important;}
    .navbar-nav>li > a { color:#<?TPLVAR_NAVIGATION_TEXT_COLOR?> !important; font-size:14px; }
    .navbar-nav>li>a:focus,
    .navbar-nav>li>a:hover {color:#<?TPLVAR_NAVIGATION_TEXT_HOVER_COLOR?> !important; text-decoration:none;background-color:#<?TPLVAR_NAVIGATION_COLOR?> !important; }
    .stepy-header li.stepy-active div,.confirm,.bg-purple-400,.btn-primary,.fc-button-primary,.dataTables_paginate .paginate_button.current{background-color:#<?TPLVAR_BUTTON_COLOR?> !important;border-color:transparent !important;}
    .stepy-header li.stepy-active div:after{border-left-color:#<?TPLVAR_BUTTON_COLOR?> !important;}
    .btn-primary.active, .btn-primary:active,
    .open>.dropdown-toggle.btn-primary,.fc-button-active{background-color: #<?TPLVAR_BUTTON_FOCUS_COLOR?> !important; border-color: transparent !important; }
    .navbar-expand-md { background-color:#<?TPLVAR_MAIN_COLOR?> !important; }
    .bg-purple-400:hover,.bg-grey-400:hover,.confirm:hover,.btn-primary:hover,.btn-link:hover,.fc-button-primary:hover{background-color: #<?TPLVAR_BUTTON_HOVER_COLOR?> !important;}
    .dropdown-menu>li.user-header { padding: 10px; text-align: center; color:#fff; background-color: #<?TPLVAR_BUTTON_FOCUS_COLOR?>; }
    .bootstrap-switch-handle-off.bootstrap-switch-primary, .bootstrap-switch-handle-on.bootstrap-switch-primary{background-color:#<?TPLVAR_BUTTON_COLOR?> !important;}
</style>
<div class="navbar navbar-expand-md navbar-fixed-top">
    <div class="navbar-header">
        <a class="navbar-brand" href="<?TPLVAR_ROOT_URL?>admin/dashboard">
            <img src="<?TPLVAR_ROOT_URL?>admin/company/logo/main" alt="" />
        </a>

        <ul class="nav navbar-nav visible-xs-block">
            <li class="dropdown dropdown-user">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    <img src="<?TPLVAR_PHOTO?>" class="small" />
                    <span><?TPLVAR_FNAME?> <?TPLVAR_LNAME?></span>
                    <i class="caret"></i>
                </a>

                <ul class="dropdown-menu dropdown-menu-user dropdown-menu-right width-300">
                    <li class="user-header">
                        <img src="<?TPLVAR_PHOTO?>" width="90" height="90" />

                        <div class="dropdown-menu-username text-ellipsis"><h4><?TPLVAR_FNAME?> <?TPLVAR_LNAME?></h4></div>
                        <div><small><?TPLVAR_DESIGNATION?></small></div>
                        <div><small><?LANG_EMPLOYEE_SINCE?> <?TPLVAR_START_DATE?></small></div>
                    </li>
                    <li><a href="<?TPLVAR_ROOT_URL?>admin/user/profile"><i class="icon-user"></i> <?LANG_EDIT_PROFILE?></a></li>
                    <!--<li><a href="<?TPLVAR_ROOT_URL?>admin/user/settings"><i class="icon-cog5"></i> Account settings</a></li>-->
                    <li><a href="<?TPLVAR_ROOT_URL?>admin/logout"><i class="icon-switch2"></i> <?LANG_LOGOUT?></a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a id="notification" href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-bell2"></i>
                    <span id="notificationCount" class="badge bg-warning-400"></span>
                </a>
                <?TPL_NOTIFICATION_WINDOW?>
            </li>
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-menu3"></i></a></li>
        </ul>
    </div>

    <div class="navbar-collapse collapse" id="navbar-mobile">
        <?TPL_MENU?>

        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a id="notification" href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-bell2"></i>
                    <span id="notificationCount" class="badge bg-warning-400"></span>
                </a>
                <?TPL_NOTIFICATION_WINDOW?>
            </li>

            <li class="dropdown dropdown-user">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    <img src="<?TPLVAR_PHOTO?>" class="small" />
                    <span><?TPLVAR_FNAME?> <?TPLVAR_LNAME?></span>
                    <i class="caret"></i>
                </a>

                <ul class="dropdown-menu dropdown-menu-user dropdown-menu-right width-300">
                    <li class="user-header">
                        <img src="<?TPLVAR_PHOTO?>" width="90" height="90" />

                        <div class="dropdown-menu-username text-ellipsis"><h4><?TPLVAR_FNAME?> <?TPLVAR_LNAME?></h4></div>
                        <div><small><?TPLVAR_DESIGNATION?></small></div>
                        <div><small><?LANG_EMPLOYEE_SINCE?> <?TPLVAR_START_DATE?></small></div>
                    </li>
                    <li><a href="<?TPLVAR_ROOT_URL?>admin/user/profile"><i class="icon-user"></i> <?LANG_EDIT_PROFILE?></a></li>
                    <!--<li><a href="<?TPLVAR_ROOT_URL?>admin/user/settings"><i class="icon-cog5"></i> Account settings</a></li>-->
                    <li><a href="<?TPLVAR_ROOT_URL?>admin/logout"><i class="icon-switch2"></i> <?LANG_LOGOUT?></a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>