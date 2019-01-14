
<script>
    $(function() {
        $(".select").select2();

        // Override defaults
        $.fn.stepy.defaults.legend = false;
        $.fn.stepy.defaults.transition = 'fade';
        $.fn.stepy.defaults.duration = 150;
        $.fn.stepy.defaults.backLabel = '<i class="icon-arrow-left13 position-left"></i> Back';
        $.fn.stepy.defaults.nextLabel = 'Next <i class="icon-arrow-right14 position-right"></i>';

        $(".stepy-clickable").stepy({
            titleClick: true,
            validate: true,
            //block: true,
            next: function(index) {
                $(".form-control").removeClass("border-danger");
                $(".error").remove( );
                $(".stepy-clickable").validate(validate)
            },
            finish: function( index ) {
                if( $(".stepy-clickable").valid() )  {
                    saveEmployeeForm();
                    return false;
                }
            }
        });
    });
</script>
<style>
    @media (min-width: 768px) {
        .justify-content-md-center {
            -ms-flex-pack: center !important;
            justify-content: center !important;
        }
    }
    .sidebar-light {
        background-color: #fff;
        color: #333;
        border-right: 1px solid rgba(0,0,0,.125);
        background-clip: content-box;
    }
    .sidebar-component {
        border: 1px solid transparent;
        border-radius: .1875em;
        box-shadow: 0 1px 2px rgba(0,0,0,.05);
    }
    .sidebar-component.sidebar-light {
        border-color: rgba(0,0,0,.125);
    }
    .sidebar:not(.bg-transparent) .card {
        border-width: 0;
        margin-bottom: 0;
        border-radius: 0;
        box-shadow: none;
    }
    .sidebar:not(.bg-transparent) .card:not([class*=bg-]):not(.fixed-top) {
        background-color: transparent;
    }
    .card-header {
        padding: .9375rem 1.25em;
        margin-bottom: 0;
        background-color: rgba(0,0,0,.02);
        border-bottom: 1px solid rgba(0,0,0,.125);
    }
    .header-elements-inline {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        -ms-flex-pack: justify;
        justify-content: space-between;
        -ms-flex-wrap: nowrap;
        flex-wrap: nowrap;
    }
    .card-header:first-child {
        border-radius: .125em .125em 0 0;
    }
    .form-group-feedback {
        position: relative;
    }
    .form-control-feedback {
        position: absolute;
        top: 0;
        color: #333;
        padding-left: .875em;
        padding-right: .875em;
        line-height: 2.8em;
        min-width: 1rem;
    }
    .form-group-feedback-right .form-control-feedback {
        right: 0;
    }

    @media (min-width: 768px) {
        .sidebar-expand-md.sidebar-component-left {
            margin-right: 1.25em;
        }
    }
    @media (min-width: 768px) {
        .sidebar-expand-md.sidebar-component {
            display: block;
        }
    }
    .d-md-flex .sidebar {
        -ms-flex: 0 0 auto;
        flex: 0 0 auto;
        width:320px;
    }
    .col-6 {
        -ms-flex: 0 0 50%;
        flex: 0 0 50%;
        max-width: 50%;
    }
    .row {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: -.625em;
        margin-left: -.625em;
    }
    .row-tile div[class*=col]+div[class*=col] .btn {
        border-left: 0;
    }
    .no-gutters {
        margin-right: 0 !important;
        margin-left: 0 !important;
    }
    .no-gutters>.col, .no-gutters>[class*=col-] {
        padding-right: 0 !important;
        padding-left: 0 !important;
    }
    .row-tile div[class*=col] .btn {
        border-radius: 0;
    }
    .row-tile div[class*=col]:first-child .btn:first-child {
        border-top-left-radius: .1875em;
    }
    .nav-sidebar .nav-item-header {
        padding: .75em 2.9em;
        margin-top: .5em;
    }
    .sidebar-light .nav-sidebar .nav-item-header {
        color: rgba(51,51,51,.5);
    }
    .nav {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        padding-left: 0;
        margin-bottom: 0;
        list-style: none;
    }
    .nav-sidebar {
        -ms-flex-direction: column;
        flex-direction: column;
    }
    .nav-sidebar .nav-item:not(.nav-item-divider) {
        margin-bottom: 1px;
    }
    .nav-sidebar .nav-link {
        position: relative;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: start;
        align-items: flex-start;
        padding:.75em 2.9em;
        transition: background-color ease-in-out .15s,color ease-in-out .15s;
    }
    .nav-sidebar>.nav-item>.nav-link {
        font-weight: 500;
    }
    .sidebar-light .nav-sidebar .nav-link {
        color: rgba(51,51,51,.85);
    }
    .nav-sidebar .nav-link i {
        margin-right: 1.25em;
        margin-top: .12502em;
        margin-bottom: .12502em;
        top: 0;
    }
    .p-0 {
        padding: 0!important;
    }
    .mb-2, .my-2 {
        margin-bottom:1.625em!important;
    }
    .rounded-round {
        border-radius: 100px!important;
    }
    .form-control-datepicker {
        margin-top:20px;
    }
</style>
<script>
    $(document).ready(function( ) {
        $('.form-control-datepicker').datepicker();
    });
</script>
<div class="d-md-flex">
    <div class="sidebar sidebar-light sidebar-component sidebar-component-left sidebar-expand-md">

        <!-- Sidebar content -->
        <div class="sidebar-content">

            <!-- Sidebar search -->
            <div class="card">
                <div class="card-header bg-transparent header-elements-inline">
                    <span class="text-uppercase font-size-sm font-weight-semibold">Sidebar search</span>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="#">
                        <div class="form-group-feedback form-group-feedback-right">
                            <input type="search" class="form-control" placeholder="Search">
                            <div class="form-control-feedback">
                                <i class="icon-search4 font-size-base text-muted"></i>
                            </div>
                        </div>
                    </form>
                    <div class="form-control-datepicker border-0"></div>
                </div>
            </div>
            <!-- /sidebar search -->


            <!-- Actions -->
            <div class="card">
                <div class="card-header bg-transparent header-elements-inline">
                    <span class="text-uppercase font-size-sm font-weight-semibold">Actions</span>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row row-tile no-gutters">
                        <div class="col-6">
                            <button type="button" class="btn btn-light btn-block btn-float m-0">
                                <i class="icon-github4 icon-2x"></i>
                                <span>Github</span>
                            </button>

                            <button type="button" class="btn btn-light btn-block btn-float m-0">
                                <i class="icon-dropbox text-blue-400 icon-2x"></i>
                                <span>Dropbox</span>
                            </button>
                        </div>

                        <div class="col-6">
                            <button type="button" class="btn btn-light btn-block btn-float m-0">
                                <i class="icon-dribbble3 text-pink-400 icon-2x"></i>
                                <span>Dribbble</span>
                            </button>

                            <button type="button" class="btn btn-light btn-block btn-float m-0">
                                <i class="icon-google-drive text-success-400 icon-2x"></i>
                                <span>Google Drive</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /actions -->


            <!-- Sub navigation -->
            <div class="card mb-2">
                <div class="card-header bg-transparent header-elements-inline">
                    <span class="text-uppercase font-size-sm font-weight-semibold">Navigation</span>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <ul class="nav nav-sidebar" data-nav-type="accordion">
                        <li class="nav-item-header">Actions</li>
                        <li class="nav-item">
                            <a href="#" class="nav-link"><i class="icon-googleplus5"></i> Create task</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link"><i class="icon-portfolio"></i> Create project</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link"><i class="icon-compose"></i> Edit task list</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="icon-user-plus"></i>
                                Assign users
                                <span class="badge bg-primary badge-pill ml-auto">94 online</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link"><i class="icon-collaboration"></i> Create team</a>
                        </li>
                        <li class="nav-item-header">Navigate</li>
                        <li class="nav-item">
                            <a href="#" class="nav-link"><i class="icon-files-empty"></i> All tasks</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="icon-file-plus"></i>
                                Active tasks
                                <span class="badge bg-dark badge-pill ml-auto">28</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link"><i class="icon-file-check"></i> Closed tasks</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="icon-reading"></i>
                                Assigned to me
                                <span class="badge bg-info badge-pill ml-auto">86</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="icon-make-group"></i>
                                Assigned to my team
                                <span class="badge bg-danger badge-pill ml-auto">47</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link"><i class="icon-cog3"></i> Settings</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /sub navigation -->


            <!-- Online users -->
            <div class="card">
                <div class="card-header bg-transparent header-elements-inline">
                    <span class="text-uppercase font-size-sm font-weight-semibold">Online users</span>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <ul class="media-list">
                        <li class="media">
                            <a href="#" class="mr-3">
                                <img src="../../../../global_assets/images/demo/users/face1.jpg" width="36" height="36" class="rounded-circle" alt="">
                            </a>
                            <div class="media-body">
                                <a href="#" class="media-title font-weight-semibold">James Alexander</a>
                                <span class="font-size-xs text-muted d-block">Santa Ana, CA.</span>
                            </div>
                            <div class="ml-3 align-self-center">
                                <span class="badge badge-mark border-success"></span>
                            </div>
                        </li>

                        <li class="media">
                            <a href="#" class="mr-3">
                                <img src="../../../../global_assets/images/demo/users/face2.jpg" width="36" height="36" class="rounded-circle" alt="">
                            </a>
                            <div class="media-body">
                                <a href="#" class="media-title font-weight-semibold">Jeremy Victorino</a>
                                <span class="font-size-xs text-muted d-block">Dowagiac, MI.</span>
                            </div>
                            <div class="ml-3 align-self-center">
                                <span class="badge badge-mark border-danger"></span>
                            </div>
                        </li>

                        <li class="media">
                            <a href="#" class="mr-3">
                                <img src="../../../../global_assets/images/demo/users/face3.jpg" width="36" height="36" class="rounded-circle" alt="">
                            </a>
                            <div class="media-body">
                                <a href="#" class="media-title font-weight-semibold">Margo Baker</a>
                                <span class="font-size-xs text-muted d-block">Kasaan, AK.</span>
                            </div>
                            <div class="ml-3 align-self-center">
                                <span class="badge badge-mark border-success"></span>
                            </div>
                        </li>

                        <li class="media">
                            <a href="#" class="mr-3">
                                <img src="../../../../global_assets/images/demo/users/face4.jpg" width="36" height="36" class="rounded-circle" alt="">
                            </a>
                            <div class="media-body">
                                <a href="#" class="media-title font-weight-semibold">Beatrix Diaz</a>
                                <span class="font-size-xs text-muted d-block">Neenah, WI.</span>
                            </div>
                            <div class="ml-3 align-self-center">
                                <span class="badge badge-mark border-warning"></span>
                            </div>
                        </li>

                        <li class="media">
                            <a href="#" class="mr-3">
                                <img src="../../../../global_assets/images/demo/users/face5.jpg" width="36" height="36" class="rounded-circle" alt="">
                            </a>
                            <div class="media-body">
                                <a href="#" class="media-title font-weight-semibold">Richard Vango</a>
                                <span class="font-size-xs text-muted d-block">Grapevine, TX.</span>
                            </div>
                            <div class="ml-3 align-self-center">
                                <span class="badge badge-mark border-grey-400"></span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /online-users -->


            <!-- Latest updates -->
            <div class="card">
                <div class="card-header bg-transparent header-elements-inline">
                    <span class="text-uppercase font-size-sm font-weight-semibold">Latest updates</span>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <ul class="media-list">
                        <li class="media">
                            <div class="mr-3">
                                <a href="#" class="btn bg-transparent border-primary text-primary rounded-round border-2 btn-icon">
                                    <i class="icon-git-pull-request"></i>
                                </a>
                            </div>

                            <div class="media-body">
                                Drop the IE <a href="#">specific hacks</a> for temporal inputs
                                <div class="text-muted font-size-sm">4 minutes ago</div>
                            </div>
                        </li>

                        <li class="media">
                            <div class="mr-3">
                                <a href="#" class="btn bg-transparent border-warning text-warning rounded-round border-2 btn-icon">
                                    <i class="icon-git-commit"></i>
                                </a>
                            </div>

                            <div class="media-body">
                                Add full font overrides for popovers and tooltips
                                <div class="text-muted font-size-sm">36 minutes ago</div>
                            </div>
                        </li>

                        <li class="media">
                            <div class="mr-3">
                                <a href="#" class="btn bg-transparent border-info text-info rounded-round border-2 btn-icon">
                                    <i class="icon-git-branch"></i>
                                </a>
                            </div>

                            <div class="media-body">
                                <a href="#">Chris Arney</a> created a new <span class="font-weight-semibold">Design</span> branch
                                <div class="text-muted font-size-sm">2 hours ago</div>
                            </div>
                        </li>

                        <li class="media">
                            <div class="mr-3">
                                <a href="#" class="btn bg-transparent border-success text-success rounded-round border-2 btn-icon">
                                    <i class="icon-git-merge"></i>
                                </a>
                            </div>

                            <div class="media-body">
                                <a href="#">Eugene Kopyov</a> merged <span class="font-weight-semibold">Master</span> and <span class="font-weight-semibold">Dev</span> branches
                                <div class="text-muted font-size-sm">Dec 18, 18:36</div>
                            </div>
                        </li>

                        <li class="media">
                            <div class="mr-3">
                                <a href="#" class="btn bg-transparent border-primary text-primary rounded-round border-2 btn-icon">
                                    <i class="icon-git-pull-request"></i>
                                </a>
                            </div>

                            <div class="media-body">
                                Have Carousel ignore keyboard events
                                <div class="text-muted font-size-sm">Dec 12, 05:46</div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /latest updates -->


            <!-- Filter -->
            <div class="card">
                <div class="card-header bg-transparent header-elements-inline">
                    <span class="text-uppercase font-size-sm font-weight-semibold">Filter</span>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="#">
                        <div class="form-group">
                            <div class="form-check form-check-right">
                                <label class="form-check-label">
                                    <div class="uniform-checker"><span class="checked"><input type="checkbox" class="form-input-styled" checked="" data-fouc=""></span></div>
                                    Free People
                                </label>
                            </div>

                            <div class="form-check form-check-right">
                                <label class="form-check-label">
                                    <div class="uniform-checker"><span><input type="checkbox" class="form-input-styled" data-fouc=""></span></div>
                                    GAP
                                </label>
                            </div>

                            <div class="form-check form-check-right">
                                <label class="form-check-label">
                                    <div class="uniform-checker"><span class="checked"><input type="checkbox" class="form-input-styled" checked="" data-fouc=""></span></div>
                                    Lane Bryant
                                </label>
                            </div>

                            <div class="form-check form-check-right">
                                <label class="form-check-label">
                                    <div class="uniform-checker"><span class="checked"><input type="checkbox" class="form-input-styled" checked="" data-fouc=""></span></div>
                                    Ralph Lauren
                                </label>
                            </div>

                            <div class="form-check form-check-right">
                                <label class="form-check-label">
                                    <div class="uniform-checker"><span><input type="checkbox" class="form-input-styled" data-fouc=""></span></div>
                                    Liz Claiborne
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /filter -->


            <!-- Contacts -->
            <div class="card">
                <div class="card-header bg-transparent header-elements-inline">
                    <span class="text-uppercase font-size-sm font-weight-semibold">Contacts</span>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <ul class="media-list">
                        <li class="media">
                            <a href="#" class="mr-3 position-relative">
                                <img src="../../../../global_assets/images/demo/users/face11.jpg" width="36" height="36" class="rounded-circle" alt="">
                                <span class="badge badge-info badge-pill badge-float">6</span>
                            </a>

                            <div class="media-body align-self-center">
                                Rebecca Jameson
                            </div>

                            <div class="ml-3 align-self-center">
                                <div class="dropdown">
                                    <a href="#" class="text-default dropdown-toggle caret-0" data-toggle="dropdown"><i class="icon-more2"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item"><i class="icon-comment-discussion"></i> Start chat</a>
                                        <a href="#" class="dropdown-item"><i class="icon-phone2"></i> Make a call</a>
                                        <a href="#" class="dropdown-item"><i class="icon-mail5"></i> Send mail</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="#" class="dropdown-item"><i class="icon-statistics"></i> Statistics</a>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="media">
                            <a href="#" class="mr-3 position-relative">
                                <img src="../../../../global_assets/images/demo/users/face25.jpg" width="36" height="36" class="rounded-circle" alt="">
                                <span class="badge badge-info badge-pill badge-float">9</span>
                            </a>

                            <div class="media-body align-self-center">
                                Walter Sommers
                            </div>

                            <div class="ml-3 align-self-center">
                                <div class="dropdown">
                                    <a href="#" class="text-default dropdown-toggle caret-0" data-toggle="dropdown"><i class="icon-more2"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item"><i class="icon-comment-discussion"></i> Start chat</a>
                                        <a href="#" class="dropdown-item"><i class="icon-phone2"></i> Make a call</a>
                                        <a href="#" class="dropdown-item"><i class="icon-mail5"></i> Send mail</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="#" class="dropdown-item"><i class="icon-statistics"></i> Statistics</a>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="media">
                            <a href="#" class="mr-3">
                                <img src="../../../../global_assets/images/demo/users/face10.jpg" width="36" height="36" class="rounded-circle" alt="">
                            </a>

                            <div class="media-body align-self-center">
                                Otto Gerwald
                            </div>

                            <div class="ml-3 align-self-center">
                                <div class="dropdown">
                                    <a href="#" class="text-default dropdown-toggle caret-0" data-toggle="dropdown"><i class="icon-more2"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item"><i class="icon-comment-discussion"></i> Start chat</a>
                                        <a href="#" class="dropdown-item"><i class="icon-phone2"></i> Make a call</a>
                                        <a href="#" class="dropdown-item"><i class="icon-mail5"></i> Send mail</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="#" class="dropdown-item"><i class="icon-statistics"></i> Statistics</a>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="media">
                            <a href="#" class="mr-3">
                                <img src="../../../../global_assets/images/demo/users/face14.jpg" width="36" height="36" class="rounded-circle" alt="">
                            </a>

                            <div class="media-body align-self-center">
                                Vince Satmann
                            </div>

                            <div class="ml-3 align-self-center">
                                <div class="dropdown">
                                    <a href="#" class="text-default dropdown-toggle caret-0" data-toggle="dropdown"><i class="icon-more2"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item"><i class="icon-comment-discussion"></i> Start chat</a>
                                        <a href="#" class="dropdown-item"><i class="icon-phone2"></i> Make a call</a>
                                        <a href="#" class="dropdown-item"><i class="icon-mail5"></i> Send mail</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="#" class="dropdown-item"><i class="icon-statistics"></i> Statistics</a>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="media">
                            <a href="#" class="mr-3">
                                <img src="../../../../global_assets/images/demo/users/face24.jpg" width="36" height="36" class="rounded-circle" alt="">
                            </a>

                            <div class="media-body align-self-center">
                                Jason Leroy
                            </div>

                            <div class="ml-3 align-self-center">
                                <div class="dropdown">
                                    <a href="#" class="text-default dropdown-toggle caret-0" data-toggle="dropdown"><i class="icon-more2"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item"><i class="icon-comment-discussion"></i> Start chat</a>
                                        <a href="#" class="dropdown-item"><i class="icon-phone2"></i> Make a call</a>
                                        <a href="#" class="dropdown-item"><i class="icon-mail5"></i> Send mail</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="#" class="dropdown-item"><i class="icon-statistics"></i> Statistics</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /contacts -->

        </div>
        <!-- /sidebar content -->

    </div>


    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Employee List<a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
        </div>

        <form id="employeeForm" class="stepy-clickable" action="#">

            <fieldset>
                <legend class="text-semibold">Select Pay Period</legend>

                <div class="row justify-content-md-center">
                    <div class="col col-lg-2">
                        <select name="dobMonth" data-placeholder="Month" placeholder="Month"
                                id="dobMonth" class="form-control select">
                            <option value=""></option>
                            <option value="01">2014</option>
                            <option value="02">2015</option>
                            <option value="03">2016</option>
                            <option value="04">2017</option>
                            <option value="05"selected>2018</option>
                            <option value="05">2019</option>
                        </select>
                    </div>
                    <div class="col-md-auto">
                        <select name="dobMonth" data-placeholder="Month" placeholder="Month"
                                id="dobMonth"
                                class="form-control select">
                            <option value=""></option>
                            <option value="01">January</option>
                            <option value="02">February</option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08"selected>August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>
                    <div class="col col-lg-2">
                        <select name="dobMonth" data-placeholder="Month" placeholder="Month"
                                id="dobMonth"
                                class="form-control select">
                            <option value=""></option>
                            <option value="01" selected>Whole Month</option>
                            <option value="02">1st Half of the Month</option>
                            <option value="03">2nd Half of the Month</option>
                        </select>
                    </div>
                </div>


            </fieldset>


            <fieldset style="display: none;">
                <legend class="text-semibold">Select Employee</legend>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Employee ID:</label>
                            <input type="text" name="idnumber" id="idnumber" placeholder="0000000" class="form-control" value="<?TPLVAR_IDNUMBER?>" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Office / Location:</label>
                            <?TPL_OFFICE_LIST?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Select Department(s):</label>
                            <?TPL_DEPARTMENT_LIST?>
                        </div>
                    </div>

                </div>
            </fieldset>

            <fieldset style="display: none;">
                <legend class="text-semibold">Select Pay Items</legend>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Employee ID:</label>
                            <input type="text" name="idnumber" id="idnumber" placeholder="0000000" class="form-control" value="<?TPLVAR_IDNUMBER?>" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Office / Location:</label>
                            <?TPL_OFFICE_LIST?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Select Department(s):</label>
                            <?TPL_DEPARTMENT_LIST?>
                        </div>
                    </div>

                </div>
            </fieldset>

            <fieldset style="display: none;">
                <legend class="text-semibold">View Summary</legend>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Employee ID:</label>
                            <input type="text" name="idnumber" id="idnumber" placeholder="0000000" class="form-control" value="<?TPLVAR_IDNUMBER?>" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Office / Location:</label>
                            <?TPL_OFFICE_LIST?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Select Department(s):</label>
                            <?TPL_DEPARTMENT_LIST?>
                        </div>
                    </div>

                </div>
            </fieldset>

            <button type="button" class="btn bg-purple-400 stepy-finish btn-ladda" data-style="slide-right">
                <span class="ladda-label">Submit <i class="icon-check position-right"></i></span>
            </button>
        </form>

    </div>

</div>