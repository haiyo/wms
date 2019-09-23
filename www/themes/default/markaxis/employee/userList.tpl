
<style>
    .col-xl-3 {
        -ms-flex: 0 0 25%;
        flex: 0 0 25%;
        max-width: 25%;
    }
    .img-fluid {
        width:100%;
        max-width: 100%;
        height: auto;
    }
    .text-wrap {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .userCard {
        min-height:390px;
        margin-bottom: 18px;
    }
    .noUser {
        padding: 100px 0 50px;
        text-align:center;
        font-size:28px;
        font-weight:bold;
    }
    .contactText {
        font-size:14px;
    }
</style>
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