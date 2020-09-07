
<div class="tab-pane fade" id="expenses">
    <div class="list-action-btns expense-list-action-btns">
        <ul class="icons-list">
            <li>
                <a type="button" class="btn bg-purple-400 btn-labeled"
                   data-toggle="modal" data-target="#modalExpense" data-backdrop="static" data-keyboard="false">
                    <b><i class="icon-file-plus2"></i></b> <?LANG_CREATE_NEW_EXPENSE_TYPE?>
                </a>
            </li>
        </ul>
    </div>

    <table class="table table-hover datatable tableLayoutFixed expenseTable">
        <thead>
        <tr>
            <th><?LANG_EXPENSE_ITEM_TITLE?></th>
            <th><?LANG_MAX_AMOUT?></th>
            <th><?LANG_ACTIONS?></th>
        </tr>
        </thead>
    </table>
</div>
<div id="modalExpense" class="modal fade">
    <div class="modal-dialog modal-med">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><?LANG_CREATE_NEW_EXPENSE_TYPE?></h6>
            </div>

            <form id="saveExpenseType" name="saveExpenseType" method="post" action="">
            <div class="modal-body overflow-y-visible">
                <input type="hidden" id="eiID" name="eiID" value="0" />
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><?LANG_EXPENSE_TYPE?>:</label>
                            <input type="text" name="expenseTitle" id="expenseTitle" class="form-control" value=""
                                   placeholder="<?LANG_ENTER_TITLE_EXPENSE_TYPE?>" />
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label><?LANG_MAX_ALLOWED_CLAIM?>:</label>
                            <div class="form-group">
                                <div class="col-md-12 p-0">
                                    <input type="text" name="expenseAmount" id="expenseAmount" class="form-control amountInput"
                                           value=""
                                           placeholder="<?LANG_ENTER_AMOUNT?>" />
                                </div>
                            </div>
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