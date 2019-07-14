
<script>
    $(document).ready(function( ) {
        var payItemTable = $(".payItemTable").DataTable({
            "processing": true,
            "serverSide": true,
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id', 'payItemTable-row' + aData['piID']);
            },
            ajax: {
                url: Aurora.ROOT_URL + "admin/payroll/getItemResults",
                type: "POST",
                data: function(d) {
                    d.ajaxCall = 1;
                    d.csrfToken = Aurora.CSRF_TOKEN;
                },
            },
            initComplete: function( ) {
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
                width: "200px",
                data: "title"
            },{
                targets: [1],
                orderable: true,
                searchable: false,
                width: "100px",
                data: "ordinary",
                className : "text-center",
                render: function( data ) {
                    if( data === '0' ) {
                        return '<span class="label label-pending">No</span>';
                    }
                    else {
                        return '<span class="label label-success">Yes</span>';
                    }
                }
            },{
                targets: [2],
                orderable: true,
                searchable: false,
                width: "100px",
                data: "deduction",
                className : "text-center",
                render: function( data, type, full ) {
                    if( data === '0' ) {
                        return '<span id="deduction' + full['piID'] + '" class="label label-pending">No</span>';
                    }
                    else {
                        return '<span id="deduction' + full['piID'] + '" class="label label-success">Yes</span>';
                    }
                }
            },{
                targets: [3],
                orderable: true,
                searchable: false,
                width: "100px",
                data: "deductionAW",
                className : "text-center",
                render: function( data, type, full ) {
                    if( data === '0' ) {
                        return '<span id="deductionAW' + full['piID'] + '" class="label label-pending">No</span>';
                    }
                    else {
                        return '<span id="deductionAW' + full['piID'] + '" class="label label-success">Yes</span>';
                    }
                }
            },{
                targets: [4],
                orderable: true,
                searchable: false,
                width: "100px",
                data: "additional",
                className : "text-center",
                render: function( data, type, full ) {
                    if( data === '0' ) {
                        return '<span id="additional' + full['piID'] + '" class="label label-pending">No</span>';
                    }
                    else {
                        return '<span id="additional' + full['piID'] + '" class="label label-success">Yes</span>';
                    }
                }
            }, {
                targets: [5],
                orderable: false,
                searchable: false,
                width:"100px",
                className:"text-center",
                data:"piID",
                render: function( data ) {
                    return '<div class="list-icons">' +
                            '<div class="list-icons-item dropdown">' +
                            '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                            '<i class="icon-menu9"></i></a>' +
                            '<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right" x-placement="bottom-end">' +
                            '<a class="dropdown-item" data-id="' + data + '" data-backdrop="static" data-keyboard="false" ' +
                            'data-toggle="modal" data-target="#modalPayItem">' +
                            '<i class="icon-pencil5"></i> Edit Pay Item</a>' +
                            '<div class="divider"></div>' +
                            '<a class="dropdown-item payItemDelete" data-id="' + data + '">' +
                            '<i class="icon-bin"></i> Delete Pay Item</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                }
            }],
            order: [],
            dom: '<"datatable-header"f><"datatable-scroll"t><"datatable-footer"ilp>',
            language: {
                search: '',
                searchPlaceholder: 'Search Pay Item',
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

        $(".payItems-list-action-btns").insertAfter("#payItems .dataTables_filter");

        var lastIdx = null;

        $('.payItemTable tbody').on('mouseover', 'td', function() {
            var colIdx = payItemTable.cell(this).index().column;

            if (colIdx !== lastIdx) {
                $(payItemTable.cells().nodes()).removeClass('active');
                $(payItemTable.column(colIdx).nodes()).addClass('active');
            }
        }).on('mouseleave', function( ) {
            $(payItemTable.cells( ).nodes( )).removeClass("active");
        });

        // Enable Select2 select for the length option
        $("#payItems .dataTables_length select").select2({
            minimumResultsForSearch: Infinity,
            width: "auto"
        });

        $(".payItemBtn").on("click", function ( ) {
            selectPayItemType( $(this).val( ) );
            return false;
        });

        $(document).on("click", ".payItemDelete", function ( ) {
            var id = $(this).attr("data-id");
            var title = $("#payItemTable-row" + id).find("td").eq(1).text( );
            var piID = [];
            piID.push( id );

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
                if( isConfirm === false ) return;

                var data = {
                    bundle: {
                        data: piID
                    },
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if( obj.bool === 0 ) {
                            swal("Error!", obj.errMsg, "error");
                        }
                        else {
                            $(".payItemTable").DataTable().ajax.reload();
                            swal("Done!", title + " has been successfully deleted!", "success");
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/payroll/deletePayItem", data);
            });
            return false;
        });

        $("#payItemBulkDelete").on("click", function ( ) {
            var piID = [];
            $("input[name='piID[]']:checked").each(function(i) {
                piID.push( $(this).val( ) );
            });

            if( piID.length === 0 ) {
                swal({
                    title: "No Pay Item Selected",
                    type: "info"
                });
            }
            else {
                swal({
                    title: "Are you sure you want to delete the selected pay Items?",
                    text: "This action cannot be undone once deleted.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Confirm Delete",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                }, function (isConfirm) {
                    if (isConfirm === false) return;

                    var data = {
                        bundle: {
                            data: piID
                        },
                        success: function (res) {
                            var obj = $.parseJSON(res);
                            if( obj.bool === 0 ) {
                                swal("Error!", obj.errMsg, "error");
                            }
                            else {
                                $(".payItemTable").DataTable().ajax.reload();
                                swal("Done!", obj.count + " items has been successfully deleted!", "success");
                            }
                        }
                    };
                    Aurora.WebService.AJAX("admin/payroll/deletePayItem", data);
                });
            }
            return false;
        });

        var modalPayItem = $("#modalPayItem");

        modalPayItem.on("show.bs.modal", function(e) {
            var $invoker = $(e.relatedTarget);
            var piID = $invoker.attr("data-id");

            if( piID ) {
                var data = {
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if( obj.bool === 0 ) {
                            swal("error", obj.errMsg);
                            return;
                        }
                        else {
                            $("#piID").val( obj.data.piID );
                            $("#payItemTitle").val( obj.data.title );

                            if( obj.data.ordinary == 1 ) {
                                selectPayItemType("ordinary");
                            }
                            else if( obj.data.deduction == 1 ) {
                                selectPayItemType("deduction");
                            }
                            else if( obj.data.deductionAW == 1 ) {
                                selectPayItemType("deductionAW");
                            }
                            else if( obj.data.additional == 1 ) {
                                selectPayItemType("additional");
                            }
                            else {
                                selectPayItemType("none");
                            }
                        }
                    }
                }
                Aurora.WebService.AJAX( "admin/payroll/getPayItem/" + piID, data );
            }
            else {
                $("#payItemTitle").val("")
            }
        });

        modalPayItem.on("shown.bs.modal", function(e) {
            $("#payItemTitle").focus( );
        });

        function selectPayItemType( type ) {
            $(".payItemBtn").addClass("btn-light").removeClass("btn-dark btn-green");

            if( type === "ordinary" ) {
                $("#payItemOrdinary").addClass("btn-green");
                $("#payItemType").val("ordinary");
            }
            else if( type === "deduction" ) {
                $("#payItemDeduction").addClass("btn-green");
                $("#payItemType").val("deduction");
            }
            else if( type === "deductionAW" ) {
                $("#payItemDeductionAW").addClass("btn-green");
                $("#payItemType").val("deductionAW");
            }
            else if( type === "additional" ) {
                $("#payItemAdditional").addClass("btn-green");
                $("#payItemType").val("additional");
            }
            else {
                $("#payItemNone").addClass("btn-dark");
                $("#payItemType").val("none");
            }
        }

        $("#savePayItem").validate({
            rules: {
                payItemTitle: { required: true }
            },
            messages: {
                payItemTitle: "Please enter a Pay Item Title."
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
                        data: Aurora.WebService.serializePost("#savePayItem")
                    },
                    success: function( res ) {
                        var obj = $.parseJSON( res );
                        if( obj.bool === 0 ) {
                            swal("error", obj.errMsg);
                        }
                        else {
                            $(".payItemTable").DataTable().ajax.reload( );
                            $("#payItemTitle").val("");
                            selectPayItemType( "none" );

                            swal({
                                title: $("#payItemTitle").val( ) + " has been successfully created!",
                                text: "What do you want to do next?",
                                type: 'success',
                                confirmButtonClass: 'btn btn-success',
                                cancelButtonClass: 'btn btn-danger',
                                buttonsStyling: false,
                                showCancelButton: true,
                                confirmButtonText: "Create Another Pay Item",
                                cancelButtonText: "Close Window",
                                reverseButtons: true
                            }, function( isConfirm ) {
                                if( isConfirm === false ) {
                                    $("#modalPayItem").modal("hide");
                                }
                                else {
                                    setTimeout(function() {
                                        $("#payItemTitle").focus( );
                                    }, 500);
                                }
                            });
                        }
                    }
                };
                Aurora.WebService.AJAX( "admin/payroll/savePayItem", data );
            }
        });
    });
</script>

<div class="tab-pane fade" id="payItems">
    <div class="list-action-btns payItems-list-action-btns">
        <ul class="icons-list">
            <li>
                <a type="button" class="btn bg-purple-400 btn-labeled"
                   data-toggle="modal" data-target="#modalPayItem">
                    <b><i class="icon-file-plus2"></i></b> <?LANG_CREATE_NEW_PAY_ITEM?>
                </a>
            </li>
        </ul>
    </div>

    <table class="table table-hover datatable tableLayoutFixed payItemTable">
        <thead>
        <tr>
            <th>Pay Item Title</th>
            <th>Ordinary Wage</th>
            <th>Deduction</th>
            <th>Deduction AW</th>
            <th>Additional Wage</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>
<div id="modalPayItem" class="modal fade">
    <div class="modal-dialog modal-med2">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><?LANG_CREATE_NEW_PAY_ITEM?></h6>
            </div>

            <form id="savePayItem" name="savePayItem" method="post" action="">
            <div class="modal-body overflow-y-visible">
                <input type="hidden" id="piID" name="piID" value="0" />
                <input type="hidden" id="payItemType" name="payItemType" value="" />
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Pay Item Title:</label>
                            <input type="text" name="payItemTitle" id="payItemTitle" class="form-control" value=""
                                   placeholder="Enter a title for this pay item" />
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>This Pay Item Belongs To:</label>
                            <div class="input-group">
                                <span class="input-group-prepend">
                                    <button id="payItemNone" class="btn btn-light payItemBtn" type="button" value="none">None</button>
                                    <button id="payItemOrdinary" class="btn btn-light payItemBtn" type="button" value="ordinary">Ordinary Wage</button>
                                    <button id="payItemDeduction" class="btn btn-light payItemBtn" type="button" value="deduction">Deduction</button>
                                    <button id="payItemDeductionAW" class="btn btn-light payItemBtn" type="button" value="deductionAW">Deduction AW</button>
                                </span>
                                <span class="input-group-append">
                                    <button id="payItemAdditional" class="btn btn-light payItemBtn" type="button" value="additional">Additional Wage</button>
                                </span>
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