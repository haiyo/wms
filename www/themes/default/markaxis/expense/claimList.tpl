
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
            <th>Claim Type</th>
            <th>Description</th>
            <th>Amount</th>
            <th>Attachment</th>
            <th>Status</th>
            <th>Manager(s)</th>
            <th>Date Created</th>
            <th>Actions</th>
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
                                <label>Select Expense Type: <span class="requiredField">*</span></label>
                                <?TPLVAR_EXPENSE_LIST?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description:</label>
                                <input type="text" name="claimDescript" id="claimDescript" class="form-control" value=""
                                       placeholder="Enter description for this claim" />
                            </div>
                        </div>

                        <div class="col-md-12 pb-10">
                            <div class="form-group">
                                <label>Amount To Claim: <span class="requiredField">*</span> <div id="maxAmount" class="text-muted"></div></label>
                                <input type="number" name="claimAmount" id="claimAmount" class="form-control" value=""
                                       placeholder="Enter claim amount (For eg: 2.50)" />
                            </div>
                        </div>

                        <div class="col-md-12 pb-10">
                            <label class="display-block">Upload Supporting Document (If any):</label>
                            <div class="input-group">
                                <input type="file" class="claimFileInput" data-fouc />
                                <span class="help-block">Accepted formats: pdf, doc. Max file size <?TPLVAR_MAX_ALLOWED?></span>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Approving Manager(s):</label>
                                <input type="text" name="managers" class="form-control tokenfield-typeahead suggestList"
                                       placeholder="Enter Manager's Name"
                                       value="" autocomplete="off" data-fouc />
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="modal-footer-btn">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Discard</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>