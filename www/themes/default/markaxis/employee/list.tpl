
<div class="tab-pane fade show" id="employeeList">
    <div class="list-action-btns">
        <ul class="icons-list">
            <li>
                <!-- BEGIN DYNAMIC BLOCK: addEmployeeBtn -->
                <a type="button" class="btn bg-purple-400 btn-labeled" href="<?TPLVAR_ROOT_URL?>admin/user/add">
                    <b><i class="icon-user-plus"></i></b> <?LANG_ADD_NEW_EMPLOYEE?></a>&nbsp;&nbsp;&nbsp;
                <!-- END DYNAMIC BLOCK: addEmployeeBtn -->
                <!--<button type="button" class="btn bg-purple-400 btn-labeled dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <b><i class="icon-stack3"></i></b> Bulk Action <span class="caret"></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right dropdown-employee">
                    <li><a href="<?TPLVAR_ROOT_URL?>admin/employee/upload"><i class="icon-user-plus"></i> Import Employee (CSV/Excel)</a></li>
                    <li><a href="<?TPLVAR_ROOT_URL?>admin/employee/upload"><i class="icon-cloud-download2"></i> Export All Employee Info</a></li>
                </ul>-->
            </li>
        </ul>
    </div>

    <table class="table table-hover employeeTable">
        <thead>
        <tr>
            <th rowspan="2"><?LANG_EMPLOYEE_ID?></th>
            <th colspan="3"><?LANG_HR_INFORMATION?></th>
            <th colspan="3"><?LANG_CONTACT?></th>
        </tr>
        <tr>
            <th><?LANG_NAME?></th>
            <th><?LANG_DESIGNATION?></th>
            <th><?LANG_EMPLOYMENT_STATUS?></th>
            <th><?LANG_EMAIL?></th>
            <th><?LANG_MOBILE?></th>
            <th><?LANG_ACTIONS?></th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>