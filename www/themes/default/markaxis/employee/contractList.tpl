
<div class="tab-pane fade" id="contractList">
    <div class="list-action-btns contract-list-action-btns">
        <ul class="icons-list">
            <li>
                <a type="button" class="btn bg-purple-400 btn-labeled" data-backdrop="static" data-keyboard="false"
                   data-toggle="modal" data-target="#modalContract">
                    <b><i class="icon-file-plus2"></i></b> <?LANG_CREATE_NEW_CONTRACT_TYPE?>
                </a>&nbsp;&nbsp;&nbsp;
                <button type="button" class="btn bg-purple-400 btn-labeled dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <b><i class="icon-stack3"></i></b> <?LANG_BULK_ACTION?> <span class="caret"></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right dropdown-employee">
                    <li><a href="#" id="contractBulkDelete"><i class="icon-bin"></i> <?LANG_DELETE_SELECTED_CONTRACTS?></a></li>
                </ul>
            </li>
        </ul>
    </div>

    <table class="table table-hover datatable tableLayoutFixed contractTable">
        <thead>
        <tr>
            <th></th>
            <th><?LANG_CONTRACT_TYPE?></th>
            <th><?LANG_DESCRIPTION?></th>
            <th><?LANG_NO_OF_EMPLOYEE?></th>
            <th><?LANG_ACTIONS?></th>
        </tr>
        </thead>
    </table>
</div>
<div id="modalContract" class="modal fade">
    <div class="modal-dialog modal-med">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><?LANG_CREATE_NEW_CONTRACT_TYPE?></h6>
            </div>

            <form id="saveContract" name="saveContract" method="post" action="">
                <div class="modal-body overflow-y-visible">
                    <input type="hidden" id="contractID" name="contractID" value="0" />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?LANG_CONTRACT_TITLE?>:</label>
                                <input type="text" name="contractTitle" id="contractTitle" class="form-control" value=""
                                       placeholder="<?LANG_ENTER_CONTRACT_TITLE?>" />
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?LANG_DESCRIPTION?>:</label>
                                <textarea id="contractDescript" name="contractDescript" rows="5" cols="4"
                                          placeholder="<?LANG_ENTER_CONTRACT_DESCRIPTION?>" class="form-control"></textarea>
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