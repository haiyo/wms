
<div class="tab-pane fade show" id="employeeList">

    <div class="row">
        <div class="list-action-btns">
            <div class="dataTables_filter">
                <input type="search" id="searchUser" placeholder="Search Name or Email" style="width:100%;">
            </div>

            <div class="dataTables_filter">
                <?TPL_DEPARTMENT_LIST?>
            </div>

            <div class="dataTables_filter">
                <?TPL_DESIGNATION_LIST?>
            </div>
        </div>
    </div>

    <div id="userList" class="row">
        <?TPL_USER_CARD?>
    </div>
</div>