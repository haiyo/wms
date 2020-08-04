
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
            <th>Pay Item Title</th>
            <th>Ordinary Wage</th>
            <th>Deduction</th>
            <th>Deduction AW</th>
            <th>Additional Wage</th>
            <th>Actions</th>
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
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Pay Item Title:</label>
                            <input type="text" name="payItemTitle" id="payItemTitle" class="form-control" value=""
                                   placeholder="Enter a title for this pay item" />
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>This Pay Item Belongs To:</label>
                            <div class="input-group">
                                <span class="input-group-prepend">
                                    <button id="payItemNone" class="btn btn-light payItemBtn" type="button" value="none">None</button>
                                    <button id="payItemOrdinary" class="btn btn-light payItemBtn" type="button" value="ordinary">Ordinary Wage</button>
                                    <button id="payItemDeduction" class="btn btn-light payItemBtn" type="button" value="deduction">Deduction</button>
                                    <button id="payItemDeductionAW" class="btn btn-light payItemBtn" type="button" value="deductionAW">Deduction AW</button>
                                </span>
                                <span class="input-group-append">
                                    <button id="payItemAdditional" class="btn btn-light payItemBtn" type="button" value="additional">Additional Wage</button>
                                </span>
                            </div>
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