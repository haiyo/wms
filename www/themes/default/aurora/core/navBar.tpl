<style>
    .navbar-nav {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        padding-left: 0;
        margin-bottom: 0;
        list-style: none;
    }
    .navbar-nav li > a {
        color:#<?TPLVAR_NAVIGATION_TEXT_COLOR?> !important;
        font-size:14px;
    }
    .navbar-nav>li>a:focus,.navbar-nav>li>a:hover {
        color:#<?TPLVAR_NAVIGATION_TEXT_HOVER_COLOR?> !important;
        text-decoration:none;
        background-color:#<?TPLVAR_NAVIGATION_COLOR?> !important;
    }
    .stepy-header li.stepy-active div {
        background-color:#<?TPLVAR_BUTTON_COLOR?> !important;
    }
    .nav-item i {
        margin-right: 5px;
    }
    .dropdown-menu>.dropdown-submenu {
        position: relative;
    }
    .dropdown-menu>.dropdown-submenu>.dropdown-menu {
        top: 0;
        left: 100%;
        margin-top: -.5625rem;
    }
    .dropdown-menu>li>a {
        color: #333 !important;
    }
    .dropdown-menu>li>a:focus, .dropdown-menu>li>a:hover {
        text-decoration: none;
        color: #333 !important;
        background-color: #f5f5f5;
    }
    .btn-primary.active, .btn-primary:active, .open>.dropdown-toggle.btn-primary {
        background-color: #<?TPLVAR_BUTTON_FOCUS_COLOR?> !important;
        border-color: #<?TPLVAR_BUTTON_FOCUS_COLOR?> !important;
    }
    @media (min-width: 768px) {
        .navbar-expand-md .navbar-nav {
            -ms-flex-direction: row;
            flex-direction: row;
        }
        .navbar-expand-md {
            -ms-flex-flow: row nowrap;
            flex-flow: row nowrap;
            -ms-flex-pack: start;
            justify-content: flex-start;
        }
    }
    .navbar-expand-md {
        background-color:#<?TPLVAR_MAIN_COLOR?> !important;
    }
    .navbar-nav-link {
        position: relative;
        display: block;
        cursor: pointer;
        padding: .875em 1em;
        outline: 0;
        transition: all ease-in-out .15s;
    }
</style>
<div class="navbar navbar-expand-md navbar-fixed-top">
    <div class="navbar-header">
        <a class="navbar-brand" href="<?TPLVAR_ROOT_URL?>admin/dashboard">
            <img src="<?TPLVAR_LOGO?>" alt="" />
        </a>

        <ul class="nav navbar-nav visible-xs-block">
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
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
                    <img src="<?TPLVAR_ROOT_URL?>themes/<?TPLVAR_THEME?>/assets/images/face11.jpg" alt="">
                    <span><?TPLVAR_FNAME?> <?TPLVAR_LNAME?></span>
                    <i class="caret"></i>
                </a>

                <ul class="dropdown-menu dropdown-menu-right width-200">
                    <li><a href="#"><i class="icon-user-plus"></i> My profile</a></li>
                    <li><a href="#"><i class="icon-cog5"></i> Account settings</a></li>
                    <li><a href="<?TPLVAR_ROOT_URL?>admin/logout"><i class="icon-switch2"></i> Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>