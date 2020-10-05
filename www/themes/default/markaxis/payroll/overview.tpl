

<div id="exTab1" class="exTab1">
    <div class="scroller scroller-left"><i class="icon-arrow-left15"></i></div>
    <div class="scroller scroller-right"><i class="icon-arrow-right15"></i></div>
    <div class="tabWrapper">
        <ul class="nav nav-pills">
            <!-- BEGIN DYNAMIC BLOCK: tab -->
            <li>
                <a class="tab <?TPLVAR_STATUS_TAB?> <?TPLVAR_MONTH?>" href="#<?TPLVAR_MONTH?>Month" data-id="<?TPLVAR_MONTH?>" data-date="<?TPLVAR_DATA_DATE?>" data-toggle="tab">
                    <h4><?TPLVAR_MONTH?></h4>
                    <div>YTD <?TPLVAR_YEAR?></div>
                    <div class="status"><?TPLVAR_STATUS?></div>
                </a>
            </li>
            <!-- END DYNAMIC BLOCK: tab -->
        </ul>
    </div>

    <div class="tab-content clearfix">
        <!-- BEGIN DYNAMIC BLOCK: tab-pane -->
        <div class="tab-pane <?TPLVAR_STATUS_TAB?>" id="<?TPLVAR_MONTH?>Month" data-id="<?TPLVAR_DATA_ID?>">
            <div class="content">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="daterange-custom daterange-custom2 d-flex align-items-center justify-content-center" style="margin-top:10px;">
                            <div class="daterange-custom-display daterange-custom2"><i>1</i>
                                <b><i><?TPLVAR_MONTH?></i> <i><?TPLVAR_YEAR?></i></b><em> –
                                </em><i><?TPLVAR_LAST_DAY?></i> <b><i><?TPLVAR_MONTH?></i> <i><?TPLVAR_YEAR?></i></b>
                            </div>
                            <span class="badge badge-primary ml-2"><?TPLVAR_WORK_DAYS?> <?LANG_WORK_DAYS?></span>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="col-md-6">
                            <div class="font-weight-semibold"><?LANG_AVG_SALARY?></div>
                            <h2 id="<?TPLVAR_MONTH?>avgSalary"></h2>
                        </div>
                        <div class="col-md-6">
                            <div class="font-weight-semibold"><?LANG_AVG_CONTRIBUTIONS?></div>
                            <h2 id="<?TPLVAR_MONTH?>avgContri"></h2>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="col-md-4">
                            <div class="font-weight-semibold"><?LANG_SALARIES_PAID?></div>
                            <!--<h2 id="<?TPLVAR_MONTH?>empCount"></h2>-->
                            <h2 id="<?TPLVAR_MONTH?>totalSalaries"></h2>
                        </div>
                        <div class="col-md-4">
                            <div class="font-weight-semibold"><?LANG_CLAIMS_PAID?></div>
                            <h2 id="<?TPLVAR_MONTH?>totalClaims"></h2>
                        </div>
                        <div class="col-md-4">
                            <div class="font-weight-semibold"><?LANG_LEVIES_PAID?></div>
                            <h2 id="<?TPLVAR_MONTH?>totalLevies"></h2>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <a type="button" class="btn btn-lg bg-purple-400 btn-labeled mt-10" data-date="<?TPLVAR_DATE?>"
                           data-toggle="modal" data-target="#modalEnterPassword">
                            <b><i class="icon-checkmark"></i></b> <?LANG_VIEW_FINALIZED_PAYROLL?></a>
                    </div>

                </div>
            </div>

            <div class="row" style="margin-top:10px">
                <div class="card-body">
                    <div class="chart-container">
                        <div class="chart has-fixed-height" id="<?TPLVAR_MONTH?>Chart"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END DYNAMIC BLOCK: tab-pane -->
        <!-- BEGIN DYNAMIC BLOCK: tab-pane-process -->
        <div class="tab-pane <?TPLVAR_STATUS_TAB?>" id="<?TPLVAR_MONTH?>Month" data-id="<?TPLVAR_DATA_ID?>">
            <div class="content">
                <div class="no-data text-center">
                    <div class="mb-20"><h2><?TPLVAR_LONG_MONTH?> <?TPLVAR_YEAR?> <?LANG_NOT_PROCESS_YET?></h2></div>
                        <a type="button" class="btn btn-lg bg-grey-400 btn-labeled" data-date="<?TPLVAR_DATE?>"
                           data-toggle="modal" data-target="#modalEnterPassword">
                        <b><i class="icon-calculator2"></i></b> <?LANG_LETS_DO_IT?></a>

                </div>
            </div>
        </div>
        <!-- END DYNAMIC BLOCK: tab-pane-process -->
    </div>
</div>
<div id="modalEnterPassword" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><i class="icon-lock"></i>&nbsp; <?LANG_VERIFY_CREDENTIAL?></h6>
            </div>

            <div class="modal-body overflow-y-visible">
                <form id="verifyPwd" name="verifyPwd" method="post" action="">
                    <input type="hidden" name="processDate" id="processDate" value="" />
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><?LANG_ENTER_PASSWORD_CONTINUE?>:</label>
                            <input type="password" name="password" id="password" class="form-control" value=""
                                   placeholder="" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="modal-footer-btn">
                    <button type="button" class="btn btn-link" data-dismiss="modal"><?LANG_CANCEL?></button>
                    <button id="unlock" type="submit" class="btn btn-primary"><?LANG_UNLOCK?></button>
                </div>
            </div>
        </div>
    </div>
</div>