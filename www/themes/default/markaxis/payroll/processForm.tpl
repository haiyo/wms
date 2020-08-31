<form id="processForm" name="processForm" method="post" action="">
    <input type="hidden" id="userID" name="userID" value="<?TPLVAR_USERID?>" />
    <input type="hidden" id="userName" name="userName" value="<?TPLVAR_FNAME?> <?TPLVAR_LNAME?>" />
    <input type="hidden" id="processDate" name="processDate" value="<?TPLVAR_PROCESS_DATE?>" />

    <div class="row" style="border-bottom:1px solid #ccc;margin-top:0;padding-bottom:11px;">
        <div class="col-md-1" style="width:10%;"><img width="95" src="<?TPLVAR_IMAGE?>"></div>
        <div class="col-md-4" style="width:29%;border-right: 1px solid #ccc;">
            <?TPL_COL_1?>
        </div>
        <div class="col-md-4" style="width:37%;padding-left:24px;border-right: 1px solid #ccc;">
            <?TPL_COL_2?>
        </div>
        <div class="col-md-3" style="width:22%;padding-left:24px;">
            <?TPL_COL_3?>
        </div>
    </div>

    <div class="row font-weight-semibold processColHeader">
        <div class="col-md-4"><?LANG_ITEM_TYPE?>:</div>
        <div class="col-md-3 amount"><?LANG_AMOUNT?>:</div>
        <div class="col-md-4 remark"><?LANG_REMARK?></div>
        <div class="col-lg-1 sm-addrm text-right">&nbsp;</div>
    </div>

    <div id="itemWrapper" style="min-height:189px;max-height:189px;margin-bottom:11px;border-bottom: 1px solid #ccc;overflow-y:auto;">
        <!-- BEGIN DYNAMIC BLOCK: item -->
        <div id="itemRowWrapper_<?TPLVAR_ID?>" class="row itemRow <?TPLVAR_DEDUCTION?>" style="border-bottom: 1px solid #ccc;padding-bottom: 11px;">
            <div class="col-md-4">
                <?TPL_PAYROLL_ITEM_LIST?>
            </div>

            <div class="col-md-3 amount">
                <input type="text" name="amount_<?TPLVAR_ID?>" id="amount_<?TPLVAR_ID?>" class="form-control amountInput"
                       data-currency="<?TPLVAR_CURRENCY?>"
                       value="<?TPLVAR_AMOUNT?>" placeholder="" />
            </div>

            <div class="col-md-4 remark">
                <input type="text" name="remark_<?TPLVAR_ID?>" id="remark_<?TPLVAR_ID?>" class="form-control remark"
                       value="<?TPLVAR_REMARK?>" placeholder="" autocomplete="off" data-fouc />
            </div>

            <div class="col-lg-1 sm-addrm text-center">
                <div class="mt-5 iconWrapper">
                    <a href="<?TPLVAR_ID?>" id="<?TPLVAR_HIDDEN_ID?>" class="removeItem"><i id="plus_<?TPLVAR_ID?>" class="icon icon-minus-circle2"></i></a>
                </div>
            </div>
        </div>
        <!-- END DYNAMIC BLOCK: item -->
    </div>
    <!-- BEGIN DYNAMIC BLOCK: hiddenField -->
    <input type="hidden" id="<?TPLVAR_HIDDEN_ID?>" name="<?TPLVAR_HIDDEN_NAME?>" value="<?TPLVAR_VALUE?>" />
    <!-- END DYNAMIC BLOCK: hiddenField -->

    <div id="processSummary">
        <?TPL_PROCESS_SUMMARY?>
    </div>
</form>
<div id="itemTemplate" class="hide">
    <div id="itemRowWrapper_{id}" class="row itemRow {deduction}" style="border-bottom: 1px solid #ccc;padding-bottom: 11px;">
        <div class="col-md-4">
            <?TPL_PAYROLL_ITEM_LIST?>
        </div>

        <div class="col-md-3 amount">
            <input type="text" name="amount_{id}" id="amount_{id}" class="form-control amountInput" value="" placeholder="" />
        </div>

        <div class="col-md-4 remark">
            <input type="text" name="remark_{id}" id="remark_{id}" class="form-control remark" value="" placeholder="" autocomplete="off" data-fouc />
        </div>

        <div class="col-lg-1 sm-addrm text-center">
            <div class="mt-5 iconWrapper">
                <a href="#" class="addItem"><i id="plus_{id}" class="icon icon-plus-circle2"></i></a>
            </div>
        </div>
    </div>
</div>