
<div class="tab-pane fade show" id="employeeList">

    <div class="row">
        <div class="list-action-btns">
            <div id="DataTables_Table_0_filter" class="dataTables_filter" style="margin:0 10px 0">
                <label>
                    <input type="search" id="searchUser" placeholder="Search Name or Email" style="width: 365px;">
                </label>
            </div>

            <div class="dataTables_length" id="DataTables_Table_1_length" style="width:300px;">
                <?TPL_DEPARTMENT_LIST?>
            </div>

            <div class="dataTables_length" id="DataTables_Table_1_length" style="width:300px;">
                <?TPL_DESIGNATION_LIST?>
            </div>
        </div>
    </div>

    <div id="userList" class="row">
        <?TPL_USER_CARD?>
    </div>
</div>