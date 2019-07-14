<script>
    $(document).ready(function( ) {
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
                $(".stepy").validate(validate)
            },
            finish: function( index ) {
                if( $(".stepy").valid() )  {
                    saveLeaveTypeForm();
                    return false;
                }
            }
        });

        // Apply "Back" and "Next" button styling
        $('.stepy-step').find('.button-next').addClass('btn btn-primary btn-next');
        $('.stepy-step').find('.button-back').addClass('btn btn-default');

        // Initialize validation
        var validate = {
            ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
            successClass: 'validation-valid-label',
            highlight: function(element, errorClass) {
                $(element).addClass("border-danger");
            },
            unhighlight: function(element, errorClass) {
                $(element).removeClass("border-danger");
            },
            // Different components require proper error label placement
            errorPlacement: function(error, element) {
                if( $(".error").length == 0 )
                    $(".stepy-navigator").prepend(error);
            },
            rules: {
                leaveTypeName : "required",
                leaveCode : "required"
            }
        };

        $(".select").select2( );
        $("#year").select2({minimumResultsForSearch: -1});
        $("#office").select2({minimumResultsForSearch: -1});
        $("#idType").select2({minimumResultsForSearch: -1});
    });
</script>

<div class="d-md-flex">
    <div class="sidebar sidebar-light sidebar-component sidebar-component-left sidebar-expand-md">
        <div class="sidebar-content">
            <div class="card">
                <div class="card-header bg-transparent header-elements-inline">
                    <span class="text-uppercase font-size-sm font-weight-semibold">Annual Leave</span>
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
                                You are entitled to paid annual leave if you meet the following conditions:

                                You are covered under Part IV of the Employment Act.
                                You have worked for your employer for at least 3 months.
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
                                Your annual leave entitlement depends on how many years of service you have with your employer.
                                Your year of service begins from the day you start work with your employer.
                                <div class="text-muted font-size-sm">36 minutes ago</div>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-flat">
        <div class="panel-body">

            <div class="content-wrapper side-content-wrapper rp">
                <form id="leaveTypeForm" class="stepy" action="#">
                    <fieldset>
                        <legend class="text-semibold"><?LANG_IRAS_FORM?></legend>

                        <div class="row">
                            <div class="col-md-6">
                                <label><?LANG_FILE_TAX_FOR_YEAR?>: <span class="text-danger-400">*</span></label>
                                <?TPL_YEAR_LIST?>
                            </div>

                            <div class="col-md-6">
                                <label><?LANG_SELECT_OFFICE?>: <span class="text-danger-400">*</span></label>
                                <?TPL_OFFICE_LIST?>
                            </div>
                        </div>

                        <div class="row">
                            <h6 class="mb-0 ml-10 font-weight-bold"><?LANG_AUTHORIZED_SUBMITTING_PERSONNEL?>:</h6>
                            <div class="card">
                                <div class="card-body">

                                    <div class="col-md-3">
                                        <label class="display-block"><?LANG_FIRST_NAME_LAST_NAME?>:</label>
                                        <input type="text" name="name" id="name" class="form-control" value="<?TPLVAR_NAME?>" />
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="display-block"><?LANG_DESIGNATION?>:</label>
                                            <?TPL_DESIGNATION_LIST?>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="display-block"><?LANG_IDENTITY_TYPE?>:</label>
                                            <?TPL_IDENTITY_TYPE_LIST?>
                                        </div>
                                    </div>

                                    <div class="col-md-3 contractCol">
                                        <div class="form-group">
                                            <label class="display-block"><?LANG_IDENTITY_NUMBER?>:</label>
                                            <input type="text" name="nric" id="nric" class="form-control" value="<?TPLVAR_NRIC?>" />
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="display-block"><?LANG_EMAIL?>:</label>
                                            <input type="text" name="email" id="email" class="form-control" value="<?TPLVAR_EMAIL?>" />
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="display-block"><?LANG_CONTACT_NUMBER?>:</label>
                                            <input type="text" name="phone" id="phone" class="form-control" value="<?TPLVAR_PHONE?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend class="text-semibold"><?LANG_SELECT_EMPLOYEE?></legend>
                    </fieldset>

                    <fieldset>
                        <legend class="text-semibold"><?LANG_DECLARATION_FOR_INDIVIDUAL_EMPLOYEE?></legend>

                        <div class="row">
                            <div class="col-md-4">
                                <label><?LANG_LEAVE_TYPE_NAME?>: <span class="text-danger-400">*</span></label>
                                <input type="text" name="leaveTypeName" id="leaveTypeName" class="form-control" value="<?TPLVAR_LEAVE_TYPE_NAME?>"
                                       placeholder="<?LANG_LEAVE_TYPE_PLACEHOLDER?>" />
                            </div>

                            <div class="col-md-2">
                                <label class="display-block"><?LANG_LEAVE_CODE?>: <span class="text-danger-400">*</span></label>
                                <input type="text" name="leaveCode" id="leaveCode" class="form-control" value="<?TPLVAR_LEAVE_TYPE_CODE?>"
                                       placeholder="<?LANG_LEAVE_CODE_PLACEHOLDER?>" />
                            </div>

                            <div class="col-md-3">
                                <label class="display-block">&nbsp;</label>
                                <?TPL_PAID_LEAVE?>
                            </div>

                            <div class="col-md-3">
                                <label class="display-block">&nbsp;</label>
                                <?TPL_ALLOW_HALF_DAY_RADIO?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label><?LANG_LEAVE_CAN_BE_APPLIED?>:</label>
                                <?TPL_APPLIED_LIST?>
                            </div>

                            <div class="col-md-2">
                                <label><?LANG_PROBATION_PERIOD?>:</label>
                                <input type="text" name="pPeriodValue" id="pPeriodValue" class="form-control" value="<?TPLVAR_PPERIOD?>" placeholder="3" disabled="disabled" />
                            </div>

                            <div class="col-md-2">
                                <label>&nbsp;</label>
                                <?TPL_PPERIOD_LIST?>
                            </div>

                            <div class="col-md-3">
                                <label class="display-block"><?LANG_MONTHLY_BASIS?></label>
                                <?TPL_PRO_RATED_RADIO?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label><?LANG_UNUSED_LIST?>:</label>
                                <?TPL_UNUSED_LIST?>
                            </div>

                            <div class="col-md-2">
                                <label><?LANG_CARRY_OVER_LIMIT?>:</label>
                                <input type="text" name="cPeriodValue" id="cPeriodValue" class="form-control" value="<?TPLVAR_CPERIOD?>"
                                       placeholder="3" disabled="disabled" />
                            </div>
                            <div class="col-md-2">
                                <label>&nbsp;</label>
                                <?TPL_CPERIOD_LIST?>
                            </div>

                            <div class="col-md-2">
                                <label><?LANG_TO_BE_USED_WITHIN?>:</label>
                                <input type="text" name="usedValue" id="usedValue" class="form-control" value="<?TPLVAR_UPERIOD?>"
                                       placeholder="12" disabled="disabled" />
                            </div>

                            <div class="col-md-2">
                                <label>&nbsp;</label>
                                <?TPL_USED_PERIOD_LIST?>
                            </div>
                        </div>
                    </fieldset>
                    <button type="button" class="btn bg-purple-400 stepy-finish btn-ladda" data-style="slide-right">
                        <span class="ladda-label">Submit <i class="icon-check position-right"></i></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>