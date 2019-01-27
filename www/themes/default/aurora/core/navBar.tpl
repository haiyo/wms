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
        color:#fff;
        font-size:14px;
    }
    .navbar-nav>li>a:focus,.navbar-nav>li>a:hover{text-decoration:none;background-color:rgb(126,87,194,.4);}

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
        background-color: #4e3e61;
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
            <img src="<?TPLVAR_ROOT_URL?>themes/<?TPLVAR_THEME?>/assets/images/logo.png" alt="">
        </a>

        <ul class="nav navbar-nav visible-xs-block">
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
        </ul>
    </div>

    <div class="navbar-collapse collapse" id="navbar-mobile">
        <?TPL_MENU?>

        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown language-switch">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    <img src="assets/images/flags/gb.png" class="position-left" alt="">
                    English
                    <span class="caret"></span>
                </a>

                <!--<ul class="dropdown-menu">
                    <li><a class="deutsch"><img src="assets/images/flags/de.png" alt=""> Deutsch</a></li>
                    <li><a class="ukrainian"><img src="assets/images/flags/ua.png" alt=""> Українська</a></li>
                    <li><a class="english"><img src="assets/images/flags/gb.png" alt=""> English</a></li>
                    <li><a class="espana"><img src="assets/images/flags/es.png" alt=""> España</a></li>
                    <li><a class="russian"><img src="assets/images/flags/ru.png" alt=""> Русский</a></li>
                </ul>-->
            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-bubbles4"></i>
                    <span class="visible-xs-inline-block position-right">Messages</span>
                    <span class="badge bg-warning-400">2</span>
                </a>

                <div class="dropdown-menu dropdown-content width-350">
                    <div class="dropdown-content-heading">
                        Messages
                        <ul class="icons-list">
                            <li><a href="#"><i class="icon-compose"></i></a></li>
                        </ul>
                    </div>

                    <ul class="media-list dropdown-content-body">
                        <li class="media">
                            <div class="media-left">
                                <img src="assets/images/demo/users/face10.jpg" class="img-circle img-sm" alt="">
                                <span class="badge bg-danger-400 media-badge">5</span>
                            </div>

                            <div class="media-body">
                                <a href="#" class="media-heading">
                                    <span class="text-semibold">James Alexander</span>
                                    <span class="media-annotation pull-right">04:58</span>
                                </a>

                                <span class="text-muted">who knows, maybe that would be the best thing for me...</span>
                            </div>
                        </li>

                        <li class="media">
                            <div class="media-left">
                                <img src="assets/images/demo/users/face3.jpg" class="img-circle img-sm" alt="">
                                <span class="badge bg-danger-400 media-badge">4</span>
                            </div>

                            <div class="media-body">
                                <a href="#" class="media-heading">
                                    <span class="text-semibold">Margo Baker</span>
                                    <span class="media-annotation pull-right">12:16</span>
                                </a>

                                <span class="text-muted">That was something he was unable to do because...</span>
                            </div>
                        </li>

                        <li class="media">
                            <div class="media-left"><img src="assets/images/demo/users/face24.jpg" class="img-circle img-sm" alt=""></div>
                            <div class="media-body">
                                <a href="#" class="media-heading">
                                    <span class="text-semibold">Jeremy Victorino</span>
                                    <span class="media-annotation pull-right">22:48</span>
                                </a>

                                <span class="text-muted">But that would be extremely strained and suspicious...</span>
                            </div>
                        </li>

                        <li class="media">
                            <div class="media-left"><img src="assets/images/demo/users/face4.jpg" class="img-circle img-sm" alt=""></div>
                            <div class="media-body">
                                <a href="#" class="media-heading">
                                    <span class="text-semibold">Beatrix Diaz</span>
                                    <span class="media-annotation pull-right">Tue</span>
                                </a>

                                <span class="text-muted">What a strenuous career it is that I've chosen...</span>
                            </div>
                        </li>

                        <li class="media">
                            <div class="media-left"><img src="assets/images/demo/users/face25.jpg" class="img-circle img-sm" alt=""></div>
                            <div class="media-body">
                                <a href="#" class="media-heading">
                                    <span class="text-semibold">Richard Vango</span>
                                    <span class="media-annotation pull-right">Mon</span>
                                </a>

                                <span class="text-muted">Other travelling salesmen live a life of luxury...</span>
                            </div>
                        </li>
                    </ul>

                    <div class="dropdown-content-footer">
                        <a href="#" data-popup="tooltip" title="All messages"><i class="icon-menu display-block"></i></a>
                    </div>
                </div>
            </li>

            <li class="dropdown dropdown-user">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    <img src="<?TPLVAR_ROOT_URL?>themes/<?TPLVAR_THEME?>/assets/images/face11.jpg" alt="">
                    <span><?TPLVAR_FNAME?> <?TPLVAR_LNAME?></span>
                    <i class="caret"></i>
                </a>

                <ul class="dropdown-menu dropdown-menu-right width-200">
                    <li><a href="#"><i class="icon-user-plus"></i> My profile</a></li>
                    <li><a href="#"><span class="badge bg-purple-400 pull-right">58</span> <i class="icon-comment-discussion"></i> Messages</a></li>
                    <li class="divider"></li>
                    <li><a href="#"><i class="icon-cog5"></i> Account settings</a></li>
                    <li><a href="<?TPLVAR_ROOT_URL?>admin/logout"><i class="icon-switch2"></i> Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>