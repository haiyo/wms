/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: employee.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisEmployee = (function( ) {

    /**
     * MarkaxisEmployee Constructor
     * @return void
     */
    MarkaxisEmployee = function( ) {
        this.table = null;
        this.init( );
    };

    MarkaxisEmployee.prototype = {
        constructor: MarkaxisEmployee,

        /**
         * Initialize first onload setup
         * @return void
         */
        init: function( ) {
            this.initTable( );
            this.initEvents( );
        },


        /**
         * Events Registration
         * @return void
         */
        initEvents: function( ) {
            var that = this;

            $(document).on("click", ".setSuspend", function(e) {
                that.setSuspend( $(this).attr("data-id"), $(this).attr("data-name"), $(this).attr("data-status") );
                e.preventDefault( );
            });

            $(document).on("click", ".setResign", function (e) {
                that.setResign( $(this).attr("data-id"), $(this).attr("data-name"), $(this).attr("data-status") );
                e.preventDefault( );
            });

            $(document).on("click", ".deleteEmployee", function (e) {
                that.deleteEmployee( $(this).attr("data-id"), $(this).attr("data-name") );
                e.preventDefault( );
            });
        },


        dateDiff: function( date ) {
            var dateSplit = date.split('-');
            var firstDate = new Date( );
            var secondDate = new Date( dateSplit[0], (dateSplit[1]-1), dateSplit[2] );
            return Math.round( ( secondDate-firstDate ) / (1000*60*60*24 ) );
        },


        setSuspend: function( userID, name, status ) {
            var that = this;
            if( status == 0 ) {
                setStatus = 1;
                swalType = "input";
                title = Markaxis.i18n.EmployeeRes.LANG_CONFIRM_SUSPEND_NAME.replace('{name}', name);
                text  = Markaxis.i18n.EmployeeRes.LANG_NO_LOGIN_HRS;
                confirmButtonText = Markaxis.i18n.EmployeeRes.LANG_CONFIRM_SUSPEND;
            }
            else {
                setStatus = 0;
                swalType = "warning";
                title = Markaxis.i18n.EmployeeRes.LANG_CONFIRM_UNSUSPEND.replace('{name}', name);
                text  = Markaxis.i18n.EmployeeRes.LANG_ABLE_LOGIN_HRS;
                confirmButtonText = Markaxis.i18n.EmployeeRes.LANG_CONFIRM_UNSUSPEND;
            }

            swal({
                title: title,
                text: text,
                type: swalType,
                inputPlaceholder: Markaxis.i18n.EmployeeRes.LANG_PROVIDE_REASON,
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
                        status : setStatus,
                        reason: isConfirm
                    },
                    success: function( res ) {
                        var obj = $.parseJSON( res );
                        if( obj.bool == 0 ) {
                            swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            that.table.ajax.reload();

                            //var reason = isConfirm ? ' data-popup="tooltip" title="" data-placement="bottom" data-original-title="' + isConfirm     + '"' : "";

                            if( setStatus == 1 ) {
                                swal( Aurora.i18n.GlobalRes.LANG_DONE + "!", Markaxis.i18n.EmployeeRes.LANG_SUCCESSFULLY_SUSPENDED.replace('{name}', name), "success");
                            }
                            else {
                                swal( Aurora.i18n.GlobalRes.LANG_DONE + "!", Markaxis.i18n.EmployeeRes.LANG_SUCCESSFULLY_UNSUSPENDED.replace('{name}', name), "success");
                            }
                            Popups.init();
                            return;
                        }
                    }
                };
                Aurora.WebService.AJAX( "admin/employee/setSuspendStatus", data );
            });
        },


        setResign: function( userID, name, status ) {
            var that = this;
            if( status == 0 ) {
                setStatus = 1;
                title = Markaxis.i18n.EmployeeRes.LANG_SET_RESIGNED_EMPLOYEE.replace('{name}', name);
                confirmButtonText = Markaxis.i18n.EmployeeRes.LANG_CONFIRM_RESIGN;
            }
            else {
                setStatus = 0;
                title = Markaxis.i18n.EmployeeRes.LANG_SET_UNRESIGNED_EMPLOYEE.replace('{name}', name);
                confirmButtonText = Markaxis.i18n.EmployeeRes.LANG_CONFIRM_UNRESIGN;
            }

            swal({
                title: title,
                type: "warning",
                inputPlaceholder: Markaxis.i18n.EmployeeRes.LANG_PROVIDE_REASON,
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: confirmButtonText,
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function (isConfirm) {
                if (isConfirm === false) return;

                var data = {
                    bundle: {
                        userID: userID,
                        status: setStatus
                    },
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if (obj.bool == 0) {
                            swal("Error!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            that.table.ajax.reload();

                            if( setStatus == 1 ) {
                                swal( Aurora.i18n.GlobalRes.LANG_DONE + "!", Markaxis.i18n.EmployeeRes.LANG_SUCCESSFULLY_RESIGNED.replace('{name}', name), "success");
                            }
                            else {
                                swal( Aurora.i18n.GlobalRes.LANG_DONE + "!", Markaxis.i18n.EmployeeRes.LANG_SUCCESSFULLY_UNRESIGNED.replace('{name}', name), "success");
                            }
                            return;
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/employee/setResignStatus", data);
            });
        },


        deleteEmployee: function( userID, name ) {
            var that = this;
            swal({
                title: Markaxis.i18n.EmployeeRes.LANG_DELETE_EMPLOYEE_NAME.replace('{name}', name),
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: Markaxis.i18n.EmployeeRes.LANG_CONFIRM_DELETE,
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
                        if( obj.bool == 0 ) {
                            swal("Error!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            that.table.ajax.reload();
                            swal("Done!", Aurora.i18n.GlobalRes.LANG_SUCCESSFULLY_DELETE.replace('{title}', name), "success");
                            return;
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/employee/delete", data);
            });
        },


        /**
         * Table Initialize
         * @return void
         */
        initTable: function( ) {
            var that = this;

            that.table = $(".employeeTable").DataTable({
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
                        return '<img src="' + full['photo'] + '" class="user-table-photo" />' + data;
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
                        var reason = "";

                        if( full['suspendReason'] != null && full['suspendReason'] != "true" ) {
                            reason = full['suspendReason'] != "true" ? ' data-popup="tooltip" title="" data-placement="bottom" data-original-title="' + full['suspendReason'] + '"' : "";
                        }

                        if( full['resigned'] == 1 ) {
                            return '<span id="status' + full['userID'] + '" class="label label-pending"' + reason + '>' + Markaxis.i18n.EmployeeRes.LANG_RESIGNED + '</span>';
                        }
                        else if( full['suspended'] == 1 ) {
                            return '<span id="status' + full['userID'] + '" class="label label-danger"' + reason + '>' + Markaxis.i18n.EmployeeRes.LANG_SUSPENDED + '</span>';
                        }
                        else {
                            return '<span id="status' + full['userID'] + '" class="label label-success"' + reason + '>' + Markaxis.i18n.EmployeeRes.LANG_ACTIVE + '</span>';
                        }
                    }
                },{
                    targets: [4],
                    orderable: true,
                    width: '220px',
                    data: 'email'
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
                        var statusText = full['suspended'] == 1 ? Markaxis.i18n.EmployeeRes.LANG_UNSUSPEND_EMPLOYEE : Markaxis.i18n.EmployeeRes.LANG_SUSPEND_EMPLOYEE;
                        var resignText = full['resigned']  == 1 ? Markaxis.i18n.EmployeeRes.LANG_EMPLOYEE_UNRESIGNED : Markaxis.i18n.EmployeeRes.LANG_EMPLOYEE_RESIGNED;

                        return '<div class="list-icons">' +
                            '<div class="list-icons-item dropdown">' +
                            '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                            '<i class="icon-menu7"></i></a>' +
                            '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm" x-placement="bottom-end">' +
                            '<a class="dropdown-item" href="' + Aurora.ROOT_URL + 'admin/user/edit/' + data + '">' +
                            '<i class="icon-pencil5"></i> ' + Markaxis.i18n.EmployeeRes.LANG_EDIT_EMPLOYEE_INFO + '</a>' +
                            '<div class="divider"></div>' +
                            '<a class="dropdown-item setSuspend" href="#" data-id="' + data + '" data-name="' + name + '" data-status="' + full['suspended'] + '">' +
                            '<i class="icon-user-block"></i> ' + statusText + '</a>' +
                            '<a class="dropdown-item setResign" href="#" data-id="' + data + '" data-name="' + name + '" data-status="' + full['resigned'] + '">' +
                            '<i class="icon-exit3"></i> ' + resignText + '</a>' +
                            '<div class="divider"></div>' +
                            '<a class="dropdown-item deleteEmployee" href="#" data-id="' + data + '" data-name="' + name + '">' +
                            '<i class="icon-bin"></i> ' + Markaxis.i18n.EmployeeRes.LANG_DELETE_EMPLOYEE + '</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                    }
                }],
                order: [],
                dom: '<"datatable-header"f><"datatable-scroll"t><"datatable-footer"ilp>',
                language: {
                    search: '',
                    info: Aurora.i18n.GlobalRes.LANG_TABLE_ENTRIES,
                    searchPlaceholder: Markaxis.i18n.EmployeeRes.LANG_SEARCH_EMPLOYEE,
                    lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + Aurora.i18n.GlobalRes.LANG_NUMBER_ROWS + ':</span> _MENU_',
                    paginate: { 'first': Aurora.i18n.GlobalRes.LANG_FIRST, 'last': Aurora.i18n.GlobalRes.LANG_LAST, 'next': '&rarr;', 'previous': '&larr;' }
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
            $('.employeeTable .datatable-pagination').DataTable({
                pagingType: "simple",
                language: {
                    paginate: {'next': Aurora.i18n.GlobalRes.LANG_NEXT + ' &rarr;', 'previous': '&larr; ' + Aurora.i18n.GlobalRes.LANG_PREV}
                }
            });

            // Datatable with saving state
            $('.employeeTable .datatable-save-state').DataTable({
                stateSave: true
            });

            // Scrollable datatable
            $('.employeeTable .datatable-scroll-y').DataTable({
                autoWidth: true,
                scrollY: 300
            });

            $(".employeeTable tbody").on("mouseover", "td", function( ) {
                var colIdx = that.table.cell(this).index( ).column;

                if( colIdx !== null ) {
                    $(that.table.cells().nodes()).removeClass("active");
                    $(that.table.column(colIdx).nodes()).addClass("active");
                }
            }).on("mouseleave", function() {
                $(that.table.cells().nodes()).removeClass("active");
            });

            // External table additions
            // ------------------------------

            // Enable Select2 select for the length option
            $('.employeeTable .dataTables_length select').select2({
                minimumResultsForSearch: Infinity,
                width: 'auto'
            });

            $("#employeeList .list-action-btns").insertAfter("#employeeList .dataTables_filter");
        }
    }
    return MarkaxisEmployee;
})();
var markaxisEmployee = null;
$(document).ready( function( ) {
    markaxisEmployee = new MarkaxisEmployee( );
});