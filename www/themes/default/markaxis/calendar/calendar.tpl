
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
                                <label>Event Title: <span class="requiredField">*</span></label>
                                <input type="text" name="title" id="title" class="form-control" value=""
                                       placeholder="For e.g: Meeting at 3pm" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Event Description:</label>
                                <input type="text" name="descript" id="descript" class="form-control" value=""
                                       placeholder="For e.g: Daily standup meeting" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Start Date: <span class="requiredField">*</span></label>
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
                                <label>End Date: <span class="requiredField">*</span></label>
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
                                    <label for="allDay" class="ml-5">Whole Day Event</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Start Time:</label>
                                <div class="input-group">
                                    <?TPLVAR_START_TIME?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>End Time:</label>
                                <div class="input-group">
                                    <?TPLVAR_END_TIME?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Recurring Every:</label>
                                <?TPLVAR_RECUR_TYPE?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Send Email Reminder:</label>
                                <div class="input-group">
                                    <?TPLVAR_REMINDER?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Event Label:</label>
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
                                    <label for="public" class="ml-5">Public Event (Everyone can see)</label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="modal-footer-btn">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="saveEvent">Submit</button>
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

            <!-- Sidebar search -->
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
            <!-- /sidebar search -->

            <!-- Sub navigation -->
            <div class="card mb-2">
                <div class="card-header bg-transparent header-elements-inline">
                    <span class="text-uppercase font-size-sm font-weight-semibold">Filter Event Types</span>
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
                            <input type="checkbox" checked="checked" id="myEvents" data-size="mini" data-label-text="My Events" data-label-width="150">
                        </li>
                        <li class="nav-item nav-link">
                            <input type="checkbox" checked="checked" id="colleagues" data-size="mini" data-label-text="Colleague Events" data-label-width="150">
                        </li>
                        <li class="nav-item nav-link">
                            <input type="checkbox" checked="checked" id="includeBirthday" data-size="mini" data-label-text="Include Birthdays" data-label-width="150">
                        </li>
                        <li class="nav-item nav-link">
                            <input type="checkbox" checked="checked" id="includeHoliday" data-size="mini" data-label-text="Include Holidays" data-label-width="150">
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