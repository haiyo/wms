/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: taxFileDeclare.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisTaxFileDeclare = (function( ) {

    /**
     * MarkaxisTaxFileDeclare Constructor
     * @return void
     */
    MarkaxisTaxFileDeclare = function( ) {
        this.table = null;
        this.selected = [];
        this.selectAll = [];
        this.modalIR8A = $("#modalIR8A");
        this.ir8aValidate = false;
        this.ira8aValidate = false;
        this.ir8aError = false;
        this.ira8aError = false;
        this.init( );
    };

    MarkaxisTaxFileDeclare.prototype = {
        constructor: MarkaxisTaxFileDeclare,

        /**
         * Initialize first onload setup
         * @return void
         */
        init: function( ) {
            this.initEvents( );
        },


        /**
         * Events Registration
         * @return void
         */
        initEvents: function( ) {
            var that = this;

            $("#modalIR8A").on("show.bs.modal", function(e) {
                var $invoker = $(e.relatedTarget);

                $(this).find(".modal-body").load( Aurora.ROOT_URL + 'admin/taxfile/editIr8a/' + $("#tfID").val( ) + '/' + $invoker.attr("data-id"), function() {
                    $("#dobMonth").select2({minimumResultsForSearch: Infinity});
                    $("#dobDay").select2({minimumResultsForSearch: Infinity});
                    $("#startMonth").select2({minimumResultsForSearch: Infinity});
                    $("#startDay").select2({minimumResultsForSearch: Infinity});
                    $("#endMonth").select2({minimumResultsForSearch: Infinity});
                    $("#endDay").select2({minimumResultsForSearch: Infinity});
                    $("#nationality").select2({minimumResultsForSearch: Infinity});
                    $("#commFromMonth").select2({minimumResultsForSearch: Infinity});
                    $("#commFromDay").select2({minimumResultsForSearch: Infinity});
                    $("#commToMonth").select2({minimumResultsForSearch: Infinity});
                    $("#commToDay").select2({minimumResultsForSearch: Infinity});
                    $("#approvedMonth").select2({minimumResultsForSearch: Infinity});
                    $("#approvedDay").select2({minimumResultsForSearch: Infinity});

                    $(".styled").uniform({
                        radioClass: 'choice'
                    });

                    if( $("#gender1").attr("checked") == "checked" ) {
                        $("#gender1").prop('checked',true);
                    }
                    else if( $("#gender2").attr("checked") == "checked" ) {
                        $("#gender2").prop('checked',true);
                    }

                    setTimeout( function( ) {
                        $("#saveIr8a").validate( that.ir8aValidate );
                        $("#saveIr8a").valid();
                    }, 100 );

                    setTimeout( function( ) {
                        $("#empRef").prop("disabled", true);
                        $("#empIDNo").prop("disabled", true);
                        $("#empName").prop("disabled", true);
                        $("#dobDay").prop("disabled", true);
                        $("#dobMonth").prop("disabled", true);
                        $("#dobYear").prop("disabled", true);
                        $("#nationality").prop("disabled", true);
                        $("#address").prop("disabled", true);
                        $("#designation").prop("disabled", true);
                        $("#bankName").prop("disabled", true);
                        $("#gender1").prop("disabled", true);
                        $("#gender2").prop("disabled", true);
                        $("#commPaymentType1").prop("disabled", true);
                        $("#commPaymentType2").prop("disabled", true);
                        $.uniform.update();
                    }, 200 );
                });
            });

            $("#modalA8A").on("show.bs.modal", function(e) {
                var $invoker = $(e.relatedTarget);

                $(this).find(".modal-body").load( Aurora.ROOT_URL + 'admin/taxfile/editA8a/' + $("#tfID").val( ) + '/' + $invoker.attr("data-id"), function() {
                    $("#fromMonth").select2({minimumResultsForSearch: Infinity});
                    $("#fromDay").select2({minimumResultsForSearch: Infinity});
                    $("#toMonth").select2({minimumResultsForSearch: Infinity});
                    $("#toDay").select2({minimumResultsForSearch: Infinity});

                    setTimeout( function( ) {
                        $("#saveIra8a").validate( that.ira8aValidate );
                        $("#saveIra8a").valid();
                    }, 100 );

                    setTimeout( function( ) {
                        $("#empIDNo8A").prop("disabled", true);
                        $("#empName8A").prop("disabled", true);
                    }, 200 );
                });
            });

            that.ir8aValidate = {
                ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
                successClass: 'validation-valid-label',
                highlight: function( element, errorClass ) {
                    var selectEle = $(element).next().find(".select2-selection");
                    if( selectEle.length > 0 ) {
                        selectEle.addClass("border-danger");
                    }
                    else {

                        $(element).addClass("border-danger");
                    }
                    if( $(element).attr("type") == "radio" ) {
                        $(element).parent().addClass("border-danger");
                    }
                    that.ir8aError = true;
                },
                unhighlight: function( element, errorClass ) {
                    var selectEle = $(element).next().find(".select2-selection");
                    if( selectEle.length > 0 ) {
                        selectEle.removeClass("border-danger");
                    }
                    else {
                        $(element).removeClass("border-danger");
                    }
                },
                // Different components require proper error label placement
                errorPlacement: function( error, element ) {
                    //$(".stepy-navigator .error").remove( );
                    //$(".stepy-navigator").prepend(error);
                },
                rules: {
                    empRef : "required",
                    empIDNo : "required",
                    empName : "required",
                    dobMonth: "required",
                    dobDay: "required",
                    dobYear: "required",
                    nationality: "required",
                    gender: "required",
                    address : "required",
                    designation: "required",
                    bankName: "required"
                }
            };

            that.ira8aValidate = {
                ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
                successClass: 'validation-valid-label',
                highlight: function( element, errorClass ) {
                    var selectEle = $(element).next().find(".select2-selection");
                    if( selectEle.length > 0 ) {
                        selectEle.addClass("border-danger");
                    }
                    else {

                        $(element).removeAttr("disabled").addClass("border-danger");
                    }
                },
                unhighlight: function( element, errorClass ) {
                    var selectEle = $(element).next().find(".select2-selection");
                    if( selectEle.length > 0 ) {
                        selectEle.removeClass("border-danger");
                    }
                    else {
                        $(element).removeClass("border-danger");
                    }
                },
                // Different components require proper error label placement
                errorPlacement: function( error, element ) {
                    //$(".stepy-navigator .error").remove( );
                    //$(".stepy-navigator").prepend(error);
                },
                rules: {
                    empName : "required",
                    empIDNo : "required",
                    address : "required",
                    days: "required",
                    numberShare: "required",
                    fromMonth: "required",
                    fromDay: "required",
                    fromYear: "required",
                    toMonth: "required",
                    toDay: "required",
                    toYear: "required",
                }
            };

            $("#submitIr8a").on("click", function(e) {
                var data = {
                    bundle: {
                        data: Aurora.WebService.serializePost("#saveIr8a")
                    },
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if( obj.bool === 0 ) {
                            swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            swal({
                                title: $("#empName").val() + "'s IR8A form has been successfully updated!",
                                type: "success"
                            }, function( isConfirm ) {
                                that.table.ajax.reload( );
                                $("#modalIR8A").modal("hide");

                                setTimeout( function( ) {
                                    that.prepareUserDeclaration(0);
                                }, 500 );
                            });
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/taxfile/saveIr8a", data);
                return false;
            });

            $("#submitIra8a").on("click", function(e) {
                var data = {
                    bundle: {
                        data: Aurora.WebService.serializePost("#saveIra8a")
                    },
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if( obj.bool === 0 ) {
                            swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            swal({
                                title: $("#empName8A").val() + "'s Appendix 8A form has been successfully updated!",
                                type: "success"
                            }, function( isConfirm ) {
                                that.table.ajax.reload( );
                                $("#modalA8A").modal("hide");

                                setTimeout( function( ) {
                                    that.prepareUserDeclaration(0);
                                }, 500 );
                            });
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/taxfile/saveIra8a", data);
                return false;
            });
        },


        prepareUserDeclaration: function( i ) {
            var that = this;
            if( markaxisTaxFileEmployee.selected.length > 0 ) {
                var userID = markaxisTaxFileEmployee.selected[i];

                var data = {
                    bundle: {
                        userID: userID,
                        tfID: $("#tfID").val( ),
                        year: $("#year").val( )
                    },
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if( obj.bool === 0 ) {
                            swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            var ir8a = $("#ir8a_" + obj.data.ir8a.userID);

                            if( obj.data.ir8a.completed == 1 ) {
                                ir8a.removeClass("label-pending").addClass("label-success").text("Prepared");
                            }
                            else {
                                ir8a.removeClass("label-pending").addClass("label-warning").text("Action Required");
                            }

                            var a8a = $("#a8a_" + obj.data.ir8a.userID);
                            a8a.removeClass("label-pending");

                            if( obj.data.ira8a.completed != undefined ) {
                                if( obj.data.ira8a.completed == 0 ) {
                                    a8a.removeClass("label-pending").addClass("label-warning").text("Action Required");
                                }
                                else {
                                    a8a.removeClass("label-pending").addClass("label-success").text("Prepared");
                                }
                            }
                            else {
                                a8a.removeClass("label-pending").addClass("label-default").text("Not Required");
                            }

                            i++;

                            if( i != markaxisTaxFileEmployee.selected.length ) {
                                that.prepareUserDeclaration( i );
                            }
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/taxfile/prepareUserDeclaration", data);
            }
        },


        /**
         * Table Initialize
         * @return void
         */
        initTable: function( ) {
            var that = this;

            if( that.table ) {
                that.table.destroy();
            }

            that.table = $(".declareTable").DataTable({
                processing: true,
                serverSide: true,
                fnCreatedRow: function (nRow, aData, iDataIndex) {
                    $(nRow).attr('id', 'row' + aData['userID']);
                },
                ajax: {
                    url: Aurora.ROOT_URL + "admin/taxfile/getDeclarationResults/",
                    type: "POST",
                    data: function ( d ) {
                        d.ajaxCall = 1;
                        d.csrfToken = Aurora.CSRF_TOKEN;
                        d.selected = markaxisTaxFileEmployee.selected;
                        d.year = $("#year").val( );
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
                    targets: [0],
                    orderable: true,
                    width: '200px',
                    data: 'name',
                    render: function(data, type, full, meta) {
                        return '<img src="' + full['photo'] + '" class="user-table-photo" />' + data;
                    }
                },{
                    targets: [1],
                    orderable: true,
                    width: '100px',
                    className : "text-center",
                    render: function(data, type, full, meta) {
                        return '<span id="ir8a_' + full['userID'] + '" class="label label-pending">Preparing <div class="loader"></div></span>';
                    }
                },{
                    targets: [2],
                    orderable: true,
                    width: '100px',
                    className : "text-center",
                    render: function(data, type, full, meta) {
                        return '<span id="a8a_' + full['userID'] + '" class="label label-pending">Preparing <div class="loader"></div></span>';
                    }
                },{
                    targets: [3],
                    searchable : false,
                    width: '100px',
                    className : "text-center",
                    render: function(data, type, full, meta) {
                        return '<span id="status' + full['userID'] + '" class="label label-striped">Not Supported</span>';
                    }
                },{
                    targets: [4],
                    orderable: false,
                    searchable : false,
                    width: '100px',
                    className : "text-center",
                    render: function(data, type, full, meta) {
                        return '<span id="status' + full['userID'] + '" class="label label-striped">Not Supported</span>';
                    }
                },{
                    targets: [5],
                    orderable: false,
                    searchable : false,
                    width: '100px',
                    className : "text-center",
                    render: function(data, type, full, meta) {
                        return '<span id="status' + full['userID'] + '" class="label label-striped">Not Supported</span>';
                    }
                },{
                    targets: [6],
                    orderable: false,
                    searchable : false,
                    width: '100px',
                    className : "text-center",
                    render: function(data, type, full, meta) {
                        return '<span id="status' + full['userID'] + '" class="label label-striped">Not Supported</span>';
                    }
                },{
                    targets: [7],
                    orderable: false,
                    searchable : false,
                    width: '100px',
                    className : "text-center p-0",
                    data: 'userID',
                    render: function(data, type, full, meta) {
                        return '<div class="list-icons">' +
                            '<div class="list-icons-item dropdown">' +
                            '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                            '<i class="icon-menu7"></i></a>' +
                            '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm" x-placement="bottom-end">' +
                            '<a class="dropdown-item" data-id="' + data + '" data-toggle="modal" data-target="#modalIR8A">' +
                            '<i class="icon-pencil5"></i> Edit IR8A</a>' +
                            '<a class="dropdown-item" data-id="' + data + '" data-toggle="modal" data-target="#modalA8A">' +
                            '<i class="icon-pencil5"></i> Edit A8A</a>' +
                            /*'<a class="dropdown-item" href="' + Aurora.ROOT_URL + 'admin/user/edit/' + data + '">' +
                            '<i class="icon-pencil5"></i> Edit A8B</a>' +
                            '<a class="dropdown-item" href="' + Aurora.ROOT_URL + 'admin/user/edit/' + data + '">' +
                            '<i class="icon-pencil5"></i> Edit IR8S</a>' +
                            '<a class="dropdown-item" href="' + Aurora.ROOT_URL + 'admin/user/edit/' + data + '">' +
                            '<i class="icon-pencil5"></i> Edit IR21</a>' +
                            '<a class="dropdown-item" href="' + Aurora.ROOT_URL + 'admin/user/edit/' + data + '">' +
                            '<i class="icon-pencil5"></i> Edit IR21A</a>' +*/
                            '</div>' +
                            '</div>' +
                            '</div>';
                    }
                }],
                order: [],
                dom: '<"datatable-header"Bfr><"datatable-scroll"t><"datatable-footer"ilp>',
                language: {
                    search: '',
                    info: Aurora.i18n.GlobalRes.LANG_TABLE_ENTRIES,
                    searchPlaceholder: Markaxis.i18n.PayrollRes.LANG_SEARCH_EMPLOYEE,
                    lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + Aurora.i18n.GlobalRes.LANG_NUMBER_ROWS + ':</span> _MENU_',
                    paginate: { 'first': Aurora.i18n.GlobalRes.LANG_FIRST, 'last': Aurora.i18n.GlobalRes.LANG_LAST, 'next': '&rarr;', 'previous': '&larr;' }
                },
                drawCallback: function () {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                },
                preDrawCallback: function() {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
                },
                initComplete: function( settings, json ) {
                    that.prepareUserDeclaration(0);
                }
            });

            // Datatable with saving state
            $('.declareTable .datatable-save-state').DataTable({
                stateSave: true
            });

            // Scrollable datatable
            $('.declareTable .datatable-scroll-y').DataTable({
                autoWidth: true,
                scrollY: 300
            });

            $(".declareTable tbody").on("mouseover", "td", function() {
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
            $(".dataTables_length select").select2({
                minimumResultsForSearch: Infinity,
                width: "auto"
            });
        }
    }
    return MarkaxisTaxFileDeclare;
})();
var markaxisTaxFileDeclare = null;
$(document).ready( function( ) {
    markaxisTaxFileDeclare = new MarkaxisTaxFileDeclare( );
});