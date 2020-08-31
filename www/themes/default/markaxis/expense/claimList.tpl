
<div class="tab-pane fade" id="claim">
    <div class="list-action-btns claim-list-action-btns">
        <ul class="icons-list">
            <li>
                <a type="button" class="btn bg-purple-400 btn-labeled"
                   data-toggle="modal" data-target="#modalClaim">
                    <b><i class="icon-file-plus2"></i></b> <?LANG_CREATE_NEW_CLAIM?>
                </a>
            </li>
        </ul>
    </div>

    <table class="table table-hover datatable tableLayoutFixed claimTable">
        <thead>
        <tr>
            <th><?LANG_CLAIM_TYPE?></th>
            <th><?LANG_DESCRIPTION?></th>
            <th><?LANG_AMOUNT?></th>
            <th><?LANG_ATTACHMENT?></th>
            <th><?LANG_STATUS?></th>
            <th><?LANG_MANAGERS?></th>
            <th><?LANG_DATE_CREATED?></th>
            <th><?LANG_ACTIONS?></th>
        </tr>
        </thead>
    </table>
</div>
<div id="modalClaim" class="modal fade">
    <div class="modal-dialog modal-med">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><?LANG_CREATE_NEW_CLAIM?></h6>
            </div>

            <form id="saveClaim" name="saveClaim" method="post" action="">
                <div class="modal-body overflow-y-visible">
                    <input type="hidden" id="ecID" name="ecID" value="0" />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?LANG_SELECT_EXPENSE_TYPE?>: <span class="requiredField">*</span></label>
                                <?TPLVAR_EXPENSE_LIST?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?LANG_DESCRIPTION?>:</label>
                                <input type="text" name="claimDescript" id="claimDescript" class="form-control" value=""
                                       placeholder="<?LANG_ENTER_DESCRIPTION_CLAIM?>" />
                            </div>
                        </div>

                        <div class="col-md-12 pb-10">
                            <div class="form-group">
                                <label><?LANG_AMOUNT_TO_CLAIM?>: <span class="requiredField">*</span> <div id="maxAmount" class="text-muted"></div></label>
                                <input type="number" name="claimAmount" id="claimAmount" class="form-control" value=""
                                       placeholder="<?LANG_ENTER_CLAIM_AMOUNT?> (For eg: 2.50)" />
                            </div>
                        </div>

                        <div class="col-md-12 pb-10">
                            <label class="display-block"><?LANG_UPLOAD_SUPPORTING_DOCUMENT?>:</label>
                            <div class="input-group">
                                <input type="file" class="claimFileInput" data-fouc />
                                <span class="help-block"><?LANG_ACCEPTED_FORMATS?> <?TPLVAR_MAX_ALLOWED?></span>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?LANG_APPROVING_MANAGERS?>:</label>
                                <input type="text" name="managers" class="form-control tokenfield-typeahead suggestList"
                                       placeholder="<?LANG_ENTER_MANAGER_NAME?>"
                                       value="" autocomplete="off" data-fouc />
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