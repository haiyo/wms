<script>
    $(document).ready(function( ) {
        var contractTable = $(".contractTable").DataTable({
            "processing": true,
            "serverSide": true,
            "fnCreatedRow": function (nRow, aData, iDataIndex) {
                $(nRow).attr('id', 'contractTable-row' + aData['cID']);
            },
            ajax: {
                url: Aurora.ROOT_URL + "admin/employee/getContractResults",
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
                targets:[0],
                checkboxes: {
                    selectRow: true
                },
                width: '10px',
                orderable: false,
                searchable : false,
                data: 'cID',
                render: function( data, type, full, meta ) {
                    return '<input type="checkbox" class="dt-checkboxes check-input" name="cID[]" value="' + $('<div/>').text(data).html() + '">';
                }
            },{
                targets: [1],
                orderable: true,
                width: '160px',
                data: 'type',
                render: function( data, type, full, meta ) {
                    return '<span id="contractType' + full['cID'] + '">' + data + '</span>';
                }
            },{
                targets: [2],
                orderable: true,
                width: '400px',
                data: 'descript'
            },{
                targets: [3],
                orderable: true,
                width: '100px',
                data: 'empCount',
                className : "text-center",
                render: function( data, type, full, meta ) {
                    if( data > 0 ) {
                        return '<a data-role="contract" data-id="' + full['cID'] + '" data-toggle="modal" data-target="#modalEmployee">' + data + '</a>';
                    }
                    else {
                        return data;
                    }
                }
            },{
                targets: [4],
                orderable: false,
                searchable : false,
                width: '100px',
                className : "text-center",
                data: 'cID',
                render: function(data, type, full, meta) {
                    return '<div class="list-icons">' +
                           '<div class="list-icons-item dropdown">' +
                           '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                           '<i class="icon-menu9"></i></a>' +
                           '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm dropdown-employee" x-placement="bottom-end">' +
                           '<a class="dropdown-item contractEdit" data-id="' + data + '" data-toggle="modal" data-target="#modalContract" ' +
                           'data-backdrop="static" data-keyboard="false">' +
                           '<i class="icon-pencil5"></i> Edit Contract Type</a>' +
                           '<div class="divider"></div>' +
                           '<a class="dropdown-item contractDelete" data-id="' + data + '">' +
                           '<i class="icon-bin"></i> Delete Contract Type</a>' +
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
                searchPlaceholder: 'Search Contract Type',
                lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of Rows:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
            },
            drawCallback: function () {
                $(".contractTable [type=checkbox]").uniform();

                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                Popups.init();
            },
            preDrawCallback: function() {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
            }
        });

        $(".contract-list-action-btns").insertAfter("#contractList .dataTables_filter");

        // Alternative pagination
        $('#contractList .datatable-pagination').DataTable({
            pagingType: "simple",
            language: {
                paginate: {'next': 'Next &rarr;', 'previous': '&larr; Prev'}
            }
        });

        // Datatable with saving state
        $('#contractList .datatable-save-state').DataTable({
            stateSave: true
        });

        // Scrollable datatable
        $('#contractList .datatable-scroll-y').DataTable({
            autoWidth: true,
            scrollY: 300
        });

        // Highlighting rows and columns on mouseover
        var lastIdx = null;

        $("#contractList .datatable tbody").on("mouseover", "td", function() {
            if( typeof contractTable.cell(this).index() == "undefined" ) return;
            var colIdx = contractTable.cell(this).index().column;

            if (colIdx !== lastIdx) {
                $(contractTable.cells().nodes()).removeClass('active');
                $(contractTable.column(colIdx).nodes()).addClass('active');
            }
        }).on('mouseleave', function() {
            $(contractTable.cells().nodes()).removeClass("active");
        });

        // Enable Select2 select for the length option
        $("#contractList .dataTables_length select").select2({
            minimumResultsForSearch: Infinity,
            width: "auto"
        });

        $("#modalContract").on("show.bs.modal", function(e) {
            var $invoker = $(e.relatedTarget);
            var cID = $invoker.attr("data-id");

            if( cID ) {
                var data = {
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if (obj.bool == 0) {
                            swal("error", obj.errMsg);
                            return;
                        }
                        else {
                            $("#contractID").val( obj.data.cID );
                            $("#contractTitle").val( obj.data.type );
                            $("#contractDescript").val( obj.data.descript );
                        }
                    }
                }
                Aurora.WebService.AJAX( "admin/employee/getContract/" + cID, data );
            }
            else {
                $("#contractID").val(0);
                $("#contractTitle").val("");
                $("#contractDescript").val("");
            }
        });

        $("#modalContract").on("shown.bs.modal", function(e) {
            $("#contractTitle").focus( );
        });

        $("#modalEmployee").on("show.bs.modal", function(e) {
            var $invoker = $(e.relatedTarget);

            if( $invoker.attr("data-role") == "contract" ) {
                var cID = $invoker.attr("data-id");

                $(this).find(".modal-body").load( Aurora.ROOT_URL + 'admin/employee/getCountList/contract/' + cID, function() {
                    $(".modal-title").text( $("#contractType" + cID).text( ) );
                });
            }
        });

        $("#saveContract").validate({
            rules: {
                contractTitle: { required: true }
            },
            messages: {
                contractTitle: "Please enter a Contract Title."
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
                        data: Aurora.WebService.serializePost("#saveContract")
                    },
                    success: function( res ) {
                        var obj = $.parseJSON( res );
                        if( obj.bool == 0 ) {
                            swal("error", obj.errMsg);
                            return;
                        }
                        else {
                            $(".contractTable").DataTable().ajax.reload();

                            swal({
                                title: $("#contractTitle").val( ) + " has been successfully created!",
                                text: "What do you want to do next?",
                                type: 'success',
                                confirmButtonClass: 'btn btn-success',
                                cancelButtonClass: 'btn btn-danger',
                                buttonsStyling: false,
                                showCancelButton: true,
                                confirmButtonText: "Create Another Contract",
                                cancelButtonText: "Close Window",
                                reverseButtons: true
                            }, function( isConfirm ) {
                                $("#contractID").val(0);
                                $("#contractTitle").val("");
                                $("#contractDescript").val("");

                                if( isConfirm === false ) {
                                    $("#modalContract").modal("hide");
                                }
                                else {
                                    setTimeout(function() {
                                        $("#contractTitle").focus( );
                                    }, 500);
                                }
                            });
                        }
                    }
                };
                Aurora.WebService.AJAX( "admin/employee/saveContract", data );
            }
        });

        $(document).on("click", ".contractDelete", function ( ) {
            var id = $(this).attr("data-id");
            var title = $("#contractTable-row" + id).find("td").eq(1).text( );
            var cID = new Array( );
            cID.push( id );

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
                        data: cID
                    },
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if (obj.bool == 0) {
                            swal("Error!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            $(".contractTable").DataTable().ajax.reload();
                            swal("Done!", title + " has been successfully deleted!", "success");
                            return;
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/employee/deleteContract", data);
            });
            return false;
        });

        $("#contractBulkDelete").on("click", function ( ) {
            var cID = new Array( );
            $("input[name='cID[]']:checked").each(function(i) {
                cID.push( $(this).val( ) );
            });

            if( cID.length == 0 ) {
                swal({
                    title: "No Contract Selected",
                    type: "info"
                });
            }
            else {
                swal({
                    title: "Are you sure you want to delete the selected contracts?",
                    text: "This action cannot be undone once deleted.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Confirm Delete",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                }, function( isConfirm ) {
                    if( isConfirm === false ) return;

                    var data = {
                        bundle: {
                            data: cID
                        },
                        success: function(res) {
                            var obj = $.parseJSON(res);
                            if (obj.bool == 0) {
                                swal("Error!", obj.errMsg, "error");
                                return;
                            }
                            else {
                                $(".contractTable").DataTable( ).ajax.reload( );
                                swal("Done!", obj.count + " items has been successfully deleted!", "success");
                                return;
                            }
                        }
                    };
                    Aurora.WebService.AJAX("admin/employee/deleteContract", data);
                });
            }
            return false;
        });
    });
</script>

<div class="tab-pane fade" id="contractList">
    <div class="list-action-btns contract-list-action-btns">
        <ul class="icons-list">
            <li>
                <a type="button" class="btn bg-purple-400 btn-labeled" data-backdrop="static" data-keyboard="false"
                   data-toggle="modal" data-target="#modalContract">
                    <b><i class="icon-file-plus2"></i></b> <?LANG_CREATE_NEW_CONTRACT_TYPE?>
                </a>&nbsp;&nbsp;&nbsp;
                <button type="button" class="btn bg-purple-400 btn-labeled dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <b><i class="icon-stack3"></i></b> Bulk Action <span class="caret"></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right dropdown-employee">
                    <li><a href="#" id="contractBulkDelete"><i class="icon-bin"></i> Delete Selected Contracts</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <table class="table table-hover datatable tableLayoutFixed contractTable">
        <thead>
        <tr>
            <th></th>
            <th>Contract Type</th>
            <th>Description</th>
            <th>No. of Employee</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>
<div id="modalContract" class="modal fade">
    <div class="modal-dialog modal-med">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title">Create New Contract Type</h6>
            </div>

            <form id="saveContract" name="saveContract" method="post" action="">
                <div class="modal-body overflow-y-visible">
                    <input type="hidden" id="contractID" name="contractID" value="0" />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Contract Title:</label>
                                <input type="text" name="contractTitle" id="contractTitle" class="form-control" value=""
                                       placeholder="Enter Contract Title" />
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Contract Description:</label>
                                <textarea id="contractDescript" name="contractDescript" rows="5" cols="4"
                                          placeholder="Enter Contract Description" class="form-control"></textarea>
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