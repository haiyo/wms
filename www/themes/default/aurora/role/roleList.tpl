
<div class="tab-pane fade show" id="rolePermList">
    <div class="list-action-btns rolePerm-list-action-btns">
        <ul class="icons-list">
            <li>
                <a type="button" class="btn bg-purple-400 btn-labeled" data-backdrop="static" data-keyboard="false"
                   data-toggle="modal" data-target="#modalRole">
                    <b><i class="icon-file-plus2"></i></b> <?LANG_CREATE_NEW_ROLE?>
                </a>
            </li>
        </ul>
    </div>

    <table class="table table-hover datatable tableLayoutFixed rolePermTable">
        <thead>
        <tr>
            <th><?LANG_ROLE_NAME?></th>
            <th><?LANG_DESCRIPTION?></th>
            <th><?LANG_NO_OF_EMPLOYEE?></th>
            <th><?LANG_ACTIONS?></th>
        </tr>
        </thead>
    </table>
</div>
<div id="modalRole" class="modal fade">
    <div class="modal-dialog modal-med">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><?LANG_CREATE_NEW_ROLE?></h6>
            </div>

            <form id="saveRole" name="saveRole" method="post" action="">
                <div class="modal-body overflow-y-visible">
                    <input type="hidden" id="roleID" name="roleID" value="0" />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?LANG_ROLE_TITLE?>:</label>
                                <input type="text" name="roleTitle" id="roleTitle" class="form-control" value="" placeholder="<?LANG_ENTER_ROLE_TITLE?>" />
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?LANG_ROLE_DESCRIPTION?>:</label>
                                <textarea id="roleDescript" name="roleDescript" rows="5" cols="4"
                                          placeholder="<?LANG_ENTER_ROLE_DESCRIPTION?>" class="form-control"></textarea>
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

<div id="modalPermission" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><?LANG_DEFINE_PERMISSIONS?> (<strong id="defineTitle"></strong>)</h6>
            </div>
            <form id="permForm" name="permForm" method="post" action="">
                <input type="hidden" id="roleID" value="" />
                <div class="modal-body modal-perm"></div>

                <div class="modal-footer modal-perm-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal"><?LANG_CLOSE?></button>
                    <button id="savePerm" type="submit" class="btn btn-primary"><?LANG_SAVE_PERMISSIONS?></button>
                </div>
            </form>
        </div>
    </div>
</div>