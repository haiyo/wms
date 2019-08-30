
<script>
    $(function() {
        var employeeTable = $(".employeeTable").DataTable({
            "processing": true,
            "serverSide": true,
            "fnCreatedRow": function (nRow, aData, iDataIndex) {
                $(nRow).attr('id', 'row' + aData['userID']);
            },
            ajax: {
                url: Aurora.ROOT_URL + "admin/employee/results",
                type: "POST",
                data: function ( d ) {
                    d.ajaxCall = 1;
                    d.csrfToken = Aurora.CSRF_TOKEN;
                },
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
                targets: [0],
                orderable: true,
                width: '150px',
                data: 'idnumber'
            },{
                targets: [1],
                orderable: true,
                width: '270px',
                data: 'name',
                render: function(data, type, full, meta) {
                    return '<img src="' + full['photo'] + '" width="32" height="32" style="margin-right:10px" />' + data;
                }
            },{
                targets: [2],
                orderable: true,
                width: '260px',
                data: 'designation'
            },{
                targets: [3],
                searchable : false,
                data: 'status',
                width: '190px',
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
                targets: [4],
                orderable: true,
                width: '220px',
                data: 'email1'
            },{
                targets: [5],
                orderable: true,
                width: '150px',
                data: 'mobile'
            },{
                targets: [6],
                orderable: false,
                searchable : false,
                width: '100px',
                className : "text-center p-0",
                data: 'userID',
                render: function(data, type, full, meta) {
                    var name   = full["name"];
                    var statusText = full['suspended'] == 1 ? "Unsuspend Employee" : "Suspend Employee"

                    return '<div class="list-icons">' +
                                '<div class="list-icons-item dropdown">' +
                                    '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                                        '<i class="icon-menu9"></i></a>' +
                                    '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm" x-placement="bottom-end">' +
                                        '<a class="dropdown-item" data-href="<?TPLVAR_ROOT_URL?>admin/user/view/' + data + '">' +
                                            '<i class="icon-user"></i> View Employee Info</a>' +
                                        '<a class="dropdown-item" href="<?TPLVAR_ROOT_URL?>admin/user/edit/' + data + '">' +
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
            }],
            select: {
                "style": "multi"
            },
            order: [],
            dom: '<"datatable-header"f><"datatable-scroll"t><"datatable-footer"ilp>',
            language: {
                search: '',
                searchPlaceholder: 'Search Employee, Designation or Contract Type',
                lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of Rows:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
            },
            drawCallback: function () {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                Popups.init();
                $(".employeeTable [type=checkbox]").uniform();
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

        // Highlighting rows and columns on mouseover
        var lastIdx = null;

        $(".dataTable tbody").on("mouseover", "td", function( ) {
            var colIdx = employeeTable.cell(this).index( ).column;

            if( colIdx !== lastIdx ) {
                $(employeeTable.cells().nodes()).removeClass("active");
                $(employeeTable.column(colIdx).nodes()).addClass("active");
            }
        }).on("mouseleave", function() {
            $(employeeTable.cells().nodes()).removeClass("active");
        });

        // External table additions
        // ------------------------------

        // Enable Select2 select for the length option
        $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity,
            width: 'auto'
        });

        $(".list-action-btns").insertAfter(".dataTables_filter");
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
<div class="list-action-btns">
    <ul class="icons-list">
        <li>
            <!-- BEGIN DYNAMIC BLOCK: addEmployeeBtn -->
            <a type="button" class="btn bg-purple-400 btn-labeled" href="<?TPLVAR_ROOT_URL?>admin/user/add">
                <b><i class="icon-user-plus"></i></b> <?LANG_ADD_NEW_EMPLOYEE?></a>&nbsp;&nbsp;&nbsp;
            <!-- END DYNAMIC BLOCK: addEmployeeBtn -->
            <button type="button" class="btn bg-purple-400 btn-labeled dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <b><i class="icon-stack3"></i></b> Bulk Action <span class="caret"></span>
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

<table class="table table-hover employeeTable">
    <thead>
    <tr>
        <th rowspan="2">Employee ID</th>
        <th colspan="3">HR Information</th>
        <th colspan="3">Contact</th>
    </tr>
    <tr>
        <th>Name</th>
        <th>Designation</th>
        <th>Employment Status</th>
        <th>E-mail</th>
        <th>Mobile</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody></tbody>
</table>
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