
<script>
    $(function() {
        $(".employeeTable").DataTable({
            "processing": true,
            "serverSide": true,
            "fnCreatedRow": function (nRow, aData, iDataIndex) {
                $(nRow).attr('id', 'row' + aData['userID']);
            },
            ajax: {
                url: Aurora.ROOT_URL + "admin/employee/results",
                type: "POST",
                data: function ( d ) { d.ajaxCall = 1; d.csrfToken = Aurora.CSRF_TOKEN; },
            },
            initComplete: function() {
                Popups.init();
                /*var api = this.api();
                var that = this;
                $('input').on('keyup change', function() {
                    if (that.search() !== this.value) {
                        that.search(this.value).draw();
                    }
                });*/
            },
            autoWidth: false,
            mark: true,
            columnDefs: [{
                targets: 0,
                checkboxes: {
                    selectRow: true
                },
                width: '10px',
                orderable: false,
                searchable : false,
                data: 'userID',
                render: function (data, type, full, meta) {
                    return '<input type="checkbox" class="dt-checkboxes" name="id[]" value="' + $('<div/>').text(data).html() + '">';
                }
            },{
                targets: [1],
                orderable: true,
                width: '150px',
                data: 'idnumber'
            },{
                targets: [2],
                orderable: true,
                width: '250px',
                data: 'name'
            },{
                targets: [3],
                orderable: true,
                width: '120px',
                data: 'designation',
                className: "split",
                render: function(data, type, full, meta) {
                    return '<div class="cell"><div>5pm <div>3am</div></div></div>';
                }
            },{
                targets: [4],
                orderable: true,
                width: '120px',
                data: 'designation',
                className: "split",
                render: function(data, type, full, meta) {
                    return '<div class="cell"><div>5pm <div>3am</div></div></div>';
                }
            },{
                targets: [5],
                orderable: true,
                width: '120px',
                data: 'designation',
                className: "split",
                render: function(data, type, full, meta) {
                    return '<div class="cell"><div>5pm <div>3am</div></div></div>';
                }
            },{
                targets: [6],
                orderable: true,
                width: '120px',
                data: 'designation',
                className: "split",
                render: function(data, type, full, meta) {
                    return '<div class="cell"><div>5pm <div>3am</div></div></div>';
                }
            },{
                targets: [7],
                orderable: true,
                width: '120px',
                data: 'designation',
                className: "split",
                render: function(data, type, full, meta) {
                    return '<div class="cell"><div>5pm <div>3am</div></div></div>';
                }
            },{
                targets: [8],
                orderable: true,
                width: '120px',
                data: 'designation',
                className: "split",
                render: function(data, type, full, meta) {
                    return '<div class="cell"><div>5pm <div>3am</div></div></div>';
                }
            },{
                targets: [9],
                orderable: true,
                width: '120px',
                data: 'designation',
                className: "split",
                render: function(data, type, full, meta) {
                    return '<div class="cell"><div>5pm <div>3am</div></div></div>';
                }
            },{
                targets: [10],
                orderable: true,
                width: '120px',
                data: 'designation',
                render: function(data, type, full, meta) {
                    return "10 Hours";
                }
            }


                /*,{
                targets: [4],
                searchable : false,
                data: 'status',
                width: '130px',
                className : "text-center",
                render: function(data, type, full, meta) {
                    var reason = full['suspendReason'] ? ' data-popup="tooltip" title="" data-placement="bottom" data-original-title="' + full['suspendReason'] + '"' : "";

                    if( full['suspended'] == 1 ) {
                        return '<span id="status' + full['userID'] + '" class="label label-danger"' + reason + '>Suspended</span>';
                    }
                    else {
                        if( full['endDate'] ) {
                            if( dateDiff( full['endDate'] ) <= 30 ) {
                                reason = ' data-popup="tooltip" title="" data-placement="bottom" data-original-title="Expire on ' + full['endDate'] + '"'
                                return '<span id="status' + full['userID'] + '" class="label label-pending"' + reason + '>Expired Soon</span>';
                            }
                        }
                        return '<span id="status' + full['userID'] + '" class="label label-success"' + reason + '>Active</span>';
                    }
                }
            },{
                targets: [5],
                orderable: true,
                width: '220px',
                data: 'email'
            },{
                targets: [6],
                orderable: true,
                width: '150px',
                data: 'mobile'
            },{
                targets: [7],
                orderable: false,
                searchable : false,
                width: '100px',
                className : "text-center",
                data: 'userID',
                render: function(data, type, full, meta) {
                    var name   = full["name"];
                    var statusText = full['suspended'] == 1 ? "Unsuspend Employee" : "Suspend Employee"

                    return '<div class="list-icons">' +
                                '<div class="list-icons-item dropdown">' +
                                    '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                                        '<i class="icon-menu9"></i></a>' +
                                    '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm dropdown-employee" x-placement="bottom-end">' +
                                        '<a class="dropdown-item" data-href="<?TPLVAR_ROOT_URL?>admin/employee/view">' +
                                            '<i class="icon-user"></i> View Employee Info</a>' +
                                        '<a class="dropdown-item" href="<?TPLVAR_ROOT_URL?>admin/employee/edit/' + data + '">' +
                                            '<i class="icon-pencil5"></i> Edit Employee Info</a>' +
                                        '<a class="dropdown-item" href="<?TPLVAR_ROOT_URL?>admin/employee/email/' + data + '">' +
                                            '<i class="icon-mail5"></i> Message Employee</a>' +
                                        '<a class="dropdown-item" data-title="View ' + name + ' History Log" href="<?TPLVAR_ROOT_URL?>admin/employee/log/' + data + '">' +
                                            '<i class="icon-history"></i> View History Log</a>' +
                                        '<div class="divider"></div>' +
                                        '<a class="dropdown-item" id="menuSetStatus' + full['userID'] + '" href="#" onclick="return setSuspend(' + data + ', \'' + name + '\')">' +
                                        '<i class="icon-user-block"></i> ' + statusText + '</a>' +
                                        '<a class="dropdown-item" id="menuSetStatus' + full['userID'] + '" href="#" onclick="return setResign(' + data + ', \'' + name + '\')">' +
                                        '<i class="icon-exit3"></i> Employee Resigned</a>' +
                                    '</div>' +
                                '</div>' +
                            '</div>';
                }
            }*/],
            select: {
                "style": "multi"
            },
            order: [],
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                search: '',
                searchPlaceholder: 'Search Employee',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
            },
            drawCallback: function () {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                Popups.init();
            },
            preDrawCallback: function() {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
            }
        });

        // Alternative pagination
        $('.datatable-pagination').DataTable({
            pagingType: "simple",
            language: {
                paginate: {'next': 'Next &rarr;', 'previous': '&larr; Prev'}
            }
        });

        // Datatable with saving state
        $('.datatable-save-state').DataTable({
            stateSave: true
        });

        // Scrollable datatable
        $('.datatable-scroll-y').DataTable({
            autoWidth: true,
            scrollY: 300
        });

        var table = $(".dataTable").DataTable( );

        $(".dataTable tbody").on("mouseover", "td", function( ) {
            var colIdx = table.cell(this).index( ).column;

            if( colIdx !== null ) {
                $(table.cells().nodes()).removeClass("active");
                $(table.column(colIdx).nodes()).addClass("active");
            }
        }).on("mouseleave", function() {
            $(table.cells().nodes()).removeClass("active");
        });

        // External table additions
        // ------------------------------

        // Enable Select2 select for the length option
        $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity,
            width: 'auto'
        });

        $('.form-control-datepicker').datepicker();
    });

    function dateDiff( date ) {
        var date = date.split('-');
        var firstDate = new Date( );
        var secondDate = new Date( date[0], (date[1]-1), date[2] );
        return Math.round( ( secondDate-firstDate ) / (1000*60*60*24 ) );
    }

    function setSuspend( userID, name ) {
        if( $("#status" + userID).hasClass("label-success") ) {
            status = 1;
            title = "Are you sure you want to suspend " + name + "?";
            text  = "This employee will no longer be able to login to the HRS System.";
            confirmButtonText = "Confirm Suspend";
        }
        else {
            status = 0;
            title = "Are you sure you want to unsuspend " + name + "?";
            text  = "This employee will be able to login to the HRS System.";
            confirmButtonText = "Confirm Unsuspend";
        }

        swal({
            title: title,
            text: text,
            type: "input",
            inputPlaceholder: "Provide reason(s) if any",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: confirmButtonText,
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        }, function (isConfirm) {
            if (isConfirm === false) return;

            var data = {
                bundle: {
                    userID : userID,
                    status : status,
                    reason: isConfirm
                },
                success: function( res ) {
                    var obj = $.parseJSON( res );
                    if( obj.bool == 0 ) {
                        swal("Error!", obj.errMsg, "error");
                        return;
                    }
                    else {
                        var reason = isConfirm ? ' data-popup="tooltip" title="" data-placement="bottom" data-original-title="' + isConfirm     + '"' : "";

                        if( status == 1 ) {
                            $("#menuSetStatus" + userID).html('<i class="icon-user-check"></i> Unsuspend Employee');
                            $("#status" + userID).replaceWith('<span id="status' + userID + '" class="label label-danger"' + reason + '>Suspended</span>');
                            swal("Done!", name + " has been successfully suspended!", "success");
                        }
                        else {
                            $("#menuSetStatus" + userID).html('<i class="icon-user-block"></i> Suspend Employee');
                            $("#status" + userID).replaceWith('<span id="status' + userID + '" class="label label-success"' + reason + '>Active</span>');
                            swal("Done!", name + " has been successfully unsuspended!", "success");
                        }
                        Popups.init();
                        return;
                    }
                }
            };
            Aurora.WebService.AJAX( "admin/employee/setSuspendStatus", data );
        });
        return false;
    }


    function setResign( userID, name ) {
        swal({
            title: "Set " + name + " as Resigned Employee?",
            text: name + "'s account will be move to the Alumni section.",
            type: "input",
            inputPlaceholder: "Provide reason(s) if any",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Confirm Delete",
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        }, function (isConfirm) {
            if (isConfirm === false) return;

            var data = {
                bundle: {
                    userID: userID,
                    status: 1,
                    reason: isConfirm
                },
                success: function (res) {
                    var obj = $.parseJSON(res);
                    if (obj.bool == 0) {
                        swal("Error!", obj.errMsg, "error");
                        return;
                    }
                    else {
                        $("#row" + userID).fadeOut("slow");
                        swal("Done!", name + " has been successfully set to Resigned!", "success");
                        return;
                    }
                }
            };
            Aurora.WebService.AJAX("admin/employee/setResignStatus", data);
        });
        return false;
    }
</script>
<style>
    @media (min-width: 768px) {
        .justify-content-md-center {
            -ms-flex-pack: center !important;
            justify-content: center !important;
        }
    }
    .sidebar-light {
        background-color: #fff;
        color: #333;
        border-right: 1px solid rgba(0,0,0,.125);
        background-clip: content-box;
    }
    .sidebar-component {
        border: 1px solid transparent;
        border-radius: .1875em;
        box-shadow: 0 1px 2px rgba(0,0,0,.05);
    }
    .sidebar-component.sidebar-light {
        border-color: rgba(0,0,0,.125);
    }
    .sidebar:not(.bg-transparent) .card {
        border-width: 0;
        margin-bottom: 0;
        border-radius: 0;
        box-shadow: none;
    }
    .sidebar:not(.bg-transparent) .card:not([class*=bg-]):not(.fixed-top) {
        background-color: transparent;
    }
    .card-header {
        padding: .9375rem 1.25em;
        margin-bottom: 0;
        background-color: rgba(0,0,0,.02);
        border-bottom: 1px solid rgba(0,0,0,.125);
    }
    .header-elements-inline {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        -ms-flex-pack: justify;
        justify-content: space-between;
        -ms-flex-wrap: nowrap;
        flex-wrap: nowrap;
    }
    .card-header:first-child {
        border-radius: .125em .125em 0 0;
    }
    .form-group-feedback {
        position: relative;
    }
    .form-control-feedback {
        position: absolute;
        top: 0;
        color: #333;
        padding-left: .875em;
        padding-right: .875em;
        line-height: 2.8em;
        min-width: 1rem;
    }
    .form-group-feedback-right .form-control-feedback {
        right: 0;
    }

    @media (min-width: 768px) {
        .sidebar-expand-md.sidebar-component-left {
            margin-right: 1.25em;
        }
    }
    @media (min-width: 768px) {
        .sidebar-expand-md.sidebar-component {
            display: block;
        }
    }
    .d-md-flex .sidebar {
        -ms-flex: 0 0 auto;
        flex: 0 0 auto;
        width:320px;
    }
    .col-6 {
        -ms-flex: 0 0 50%;
        flex: 0 0 50%;
        max-width: 50%;
    }
    .row {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: -.625em;
        margin-left: -.625em;
    }
    .row-tile div[class*=col]+div[class*=col] .btn {
        border-left: 0;
    }
    .no-gutters {
        margin-right: 0 !important;
        margin-left: 0 !important;
    }
    .no-gutters>.col, .no-gutters>[class*=col-] {
        padding-right: 0 !important;
        padding-left: 0 !important;
    }
    .row-tile div[class*=col] .btn {
        border-radius: 0;
    }
    .row-tile div[class*=col]:first-child .btn:first-child {
        border-top-left-radius: .1875em;
    }
    .nav-sidebar .nav-item-header {
        padding: .75em 2.9em;
        margin-top: .5em;
    }
    .sidebar-light .nav-sidebar .nav-item-header {
        color: rgba(51,51,51,.5);
    }
    .nav {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        padding-left: 0;
        margin-bottom: 0;
        list-style: none;
    }
    .nav-sidebar {
        -ms-flex-direction: column;
        flex-direction: column;
    }
    .nav-sidebar .nav-item:not(.nav-item-divider) {
        margin-bottom: 1px;
    }
    .nav-sidebar .nav-link {
        position: relative;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: start;
        align-items: flex-start;
        padding:.75em 2.9em;
        transition: background-color ease-in-out .15s,color ease-in-out .15s;
    }
    .nav-sidebar>.nav-item>.nav-link {
        font-weight: 500;
    }
    .sidebar-light .nav-sidebar .nav-link {
        color: rgba(51,51,51,.85);
    }
    .nav-sidebar .nav-link i {
        margin-right: 1.25em;
        margin-top: .12502em;
        margin-bottom: .12502em;
        top: 0;
    }
    .p-0 {
        padding: 0!important;
    }
    .mb-2, .my-2 {
        margin-bottom:1.625em!important;
    }
    .rounded-round {
        border-radius: 100px!important;
    }
    .form-control-datepicker {
        margin-top:0px;
    }
    .ui-datepicker {
        border:none;
        border-radius:0px;
        -webkit-box-shadow:none;
        box-shadow:none;
    }
    td .cell {
        display:table;
        width:100%;
        height: 43px;
        position: relative;
    }
    tbody td.split {
        background: -webkit-linear-gradient(-19deg, #efefef 50%, #fff 50%);
        background: linear-gradient(-19deg, #efefef 50%, #fff 50%);
        color: #333;
        padding: 0 !important;
    }
    tbody td.split div div {
        position:absolute;
    }
    tbody td.split > div > div {
        top: 6px;
        left: 17px;
    }
    tbody td.split > div > div > div {
        bottom: -13px;
        left: 72px;
    }
    tfoot td {
        background:none !important;
        padding: 12px 20px !important;
    }
</style>


<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Timesheet<a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li>
                    <a type="button" class="btn bg-purple-400 btn-labeled" href="<?TPLVAR_ROOT_URL?>admin/employee/add">
                        <b><i class="icon-user-plus"></i></b> <?LANG_ADD_NEW_EMPLOYEE?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn bg-purple-400 btn-labeled dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <b><i class="icon-reading"></i></b> Bulk Action <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right dropdown-employee">
                        <li><a href="<?TPLVAR_ROOT_URL?>admin/employee/upload"><i class="icon-user-plus"></i> Import Employee (CSV/Excel)</a></li>
                        <li><a href="<?TPLVAR_ROOT_URL?>admin/employee/upload"><i class="icon-cloud-download2"></i> Export All Employees</a></li>
                        <li><a href="<?TPLVAR_ROOT_URL?>admin/employee/email"><i class="icon-mail5"></i> Message Selected Employees</a></li>
                        <li class="divider"></li>
                        <li><a href="#"><i class="icon-user-block"></i> Suspend Selected Employees</a></li>
                        <li><a href="<?TPLVAR_ROOT_URL?>admin/employee/delete"><i class="icon-user-minus"></i> Delete Selected Employees</a></li>
                        <li class="divider"></li>
                        <li><a href="<?TPLVAR_ROOT_URL?>admin/employee/settings"><i class="icon-gear"></i> Employee Settings</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    <table class="table table-bordered employeeTable">
        <thead>

        <tr>
            <th></th>
            <th>Employee ID</th>
            <th>Name</th>
            <th>Sat 9/6</th>
            <th>Sun 9/7</th>
            <th>Mon 9/8</th>
            <th>Tue 9/9</th>
            <th>Wed 9/10</th>
            <th>Thu 9/11</th>
            <th>Fri 9/12</th>
            <th>Total Hours</th>
        </tr>
        </thead>
        <tbody></tbody>
        <tfoot>
        <tr>
            <td></td>
            <td></td>
            <td>Day Total</td>
            <td>30 Hours</td>
            <td>30 Hours</td>
            <td>30 Hours</td>
            <td>30 Hours</td>
            <td>30 Hours</td>
            <td>30 Hours</td>
            <td>30 Hours</td>
            <td>150 Hours</td>
        </tr>
        </tfoot>
    </table>
</div>
<div id="modalLoad" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title">Info header</h6>
            </div>

            <div class="modal-body"></div>

            <div class="modal-footer">
                <!--<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div>
    </div>
</div>