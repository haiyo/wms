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
                    <div class="avatar"><img src="<?TPLVAR_PHOTO?>" width="95" height="95" /></div>
                    <div class="bg-transparent dashboard-side-header text-ellipsis dashboard-side-ellipsis">
                        <div class="dashboard-side-role"><h2><?TPLVAR_FNAME?> <?TPLVAR_LNAME?></h2></div>
                        <div class="dashboard-side-role">HR Administrator</div>
                    </div>
                </div>

                <?TPL_SIDEBAR_SEARCH_BOX?>
            </div>

            <?TPL_SIDEBAR_CARDS?>

        </div>
    </div>

    <div class="dashboard-panel panel-flat">
        <div class="box1 sb8">hello.</div>

        <div class="card">
            <div class="card-body">

                <div class="panel-heading dashboard-heading">
                    <h1 class="panel-title">Welcome <?TPLVAR_FNAME?> <?TPLVAR_LNAME?>!</h1>
                    <div class="panel-descript">You're looking at HRMS, your new tool for work. Here's a quick look at some
                        of the things you can do here in HRMS.</div>
                </div>

                <div class="quick-boxes">
                    <div class="bottom">
                        <div class="box-content right">
                            <a href="<?TPLVAR_ROOT_URL?>admin/leave/balance"><i class="mi-av-timer mr-3 mi-2x"></i><h4>My Leaves</h4>
                                <div class="box-content-descript">Check your leave balances, approval status and history</div>
                            </a>
                        </div>
                        <div class="box-content right">
                            <a href="<?TPLVAR_ROOT_URL?>admin/calendar/view"><i class="mi-event-note mr-3 mi-2x"></i><h4>My Calendar</h4>
                                <div class="box-content-descript">Find out any events or planned leaves</div>
                            </a>
                        </div>
                        <div class="box-content">
                            <a href="<?TPLVAR_ROOT_URL?>admin/user/list"><i class="icon-people"></i><h4>Staff Directory</h4>
                                <div class="box-content-descript">Search for coworkers and their contact information</div>
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
                            <a href="<?TPLVAR_ROOT_URL?>admin/expense/claim"><i class="mi-local-atm mr-3 mi-2x"></i><h4>Expenses Claim</h4>
                                <div class="box-content-descript">Submit claims or check approval status</div>
                            </a>
                        </div>
                        <div class="box-content right">
                            <a href="<?TPLVAR_ROOT_URL?>admin/payroll/view"><i class="icon-cash3"></i><h4>My Payslips</h4>
                                <div class="box-content-descript">View history or download your monthly payslips</div>
                            </a>
                        </div>
                        <div class="box-content">
                            <a href="<?TPLVAR_ROOT_URL?>admin/company/loa"><i class="mi-description mr-3 mi-2x"></i><h4>Letter of Appointment</h4>
                                <div class="box-content-descript">Access your Letter of Appointment</div>
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
                    <span class="dashboard-card-header text-uppercase font-size-sm font-weight-semibold">Pending Action(s)</span>
                </div>

                <div class="actions">
                    <div id="noPendingAction">
                        <div class="card">
                            <div class="card-body">
                                <div class="no-notification text-center">
                                    <i class="icon-pulse2 mr-3 icon-3x"></i>
                                    <span>You have no pending action at the moment...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="pendingAction"></div>
                </div>
            </div>


            <div id="requestWrapper">
                <div class="bg-transparent header-elements-inline">
                    <span class="dashboard-card-header text-uppercase font-size-sm font-weight-semibold">Latest Request(s)</span>
                </div>

                <div id="requestWrapper" class="actions">
                    <div id="noRequest">
                        <div class="card">
                            <div class="card-body">
                                <div class="no-notification text-center">
                                    <i class="icon-pulse2 mr-3 icon-3x"></i>
                                    <span>You have not made any request at the moment...</span>
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