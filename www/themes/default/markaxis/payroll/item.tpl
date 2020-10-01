<div id="itemWrapper" style="min-height:189px;max-height:189px;margin-bottom:11px;border-bottom: 1px solid #ccc;overflow-y:auto;">
    <!-- BEGIN DYNAMIC BLOCK: item -->
    <div id="itemRowWrapper" class="row itemRow" style="border-bottom: 1px solid #ccc;padding-bottom: 11px;">
        <div class="col-md-4" style="line-height:39px;">
            <?TPL_PAYROLL_ITEM_LIST?>
        </div>

        <div class="col-md-3 amount" style="line-height:39px;">
            <?TPLVAR_AMOUNT?>
        </div>

        <div class="col-md-4 remark" style="line-height:39px;">
            <?TPLVAR_REMARK?>
        </div>
    </div>
    <!-- END DYNAMIC BLOCK: item -->
</div>