
<div class="row mt-10 balance-chart">
    <div class="col-md-9">
        <!-- BEGIN DYNAMIC BLOCK: balChart -->
        <div class="col-md-3">
            <div class="card card-body text-center">
                <h6 class="font-weight-semibold mb-0 mt-1 mb-10"><?TPLVAR_LEAVE_NAME?></h6>
                <div class="svg-center" data-goal="<?TPLVAR_TOTAL_LEAVES?>" data-balance="<?TPLVAR_BALANCE?>" id="progress_<?TPLVAR_ID?>"></div>

                <div class="row mt-20 mb-5 text-left">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td><div style="width:10px;height:10px;margin-top: 5px;background-color:#<?TPLVAR_COLOR_1?>;"></div></td>
                            <td>Available</td>
                            <td class="text-right"><?TPLVAR_BALANCE?> Days</td>
                        </tr>
                        <tr>
                            <td><div style="width:10px;height:10px;margin-top: 5px;background-color:#<?TPLVAR_COLOR_2?>;"></div></td>
                            <td>Consumed</td>
                            <td class="text-right"><?TPLVAR_TOTAL_APPLIED?> Days</td>
                        </tr>
                        <tr>
                            <td><div style="width:10px;height:10px;margin-top: 5px;background-color:#ccc;"></div></td>
                            <td>Pending</td>
                            <td class="text-right"><?TPLVAR_TOTAL_PENDING?> Days</td>
                        </tr>
                        <tr>
                            <td><div style="width:10px;height:10px;margin-top: 5px;background-color:#ccc;"></div></td>
                            <td>Entitled</td>
                            <td class="text-right"><?TPLVAR_TOTAL_LEAVES?> Days</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <!-- END DYNAMIC BLOCK: balChart -->

    </div>

    <div class="col-md-3 pl-0">
        <div class="col-md-12 pl-0">
            <div class="card card-body" style="height:330px;">
                <h6 class="font-weight-semibold mb-0 mt-1">Leave Actions</h6>
                <a href="#" class="button-next btn btn-primary btn-next mt-20" data-toggle="modal" data-target="#modalApplyLeave">Apply Leave Now</a>
                <!--<h6 class="font-weight-semibold mb-10 mt-30">Useful Resources</h6>
                <a href="" target="_blank" class="mt-10 ml-10"><i class="icon-file-text2"></i> Leave Policy Document</a>-->
            </div>
        </div>
    </div>

</div>
<?TPL_CONTENT?>

<table class="table table-bordered leaveHistoryTable">
    <thead>
    <tr>
        <th>Leave Type (Code)</th>
        <th>Period</th>
        <th>Days</th>
        <th>Reason</th>
        <th>Status</th>
        <th>Approved By</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody></tbody>
</table>