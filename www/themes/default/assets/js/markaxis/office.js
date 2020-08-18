/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: office.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisOffice = (function( ) {

    /**
     * MarkaxisOffice Constructor
     * @return void
     */
    MarkaxisOffice = function( ) {
        this.table = null;
        this.modalOffice = $("#modalOffice");
        this.init( );
    };

    MarkaxisOffice.prototype = {
        constructor: MarkaxisOffice,

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

            $("#officeType").select2({minimumResultsForSearch: -1});
            $("#workDayFrom").select2({minimumResultsForSearch: -1});
            $("#workDayTo").select2({minimumResultsForSearch: -1});

            $(document).on("click", ".officeDelete", function(e) {
                that.officeDelete( $(this).attr("data-id") );
                e.preventDefault( );
            });

            that.modalOffice.on("shown.bs.modal", function(e) {
                $("#officeName").focus( );
            });

            that.modalOffice.on("show.bs.modal", function(e) {
                var $invoker = $(e.relatedTarget);
                var oID = $invoker.attr("data-id");

                if( oID ) {
                    var data = {
                        success: function (res) {
                            var obj = $.parseJSON(res);
                            if( obj.bool == 0 ) {
                                swal("error", obj.errMsg);
                                return;
                            }
                            else {
                                $("#modalOffice .modal-title").text("Edit Office");
                                $("#officeID").val( obj.data.oID );
                                $("#officeName").val( obj.data.officeName );
                                $("#officeAddress").val( obj.data.address );
                                $("#officeCountry").val( obj.data.countryID ).trigger("change");
                                $("#officeType").val( obj.data.officeTypeID ).trigger("change");
                                $("#workDayFrom").val( obj.data.workDayFrom ).trigger("change");
                                $("#workDayTo").val( obj.data.workDayTo ).trigger("change");

                                if( obj.data.halfDay == 1 ) {
                                    $("#halfDay").prop("checked", true);
                                    $.uniform.update('#halfDay');
                                }
                            }
                        }
                    }
                    Aurora.WebService.AJAX( "admin/company/getOffice/" + oID, data );
                }
                else {
                    $("#modalOffice .modal-title").text("Create New Office");
                    $("#officeID").val(0);
                    $("#officeName").val("");
                    $("#officeAddress").val("");
                    $("#officeCountry").val("").trigger("change");
                    $("#officeType").val("").trigger("change");
                    $("#workDayFrom").val("").trigger("change");
                    $("#workDayTo").val("").trigger("change");
                    $("#halfDay").prop("checked", false);
                    $.uniform.update('#halfDay');
                }
            });

            $("#modalEmployee").on("show.bs.modal", function(e) {
                var $invoker = $(e.relatedTarget);

                if( $invoker.attr("data-role") == "office" ) {
                    var oID = $invoker.attr("data-id");

                    $(this).find(".modal-body").load( Aurora.ROOT_URL + 'admin/employee/getCountList/office/' + oID, function() {
                        $(".modal-title").text( $("#officeName" + oID).text( ) );
                    });
                }
            });

            $("#saveOffice").validate({
                rules: {
                    officeName: { required: true },
                    officeCountry: { required: true }
                },
                messages: {
                    officeName: "Please enter a Office Name.",
                    officeCountry: "Please select country of operation."
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
                            data: Aurora.WebService.serializePost("#saveOffice")
                        },
                        success: function( res ) {
                            var obj = $.parseJSON( res );
                            if( obj.bool == 0 ) {
                                swal("error", obj.errMsg);
                                return;
                            }
                            else {
                                that.table.ajax.reload();

                                swal({
                                    title: $("#officeName").val( ) + " has been successfully created!",
                                    text: "What do you want to do next?",
                                    type: 'success',
                                    confirmButtonClass: 'btn btn-success',
                                    cancelButtonClass: 'btn btn-danger',
                                    buttonsStyling: false,
                                    showCancelButton: true,
                                    confirmButtonText: "Create Another Office",
                                    cancelButtonText: "Close Window",
                                    reverseButtons: true
                                }, function( isConfirm ) {
                                    $("#officeID").val(0);
                                    $("#officeName").val("");
                                    $("#officeAddress").val("");
                                    $("#officeCountry").val("").trigger("change");
                                    $("#officeType").val("").trigger("change");
                                    $("#workDayFrom").val("").trigger("change");
                                    $("#workDayTo").val("").trigger("change");
                                    $("#halfDay").prop("checked", false);
                                    $.uniform.update('#halfDay');

                                    if( isConfirm === false ) {
                                        that.modalOffice.modal("hide");
                                    }
                                    else {
                                        setTimeout(function() {
                                            $("#officeName").focus( );
                                        }, 500);
                                    }
                                });
                            }
                        }
                    };
                    Aurora.WebService.AJAX( "admin/company/saveOffice", data );
                }
            });
        },


        officeDelete: function( oID ) {
            var that = this;
            var title = $("#officeTable-row" + oID).find("td").eq(0).text( );

            swal({
                title: "Are you sure you want to delete " + title + "?",
                text: "This action cannot be undone once deleted.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Confirm Delete",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function( isConfirm ) {
                if (isConfirm === false) return;

                var data = {
                    bundle: {
                        data: oID
                    },
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if( obj.bool == 0 ) {
                            swal("Error!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            that.table.ajax.reload();
                            swal("Done!", title + " has been successfully deleted!", "success");
                            return;
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/company/deleteOffice", data);
            });
        },


        /**
         * Table Initialize
         * @return void
         */
        initTable: function( ) {
            var that = this;

            that.table = $(".officeTable").DataTable({
                "processing": true,
                "serverSide": true,
                "fnCreatedRow": function (nRow, aData, iDataIndex) {
                    $(nRow).attr('id', 'officeTable-row' + aData['oID']);
                },
                ajax: {
                    url: Aurora.ROOT_URL + "admin/company/getOfficeResults",
                    type: "POST",
                    data: function ( d ) {
                        d.ajaxCall = 1;
                        d.csrfToken = Aurora.CSRF_TOKEN;
                    },
                },
                initComplete: function() {
                    //
                },
                autoWidth: false,
                mark: true,
                columnDefs: [{
                    targets: [0],
                    orderable: true,
                    width: '250px',
                    data: 'name',
                    render: function( data, type, full, meta ) {
                        return '<span id="officeName' + full['oID'] + '">' + data + '</span>';
                    }
                },{
                    targets: [1],
                    orderable: true,
                    width: '320px',
                    data: 'address'
                },{
                    targets: [2],
                    orderable: true,
                    width: '220px',
                    data: 'country'
                },{
                    targets: [3],
                    orderable: true,
                    width: '150px',
                    data: 'workDays'
                },{
                    targets: [4],
                    orderable: true,
                    width: '150px',
                    data: 'empCount',
                    className : "text-center",
                    render: function( data, type, full, meta ) {
                        if( data > 0 ) {
                            return '<a data-role="office" data-id="' + full['oID'] + '" data-toggle="modal" data-target="#modalEmployee">' + data + '</a>';
                        }
                        else {
                            return data;
                        }
                    }
                },{
                    targets: [5],
                    orderable: false,
                    searchable : false,
                    width: '100px',
                    className : "text-center",
                    data: 'oID',
                    render: function(data, type, full, meta) {
                        return '<div class="list-icons">' +
                            '<div class="list-icons-item dropdown">' +
                            '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                            '<i class="icon-menu7"></i></a>' +
                            '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm dropdown-employee" x-placement="bottom-end">' +
                            '<a class="dropdown-item officeEdit" data-id="' + data + '" data-toggle="modal" data-target="#modalOffice" ' +
                            'data-backdrop="static" data-keyboard="false">' +
                            '<i class="icon-pencil5"></i> Edit Office</a>' +
                            '<div class="divider"></div>' +
                            '<a class="dropdown-item officeDelete" data-id="' + data + '">' +
                            '<i class="icon-bin"></i> Delete Office</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                    }
                }],
                order: [],
                dom: '<"datatable-header"f><"datatable-scroll"t><"datatable-footer"ilp>',
                language: {
                    search: '',
                    searchPlaceholder: 'Search Office',
                    lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of Rows:</span> _MENU_',
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

            $(".office-list-action-btns").insertAfter("#officeList .dataTables_filter");

            // Alternative pagination
            $("#officeList .datatable-pagination").DataTable({
                pagingType: "simple",
                language: {
                    paginate: {'next': 'Next &rarr;', 'previous': '&larr; Prev'}
                }
            });

            // Datatable with saving state
            $("#officeList .datatable-save-state").DataTable({
                stateSave: true
            });

            // Scrollable datatable
            $("#officeList .datatable-scroll-y").DataTable({
                autoWidth: true,
                scrollY: 300
            });

            $("#officeList .datatable tbody").on("mouseover", "td", function() {
                if( typeof that.table.cell(this).index() == "undefined" ) return;
                var colIdx = that.table.cell(this).index().column;

                if (colIdx !== null) {
                    $(that.table.cells().nodes()).removeClass("active");
                    $(that.table.column(colIdx).nodes()).addClass("active");
                }
            }).on("mouseleave", function() {
                $(that.table.cells().nodes()).removeClass("active");
            });

            // Enable Select2 select for the length option
            $("#officeList .dataTables_length select").select2({
                minimumResultsForSearch: Infinity,
                width: "auto"
            });
        }
    }
    return MarkaxisOffice;
})();
var markaxisOffice = null;
$(document).ready( function( ) {
    markaxisOffice = new MarkaxisOffice( );
});