
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
                            <td><?LANG_AVAILABLE?></td>
                            <td class="text-right"><?TPLVAR_BALANCE?> <?LANG_DAYS?></td>
                        </tr>
                        <tr>
                            <td><div style="width:10px;height:10px;margin-top: 5px;background-color:#<?TPLVAR_COLOR_2?>;"></div></td>
                            <td><?LANG_CONSUMED?></td>
                            <td class="text-right"><?TPLVAR_TOTAL_APPLIED?> <?LANG_DAYS?></td>
                        </tr>
                        <tr>
                            <td><div style="width:10px;height:10px;margin-top: 5px;background-color:#ccc;"></div></td>
                            <td><?LANG_PENDING?></td>
                            <td class="text-right"><?TPLVAR_TOTAL_PENDING?> <?LANG_DAYS?></td>
                        </tr>
                        <tr>
                            <td><div style="width:10px;height:10px;margin-top: 5px;background-color:#ccc;"></div></td>
                            <td><?LANG_ENTITLED?></td>
                            <td class="text-right"><?TPLVAR_TOTAL_LEAVES?> <?LANG_DAYS?></td>
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
                <h6 class="font-weight-semibold mb-0 mt-1"><?LANG_LEAVE_ACTIONS?></h6>
                <a href="#" class="button-next btn btn-primary btn-next mt-20" data-toggle="modal" data-target="#modalApplyLeave"><?LANG_APPLY_LEAVE_NOW?></a>
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
        <th><?LANG_LEAVE_TYPE_CODE?></th>
        <th><?LANG_PERIOD?></th>
        <th><?LANG_DAYS?></th>
        <th><?LANG_REASON?></th>
        <th><?LANG_STATUS?></th>
        <th><?LANG_APPROVED_BY?></th>
        <th><?LANG_ACTIONS?></th>
    </tr>
    </thead>
    <tbody></tbody>
</table>