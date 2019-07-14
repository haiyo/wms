<div class="row col-md-12">

    <div class="col-md-4">
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

    <div class="col-md-4">
        <div class="col-md-12 text-light" style="border-bottom:1px solid #ccc;">
            <div class="col-md-8 text-right" style="padding:5px;">
                <strong>Employer CPF Contribution:</strong>
            </div>
            <div class="col-md-4 text-right" style="padding:5px;">
                <?TPLVAR_CURRENCY?><?TPLVAR_CONTRIBUTION_AMOUNT?>
            </div>
        </div>

        <div class="col-md-12 text-light" style="border-bottom:1px solid #ccc;">
            <div class="col-md-8 text-right" style="padding:5px;">
                <strong>Foreign Worker Levy (FWL):</strong>
            </div>
            <div class="col-md-4 text-right" style="padding:5px;">
                <?TPLVAR_CURRENCY?><?TPLVAR_FWL_AMOUNT?>
            </div>
        </div>

        <div class="col-md-12 text-light" style="border-bottom:1px solid #ccc;">
            <div class="col-md-8 text-right" style="padding:5px;">
                <strong>Skill Development Levy (SDL):</strong>
            </div>
            <div class="col-md-4 text-right" style="padding:5px;">
                <?TPLVAR_CURRENCY?><?TPLVAR_SDL_AMOUNT?>
            </div>
        </div>

        <div class="col-md-12 text-light" style="border-bottom:1px solid #ccc;">
            <div class="col-md-8 text-right" style="padding:5px;">
                <strong>Total Employer Levy:</strong>
            </div>
            <div class="col-md-4 text-right" style="padding:5px;">
                <?TPLVAR_CURRENCY?><?TPLVAR_TOTAL_LEVY?>
            </div>
        </div>

        <div class="col-md-12 text-light" style="">
            <div class="col-md-8 text-right" style="padding:5px;">
                <strong>Total Employer Contribution:</strong>
            </div>
            <div class="col-md-4 text-right" style="padding:5px;">
                <?TPLVAR_CURRENCY?><?TPLVAR_TOTAL_CONTRIBUTION?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="col-md-12" style="border-bottom:1px solid #ccc;">
            <div class="col-md-8 text-right" style="padding:5px;">
                <strong>Total Gross:</strong>
            </div>
            <div class="col-md-4 text-right" style="padding:5px;">
                <?TPLVAR_CURRENCY?><?TPLVAR_GROSS_AMOUNT?>
            </div>
        </div>

        <div class="col-md-12" style="border-bottom:1px solid #ccc;">
            <div class="col-md-8 text-right" style="padding:5px;">
                <strong>Total Claim:</strong>
            </div>
            <div class="col-md-4 text-right" style="padding:5px;">
                <?TPLVAR_CURRENCY?><?TPLVAR_CLAIM_AMOUNT?>
            </div>
        </div>

        <!-- BEGIN DYNAMIC BLOCK: deductionSummary -->
        <div class="col-md-12" style="border-bottom:1px solid #ccc;">
            <div class="col-md-8 text-right" style="padding:5px;">
                <strong><?TPLVAR_TITLE?>:</strong>
            </div>
            <div class="col-md-4 text-right" style="padding:5px;">
                <?TPLVAR_CURRENCY?><?TPLVAR_DEDUCTION_AMOUNT?>
            </div>
        </div>
        <!-- END DYNAMIC BLOCK: deductionSummary -->

        <div class="col-md-12" style="">
            <div class="col-md-8 text-right" style="padding:5px;">
                <strong>Total Net Payable:</strong>
            </div>
            <div class="col-md-4 text-right" style="padding:5px;">
                <?TPLVAR_CURRENCY?><?TPLVAR_NET_AMOUNT?>
            </div>
        </div>
    </div>
</div>