/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: loa.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisLOA = (function( ) {


    /**
     * MarkaxisLOA Constructor
     * @return void
     */
    MarkaxisLOA = function( ) {
        this.table = null;
        this.editor = null;
        this.modalLOA = $("#modalLOA");
        this.init( );
    };

    MarkaxisLOA.prototype = {
        constructor: MarkaxisLOA,

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

            $("#designation").multiselect({
                includeSelectAllOption: true,
                numberDisplayed: 5
            });

            $(document).on("click", ".loaDelete", function(e) {
                that.loaDelete( $(this).attr("data-id") );
                e.preventDefault( );
            });

            that.editor = function() {
                var _componentCKEditor = function() {
                    if( typeof CKEDITOR == "undefined" ) {
                        console.warn('Warning - ckeditor.js is not loaded.');
                        return;
                    }
                    CKEDITOR.replace("loaContent", {
                        language: 'en',
                        height: 270,
                    });
                };
                var _componentSelect2 = function() {
                    if( !$().select2 ) {
                        console.warn('Warning - select2.min.js is not loaded.');
                        return;
                    };

                    // Default initialization
                    $('.form-control-select2').select2({
                        minimumResultsForSearch: Infinity
                    });
                };
                return {
                    init: function() {
                        _componentCKEditor();
                        _componentSelect2();
                    }
                }
            }();

            if( typeof CKEDITOR === "function" ) {
                CKEDITOR.on('instanceReady', function () {
                    $.each(CKEDITOR.instances, function (instance) {
                        CKEDITOR.instances[instance].document.on("keyup", CK_jQ);
                        CKEDITOR.instances[instance].document.on("paste", CK_jQ);
                        CKEDITOR.instances[instance].document.on("keypress", CK_jQ);
                        CKEDITOR.instances[instance].document.on("blur", CK_jQ);
                        CKEDITOR.instances[instance].document.on("change", CK_jQ);
                    });
                });

                function CK_jQ() {
                    for (instance in CKEDITOR.instances) {
                        CKEDITOR.instances[instance].updateElement();
                    }
                }
            }

            that.editor.init();

            that.modalLOA.on("hidden.bs.modal", function() {
                $("#designation").multiselect("clearSelection");
            });

            that.modalLOA.on("shown.bs.modal", function(e) {
                var $invoker = $(e.relatedTarget);
                var loaID = $invoker.attr("data-id");

                $("#saveLOA").validate({
                    ignore: [],
                    rules: {
                        designation: { required: true },
                        loaContent: { required: true }
                    },
                    messages: {
                        designation: Markaxis.i18n.LOARes.LANG_PLEASE_SELECT_DESIGNATION,
                        loaContent: Markaxis.i18n.LOARes.LANG_PLEASE_ENTER_CONTENT
                    },
                    errorPlacement: function(error, element) {
                        if( $("#saveLOA .modal-footer .error").length > 0 ) {
                            $("#saveLOA .modal-footer .error").remove( );
                        }
                        $("#saveLOA .modal-footer").append( error );
                    },
                    submitHandler: function( ) {
                        var data = {
                            bundle: {
                                data: Aurora.WebService.serializePost("#saveLOA")
                            },
                            success: function( res, ladda ) {
                                //ladda.stop( );

                                var obj = $.parseJSON( res );

                                if( obj.error ) {
                                    if( obj.bool == 0 ) {
                                        swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                                        return;
                                    }
                                }
                                else {
                                    that.table.ajax.reload();
                                    swal( Aurora.i18n.GlobalRes.LANG_DONE + "!", Markaxis.i18n.LOARes.LANG_LOA_SUCCESSFULLY_CREATED, "success");
                                    $("#modalLOA").modal('hide');
                                }
                            }
                        };
                        Aurora.WebService.AJAX( "admin/loa/save", data );
                    }
                });

                if( loaID ) {
                    var data = {
                        success: function(res) {
                            var obj = $.parseJSON(res);

                            if( obj.bool == 0 ) {
                                swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                                return;
                            }
                            else {
                                $("#modalLOA .modal-title").text( Markaxis.i18n.LOARes.LANG_EDIT_LOA );
                                $("#loaID").val( obj.data.loaID );
                                //$("#designation").val( obj.data.designationID ).trigger("change");

                                if( obj.data.designation.length > 0 ) {
                                    for( var j=0; j<obj.data.designation.length; j++ ) {
                                        $("#designation").multiselect("select", obj.data.designation[j] );
                                    }
                                    $("#designation").multiselect("refresh");
                                }

                                CKEDITOR.instances.loaContent.setData( obj.data.content );
                            }
                        }
                    }
                    Aurora.WebService.AJAX( "admin/loa/getContent/" + loaID, data );
                }
                else {
                    $("#modalLOA .modal-title").text( Markaxis.i18n.LOARes.LANG_CREATE_NEW_LOA );
                    $("#loaID").val(0);
                    $("#designation").val("").trigger("change");
                    CKEDITOR.instances.loaContent.setData("");
                }
            });
        },


        /**
         * Delete
         * @return void
         */
        loaDelete: function( loaID ) {
            var that = this;

            swal({
                title: Aurora.i18n.GlobalRes.LANG_ARE_YOU_SURE_DELETE.replace('{title}', 'LOA'),
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
                        data: loaID
                    },
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if (obj.bool == 0) {
                            swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            that.table.ajax.reload();
                            swal( Aurora.i18n.GlobalRes.LANG_DONE + "!", Aurora.i18n.GlobalRes.LANG_SUCCESSFULLY_DELETE.replace('{title}', 'LOA'), "success");
                            return;
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/loa/delete", data);
            });
        },


        /**
         * Table Initialize
         * @return void
         */
        initTable: function( ) {
            var that = this;

            that.table = $(".loaTable").DataTable({
                "processing": true,
                "serverSide": true,
                "fnCreatedRow": function (nRow, aData, iDataIndex) {
                    $(nRow).attr('id', 'loaTable-row' + aData['loaID']);
                },
                ajax: {
                    url: Aurora.ROOT_URL + "admin/loa/results",
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
                    width: '270px',
                    data: 'designation',
                    render: function(data, type, full, meta) {
                        var badge = "";

                        if( data.length > 0 ) {
                            for( var i=0; i<data.length; i++ ) {
                                badge += '<span class="badge badge-primary badge-criteria">' + data[i] + '</span> ';
                            }
                        }
                        return badge;

                    }
                },{
                    targets: [1],
                    orderable: true,
                    width: '60px',
                    data: 'name'
                },{
                    targets: [2],
                    orderable: true,
                    width: '60px',
                    data: 'lastUpdated'
                },{
                    targets: [3],
                    orderable: false,
                    searchable : false,
                    width: '100px',
                    className : "text-center p-0",
                    data: 'loaID',
                    render: function(data, type, full, meta) {
                        return '<div class="list-icons">' +
                            '<div class="list-icons-item dropdown">' +
                            '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                            '<i class="icon-menu7"></i></a>' +
                            '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm" x-placement="bottom-end">' +
                            '<a class="dropdown-item" data-id="' + data + '" data-toggle="modal" data-target="#modalLOA" ' +
                            'data-backdrop="static" data-keyboard="false">' +
                            '<i class="icon-pencil5"></i> ' + Markaxis.i18n.LOARes.LANG_EDIT_LOA + '</a>' +
                            '<li class="divider"></li>' +
                            '<a class="dropdown-item loaDelete" data-id="' + data + '">' +
                            '<i class="icon-bin"></i> ' + Markaxis.i18n.LOARes.LANG_DELETE_LOA + '</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                    }
                }],
                order: [],
                dom: '<"datatable-header"f><"datatable-scroll"t><"datatable-footer"ilp>',
                language: {
                    search: '',
                    searchPlaceholder: '',
                    info: Aurora.i18n.GlobalRes.LANG_TABLE_ENTRIES,
                    lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + Aurora.i18n.GlobalRes.LANG_NUMBER_ROWS + ':</span> _MENU_',
                    paginate: { 'first': Aurora.i18n.GlobalRes.LANG_FIRST, 'last': Aurora.i18n.GlobalRes.LANG_LAST, 'next': '&rarr;', 'previous': '&larr;' }
                },
                drawCallback: function () {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                    Popups.init();
                    $(".loaTable [type=checkbox]").uniform();
                },
                preDrawCallback: function() {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
                }
            });

            $(".loa-list-action-btns").insertAfter("#loaList .dataTables_filter");

            $('#loaList .datatable-pagination').DataTable({
                pagingType: "simple",
                language: {
                    paginate: {'next': Aurora.i18n.GlobalRes.LANG_NEXT + ' &rarr;', 'previous': '&larr; ' + Aurora.i18n.GlobalRes.LANG_PREV}
                }
            });

            $('#loaList .datatable-save-state').DataTable({
                stateSave: true
            });

            $('#loaList .datatable-scroll-y').DataTable({
                autoWidth: true,
                scrollY: 300
            });

            $("#loaList .dataTable tbody").on("mouseover", "td", function( ) {
                if( typeof that.table.cell(this).index() == "undefined" ) return;
                var colIdx = that.table.cell(this).index().column;

                if (colIdx !== null) {
                    $(that.table.cells().nodes()).removeClass("active");
                    $(that.table.column(colIdx).nodes()).addClass("active");
                }
            }).on("mouseleave", function() {
                $(that.table.cells().nodes()).removeClass("active");
            });

            $('#loaList .dataTables_length select').select2({
                minimumResultsForSearch: Infinity,
                width: 'auto'
            });
        }
    }
    return MarkaxisLOA;
})();
var markaxisLOA = null;
$(document).ready( function( ) {
    markaxisLOA = new MarkaxisLOA( );
});