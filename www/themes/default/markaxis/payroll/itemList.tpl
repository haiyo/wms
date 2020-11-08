
<div class="tab-pane fade" id="payItems">
    <div class="list-action-btns payItems-list-action-btns">
        <ul class="icons-list">
            <li>
                <a type="button" class="btn bg-purple-400 btn-labeled"
                   data-toggle="modal" data-target="#modalPayItem">
                    <b><i class="icon-file-plus2"></i></b> <?LANG_CREATE_NEW_PAY_ITEM?>
                </a>
            </li>
        </ul>
    </div>

    <table class="table table-hover datatable tableLayoutFixed payItemTable">
        <thead>
        <tr>
            <th><?LANG_PAY_ITEM_TITLE?></th>
            <th><?LANG_TAXABLE?></th>
            <th><?LANG_ACTIONS?></th>
        </tr>
        </thead>
    </table>
</div>
<div id="modalPayItem" class="modal fade">
    <div class="modal-dialog modal-med2">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><?LANG_CREATE_NEW_PAY_ITEM?></h6>
            </div>

            <form id="savePayItem" name="savePayItem" method="post" action="">
                <div class="modal-body overflow-y-visible">
                    <input type="hidden" id="piID" name="piID" value="0" />
                    <input type="hidden" id="payItemType" name="payItemType" value="" />
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label><?LANG_PAY_ITEM_TITLE?>:</label>
                                <input type="text" name="payItemTitle" id="payItemTitle" class="form-control" value=""
                                       placeholder="<?LANG_ENTER_PAY_ITEM_TITLE?>" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label class="display-block mt-5">&nbsp;</label>
                            <input type="checkbox" class="dt-checkboxes check-input" id="taxable" name="taxable" value="1" />
                            <label for="taxable" class="ml-5"><?LANG_TAXABLE?></label>
                        </div>

                        <div id="categoryType" class="col-md-12 mb-15">
                            <?TPLVAR_ALLOWANCE_BENEFITS_STOCKS?>
                        </div>

                        <div id="allowanceType" class="col-md-12 mb-15 hide">
                            <div class="row">
                                <div class="col-md-12">
                                    <h7 class="mb-0 ml-10 font-weight-bold">Allowance Type</h7>
                                    <div class="card">
                                        <div class="card-body allowanceRadio">
                                            <?TPLVAR_ALLOWANCE_TYPE?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div id="lumpSumType" class="col-md-12 mb-15 hide">
                            <div class="row">
                                <div class="col-md-12">
                                    <h7 class="mb-0 ml-10 font-weight-bold">Lump Sum Type</h7>
                                    <div class="card">
                                        <div class="card-body lumpSumRadio">
                                            <?TPLVAR_LUMP_SUM_TYPE?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?LANG_FORMULA?>:</label>
                                <input type="text" name="formula" id="formula" class="form-control" value=""
                                       placeholder="<?LANG_ENTER_FORMULA?>" />
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