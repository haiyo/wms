
<div class="tab-pane fade" id="departmentList">
    <div class="list-action-btns department-list-action-btns">
        <ul class="icons-list">
            <li>
                <a type="button" class="btn bg-purple-400 btn-labeled"
                   data-toggle="modal" data-target="#modalDepartment">
                    <b><i class="icon-file-plus2"></i></b> <?LANG_CREATE_NEW_DEPARTMENT?>
                </a>
            </li>
        </ul>
    </div>

    <table class="table table-hover datatable departmentTable">
        <thead>
        <tr>
            <th><?LANG_DEPARTMENT_NAME?></th>
            <th><?LANG_MANAGERS?></th>
            <th><?LANG_NO_OF_EMPLOYEE?></th>
            <th><?LANG_ACTIONS?></th>
        </tr>
        </thead>
    </table>
</div>
<div id="modalDepartment" class="modal fade">
    <div class="modal-dialog modal-med2">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><?LANG_CREATE_NEW_DEPARTMENT?></h6>
            </div>

            <form id="saveDepartment" name="saveDepartment" method="post" action="">
                <input type="hidden" id="departmentID" name="departmentID" value="0" />
                <div class="modal-body overflow-y-visible">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?LANG_DEPARTMENT_NAME?>:</label>
                                <input type="text" name="departmentName" id="departmentName" class="form-control" value=""
                                       placeholder="<?LANG_ENTER_DEPARTMENT_NAME?>" />
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?LANG_DEPARTMENT_MANAGER?>:</label>
                                <input type="text" name="managers" class="form-control tokenfield-typeahead suggestList"
                                       placeholder="<?LANG_ENTER_MANAGER_NAME?>" value=""
                                       autocomplete="off" data-fouc />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="modal-footer-btn">
                        <button type="button" class="btn btn-link" data-dismiss="modal"><?LANG_DISCARD?></button>
                        <button type="submit" class="btn btn-primary" id="saveApplyLeave"><?LANG_SUBMIT?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>