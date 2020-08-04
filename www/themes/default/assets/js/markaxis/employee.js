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
                that.setSuspend( $(this).attr("data-id"), $(this).attr("data-name") );
                e.preventDefault( );
            });

            $(document).on("click", ".setResign", function (e) {
                that.setResign( $(this).attr("data-id"), $(this).attr("data-name") );
                e.preventDefault( );
            });
        },


        dateDiff: function( date ) {
            var dateSplit = date.split('-');
            var firstDate = new Date( );
            var secondDate = new Date( dateSplit[0], (dateSplit[1]-1), dateSplit[2] );
            return Math.round( ( secondDate-firstDate ) / (1000*60*60*24 ) );
        },


        setSuspend: function( userID, name ) {
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
        },


        setResign: function( userID, name ) {
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
                        var reason = full['suspendReason'] ? ' data-popup="tooltip" title="" data-placement="bottom" data-original-title="' + full['suspendReason'] + '"' : "";

                        if( full['suspended'] == 1 ) {
                            return '<span id="status' + full['userID'] + '" class="label label-danger"' + reason + '>Suspended</span>';
                        }
                        else {
                            if( full['endDate'] ) {
                                if( that.dateDiff( full['endDate'] ) <= 30 ) {
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
                            '<i class="icon-menu7"></i></a>' +
                            '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm" x-placement="bottom-end">' +
                            '<a class="dropdown-item" href="' + Aurora.ROOT_URL + 'admin/user/edit/' + data + '">' +
                            '<i class="icon-pencil5"></i> Edit Employee Info</a>' +
                            '<div class="divider"></div>' +
                            '<a class="dropdown-item setSuspend" href="#" data-id="' + data + '" data-name="' + name + '">' +
                            '<i class="icon-user-block"></i> ' + statusText + '</a>' +
                            '<a class="dropdown-item setResign" href="#" data-id="' + data + '" data-name="' + name + '">' +
                            '<i class="icon-exit3"></i> Employee Resigned</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                    }
                }],
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
            $('.employeeTable .datatable-pagination').DataTable({
                pagingType: "simple",
                language: {
                    paginate: {'next': 'Next &rarr;', 'previous': '&larr; Prev'}
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