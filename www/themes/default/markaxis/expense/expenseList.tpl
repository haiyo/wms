
<script>
    $(document).ready(function( ) {
        var expenseTable = $(".expenseTable").DataTable({
            "processing": true,
            "serverSide": true,
            "fnCreatedRow": function( nRow, aData ) {
                $(nRow).attr('id', 'expenseTable-row' + aData['eiID']);
            },
            ajax: {
                url: Aurora.ROOT_URL + "admin/expense/getResults",
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
                width: "450px",
                data: "title",
            },{
                targets: [1],
                orderable: true,
                searchable: false,
                width: "100px",
                data: "max_amount"
            },{
                targets: [2],
                orderable: false,
                searchable: false,
                width:"100px",
                className:"text-center",
                data:"eiID",
                render: function( data ) {
                    return '<div class="list-icons">' +
                            '<div class="list-icons-item dropdown">' +
                            '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                            '<i class="icon-menu9"></i></a>' +
                            '<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right" x-placement="bottom-end">' +
                            '<a class="dropdown-item" data-id="' + data + '" data-backdrop="static" data-keyboard="false" ' +
                            'data-toggle="modal" data-target="#modalExpense">' +
                            '<i class="icon-pencil5"></i> Edit Expense Item</a>' +
                            '<div class="divider"></div>' +
                            '<a class="dropdown-item expenseDelete" data-id="' + data + '">' +
                            '<i class="icon-bin"></i> Delete Expense Item</a>' +
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
                searchPlaceholder: 'Search Expense Type',
                lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of Rows:</span> _MENU_',
                paginate: { "first" : 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
            },
            drawCallback: function () {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                $(".expenseTable [type=checkbox]").uniform();
            },
            preDrawCallback: function () {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
            }
        });

        $(".expense-list-action-btns").insertAfter("#expenses .dataTables_filter");

        var lastIdx = null;

        $('.expenseTable tbody').on('mouseover', 'td', function() {
            if( typeof expenseTable.cell(this).index() == "undefined" ) return;
            var colIdx = expenseTable.cell(this).index().column;

            if (colIdx !== lastIdx) {
                $(expenseTable.cells().nodes()).removeClass('active');
                $(expenseTable.column(colIdx).nodes()).addClass('active');
            }
        }).on('mouseleave', function( ) {
            $(expenseTable.cells( ).nodes( )).removeClass("active");
        });

        // Enable Select2 select for the length option
        $("#expense .dataTables_length select").select2({
            minimumResultsForSearch: Infinity,
            width: "auto"
        });

        $("#itemTaxGroup").multiselect({includeSelectAllOption: true});

        $("#modalExpense").on("show.bs.modal", function( ) {
            $("#currency").select2( );
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
            $("input[name='piID[]']:checked").each(function( ) {
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

                            if( obj.data.basic === 1 ) {
                                selectPayItemType("basic");
                            }
                            else if( obj.data.deduction === 1 ) {
                                selectPayItemType("deduction");
                            }
                            else if( obj.data.expense === 1 ) {
                                selectPayItemType("expense");
                            }
                            else {
                                selectPayItemType("none");
                            }

                            $("#itemTaxGroup").multiselect("deselectAll", false);

                            if( obj.data.taxGroups.length > 0 ) {
                                for( var i=0; i<obj.data.taxGroups.length; i++ ) {
                                    $("#itemTaxGroup").multiselect("select", obj.data.taxGroups[i].tgID);
                                }
                            }
                            $("#itemTaxGroup").multiselect("refresh");
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

            if( type === "basic" ) {
                $("#payItemBasic").addClass("btn-green");
                $("#payItemType").val("basic");
            }
            else if( type === "deduction" ) {
                $("#payItemDeduction").addClass("btn-green");
                $("#payItemType").val("deduction");
            }
            else if( type === "expense" ) {
                $("#payItemClaim").addClass("btn-green");
                $("#payItemType").val("expense");
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
            highlight: function(element) {
                $(element).addClass("border-danger");
            },
            unhighlight: function(element) {
                $(element).removeClass("border-danger");
                $(".modal-footer .error").remove();
            },
            // Different components require proper error label placement
            errorPlacement: function(error) {
                if( $(".modal-footer .error").length === 0 )
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
                            return;
                        }
                        else {
                            $(".payItemTable").DataTable().ajax.reload( );
                            $("#payItemTitle").val("");
                            selectPayItemType( "none" );
                            $("#itemTaxGroup").multiselect("deselectAll", false);
                            $("#itemTaxGroup").multiselect("refresh");

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

<div class="tab-pane fade" id="expenses">
    <div class="list-action-btns expense-list-action-btns">
        <ul class="icons-list">
            <li>
                <a type="button" class="btn bg-purple-400 btn-labeled"
                   data-toggle="modal" data-target="#modalExpense" data-backdrop="static" data-keyboard="false">
                    <b><i class="icon-file-plus2"></i></b> <?LANG_CREATE_NEW_EXPENSE_TYPE?>
                </a>
            </li>
        </ul>
    </div>

    <table class="table table-hover datatable tableLayoutFixed expenseTable">
        <thead>
        <tr>
            <th>Expense Item Title</th>
            <th>Max Amount</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>
<div id="modalExpense" class="modal fade">
    <div class="modal-dialog modal-med">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><?LANG_CREATE_NEW_EXPENSE_TYPE?></h6>
            </div>

            <form id="savePayItem" name="savePayItem" method="post" action="">
            <div class="modal-body overflow-y-visible">
                <input type="hidden" id="eiID" name="eiID" value="0" />
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Expense Type:</label>
                            <input type="text" name="expenseType" id="expenseType" class="form-control" value=""
                                   placeholder="Enter a title for this expense type" />
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Maximum Amount Allowed For Claim:</label>
                            <div class="form-group">
                                <div class="col-md-4 pl-0 pb-10">
                                    <?TPL_CURRENCY_LIST?>
                                </div>
                                <div class="col-md-8 p-0">
                                    <input type="text" name="expenseAmount" id="expenseAmount" class="form-control" value=""
                                           placeholder="Enter an amount (For eg: 2.50)" />
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