
<div class="d-md-flex">
    <div class="sidebar sidebar-light sidebar-component sidebar-component-left sidebar-expand-md">

        <!-- Sidebar content -->
        <div class="sidebar-content">

            <!-- Sidebar search -->
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
        <!-- /sidebar content -->
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
                            <a href="<?TPLVAR_ROOT_URL?>admin/calendar"><i class="mi-event-note mr-3 mi-2x"></i><h4>My Calendar</h4>
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
                        <div class="box-content right">
                            <a href=""><i class="mi-school mr-3 mi-2x"></i><h4>Training &amp; Courses</h4>
                                <div class="box-content-descript">Stay on top of your trainings and certifications</div>
                            </a>
                        </div>
                        <div class="box-content right">
                            <a href="<?TPLVAR_ROOT_URL?>admin/payroll/slips"><i class="icon-cash3"></i><h4>My Payslips</h4>
                                <div class="box-content-descript">View history or download your monthly payslips</div>
                            </a>
                        </div>
                        <div class="box-content">
                            <a href="<?TPLVAR_ROOT_URL?>admin/company/benefits"><i class="mi-favorite-border mr-3 mi-2x"></i><h4>Benefits</h4>
                                <div class="box-content-descript">See which company benefits you are enrolled in</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?TPL_CONTENT?>

        <div class="bg-transparent header-elements-inline">
            <span class="dashboard-header text-uppercase font-size-sm font-weight-semibold">Pending Your Action</span>
        </div>

        <div class="actions" style="margin-bottom: 120px;">
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

</div>