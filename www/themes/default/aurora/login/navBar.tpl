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
</div>