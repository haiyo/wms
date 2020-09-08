/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: leaveType.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisLeaveType = (function( ) {

    /**
     * MarkaxisLeaveType Constructor
     * @return void
     */
    MarkaxisLeaveType = function( ) {
        this.table = null;
        this.init( );
    };

    MarkaxisLeaveType.prototype = {
        constructor: MarkaxisLeaveType,

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
        },


        /**
         * Table Initialize
         * @return void
         */
        initTable: function( ) {
            var that = this;

            that.table = $(".leaveTypeTable").DataTable({
                "processing": true,
                "serverSide": true,
                "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                    $(nRow).attr('id', 'leaveTypeTable-row' + aData['ltID']);
                },
                ajax: {
                    url: Aurora.ROOT_URL + "admin/leave/getTypeResults",
                    type: "POST",
                    data: function (d) {
                        d.ajaxCall = 1;
                        d.csrfToken = Aurora.CSRF_TOKEN;
                    },
                },
                initComplete: function () {
                    //
                },
                autoWidth: false,
                mark: true,
                columnDefs: [{
                    targets: [0],
                    checkboxes: {
                        selectRow: true
                    },
                    width: '10px',
                    orderable: false,
                    searchable: false,
                    data: 'ltID',
                    render: function( data, type, full, meta) {
                        return '<input type="checkbox" class="dt-checkboxes check-input" name="ltID[]" value="' + $('<div/>').text(data).html() + '">';
                    }
                },{
                    targets: [1],
                    orderable: true,
                    width: '450px',
                    data: 'name',
                    render: function( data, type, full, meta ) {
                        return data + " (" + full['code'] + ")";
                    }
                },{
                    targets: [2],
                    orderable: true,
                    width: '120px',
                    data: 'paidLeave',
                    className : "text-center",
                    render: function( data, type, full, meta ) {
                        if( data == 0 ) {
                            return '<span class="label label-pending">' + Aurora.i18n.GlobalRes.LANG_NO + '</span>';
                        }
                        else {
                            return '<span class="label label-success">' + Aurora.i18n.GlobalRes.LANG_YES + '</span>';
                        }
                    }
                },{
                    targets: [3],
                    orderable: true,
                    width: '120px',
                    data: 'allowHalfDay',
                    className : "text-center",
                    render: function( data, type, full, meta ) {
                        if( data == 0 ) {
                            return '<span class="label label-pending">' + Aurora.i18n.GlobalRes.LANG_NO + '</span>';
                        }
                        else {
                            return '<span class="label label-success">' + Aurora.i18n.GlobalRes.LANG_YES + '</span>';
                        }
                    }
                },{
                    targets: [4],
                    orderable: true,
                    width: '200px',
                    data: 'unused',
                },{
                    targets: [5],
                    orderable: false,
                    searchable: false,
                    width: '10px',
                    className: "text-center",
                    data: 'ltID',
                    render: function( data, type, full, meta ) {
                        return '<div class="list-icons">' +
                            '<div class="list-icons-item dropdown">' +
                            '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                            '<i class="icon-menu7"></i></a>' +
                            '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm dropdown-employee" x-placement="bottom-end">' +
                            '<a href="' + Aurora.ROOT_URL + 'admin/leave/editType/' + data + '" class="dropdown-item editLeaveType">' +
                            '<i class="icon-pencil5"></i> ' + Markaxis.i18n.LeaveRes.LANG_EDIT_LEAVE_TYPE + '</a>' +
                            '<div class="divider"></div>' +
                            '<a class="dropdown-item deleteLeaveType" data-id="' + data + '">' +
                            '<i class="icon-bin"></i> ' + Markaxis.i18n.LeaveRes.LANG_DELETE_LEAVE_TYPE + '</a>' +
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
                    info: Aurora.i18n.GlobalRes.LANG_TABLE_ENTRIES,
                    searchPlaceholder: Markaxis.i18n.LeaveRes.LANG_SEARCH_LEAVE_TYPE,
                    lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of Rows:</span> _MENU_',
                    paginate: {'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;'}
                },
                drawCallback: function () {
                    $(".leaveTypeTable [type=checkbox]").uniform();

                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                    Popups.init();
                },
                preDrawCallback: function () {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
                }
            });

            $(".leaveType-list-action-btns").insertAfter("#leaveTypeList .dataTables_filter");

            // Alternative pagination
            $('#leaveTypeList .datatable-pagination').DataTable({
                pagingType: "simple",
                language: {
                    paginate: {'next': 'Next &rarr;', 'previous': '&larr; Prev'}
                }
            });

            // Datatable with saving state
            $('#leaveTypeList .datatable-save-state').DataTable({
                stateSave: true
            });

            // Scrollable datatable
            $('#leaveTypeList .datatable-scroll-y').DataTable({
                autoWidth: true,
                scrollY: 300
            });

            $("#leaveTypeList .datatable tbody").on("mouseover", "td", function () {
                if( typeof that.table.cell(this).index() == "undefined" ) return;
                var colIdx = that.table.cell(this).index().column;

                if( colIdx !== null ) {
                    $(that.table.cells().nodes()).removeClass('active');
                    $(that.table.column(colIdx).nodes()).addClass('active');
                }
            }).on('mouseleave', function () {
                $(that.table.cells().nodes()).removeClass("active");
            });

            // Enable Select2 select for the length option
            $("#leaveTypeList .dataTables_length select").select2({
                minimumResultsForSearch: Infinity,
                width: "auto"
            });
        }
    }
    return MarkaxisLeaveType;
})();
var markaxisLeaveType = null;
$(document).ready( function( ) {
    markaxisLeaveType = new MarkaxisLeaveType( );
});