

<div class="tab-pane fade" id="designationList">
    <div class="list-action-btns designation-list-action-btns">
        <ul class="icons-list">
            <li>
                <a type="button" class="btn bg-purple-400 btn-labeled"
                   data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#modalGroup">
                    <b><i class="icon-file-plus2"></i></b> <?LANG_CREATE_NEW_DESIGNATION_GROUP?>
                </a>&nbsp;&nbsp;&nbsp;
                <a type="button" class="btn bg-purple-400 btn-labeled"
                   data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#modalDesignation">
                    <b><i class="icon-file-plus2"></i></b> <?LANG_CREATE_NEW_DESIGNATION?>
                </a>&nbsp;&nbsp;&nbsp;
                <button type="button" class="btn bg-purple-400 btn-labeled dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <b><i class="icon-stack3"></i></b> <?LANG_BULK_ACTION?> <span class="caret"></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right dropdown-employee">
                    <li><a id="orphanGroupDelete"><i class="icon-bin"></i> <?LANG_DELETE_ORPHAN_GROUPS?></a></li>
                    <li><a id="designationBulkDelete"><i class="icon-bin"></i> <?LANG_DELETED_SELECTED_DESIGNATIONS?></a></li>
                </ul>
            </li>
        </ul>
    </div>

    <table class="table table-hover datatable datatableGroup tableLayoutFixed designationTable">
        <thead>
        <tr>
            <th></th>
            <th></th>
            <th><?LANG_DESIGNATION_GROUP_TITLE?></th>
            <th><?LANG_DESCRIPTION?></th>
            <th><?LANG_NO_OF_EMPLOYEE?></th>
            <th><?LANG_ACTIONS?></th>
        </tr>
        </thead>
    </table>
</div>
<div id="modalGroup" class="modal fade">
    <div class="modal-dialog modal-med">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><?LANG_CREATE_NEW_DESIGNATION_GROUP?></h6>
            </div>

            <form id="saveGroup" name="saveGroup" method="post" action="">
                <div class="modal-body overflow-y-visible">
                    <input type="hidden" id="groupID" name="groupID" value="0" />
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><?LANG_DESIGNATION_GROUP_TITLE?>: <span class="requiredField">*</span></label>
                            <input type="text" name="groupTitle" id="groupTitle" class="form-control" value=""
                                   placeholder="<?LANG_ENTER_GROUP_TITLE?>" />
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                        <label><strong><?LANG_NOTE?>:</strong> <?LANG_DESIGNATION_GROUP_DESCRIPT?></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="modal-footer-btn">
                        <button type="button" class="btn btn-link" data-dismiss="modal"><?LANG_CANCEL?></button>
                        <button type="submit" class="btn btn-primary"><?LANG_SUBMIT?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="modalDesignation" class="modal fade">
    <div class="modal-dialog modal-med">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><?LANG_CREATE_NEW_DESIGNATION?></h6>
            </div>

            <form id="saveDesignation" name="saveDesignation" method="post" action="">
                <div class="modal-body overflow-y-visible">
                    <input type="hidden" id="designationID" name="designationID" value="0" />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?LANG_DESIGNATION_TITLE?>: <span class="requiredField">*</span></label>
                                <input type="text" name="designationTitle" id="designationTitle" class="form-control" value=""
                                       placeholder="<?LANG_ENTER_DESIGNATION_TITLE?>" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?LANG_DESCRIPTION?>:</label>
                                <textarea id="designationDescript" name="designationDescript" rows="5" cols="4"
                                          placeholder="<?LANG_ENTER_DESIGNATION_DESCRIPTIONS?>" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?LANG_DESIGNATION_GROUP?>: <span class="requiredField">*</span></label>
                                <div id="groupUpdate"><?TPL_DESIGNATION_GROUP_LIST?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="modal-footer-btn">
                        <button type="button" class="btn btn-link" data-dismiss="modal"><?LANG_CANCEL?></button>
                        <button type="submit" class="btn btn-primary"><?LANG_SUBMIT?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>