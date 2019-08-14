<fieldset>
    <legend class="text-semibold"><?LANG_ENTITLEMENT_STRUCTURE?></legend>

    <div class="panel-heading">
        <div class="heading-elements">
            <ul class="icons-list">
                <li>
                    <a type="button" class="btn bg-purple-400 btn-labeled"
                       data-backdrop="static" data-keyboard="false" data-id="0" data-index=""
                       data-toggle="modal" data-target="#modalLeaveGroup">
                        <b><i class="icon-folder-plus"></i></b> Create New Leave Group
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="row"></div>

    <div class="groupList">
        <div id="groupWrapper" class="list-group list-group-root border-top border-top-grey border-bottom border-bottom-grey mb-20">
            <!-- BEGIN DYNAMIC BLOCK: noGroup -->
            <div style="padding:0 20px 20px 20px; text-align: center;font-size:20px;">
                There is no leave group currently
            </div>
            <!-- END DYNAMIC BLOCK: noGroup -->
            <!-- BEGIN DYNAMIC BLOCK: group -->
            <div id="group_<?TPLVAR_GID?>" class="groupRow">
                <div class="header-elements-inline">
                    <div href="#item-<?TPLVAR_GID?>" class="list-group-item" data-toggle="collapse">
                        <i class="glyphicon glyphicon-chevron-right" id="expandIcon_<?TPLVAR_GID?>"></i>
                        <span id="groupTitle_<?TPLVAR_INDEX?>" class="title"><?TPLVAR_GROUP_TITLE?></span>
                    </div>
                    <div class="header-elements">
                        <div class="list-icons tax-icons">
                            <a data-id="<?TPLVAR_GID?>" data-index="<?TPLVAR_INDEX?>" class="list-icons-item"
                               data-toggle="modal" data-target="#modalLeaveGroup">
                                <i class="icon-pencil5"></i>
                            </a>
                            <a data-id="<?TPLVAR_GID?>" class="list-icons-item"><i class="icon-bin"></i></a>
                        </div>
                    </div>
                </div>

                <div id="item-<?TPLVAR_GID?>" class="list-group collapse">
                    <?TPL_GROUP_CHILD?>
                </div>
            </div>
            <!-- END DYNAMIC BLOCK: group -->
            <input type="hidden" name="leaveGroups" id="leaveGroups" value="" />
        </div>
    </div>

    <div id="structureTemplate" class="hide">
        <div class="row structureRow">
            <div class="col-md-4">
                <label><?LANG_EMPLOYEE_START_MONTH?>:</label>
                <input type="text" name="start_{id}" id="start_{id}" class="form-control start" value=""
                       placeholder="0" />
            </div>
            <div class="col-md-4">
                <label><?LANG_EMPLOYEE_END_MONTH?>:</label>
                <input type="text" name="end_{id}" id="end_{id}" class="form-control end" value=""
                       placeholder="3" />
            </div>
            <div class="col-md-3">
                <label><?LANG_ELIGIBLE_DAYS_LEAVES?>:</label>
                <input type="text" name="days_{id}" id="days_{id}" class="form-control days" value=""
                       placeholder="2" />
            </div>
            <div class="col-md-1">
                <div class="form-group addCol">
                    <a href="{id}" class="addStructure"><i id="plus_{id}" class="icon-plus-circle2"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div id="groupTemplate" class="hide groupRow">
        <div class="header-elements-inline">
            <div href="#item-{index}" class="list-group-item" data-toggle="collapse">
                <i class="glyphicon glyphicon-chevron-right" id="expandIcon_{index}"></i>
                <span id="groupTitle_{index}" class="title">{groupTitle}</span>
            </div>
            <div class="header-elements">
                <div class="list-icons tax-icons">
                    <a data-id="0" data-index="{index}" class="list-icons-item"
                       data-toggle="modal" data-target="#modalLeaveGroup">
                        <i class="icon-pencil5"></i>
                    </a>
                    <a data-id="{index}" class="list-icons-item"><i class="icon-bin"></i></a>
                </div>
            </div>
        </div>

        <div id="item-{lgID}" class="list-group collapse">
            <?TPL_GROUP_CHILD?>
        </div>
    </div>

    <div id="modalLeaveGroup" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h6 class="modal-title">Create New Leave Group</h6>
                </div>

                <div class="modal-body overflow-y-visible">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Leave Group Title:</label>
                            <input type="hidden" name="lgIndex" id="lgIndex" class="form-control" value="" />
                            <input type="hidden" name="lgID" id="lgID" class="form-control" value="" />
                            <input type="text" name="groupTitle" id="groupTitle" class="form-control" value="" />
                        </div>
                    </div>

                    <div class="col-md-6 pr-0">
                        <div class="form-group">
                            <label>Assign Designation:</label>
                            <?TPL_DESIGNATION_LIST?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 pr-0">
                            <div class="form-group">
                                <label>Assign Contract:</label>
                                <?TPL_CONTRACT_LIST?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="display-block"><?LANG_IS_THIS_PRO_RATED?></label>
                            <?TPL_PRO_RATED_RADIO?>
                        </div>
                    </div>

                    <div id="structureRow" class="row hide">
                        <span class="mb-0 ml-10 font-weight-bold">Leave Entitlement Structure:</span>
                        <div class="card">
                            <div class="card-body">
                                <div id="structureWrapper" style="float:left;width:100%;max-height:300px;overflow-y:auto;padding:10px"></div>
                            </div>
                        </div>
                    </div>
                    <div id="entitledRow" class="row hide">
                        <span class="mb-0 ml-10 font-weight-bold">Leave Entitlement Structure:</span>
                        <div class="card">
                            <div class="card-body">
                                <div id="structureWrapper" style="float:left;width:100%;max-height:300px;overflow-y:auto;padding:10px">
                                    <div class="row structureRow">
                                        <div class="col-md-5">
                                            <label>Total No. of Leaves Entitled For the Year:</label>
                                            <input type="text" name="entitledLeaves" id="entitledLeaves" class="form-control start" value="" placeholder="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="modal-footer-btn">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Discard</button>
                        <button type="button" class="btn btn-primary" id="saveLeaveGroup">Create Group</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</fieldset>