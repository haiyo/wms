
<div id="eventModal" class="modal fade">
    <div class="modal-dialog modal-med2">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><?LANG_CREATE_NEW_EVENT?></h6>
            </div>

            <div id="modalNote" class="modalNote hide"><?LANG_RECUR_EDIT_NOTE?></div>

            <form id="eventForm" name="eventForm" method="post" action="">
                <div class="modal-body overflow-y-visible">
                    <input type="hidden" id="eID" name="eID" value="0" />
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?LANG_EVENT_TITLE?>: <span class="requiredField">*</span></label>
                                <input type="text" name="title" id="title" class="form-control" value=""
                                       placeholder="<?LANG_MEETING_3PM?>" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?LANG_EVENT_DESCRIPTION?>:</label>
                                <input type="text" name="descript" id="descript" class="form-control" value=""
                                       placeholder="<?LANG_DAILY_MEETING?>" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?LANG_START_DATE?>: <span class="requiredField">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                    </span>
                                    <input type="text" class="form-control pickadate-start" id="startDate" name="startDate" placeholder="" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?LANG_END_DATE?>: <span class="requiredField">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                    </span>
                                    <input type="text" class="form-control pickadate-end" id="endDate" name="endDate" placeholder="" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-checkbox-group">
                                <div class="input-group">
                                    <input type="checkbox" class="dt-checkboxes check-input" id="allDay" checked="checked" name="allDay" value="1" />
                                    <label for="allDay" class="ml-5"><?LANG_WHOLE_DAY_EVENT?></label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?LANG_START_TIME?>:</label>
                                <div class="input-group">
                                    <?TPLVAR_START_TIME?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?LANG_END_TIME?>:</label>
                                <div class="input-group">
                                    <?TPLVAR_END_TIME?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?LANG_RECURRING_EVERY?>:</label>
                                <?TPLVAR_RECUR_TYPE?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?LANG_SEND_EMAIL_REMINDER?>:</label>
                                <div class="input-group">
                                    <?TPLVAR_REMINDER?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?LANG_EVENT_LABEL?>:</label>
                                <div class="input-group">
                                    <?TPLVAR_LABEL_LIST?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-checkbox-group">
                                <label>&nbsp;</label>
                                <div class="input-group">
                                    <input type="checkbox" class="dt-checkboxes check-input" id="public" name="public" value="1" />
                                    <label for="public" class="ml-5"><?LANG_PUBLIC_EVENT?></label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="modal-footer-btn">
                        <button type="button" class="btn btn-link hide" id="deleteEvent"><?LANG_DELETE?></button>
                        <button type="button" class="btn btn-link" data-dismiss="modal"><?LANG_CANCEL?></button>
                        <button type="submit" class="btn btn-primary" id="saveEvent"><?LANG_SUBMIT?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="d-md-flex">
    <div class="sidebar sidebar-light sidebar-component sidebar-component-left sidebar-expand-md">

        <!-- Sidebar content -->
        <div class="sidebar-content">

            <!-- Sidebar search
            <div class="card">
                <div class="card-header bg-transparent header-elements-inline">
                    <span class="text-uppercase font-size-sm font-weight-semibold">Event search</span>
                    <div class="header-elements">
                        <div class="list-icons">
                            <span class="list-icons-item" data-action="collapse"></span>
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
                </div>
            </div>
          /sidebar search -->

            <!-- Sub navigation -->
            <div class="card mb-2">
                <div class="card-header bg-transparent header-elements-inline">
                    <span class="text-uppercase font-size-sm font-weight-semibold"><?LANG_FILTER_EVENT_TYPES?></span>
                    <div class="header-elements">
                        <div class="list-icons">
                            <span class="list-icons-item" data-action="collapse"></span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <ul class="nav nav-sidebar">
                        <li class="nav-item-header"></li>
                        <li class="nav-item nav-link">
                            <input type="checkbox" checked="checked" id="myEvents" data-size="mini" data-label-text="<?LANG_MY_EVENTS?>" data-label-width="150">
                        </li>
                        <li class="nav-item nav-link">
                            <input type="checkbox" checked="checked" id="colleagues" data-size="mini" data-label-text="<?LANG_COLLEAGUE_EVENTS?>" data-label-width="150">
                        </li>
                        <li class="nav-item nav-link">
                            <input type="checkbox" checked="checked" id="includeBirthday" data-size="mini" data-label-text="<?LANG_INCLUDE_BIRTHDAYS?>" data-label-width="150">
                        </li>
                        <li class="nav-item nav-link">
                            <input type="checkbox" checked="checked" id="includeHoliday" data-size="mini" data-label-text="<?LANG_INCLUDE_HOLIDAYS?>" data-label-width="150">
                        </li>

                    </ul>
                </div>
            </div>
            <!-- /sub navigation -->
        </div>
        <!-- /sidebar content -->

    </div>
    <div id="calendar"></div>
</div>