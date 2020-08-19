<style>
    .header-inline{background-color:#<?TPLVAR_MAIN_COLOR?>;}
    .box1{border-color:#<?TPLVAR_DASHBOARD_BG_COLOR?>;color:#<?TPLVAR_DASHBOARD_BG_COLOR?>;}
    .dashboard-header-content{background-color:#<?TPLVAR_DASHBOARD_BG_COLOR?>;}
    .header-inline img{border-color:#<?TPLVAR_DASHBOARD_BG_COLOR?>;}
    .sb8:before{border-right-color:#<?TPLVAR_DASHBOARD_BG_COLOR?>;border-top-color:#<?TPLVAR_DASHBOARD_BG_COLOR?>}
</style>
<div class="d-md-flex">
    <div class="sidebar sidebar-light sidebar-component sidebar-component-left sidebar-expand-md">

        <div class="sidebar-content">

            <div class="card">
                <div class="header-inline">
                    <a href="<?TPLVAR_ROOT_URL?>admin/user/profile">
                        <div class="avatar"><img src="<?TPLVAR_PHOTO?>" width="95" height="95" /></div>
                        <div class="bg-transparent dashboard-side-header text-ellipsis dashboard-side-ellipsis">
                            <div class="dashboard-side-role"><h2><?TPLVAR_FNAME?> <?TPLVAR_LNAME?></h2></div>
                            <div class="dashboard-side-role"><?TPLVAR_DESIGNATION?></div>
                        </div>
                    </a>
                </div>

                <?TPL_SIDEBAR_SEARCH_BOX?>
            </div>

            <?TPL_SIDEBAR_CARDS?>

        </div>
    </div>

    <div class="dashboard-panel panel-flat">
        <div class="box1 sb8"><?LANG_HELLO?>.</div>

        <div class="card">
            <div class="card-body">

                <div class="panel-heading dashboard-heading">
                    <h1 class="panel-title"><?LANG_WELCOME?> <?TPLVAR_FNAME?> <?TPLVAR_LNAME?>!</h1>
                    <div class="panel-descript"><?LANG_DASHBOARD_INTRO?></div>
                </div>

                <div class="quick-boxes">
                    <div class="bottom">
                        <div class="box-content right">
                            <a href="<?TPLVAR_ROOT_URL?>admin/leave/balance"><i class="mi-av-timer mr-3 mi-2x"></i><h4><?LANG_MY_LEAVE?></h4>
                                <div class="box-content-descript"><?LANG_LEAVE_INTRO?></div>
                            </a>
                        </div>
                        <div class="box-content right">
                            <a href="<?TPLVAR_ROOT_URL?>admin/calendar/view"><i class="mi-event-note mr-3 mi-2x"></i><h4><?LANG_MY_CALENDAR?></h4>
                                <div class="box-content-descript"><?LANG_CALENDAR_INTRO?></div>
                            </a>
                        </div>
                        <div class="box-content">
                            <a href="<?TPLVAR_ROOT_URL?>admin/user/list"><i class="icon-people"></i><h4><?LANG_STAFF_DIRECTORY?></h4>
                                <div class="box-content-descript"><?LANG_STAFF_INTRO?></div>
                            </a>
                        </div>
                    </div>
                    <div>
                        <!--<div class="box-content right">
                            <a href=""><i class="mi-school mr-3 mi-2x"></i><h4>Training &amp; Courses</h4>
                                <div class="box-content-descript">Stay on top of your trainings and certifications</div>
                            </a>
                        </div>-->
                        <div class="box-content right">
                            <a href="<?TPLVAR_ROOT_URL?>admin/expense/claim"><i class="mi-local-atm mr-3 mi-2x"></i><h4><?LANG_EXPENSES_CLAIMS?></h4>
                                <div class="box-content-descript"><?LANG_CLAIMS_INTRO?></div>
                            </a>
                        </div>
                        <div class="box-content right">
                            <a href="<?TPLVAR_ROOT_URL?>admin/payroll/view"><i class="icon-cash3"></i><h4><?LANG_MY_PAYSLIP?></h4>
                                <div class="box-content-descript"><?LANG_PAYSLIP_INTRO?></div>
                            </a>
                        </div>
                        <div class="box-content">
                            <a href="<?TPLVAR_ROOT_URL?>admin/company/loa" target="_blank"><i class="mi-description mr-3 mi-2x"></i><h4><?LANG_LOA?></h4>
                                <div class="box-content-descript"><?LANG_LOA_INTRO?></div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?TPL_CONTENT?>

        <div style="margin-bottom:80px;">

            <div id="pendingWrapper">
                <div class="bg-transparent header-elements-inline">
                    <span class="dashboard-card-header text-uppercase font-size-sm font-weight-semibold"><?LANG_PENDING_ACTIONS?></span>
                </div>

                <div class="actions">
                    <div id="noPendingAction">
                        <div class="card">
                            <div class="card-body">
                                <div class="no-notification text-center">
                                    <i class="icon-pulse2 mr-3 icon-3x"></i>
                                    <span><?LANG_NO_PENDING_ACTION?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="pendingAction"></div>
                </div>
            </div>


            <div id="requestWrapper">
                <div class="bg-transparent header-elements-inline">
                    <span class="dashboard-card-header text-uppercase font-size-sm font-weight-semibold"><?LANG_LATEST_REQUESTS?></span>
                </div>

                <div id="requestWrapper" class="actions">
                    <div id="noRequest">
                        <div class="card">
                            <div class="card-body">
                                <div class="no-notification text-center">
                                    <i class="icon-pulse2 mr-3 icon-3x"></i>
                                    <span><?LANG_NO_LATEST_REQUEST?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="latestRequest"></div>
                </div>
            </div>
        </div>

    </div>

</div>