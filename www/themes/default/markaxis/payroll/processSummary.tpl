<div class="row col-md-12">

    <!--<div class="col-md-4">
        <div class="row">
            <div class="tipsIco"><strong><i class="mi-lightbulb-outline"></i></strong></div>
            <div class="tipsTxt">
                <strong>Tips:</strong>
                You can pre-populate employee's payroll using previous month
                template. This saves you time to re-enter the same set of data every month.
            </div>
        </div>
        <button id="useTemplate" type="submit" class="btn btn-primary useTemplate">Use Previous Month Template</button>
    </div>-->

    <div class="col-md-6">

        <!-- BEGIN DYNAMIC BLOCK: employerItem -->
        <div class="col-md-12 text-light summaryItem">
            <div class="col-md-8 text-right p-5">
                <strong><?TPLVAR_TITLE?> <i class="icon-info22 mr-3 <?TPLVAR_SHOW_TIP?>" data-popup="tooltip" title="" data-html="true"
                                            data-original-title="<?TPLVAR_REMARK?>"></i>:</strong>
            </div>
            <div class="col-md-4 text-right p-5">
                <?TPLVAR_CURRENCY?><?TPLVAR_AMOUNT?>
            </div>
        </div>
        <!-- END DYNAMIC BLOCK: employerItem -->
    </div>

    <div class="col-md-6">
        <div class="col-md-12 summaryItem">
            <div class="col-md-8 text-right p-5">
                <strong><?LANG_TOTAL_GROSS?>:</strong>
            </div>
            <div class="col-md-4 text-right p-5">
                <?TPLVAR_CURRENCY?><?TPLVAR_GROSS_AMOUNT?>
            </div>
        </div>

        <!-- BEGIN DYNAMIC BLOCK: deductionSummary -->
        <div class="col-md-12 summaryItem">
            <div class="col-md-8 text-right p-5">
                <strong><?TPLVAR_TITLE?> <i class="icon-info22 mr-3 <?TPLVAR_SHOW_TIP?>" data-popup="tooltip" title="" data-html="true"
                                            data-original-title="<?TPLVAR_REMARK?>"></i>:</strong>
            </div>
            <div class="col-md-4 text-right p-5">
                <?TPLVAR_CURRENCY?><?TPLVAR_AMOUNT?>
            </div>
        </div>
        <!-- END DYNAMIC BLOCK: deductionSummary -->

        <div class="col-md-12">
            <div class="col-md-8 text-right p-5">
                <strong><?LANG_TOTAL_NET_PAYABLE?>:</strong>
            </div>
            <div class="col-md-4 text-right p-5">
                <?TPLVAR_CURRENCY?><?TPLVAR_NET_AMOUNT?>
            </div>
        </div>
    </div>
</div>