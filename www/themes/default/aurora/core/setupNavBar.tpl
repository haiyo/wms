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
    .content-setup {
        padding:30px 30px 10px 50px;
    }
</style>
<script>
    $(function() {
        // Override defaults
        $.fn.stepy.defaults.legend = false;
        $.fn.stepy.defaults.transition = 'fade';
        $.fn.stepy.defaults.duration = 150;
        $.fn.stepy.defaults.backLabel = '<i class="icon-arrow-left13 position-left"></i> Back';
        $.fn.stepy.defaults.nextLabel = 'Next <i class="icon-arrow-right14 position-right"></i>';

        $(".stepy").stepy({
            titleClick: true,
            validate: true,
            focusInput: true,
            //block: true,
            next: function(index) {
                $(".form-control").removeClass("border-danger");
                $(".error").remove( );
                //$(".stepy").validate(validate)
            },
            finish: function( index ) {
                if( $(".stepy").valid() )  {
                    saveEmployeeForm();
                    return false;
                }
            }
        });
    });
</script>
<div class="navbar navbar-expand-md navbar-fixed-top">
    <div class="navbar-header">
        <a class="navbar-brand" href="<?TPLVAR_ROOT_URL?>admin/dashboard">
            <img src="<?TPLVAR_ROOT_URL?>themes/<?TPLVAR_THEME?>/assets/images/logo.png" alt="">
        </a>
    </div>
</div>
<div class="content-setup">
    <h1>First Things First...</h1>
    Before we get started, let's make sure we've covered the bases. There are a couple of pre-requesites and pieces of
    information you need to have already setup before using the HRMS system.
</div>