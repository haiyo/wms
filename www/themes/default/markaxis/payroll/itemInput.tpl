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