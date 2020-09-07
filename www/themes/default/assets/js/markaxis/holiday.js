/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: holiday.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisHoliday = (function( ) {


    /**
     * MarkaxisHoliday Constructor
     * @return void
     */
    MarkaxisHoliday = function( ) {
        this.table = null;
        this.modalHoliday = $("#modalHoliday");
        this.picker = null;
        this.init( );
    };

    MarkaxisHoliday.prototype = {
        constructor: MarkaxisHoliday,

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

            $("#contentType").select2({minimumResultsForSearch: -1});
            $(".form-check-input-styled").uniform( );

            $(document).on("click", ".deleteHoliday", function(e) {
                that.deleteHoliday( $(this).attr("data-id") );
                e.preventDefault( );
            });

            that.picker = $(".pickadate").pickadate({
                format:"dd mmmm yyyy",
                onOpen: function ( ) {
                    markaxisPickerExtend.setPickerHolidays( "#date_table", that.pickerStart );
                },
                onSet: function ( context ) {
                    markaxisPickerExtend.setPickerHolidays( "#date_table", that.pickerStart, context );
                    $("div[role=tooltip]").remove();
                }
            });

            that.modalHoliday.on("show.bs.modal", function(e) {
                var $invoker = $(e.relatedTarget);
                var hID = $invoker.attr("data-id");

                if( hID ) {
                    var data = {
                        success: function (res) {
                            var obj = $.parseJSON(res);
                            if( obj.bool === 0 ) {
                                swal("error", obj.errMsg);
                                return;
                            }
                            else {
                                $("#modalHoliday .modal-title").text( Markaxis.i18n.HolidayRes.LANG_EDIT_HOLIDAY );
                                $("#hID").val( obj.data.hID );
                                $("#holidayTitle").val( obj.data.title );
                                $("#date").val( obj.data.date );

                                if( obj.data.workDay == 1 ) {
                                    $("#workDay").prop("checked", true).uniform( );
                                }

                                var year  = moment(obj.data.date).format("YYYY");
                                var month = moment(obj.data.date).format("MM");
                                var day   = moment(obj.data.date).format("DD");

                                var date = that.picker.pickadate("picker");
                                date.set( "select", new Date( year, parseInt(month)-1, day ) );
                            }
                        }
                    }
                    Aurora.WebService.AJAX( "admin/leave/getHoliday/" + hID, data );
                }
                else {
                    $("#modalHoliday .modal-title").text( Markaxis.i18n.HolidayRes.LANG_CREATE_CUSTOM_HOLIDAY );
                    $("#hID").val(0);
                    $("#holidayTitle").val("");
                    $("#date").val("");
                    $("#workDay").prop("checked", false).uniform( );
                }
            });

            that.modalHoliday.on("shown.bs.modal", function(e) {
                $("#holidayTitle").focus( );
            });

            that.modalHoliday.on("hidden.bs.modal", function (e) {
                $("#hID").val(0);
                $("#holidayTitle").val("");
                $("#workDay").prop("checked", false).uniform( );

                var date = that.picker.pickadate("picker");
                date.clear();
            });

            $("#saveHoliday").validate({
                rules: {
                    holidayTitle: { required: true },
                    date: { required: true }
                },
                messages: {
                    holidayTitle: Markaxis.i18n.HolidayRes.LANG_ENTER_HOLIDAY_TITLE,
                    date: Markaxis.i18n.HolidayRes.LANG_SELECT_DATE
                },
                highlight: function(element, errorClass) {
                    $(element).addClass("border-danger");
                },
                unhighlight: function(element, errorClass) {
                    $(element).removeClass("border-danger");
                    $(".modal-footer .error").remove();
                },
                // Different components require proper error label placement
                errorPlacement: function(error, element) {
                    if( $(".modal-footer .error").length == 0 )
                        $(".modal-footer").append(error);
                },
                submitHandler: function( ) {
                    var data = {
                        bundle: {
                            data: Aurora.WebService.serializePost("#saveHoliday")
                        },
                        success: function( res ) {
                            var obj = $.parseJSON( res );
                            if( obj.bool === 0 ) {
                                swal("error", obj.errMsg);
                            }
                            else {
                                if( $("#hID").val( ) == 0 ) {
                                    var title = Markaxis.i18n.HolidayRes.LANG_HOLIDAY_CREATED_SUCCESSFULLY;
                                    var text = Markaxis.i18n.HolidayRes.LANG_HOLIDAY_CREATED_SUCCESSFULLY_DESCRIPT;
                                }
                                else {
                                    var title = Markaxis.i18n.HolidayRes.LANG_HOLIDAY_UPDATED_SUCCESSFULLY;
                                    var text = Markaxis.i18n.HolidayRes.LANG_HOLIDAY_UPDATED_SUCCESSFULLY_DESCRIPT;
                                }

                                swal({
                                    title: title,
                                    text: text,
                                    type: "success"
                                }, function( isConfirm ) {
                                    that.table.ajax.reload( );
                                    $("#modalHoliday").modal("hide");
                                    markaxisPickerExtend.clearCache( );
                                });
                            }
                        }
                    };
                    Aurora.WebService.AJAX( "admin/leave/saveHoliday", data );
                }
            });
        },


        /**
         * Delete
         * @return void
         */
        deleteHoliday: function( hID ) {
            var that = this;
            var title = $("#holidayTable-row" + hID).find("td").eq(0).text( );

            swal({
                title: Aurora.i18n.GlobalRes.LANG_ARE_YOU_SURE_DELETE.replace('{title}', title),
                text: Aurora.i18n.GlobalRes.LANG_CANNOT_UNDONE_DELETED,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: Aurora.i18n.GlobalRes.LANG_CONFIRM_DELETE,
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function( isConfirm ) {
                if (isConfirm === false) return;

                var data = {
                    bundle: {
                        hID: hID
                    },
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if( obj.bool == 0 ) {
                            swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            that.table.ajax.reload();
                            swal( Aurora.i18n.GlobalRes.LANG_DONE + "!", Aurora.i18n.GlobalRes.LANG_SUCCESSFULLY_DELETE.replace('{title}', title), "success");
                            return;
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/leave/deleteHoliday", data);
            });
        },


        /**
         * Table Initialize
         * @return void
         */
        initTable: function( ) {
            var that = this;

            this.table = $(".holidayTable").DataTable({
                "processing": true,
                "serverSide": true,
                "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                    $(nRow).attr('id', 'holidayTable-row' + aData['hID']);
                },
                ajax: {
                    url: Aurora.ROOT_URL + "admin/leave/getHolidayResults",
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
                    orderable: true,
                    width: '800px',
                    data: 'title'
                },{
                    targets: [1],
                    orderable: true,
                    width: '300px',
                    data: 'country'
                },{
                    targets: [2],
                    orderable: true,
                    width: '250px',
                    data: 'date',
                },{
                    targets: [3],
                    orderable: true,
                    width: '180px',
                    data: 'workDay',
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
                    orderable: false,
                    searchable: false,
                    width: '10px',
                    className: "text-center",
                    data: 'hID',
                    render: function( data, type, full, meta ) {
                        return '<div class="list-icons">' +
                            '<div class="list-icons-item dropdown">' +
                            '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                            '<i class="icon-menu7"></i></a>' +
                            '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm dropdown-employee" x-placement="bottom-end">' +
                            '<a class="dropdown-item editHoliday" data-id="' + data + '" data-toggle="modal" data-target="#modalHoliday" data-backdrop="static" data-keyboard="false">' +
                            '<i class="icon-pencil5"></i> ' + Markaxis.i18n.HolidayRes.LANG_EDIT_HOLIDAY + '</a>' +
                            '<div class="divider"></div>' +
                            '<a class="dropdown-item deleteHoliday" data-id="' + data + '">' +
                            '<i class="icon-bin"></i> ' + Markaxis.i18n.HolidayRes.LANG_DELETE_HOLIDAY + '</a>' +
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
                    searchPlaceholder: 'Search Holiday',
                    lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + Aurora.i18n.GlobalRes.LANG_NUMBER_ROWS + ':</span> _MENU_',
                    paginate: { 'first': Aurora.i18n.GlobalRes.LANG_FIRST, 'last': Aurora.i18n.GlobalRes.LANG_LAST, 'next': '&rarr;', 'previous': '&larr;' }
                },
                drawCallback: function () {
                    $(".holidayTable [type=checkbox]").uniform();

                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                    Popups.init();
                },
                preDrawCallback: function () {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
                }
            });

            $(".holiday-list-action-btns").insertAfter("#holidayList .dataTables_filter");

            // Alternative pagination
            $('#holidayList .datatable-pagination').DataTable({
                pagingType: "simple",
                language: {
                    paginate: {'next': Aurora.i18n.GlobalRes.LANG_NEXT + ' &rarr;', 'previous': '&larr; ' + Aurora.i18n.GlobalRes.LANG_PREV}
                }
            });

            // Datatable with saving state
            $('#holidayList .datatable-save-state').DataTable({
                stateSave: true
            });

            // Scrollable datatable
            $('#holidayList .datatable-scroll-y').DataTable({
                autoWidth: true,
                scrollY: 300
            });

            $("#holidayList .datatable tbody").on("mouseover", "td", function () {
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
            $("#holidayList .dataTables_length select").select2({
                minimumResultsForSearch: Infinity,
                width: "auto"
            });
        }
    }
    return MarkaxisHoliday;
})();
var markaxisHoliday = null;
$(document).ready( function( ) {
    markaxisHoliday = new MarkaxisHoliday( );
});