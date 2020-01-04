
<script>
    $(document).ready(function( ) {
        $("#contentType").select2({minimumResultsForSearch: -1});

        var CKEditor = function() {
            var _componentCKEditor = function() {
                if( typeof CKEDITOR == "undefined" ) {
                    console.warn('Warning - ckeditor.js is not loaded.');
                    return;
                }
                CKEDITOR.replace("naContent", {
                    language: 'en',
                    height: 300,
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


        var naTable = $(".naTable").DataTable({
            "processing": true,
            "serverSide": true,
            "fnCreatedRow": function (nRow, aData, iDataIndex) {
                $(nRow).attr('id', 'row' + aData['userID']);
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
                data: 'title'
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
                        '<i class="icon-menu9"></i></a>' +
                        '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm" x-placement="bottom-end">' +
                        '<a class="dropdown-item" data-id="' + data + '" data-toggle="modal" data-target="#modalNA" ' +
                        'data-backdrop="static" data-keyboard="false">' +
                        '<i class="icon-pencil5"></i> Edit Content</a>' +
                        '<li class="divider"></li>' +
                        '<a class="dropdown-item" href="<?TPLVAR_ROOT_URL?>admin/employee/email/' + data + '">' +
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
            var colIdx = naTable.cell(this).index( ).column;

            if( colIdx !== lastIdx ) {
                $(naTable.cells().nodes()).removeClass("active");
                $(naTable.column(colIdx).nodes()).addClass("active");
            }
        }).on("mouseleave", function() {
            $(naTable.cells().nodes()).removeClass("active");
        });

        // External table additions
        // ------------------------------

        // Enable Select2 select for the length option
        $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity,
            width: 'auto'
        });

        $(".list-action-btns").insertAfter(".dataTables_filter");

        $("#modalNA").on("show.bs.modal", function(e) {
            CKEditor.init();
        });

        $("#modalNA").on("shown.bs.modal", function(e) {
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
    });
</script>
<div class="tab-pane fade show" id="naList">
    <div class="list-action-btns">
        <ul class="icons-list">
            <li>
                <!-- BEGIN DYNAMIC BLOCK: addEmployeeBtn -->
                <a type="button" class="btn bg-purple-400 btn-labeled" data-toggle="modal" data-target="#modalNA">
                    <b><i class="mi-description"></i></b> <?LANG_CREATE_NEW_CONTENT?></a>&nbsp;&nbsp;&nbsp;
                <!-- END DYNAMIC BLOCK: addEmployeeBtn -->
            </li>
        </ul>
    </div>

    <table class="table table-hover naTable">
        <thead>
        <tr>
            <th>Title</th>
            <th>Content Type</th>
            <th>Author</th>
            <th>Date Created</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<div id="modalNA" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><?LANG_CREATE_NEW_CONTENT?></h6>
            </div>

            <form id="saveNA" name="saveNA" class="saveNA" method="post" action="">
                <div class="modal-body overflow-y-visible">
                    <input type="hidden" id="naID" name="naID" value="0" />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?LANG_SELECT_CONTENT_TYPE?>: <span class="requiredField">*</span></label>
                                <label for="contentType" generated="true" class="error errorLabel"></label>
                                <?TPLVAR_CONTENT_TYPE_LIST?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?LANG_TITLE?>: <span class="requiredField">*</span></label>
                                <label for="naTitle" generated="true" class="error errorLabel"></label>
                                <input type="text" name="naTitle" id="naTitle" class="form-control" value=""
                                       placeholder="Enter title for this content" />
                            </div>
                        </div>

                        <div class="col-md-12 pb-10">
                            <div class="form-group">
                                <label>Content: <span class="requiredField">*</span></label>
                                <label for="naContent" generated="true" class="error errorLabel"></label>
                                <div class="form-group">
                                    <div class="col-md-12 p-0">
                                        <textarea name="naContent" id="naContent" rows="4" cols="4"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="modal-footer-btn">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Discard</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
