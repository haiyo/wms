
<div class="tab-pane fade show" id="employeeList">

    <div class="row p-10 mb-0">
        <div class="col-md-3">
            <div class="form-group">
                <input type="search" id="searchUser" placeholder="Search Name or Email" class="form-control" style="width:100%;">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <?TPL_DEPARTMENT_LIST?>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <?TPL_DESIGNATION_LIST?>
            </div>
        </div>
    </div>

    <div id="userList" class="row">
        <?TPL_USER_CARD?>
    </div>
</div>