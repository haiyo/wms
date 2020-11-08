/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: taxFileEmployee.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisTaxFileEmployee = (function( ) {

    /**
     * MarkaxisTaxFileEmployee Constructor
     * @return void
     */
    MarkaxisTaxFileEmployee = function( ) {
        this.table = null;
        this.selected = [];
        this.selectAll = [];
        this.init( );
    };

    MarkaxisTaxFileEmployee.prototype = {
        constructor: MarkaxisTaxFileEmployee,

        /**
         * Initialize first onload setup
         * @return void
         */
        init: function( ) {
            this.initTable( );
            //this.initEvents( );
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

            that.table = $(".employeeTable").DataTable({
                processing: true,
                serverSide: true,
                fnCreatedRow: function (nRow, aData, iDataIndex) {
                    $(nRow).attr('id', 'row' + aData['userID']);
                },
                ajax: {
                    url: Aurora.ROOT_URL + "admin/taxfile/employee/",
                    type: "POST",
                    data: function ( d ) {
                        d.ajaxCall = 1;
                        d.csrfToken = Aurora.CSRF_TOKEN;
                        d.tfID = $("#tfID").val( );
                        d.officeID = $("#office").val( );
                    }
                },
                initComplete: function() {
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
                    targets:[0],
                    className: "text-center",
                    width: '10px',
                    orderable: false,
                    searchable : false,
                    data: 'userID',
                    render: function( data, type, full, meta ) {
                        if( full["irCount"] == 1 && !that.selected.includes( data ) ) {
                            that.selected.push( data );
                        }
                        return '<input type="checkbox" class="dt-checkboxes check-input" name="userID[]" value="' + data + '">';
                    }
                },{
                    targets: [1],
                    orderable: true,
                    width: '150px',
                    data: 'idnumber'
                },{
                    targets: [2],
                    orderable: true,
                    width: '200px',
                    data: 'name',
                    render: function(data, type, full, meta) {
                        return '<img src="' + full['photo'] + '" class="user-table-photo" />' + data;
                    }
                },{
                    targets: [3],
                    orderable: true,
                    width: '180px',
                    data: 'designation'
                },{
                    targets: [4],
                    orderable: true,
                    width: '220px',
                    data: 'type'
                },{
                    targets: [5],
                    searchable : false,
                    data: 'status',
                    width: '130px',
                    className : "text-center",
                    render: function(data, type, full, meta) {
                        var reason = full['suspendReason'] ? ' title="" data-placement="bottom" data-original-title="' + full['suspendReason'] + '"' : "";

                        if( full['resigned'] == 1 ) {
                            return '<span id="status' + full['userID'] + '" class="label label-pending"' + reason + '>' + Markaxis.i18n.PayrollRes.LANG_RESIGNED + '</span>';
                        }
                        else if( full['suspended'] == 1 ) {
                            return '<span id="status' + full['userID'] + '" class="label label-danger"' + reason + '>' + Markaxis.i18n.PayrollRes.LANG_SUSPENDED + '</span>';
                        }
                        else {
                            return '<span id="status' + full['userID'] + '" class="label label-success"' + reason + '>' + Markaxis.i18n.PayrollRes.LANG_ACTIVE + '</span>';
                        }
                    }
                },{
                    targets: [6],
                    orderable: false,
                    searchable : false,
                    width: '100px',
                    className : "text-center",
                    data: 'userID',
                    render: function(data, type, full, meta) {
                        return '<a href="' + Aurora.ROOT_URL + 'admin/taxfile/viewIr8a/' + data + '/' + $("#year").val( ) + '" target="_blank">' + Markaxis.i18n.TaxFileRes.LANG_VIEW_IR8A + '</a>';
                    }
                }],
                select: {
                    style: "multi"
                },
                order: [],
                dom: '<"datatable-header"Bfr><"datatable-scroll"t><"datatable-footer"ilp>',
                language: {
                    search: '',
                    info: Aurora.i18n.GlobalRes.LANG_TABLE_ENTRIES,
                    select: {
                        rows: "<span id='selectedCount'>%d</span> rows selected"
                    },
                    searchPlaceholder: Markaxis.i18n.PayrollRes.LANG_SEARCH_EMPLOYEE,
                    lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + Aurora.i18n.GlobalRes.LANG_NUMBER_ROWS + ':</span> _MENU_',
                    paginate: { 'first': Aurora.i18n.GlobalRes.LANG_FIRST, 'last': Aurora.i18n.GlobalRes.LANG_LAST, 'next': '&rarr;', 'previous': '&larr;' }
                },
                drawCallback: function () {
                    $(".employeeTable [type=checkbox]").uniform();

                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');

                    if( that.selected.length > 0 ) {
                        var api = this.api();
                        api.rows({page:"current"}).data().each( function( row, i ) {
                            if( that.selected.includes( row.userID ) ) {
                                that.table.row(i).select( );
                                $("input[value=" + row.userID + "]").prop("checked", true);
                            }
                        });
                        $.uniform.update( );
                    }

                    setTimeout( function( ){
                        $("#selectedCount").text( that.selected.length );
                    }, 50 );

                    var info = that.table.page.info( );

                    if( that.selectAll.includes( info.page ) ) {
                        $(".dt-checkboxes-select-all").find("input[type=checkbox]").prop("checked", true).uniform("refresh");
                    }
                    else {
                        $(".dt-checkboxes-select-all").find("input[type=checkbox]").prop("checked", false).uniform("refresh");
                    }
                },
                preDrawCallback: function() {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
                }
            });

            that.table.on("select", function( e, dt, type, i ) {
                var userID = $(that.table.row(i).nodes()).find("input[type=checkbox]").val( );
                $("input[value=" + userID + "]").prop("checked", true).uniform("refresh");

                if( !that.selected.includes( userID ) ) {
                    that.selected.push(userID);
                }
                $("#selectedCount").text( that.selected.length );
            });

            that.table.on("deselect", function( e, dt, type, i ) {
                var cb = $(that.table.row(i).nodes()).find("input[type=checkbox]");
                that.selected = that.selected.filter(e => e !== cb.val( ));
                $("input[value=" + cb.val( ) + "]").prop("checked", false).uniform("refresh");
                $("#selectedCount").text( that.selected.length );

                if( that.selectAll.length > 0 ) {
                    var info = that.table.page.info( );

                    if( that.selectAll.includes( info.page ) ) {
                        $(".dt-checkboxes-select-all").find("input[type=checkbox]").prop("checked", false).uniform("refresh");
                        that.selectAll = that.selectAll.filter(e => e !== info.page);
                    }
                }
            });

            $(".dt-checkboxes-select-all").change(function( ) {
                var info = that.table.page.info( );

                if( !that.selectAll.includes( info.page ) ) {
                    that.table.rows({page: 'current'}).select();
                    that.table.rows({page: 'current'}).nodes().each(function() {
                        $("input[type=checkbox]").prop("checked", true);
                        $.uniform.update( );
                    });

                    that.table.rows(".selected").data( ).each( function( row ) {
                        if( !that.selected.includes( row.userID ) ) {
                            that.selected.push(row.userID);
                        }
                    });
                    that.selectAll.push( info.page );
                }
                else {
                    that.table.rows({ page: 'current' }).deselect( );
                    that.table.rows({ page: 'current' }).data( ).each( function( row ) {
                        $("input[value=" + row.userID + "]").prop("checked", false);
                        that.selected = that.selected.filter(e => e !== row.userID);
                    });

                    $.uniform.update( );
                    that.selectAll = that.selectAll.filter(e => e !== info.page);
                }
                $("#selectedCount").text( that.selected.length );
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

            $(".employeeTable tbody").on("mouseover", "td", function() {
                if( typeof that.table.cell(this).index() == "undefined" ) return;
                var colIdx = that.table.cell(this).index().column;

                if (colIdx !== null) {
                    $(that.table.cells().nodes()).removeClass('active');
                    $(that.table.column(colIdx).nodes()).addClass('active');
                }
            }).on('mouseleave', function() {
                $(that.table.cells().nodes()).removeClass("active");
            });

            // Enable Select2 select for the length option
            $(".employeeTable .dataTables_length select").select2({
                minimumResultsForSearch: Infinity,
                width: "auto"
            });

            $(".dataTables_length select").select2({
                minimumResultsForSearch: Infinity,
                width: "auto"
            });
        }
    }
    return MarkaxisTaxFileEmployee;
})();
var markaxisTaxFileEmployee = null;
$(document).ready( function( ) {
    markaxisTaxFileEmployee = new MarkaxisTaxFileEmployee( );
});