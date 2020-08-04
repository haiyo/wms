/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: newsAnnouncement.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var AuroraNewsAnnouncement = (function( ) {


    /**
     * AuroraNewsAnnouncement Constructor
     * @return void
     */
    AuroraNewsAnnouncement = function( ) {
        this.table = null;
        this.modalNA = $("#modalNA");
        this.init( );
    };

    AuroraNewsAnnouncement.prototype = {
        constructor: AuroraNewsAnnouncement,

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

            $(document).on("click", ".naDelete", function(e) {
                that.naDelete( $(this).attr("data-id") );
                e.preventDefault( );
            });

            var CKEditor = function() {
                var _componentCKEditor = function() {
                    if( typeof CKEDITOR == "undefined" ) {
                        console.warn('Warning - ckeditor.js is not loaded.');
                        return;
                    }
                    CKEDITOR.replace("naContent", {
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

            $("#modalContent").on("show.bs.modal", function(e) {
                var $invoker = $(e.relatedTarget);

                var data = {
                    success: function( res   ) {
                        var obj = $.parseJSON( res );

                        if( obj.bool == 0 ) {
                            $("#modalContent .modal-body").html( obj.errMsg );
                            return;
                        }
                        $("#modalContent .modal-title").text( obj.data.title );
                        $("#modalContent .modal-body").html( obj.data.content );
                    }
                };
                Aurora.WebService.AJAX("admin/newsAnnouncement/getContent/" + $invoker.attr("data-id"), data );
            });

            that.modalNA.on("show.bs.modal", function(e) {
                CKEditor.init();
            });

            that.modalNA.on("shown.bs.modal", function(e) {
                var $invoker = $(e.relatedTarget);
                var naID = $invoker.attr("data-id");

                $("#saveNA").validate({
                    ignore: [],
                    rules: {
                        contentType: { required: true },
                        naTitle: { required: true },
                        naContent: { required: true }
                    },
                    messages: {
                        contentType: Aurora.i18n.NewsAnnouncement.LANG_PLEASE_SELECT_CONTENT_TYPE,
                        naTitle: Aurora.i18n.NewsAnnouncement.LANG_PLEASE_ENTER_TITLE,
                        naContent: Aurora.i18n.NewsAnnouncement.LANG_PLEASE_ENTER_CONTENT
                    },
                    /*errorPlacement: function(error, element) {

                        error.insertBefore(element);
                    },*/
                    submitHandler: function( ) {
                        var data = {
                            bundle: {
                                data: Aurora.WebService.serializePost("#saveNA")
                            },
                            success: function( res, ladda ) {
                                //ladda.stop( );

                                var obj = $.parseJSON( res );

                                if( obj.error ) {
                                    if( obj.bool == 0 ) {
                                        swal("error", obj.errMsg);
                                        return;
                                    }
                                }
                                else {
                                    that.table.ajax.reload();
                                    swal("Done!", "Content has been successfully created!", "success");
                                    $("#modalNA").modal('hide');
                                }
                            }
                        };
                        Aurora.WebService.AJAX( "admin/newsAnnouncement/save", data );
                    }
                });

                if( naID ) {
                    var data = {
                        success: function(res) {
                            var obj = $.parseJSON(res);

                            if( obj.bool == 0 ) {
                                swal( "error", obj.errMsg );
                                return;
                            }
                            else {
                                $("#naID").val( obj.data.naID );
                                $("#contentType").val( obj.data.isNews ).trigger("change");
                                $("#naTitle").val( obj.data.title );
                                CKEDITOR.instances.naContent.setData( obj.data.content );
                            }
                        }
                    }
                    Aurora.WebService.AJAX( "admin/newsAnnouncement/getContent/" + naID, data );
                }
                else {
                    $("#naID").val(0);
                    $("#contentType").val("").trigger("change");;
                    $("#naTitle").val("");
                    CKEDITOR.instances.naContent.setData("");
                }
            });
        },


        /**
         * Delete
         * @return void
         */
        naDelete: function( naID ) {
            var that = this;
            var title = $("#naTitle" + naID).text( );

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
                        data: naID
                    },
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if (obj.bool == 0) {
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
                Aurora.WebService.AJAX("admin/newsAnnouncement/naDelete", data);
            });
        },


        /**
         * Table Initialize
         * @return void
         */
        initTable: function( ) {
            var that = this;

            this.table = $(".naTable").DataTable({
                "processing": true,
                "serverSide": true,
                "fnCreatedRow": function (nRow, aData, iDataIndex) {
                    $(nRow).attr('id', 'naTable-row' + aData['naID']);
                },
                ajax: {
                    url: Aurora.ROOT_URL + "admin/newsAnnouncement/results",
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
                    data: 'title',
                    render: function( data, type, full, meta ) {
                        return '<span id="naTitle' + full['naID'] + '">' + data + '</span>';
                    }
                },{
                    targets: [1],
                    orderable: true,
                    width: '260px',
                    data: 'isNews',
                    render: function(data, type, full, meta) {
                        if( data == 0 ) {
                            return Aurora.i18n.NewsAnnouncement.LANG_ANNOUNCEMENT;
                        }
                        else {
                            return Aurora.i18n.NewsAnnouncement.LANG_NEWS;
                        }
                    }
                },{
                    targets: [2],
                    orderable: true,
                    width: '260px',
                    data: 'createdBy'
                },{
                    targets: [3],
                    orderable: true,
                    width: '260px',
                    data: 'created'
                },{
                    targets: [4],
                    orderable: false,
                    searchable : false,
                    width: '100px',
                    className : "text-center p-0",
                    data: 'naID',
                    render: function(data, type, full, meta) {
                        return '<div class="list-icons">' +
                            '<div class="list-icons-item dropdown">' +
                            '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                            '<i class="icon-menu7"></i></a>' +
                            '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm" x-placement="bottom-end">' +
                            '<a class="dropdown-item" data-id="' + data + '" data-toggle="modal" data-target="#modalNA" ' +
                            'data-backdrop="static" data-keyboard="false">' +
                            '<i class="icon-pencil5"></i> Edit Content</a>' +
                            '<li class="divider"></li>' +
                            '<a class="dropdown-item naDelete" data-id="' + data + '">' +
                            '<i class="icon-bin"></i> Delete Content</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                    }
                }],
                order: [],
                dom: '<"datatable-header"f><"datatable-scroll"t><"datatable-footer"ilp>',
                language: {
                    search: '',
                    searchPlaceholder: 'Search Title or Author Name',
                    lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of Rows:</span> _MENU_',
                    paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
                },
                drawCallback: function () {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                    Popups.init();
                    $(".naTable [type=checkbox]").uniform();
                },
                preDrawCallback: function() {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
                }
            });

            $(".na-list-action-btns").insertAfter("#naList .dataTables_filter");

            $('#naList .datatable-pagination').DataTable({
                pagingType: "simple",
                language: {
                    paginate: {'next': 'Next &rarr;', 'previous': '&larr; Prev'}
                }
            });

            $('#naList .datatable-save-state').DataTable({
                stateSave: true
            });

            $('#naList .datatable-scroll-y').DataTable({
                autoWidth: true,
                scrollY: 300
            });

            $("#naList .dataTable tbody").on("mouseover", "td", function( ) {
                if( typeof that.table.cell(this).index() == "undefined" ) return;
                var colIdx = that.table.cell(this).index().column;

                if (colIdx !== null) {
                    $(that.table.cells().nodes()).removeClass("active");
                    $(that.table.column(colIdx).nodes()).addClass("active");
                }
            }).on("mouseleave", function() {
                $(that.table.cells().nodes()).removeClass("active");
            });

            $('#naList .dataTables_length select').select2({
                minimumResultsForSearch: Infinity,
                width: 'auto'
            });
        }
    }
    return AuroraNewsAnnouncement;
})();
var auroraNewsAnnouncement = null;
$(document).ready( function( ) {
    auroraNewsAnnouncement = new AuroraNewsAnnouncement( );
});