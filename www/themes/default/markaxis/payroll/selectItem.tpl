<div class="tab-pane fade show active" id="monthly">
    <table class="table table-hover table-pay-items select-employees-table">
        <thead>
        <tr>
            <th>Employee ID</th>
            <th>Employee Name</th>
            <th class="table-pay-items___type-header">Type</th>
            <th class="table-pay-items___amount-col">
                <span>Amount</span>
            </th>
            <th class="table-pay-items___remarks-col">
                <span>Remarks</span>
                <i data-placement="bottom" tips-content="Remarks added will be displayed in the payslip" tooltip="" class="fa fa-info-circle"
                   data-toggle="tooltip" data-original-title="" title=""></i>
            </th>
            <th><span>CPF</span>
                <i data-placement="bottom"
                   tips-content="<a target='_blank' href='https://www.cpf.gov.sg/Assets/employers/Documents/Allowances_and_payments_that_attract_CPF_contributions.pdf'>Full list</a> of pay items that attract CPF contribution<br><br>A deduction with CPF unchecked is subtracted from net salary after CPF deduction" tooltip="" class="fa fa-info-circle" data-toggle="tooltip" data-original-title="" title=""></i></th>
            <th><span>Taxable</span><i data-placement="bottom" tips-content="Click <a target='_blank' href='https://www.iras.gov.sg/irashome/Businesses/Employers/Tax-Treatment-of-Employee-Remuneration/'>here</a> for a full list of pay items that attract income tax contribution" tooltip="" class="fa fa-info-circle" data-toggle="tooltip" data-original-title="" title=""></i></th>
            <th><span>SDL</span></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <!-- BEGIN DYNAMIC BLOCK: monthly -->
        <tr>
            <td class="invisible-cells ng-binding"><?TPLVAR_IDNUMBER?></td>
            <td class="invisible-cells">
                <div>
                    <div class="table-pay-items___add-new"><span><?TPLVAR_NAME?></span><i class="fa fa-plus-circle"></i></div>
                </div>
                <div><span class="table-pay-items___citizenship ng-binding"><?TPLVAR_POSITION?></span></div>
            </td>
            <td class="table-pay-items___type">
                <select class="form-control" required="">
                    <option label="Allowance" value="string:Allowance">Allowance</option>
                    <option label="Basic Pay" value="string:Basic Pay" selected="selected">Basic Pay</option>
                    <option label="Basic Pay(without proration)" value="Basic Pay(without proration)">Basic Pay(without proration)</option>
                    <option label="Commission (Daily/Weekly/Monthly)" value="string:Commission (Daily/Weekly/Monthly)">Commission (Daily/Weekly/Monthly)</option>
                    <option label="Deduction" value="string:Deduction">Deduction</option>
                    <option label="Deduction (from Net Salary)" value="Deduction (from Net Salary)">Deduction (from Net Salary)</option>
                    <option label="Deduction (from Net Salary)(no SHG contribution)" value="Deduction (from Net Salary)(no SHG contribution)">Deduction (from Net Salary)(no SHG contribution)</option>
                    <option label="Director fees" value="string:Director fees">Director fees</option>
                    <option label="Extra Duty Allowance" value="string:Extra Duty Allowance">Extra Duty Allowance</option>
                    <option label="Housing/ Rental Allowance" value="string:Housing/ Rental Allowance">Housing/ Rental Allowance</option>
                    <option label="Incentive Allowance" value="string:Incentive Allowance">Incentive Allowance</option>
                    <option label="Meal Allowance" value="string:Meal Allowance">Meal Allowance</option>
                    <option label="Per Diem Allowance" value="string:Per Diem Allowance">Per Diem Allowance</option>
                    <option label="Tips" value="string:Tips">Tips</option>
                    <option label="Transport Allowance" value="string:Transport Allowance">Transport Allowance</option>
                </select>
            </td>
            <td><input class="form-control" type="text"></td>
            <td><input class="form-control" type="text"></td>
            <td class="table-pay-items___preferences">
                <i class="fa fa-square-o ng-hide"></i>
                <i class="fa fa-check-square-o"></i>
            </td>
            <td class="table-pay-items___preferences">
                <i class="fa fa-square-o ng-hide" ng-show="!payItem.preferences.sg_tax"></i>
                <i class="fa fa-check-square-o" ng-show="payItem.preferences.sg_tax"></i></td>
            <td class="table-pay-items___preferences" ng-click="payItem.preferences.sg_sdl = !payItem.preferences.sg_sdl; func.autosaveRecurring(payItem)">
                <i class="fa fa-square-o ng-hide" ng-show="!payItem.preferences.sg_sdl"></i>
                <i class="fa fa-check-square-o" ng-show="payItem.preferences.sg_sdl"></i>
            </td>
            <td class="table-pay-items___remove-item" ng-click="func.removeRecurringPayItem(payItem, $index)">
                <i class="fa fa-minus-circle"></i></td>
        </tr>
        <!-- END DYNAMIC BLOCK: monthly -->
        <tr>
            <td colspan="2"><span>1 people</span><button class="ui-btn ui-btn-sec">Add/Remove Employees</button></td>
            <td>Total:</td>
            <td class="table-pay-items___total ng-binding">$0.00</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tbody>
    </table>
</div>

<div class="tab-pane fade" id="adhoc">
    Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid laeggin.
</div>

<div class="tab-pane fade" id="hourly">
    DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg whatever.
</div>