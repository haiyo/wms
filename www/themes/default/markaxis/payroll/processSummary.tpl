<div class="row payrollProcessSummary">
    <div class="col-md-4">&nbsp;</div>
    <div class="col-md-4">&nbsp;</div>

    <div class="col-md-4">
        &nbsp;
    </div>
</div>

<div class="row payrollProcessSummary">
    <div class="col-md-4">&nbsp;</div>

    <div class="col-md-4 text-light" style="border-bottom:1px solid #ccc;">
        <div class="col-md-8 text-right" style="padding:5px;">
            <strong>Employer CPF Contribution:</strong>
        </div>
        <div class="col-md-4 text-right" style="padding:5px;">
            <?TPLVAR_CURRENCY?><?TPLVAR_CONTRIBUTION_AMOUNT?>
        </div>
    </div>

    <div class="col-md-4" style="border-bottom:1px solid #ccc;">
        <div class="col-md-8 text-right" style="padding:5px;">
            <strong>Total Gross Salary:</strong>
        </div>
        <div class="col-md-4 text-right" style="padding:5px;">
            <?TPLVAR_CURRENCY?><?TPLVAR_GROSS_AMOUNT?>
        </div>
    </div>

</div>

<div class="row payrollProcessSummary">
    <div class="col-md-4">&nbsp;</div>

    <div class="col-md-4 text-light" style="border-bottom:1px solid #ccc;">
        <div class="col-md-8 text-right" style="padding:5px;">
            <strong>Foreign Worker Levy (FWL):</strong>
        </div>
        <div class="col-md-4 text-right" style="padding:5px;">
            <?TPLVAR_CURRENCY?><?TPLVAR_FWL_AMOUNT?>
        </div>
    </div>

    <div class="col-md-4" style="border-bottom:1px solid #ccc;">
        <div class="col-md-8 text-right" style="padding:5px;">
            <strong>Total Claim:</strong>
        </div>
        <div class="col-md-4 text-right" style="padding:5px;">
            <?TPLVAR_CURRENCY?><?TPLVAR_CLAIM_AMOUNT?>
        </div>
    </div>
</div>

<div class="row payrollProcessSummary">
    <div class="col-md-4">
        <div class="prePopulateTxt">
            <div class="row">
                <div class="tipsIco"><strong><i class="mi-lightbulb-outline"></i></strong></div>
                <div class="tipsTxt">
                    <strong>Tips:</strong>
                    You can pre-populate employee's payroll using previous month
                    template. This saves you time to re-enter the same set of data every month.
                </div>
            </div>
            <button id="useTemplate" type="submit" class="btn btn-primary useTemplate">Use Previous Month Template</button>
        </div>
    </div>

    <div class="col-md-4 text-light" style="border-bottom:1px solid #ccc;">
        <div class="col-md-8 text-right" style="padding:5px;">
            <strong>Skill Development Levy (SDL):</strong>
        </div>
        <div class="col-md-4 text-right" style="padding:5px;">
            <?TPLVAR_CURRENCY?><?TPLVAR_SDL_AMOUNT?>
        </div>
    </div>

    <div class="col-md-4" style="border-bottom:1px solid #ccc;">
        <div class="col-md-8 text-right" style="padding:5px;">
            <strong>Total Tax / Deduction:</strong>
        </div>
        <div class="col-md-4 text-right" style="padding:5px;">
            <?TPLVAR_CURRENCY?><?TPLVAR_DEDUCTION_AMOUNT?>
        </div>
    </div>
</div>

<div class="row payrollProcessSummary">
    <div class="col-md-4">&nbsp;</div>

    <div class="col-md-4 text-light" style="">
        <div class="col-md-8 text-right" style="padding:5px;">
            <strong>Total Employer Contribution:</strong>
        </div>
        <div class="col-md-4 text-right" style="padding:5px;">
            <?TPLVAR_CURRENCY?><?TPLVAR_TOTAL_CONTRIBUTION?>
        </div>
    </div>

    <div class="col-md-4" style="">
        <div class="col-md-8 text-right" style="padding:5px;">
            <strong>Total Net Payable:</strong>
        </div>
        <div class="col-md-4 text-right" style="padding:5px;">
            <?TPLVAR_CURRENCY?><?TPLVAR_NET_AMOUNT?>
        </div>
    </div>
</div>