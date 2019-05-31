<script>
    $(document).ready(function( ) {
        var claimTable = $(".claimTable").DataTable({
            "processing": true,
            "serverSide": true,
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id', 'claimTable-row' + aData['ecID']);
            },
            ajax: {
                url: Aurora.ROOT_URL + "admin/expense/getClaimResults",
                type: "POST",
                data: function(d) {
                    d.ajaxCall = 1;
                    d.csrfToken = Aurora.CSRF_TOKEN;
                },
            },
            initComplete: function () {
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
                searchable: false,
                width: "180px",
                data: "title",
                render: function( data, type, full, meta ) {
                    return '<span id="claim' + full['ecID'] + '">' + data + '</span>';
                }
            },{
                targets: [1],
                orderable: true,
                searchable: false,
                width: "180px",
                data: "descript",
                render: function( data, type, full, meta ) {
                    return '<span id="claimDescript' + full['ecID'] + '">' + data + '</span>';
                }
            },{
                targets: [2],
                orderable: true,
                searchable: false,
                width: "100px",
                data: "amount",
                render: function( data, type, full, meta ) {
                    return full['code'] + full['symbol'] + data;
                }
            },{
                targets: [3],
                orderable: true,
                searchable: false,
                width: "110px",
                data: "uploadName",
                className : "text-center",
                render: function( data, type, full, meta ) {
                    if( data ) {
                        return '<div class="text-ellipsis"><a target="_blank" href="' + Aurora.ROOT_URL +
                               'admin/file/view/' + full['uID'] + '/' + full['hashName'] + '">' + data + '</a></div>';
                    }
                    else {
                        return '';
                    }
                }
            },{
                targets: [4],
                orderable: true,
                searchable: false,
                width: "100px",
                data: "status",
                className : "text-center",
                render: function( data, type, full, meta ) {
                    if( full['cancelled'] == 1 ) {
                        return '<span id="status' + full['piID'] + '" class="label label-default">Cancelled</span>';
                    }
                    else {
                        if( data == 0 ) {
                            return '<span id="status' + full['piID'] + '" class="label label-pending">Pending Approval</span>';
                        }
                        else if( data == 1 ) {
                            return '<span id="status' + full['piID'] + '" class="label label-success">Approved</span>';
                        }
                        else {
                            return '<span id="status' + full['piID'] + '" class="label label-danger">Disapproved</span>';
                        }
                    }
                }
            },{
                targets: [5],
                orderable: false,
                searchable : false,
                width: '140px',
                data: 'managers',
                render: function(data, type, full, meta) {
                    //var name   = full["name"];
                    //var statusText = full['suspended'] == 1 ? "Unsuspend Employee" : "Suspend Employee"
                    var length = data.length;
                    var managers = "";

                    for( var i=0; i<length; i++ ) {
                        if( data[i]["approved"] == 0 ) {
                            managers += '<i class="icon-watch2 text-grey-300 mr-3"></i>';
                        }
                        else if( data[i]["approved"] == 1 ) {
                            managers += '<i class="icon-checkmark4 text-green-800 mr-3"></i>';
                        }
                        else if( data[i]["approved"] == "-1" ) {
                            managers += '<i class="icon-cross2 text-warning-800 mr-3"></i>';
                        }
                        managers += data[i]["name"] + "<br />";
                    }
                    return managers;
                }
            },{
                targets: [6],
                orderable: true,
                searchable: false,
                width: "100px",
                data: "created"
            },{
                targets: [7],
                orderable: false,
                searchable: false,
                width:"100px",
                className:"text-center",
                data:"ecID",
                render: function( data, type, full, meta ) {
                    if( full['cancelled'] == 0 && full['status'] != 1 ) {
                        return '<div class="list-icons">' +
                                '<div class="list-icons-item dropdown">' +
                                '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                                '<i class="icon-menu9"></i></a>' +
                                '<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right" x-placement="bottom-end">' +
                                '<a class="dropdown-item" data-id="' + data + '" data-backdrop="static" data-keyboard="false" ' +
                                'data-toggle="modal" data-target="#modalClaim">' +
                                '<i class="icon-pencil5"></i> Edit Claim</a>' +
                                '<div class="divider"></div>' +
                                '<a class="dropdown-item claimCancel" data-id="' + data + '">' +
                                '<i class="icon-cross2"></i> Cancel Claim</a>' +
                                '</div>' +
                                '</div>' +
                                '</div>';
                    }
                    return '';
                }
            }],
            order: [],
            dom: '<"datatable-header"f><"datatable-scroll"t><"datatable-footer"ilp>',
            language: {
                search: '',
                searchPlaceholder: 'Search Claim',
                lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of Rows:</span> _MENU_',
                paginate: {'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;'}
            },
            drawCallback: function () {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                $(".payItemTable [type=checkbox]").uniform();
            },
            preDrawCallback: function () {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
            }
        });

        $(".claim-list-action-btns").insertAfter("#claim .dataTables_filter");

        var lastIdx = null;

        $('.claimTable tbody').on('mouseover', 'td', function() {
            if( typeof claimTable.cell(this).index() == "undefined" ) return;
            var colIdx = claimTable.cell(this).index().column;

            if (colIdx !== lastIdx) {
                $(claimTable.cells().nodes()).removeClass('active');
                $(claimTable.column(colIdx).nodes()).addClass('active');
            }
        }).on('mouseleave', function( ) {
            $(claimTable.cells( ).nodes( )).removeClass("active");
        });

        // Enable Select2 select for the length option
        $("#claim .dataTables_length select").select2({
            minimumResultsForSearch: Infinity,
            width: "auto"
        });

        $(document).on("click", ".claimCancel", function ( ) {
            var ecID = $(this).attr("data-id");
            var title = $("#claim" + id).text( );

            swal({
                title: "Are you sure you want to cancel the claim " + title + "?",
                text: "Description: " + $("#claimDescript" + id).text( ),
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Confirm Cancel",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function( isConfirm ) {
                if( isConfirm === false ) return;

                var data = {
                    bundle: {
                        data: ecID
                    },
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if( obj.bool == 0 ) {
                            swal("Error!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            $(".claimTable").DataTable().ajax.reload();
                            swal("Done!", title + " has been successfully cancelled!", "success");
                            return;
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/expense/cancelClaim", data);
            });
            return false;
        });

        $("#modalClaim").on("show.bs.modal", function(e) {
            var $invoker = $(e.relatedTarget);
            var ecID = $invoker.attr("data-id");

            markaxisUSuggest = new MarkaxisUSuggest( false );

            if( ecID ) {
                var data = {
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if( obj.bool == 0 ) {
                            swal("error", obj.errMsg);
                            return;
                        }
                        else {
                            $("#ecID").val( obj.data.ecID )
                            $("#expense").val( obj.data.eiID ).trigger("change");
                            $("#claimDescript").val( obj.data.descript );
                            $("#currency").val( obj.data.currencyID ).trigger("change");
                            $("#claimAmount").val( obj.data.amount );
                            $("#ecaUploadField").val( obj.data.uploadName );

                            markaxisUSuggest.setSuggestToken( obj.data.managers );
                        }
                    }
                }
                Aurora.WebService.AJAX( "admin/expense/getClaim/" + ecID, data );
            }
            else {
                $("#ecID").val(0);
                $("#claimDescript").val("");
                $("#claimAmount").val("");
                $("#ecaUploadField").val("");

                markaxisUSuggest.clearToken( );
                markaxisUSuggest.getSuggestToken("admin/employee/getSuggestToken" );
            }
        });

        $("#expense").select2( ).change(function( ) {
            $(this).valid( );
            $(this).removeAttr("aria-required");
        });
        $("#currency").select2( ).change(function( ) {
            $(this).valid( );
            $(this).removeAttr("aria-required");
        });

        var validator = $("#saveClaim").validate({
            ignore: "",
            rules: {
                expense: { required: true },
                currency: { required: true },
                claimAmount: { required: true }
            },
            messages: {
                expense: "Please provide all required fields."
            },
            highlight: function(element, errorClass, validClass) {
                var elem = $(element);
                if( elem.hasClass("select2-hidden-accessible") ) {
                    $("#select2-" + elem.attr("id") + "-container").parent( ).addClass("border-danger");
                }
                else {
                    elem.addClass("border-danger");
                }
            },
            unhighlight: function(element, errorClass, validClass) {
                var elem = $(element);
                if( elem.hasClass("select2-hidden-accessible") ) {
                    $("#select2-" + elem.attr("id") + "-container").parent( ).removeClass("border-danger");
                }
                else {
                    elem.removeClass("border-danger");
                }
            },
            // Different components require proper error label placement
            errorPlacement: function(error, element) {
                if( $(".modal-footer .error").length == 0 )
                    $(".modal-footer").append(error);
            },
            submitHandler: function( ) {
                $("#expense-error").remove( );

                var data = {
                    bundle: {
                        data: Aurora.WebService.serializePost("#saveClaim")
                    },
                    success: function( res ) {
                        var obj = $.parseJSON( res );

                        if( obj.bool == 0 ) {
                            swal("error", obj.errMsg);
                            return;
                        }
                        else {
                            $(".claimTable").DataTable( ).ajax.reload( );

                            $("#expense").val("").trigger("change");
                            $("#expense-error").remove( );
                            $("#claimDescript").val("");
                            $("#claimAmount").val("");
                            validator.resetForm( );

                            swal({
                                title: "Claim has been successfully created!",
                                text: "What do you want to do next?",
                                type: 'success',
                                confirmButtonClass: 'btn btn-success',
                                cancelButtonClass: 'btn btn-danger',
                                buttonsStyling: false,
                                showCancelButton: true,
                                confirmButtonText: "Create Another Claim",
                                cancelButtonText: "Close Window",
                                reverseButtons: true
                            }, function( isConfirm ) {
                                if( isConfirm === false ) {
                                    $("#modalClaim").modal("hide");
                                }
                            });
                        }
                    }
                };
                Aurora.WebService.AJAX( "admin/expense/saveClaim", data );
            }
        });

        // Modal template
        var modalTemplate = '<div class="modal-dialog modal-lg" role="document">\n' +
            '  <div class="modal-content">\n' +
            '    <div class="modal-header align-items-center">\n' +
            '      <h6 class="modal-title">{heading} <small><span class="kv-zoom-title"></span></small></h6>\n' +
            '      <div class="kv-zoom-actions btn-group">{toggleheader}{fullscreen}{borderless}{close}</div>\n' +
            '    </div>\n' +
            '    <div class="modal-body">\n' +
            '      <div class="floating-buttons btn-group"></div>\n' +
            '      <div class="kv-zoom-body file-zoom-content"></div>\n' + '{prev} {next}\n' +
            '    </div>\n' +
            '  </div>\n' +
            '</div>\n';

        var preview = '<div class="file-preview {class}">\n' +
        '    <div class="{dropClass}">\n' +
        '    <div class="file-preview-thumbnails">\n' +
        '    </div>\n' +
        '    <div class="clearfix"></div>' +
        '    <div class="file-preview-status text-center text-success"></div>\n' +
        '    <div class="kv-fileinput-error"></div>\n' +
        '    </div>\n' +
        '</div>';

        // Buttons inside zoom modal
        var previewZoomButtonClasses = {
            toggleheader: 'btn btn-light btn-icon btn-header-toggle btn-sm',
            fullscreen: 'btn btn-light btn-icon btn-sm',
            borderless: 'btn btn-light btn-icon btn-sm',
            close: 'btn btn-light btn-icon btn-sm'
        };

        // Icons inside zoom modal classes
        var previewZoomButtonIcons = {
            prev: '<i class="icon-arrow-left32"></i>',
            next: '<i class="icon-arrow-right32"></i>',
            toggleheader: '<i class="icon-menu-open"></i>',
            fullscreen: '<i class="icon-screen-full"></i>',
            borderless: '<i class="icon-alignment-unalign"></i>',
            close: '<i class="icon-cross2 font-size-base"></i>'
        };

        // File actions
        var fileActionSettings = {
            removeClass: 'kv-file-remove btn btn-sm',
            removeIcon: '<i class="icon-bin"></i>',
            uploadIcon: '<i class="icon-upload"></i>',
            uploadClass: '',
            zoomClass: 'btn btn-sm',
            zoomIcon: '<i class="icon-zoomin3"></i>',
        };

        var previewSettings = {
            pdf: {width: "400px", height: "290px"},
            image: {width: "400px", height: "290px"},
            object: {width: "400px", height: "290px"},
            other: {width: "400px", height: "290px"}
        };

        var uploadedFile = false;

        $(".claimFileInput").fileinput({
            browseLabel: 'Browse',
            uploadUrl: Aurora.ROOT_URL + "admin/expense/upload",
            uploadAsync: false,
            showRemove: false,
            showDrag: false,
            maxFileCount: 1,
            initialPreview: [],
            browseIcon: '<i class="icon-file-plus mr-2"></i>',
            uploadIcon: '<i class="icon-file-upload2 mr-2"></i>',
            removeIcon: '<i class="icon-cross2 font-size-base mr-2"></i>',
            fileActionSettings: fileActionSettings,
            layoutTemplates: {
                icon: '<i class="icon-file-check"></i>',
                modal: modalTemplate,
                preview: preview,
                main1: '{preview}\n' +
                '<div class="kv-upload-progress kv-hidden"></div><div class="clearfix"></div>\n' +
                '<div class="input-group {class}">\n' +
                '  {caption}\n' +
                '    {remove}\n' +
                '    {cancel}\n' +
                '    {upload}\n' +
                '    {browse}\n' +
                '</div>',
                actions: '<div class="file-actions">\n' +
                '    <div class="file-footer-buttons">\n' +
                '        {delete} {zoom} {other}' +
                '    </div>\n' +
                '    {drag}\n' +
                '    <div class="clearfix"></div>\n' +
                '</div>',
            },
            initialCaption: 'No file selected',
            previewZoomButtonClasses: previewZoomButtonClasses,
            previewZoomButtonIcons: previewZoomButtonIcons,
            allowedFileExtensions: ['pdf', 'doc', 'docx'],
            previewSettings: previewSettings
        }).on('fileuploaderror', function(event, data, msg) {
            console.log('File uploaded', data.previewId, data.index, data.fileId, msg);
        }).on('filebatchuploadsuccess', function(event, data) {
            console.log(data)
            uploadedFile = data.response;
        });

        $("#claimSaveUploaded").on("click", function( ) {
            if( uploadedFile ) {

                // Upload via Menu
                if( $("#ecaUID").val( ) ) {
                    if( $("#claimIDModal").val( ) ) {
                        var data = {
                            bundle: {
                                ecID: $("#claimIDModal").val( ),
                                uID: uploadedFile.uID,
                                hashName: uploadedFile.hashName
                            },
                            success: function( res ) {
                                if( $("#eduEdit").val( ) ) {
                                    $("#eduCertificate").val( uploadedFile.name );
                                    $("#eduUID").val( uploadedFile.uID );
                                    $("#eduHashName").val( uploadedFile.hashName );
                                }

                                uploadedFile = false;
                                $(".fileinput-remove").click( );
                                $("#uploadEduModal").modal("hide");
                            }
                        };
                        Aurora.WebService.AJAX( "admin/employee/updateCertificate", data );
                    }
                }
                else {
                    // New Upload
                    $("#ecaUID").val( uploadedFile.uID );
                    $("#ecaName").val( uploadedFile.name );
                    $("#ecaHashName").val( uploadedFile.hashName );
                    $("#ecaUploadField").val( uploadedFile.name );

                    uploadedFile = false;
                    $(".fileinput-remove").click( );
                    $("#uploadClaimModal").modal("hide");
                }
            }
        });
    });
</script>

<div class="tab-pane fade" id="claim">
    <div class="list-action-btns claim-list-action-btns">
        <ul class="icons-list">
            <li>
                <a type="button" class="btn bg-purple-400 btn-labeled"
                   data-toggle="modal" data-target="#modalClaim">
                    <b><i class="icon-file-plus2"></i></b> <?LANG_CREATE_NEW_CLAIM?>
                </a>
            </li>
        </ul>
    </div>

    <table class="table table-hover datatable tableLayoutFixed claimTable">
        <thead>
        <tr>
            <th>Claim Type</th>
            <th>Description</th>
            <th>Amount</th>
            <th>Attachment</th>
            <th>Status</th>
            <th>Manager(s)</th>
            <th>Date Created</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>
<div id="modalClaim" class="modal fade">
    <div class="modal-dialog modal-med">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><?LANG_CREATE_NEW_CLAIM?></h6>
            </div>

            <form id="saveClaim" name="saveClaim" method="post" action="">
                <div class="modal-body overflow-y-visible">
                    <input type="hidden" id="ecID" name="ecID" value="0" />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Select Expense Type: <span class="requiredField">*</span></label>
                                <?TPLVAR_EXPENSE_LIST?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description:</label>
                                <input type="text" name="claimDescript" id="claimDescript" class="form-control" value=""
                                       placeholder="Enter description for this claim" />
                            </div>
                        </div>

                        <div class="col-md-12 pb-10">
                            <div class="form-group">
                                <label>Amount To Claim: <span class="requiredField">*</span></label>
                                <div class="form-group">
                                    <div class="col-md-4 pl-0 pb-10">
                                        <?TPL_CURRENCY_LIST?>
                                    </div>
                                    <div class="col-md-8 p-0">
                                        <input type="number" name="claimAmount" id="claimAmount" class="form-control" value=""
                                               placeholder="Enter claim amount (For eg: 2.50)" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 pb-10">
                            <label class="display-block">Upload Receipt or Any Supporting Document:</label>
                            <div class="input-group">
                                <input type="text" id="ecaUploadField" name="ecaUploadField" class="form-control upload-control" readonly="readonly" />
                                <input type="hidden" id="ecaUID" name="ecaUID" class="form-control" />
                                <input type="hidden" id="ecaHashName" name="ecaHashName" class="form-control" />
                                <span class="input-group-append">
                                    <button class="btn btn-light" type="button" data-toggle="modal" data-target="#uploadClaimModal">
                                        Upload &nbsp;<i class="icon-file-plus"></i>
                                    </button>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Approving Manager(s):</label>
                                <input type="text" name="managers" class="form-control tokenfield-typeahead suggestList"
                                       placeholder="Enter Manager's Name"
                                       value="" autocomplete="off" data-fouc />
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
<div id="uploadClaimModal" class="modal fade">
    <div class="modal-dialog modal-med">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title">Upload Attachment</h6>
            </div>

            <div class="modal-body overflow-y-visible">
                <div class="col-lg-12">
                    <input type="file" class="claimFileInput" multiple="multiple" data-fouc />
                    <span class="help-block">Accepted formats: pdf, doc. Max file size <?TPLVAR_MAX_ALLOWED?></span>
                </div>
            </div>
            <div class="modal-footer">
                <div class="modal-footer-btn">
                    <input type="hidden" id="ecaIDModal" name="ecaIDModal" value="" />
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="button" class="btn bg-primary" id="claimSaveUploaded">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>