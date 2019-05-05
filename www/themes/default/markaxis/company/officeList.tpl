<script>
    $(document).ready(function( ) {
        var officeTable = $(".officeTable").DataTable({
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
                data: 'name'
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
                data: 'openTime',
                className : "text-center",
            },{
                targets: [4],
                orderable: true,
                width: '150px',
                data: 'closeTime',
                className : "text-center",
            },{
                targets: [5],
                orderable: true,
                width: '150px',
                data: 'empCount',
                className : "text-center",
            },{
                targets: [6],
                orderable: false,
                searchable : false,
                width: '100px',
                className : "text-center",
                data: 'oID',
                render: function(data, type, full, meta) {
                    return '<div class="list-icons">' +
                            '<div class="list-icons-item dropdown">' +
                            '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                            '<i class="icon-menu9"></i></a>' +
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
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                search: '',
                searchPlaceholder: 'Search Office',
                lengthMenu: '<span>Show:</span> _MENU_',
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

        // Highlighting rows and columns on mouseover
        var lastIdx = null;

        $("#officeList .datatable tbody").on("mouseover", "td", function() {
            if( typeof officeTable.cell(this).index() == "undefined" ) return;
            var colIdx = officeTable.cell(this).index().column;

            if (colIdx !== lastIdx) {
                $(officeTable.cells().nodes()).removeClass("active");
                $(officeTable.column(colIdx).nodes()).addClass("active");
            }
        }).on("mouseleave", function() {
            $(officeTable.cells().nodes()).removeClass("active");
        });

        // Enable Select2 select for the length option
        $("#officeList .dataTables_length select").select2({
            minimumResultsForSearch: Infinity,
            width: "auto"
        });

        $("#modalOffice").on("shown.bs.modal", function(e) {
            $("#officeName").focus( );
        });

        $("#modalOffice").on("show.bs.modal", function(e) {
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
                            $("#officeID").val( obj.data.oID );
                            $("#officeName").val( obj.data.name );
                            $("#officeAddress").val( obj.data.address );
                            $("#officeCountry").val( obj.data.countryID ).trigger("change");
                            $("#officeType").val( obj.data.officeTypeID ).trigger("change");
                            $("#openTime").val( obj.data.openTime ).trigger("change");
                            $("#closeTime").val( obj.data.closeTime ).trigger("change");
                        }
                    }
                }
                Aurora.WebService.AJAX( "admin/company/getOffice/" + oID, data );
            }
            else {
                $("#officeID").val(0);
                $("#officeName").val("");
                $("#officeAddress").val("");
                $("#officeCountry").val("").trigger("change");
                $("#officeType").val("").trigger("change");
                $("#openTime").val("").trigger("change");
                $("#closeTime").val("").trigger("change");
            }
        });

        $("#officeType").select2({minimumResultsForSearch: -1});
        $("#openTime").pickatime({interval:60, min: [9,0], max: [18,0]});
        $("#closeTime").pickatime({interval:60, min: [9,0], max: [18,0]});

        $("#saveOffice").validate({
            rules: {
                officeName: { required: true }
            },
            messages: {
                officeName: "Please enter a Office Name."
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
                            $(".officeTable").DataTable().ajax.reload();

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
                                $("#openTime").val("").trigger("change");
                                $("#closeTime").val("").trigger("change");

                                if( isConfirm === false ) {
                                    $("#modalOffice").modal("hide");
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

        $(document).on("click", ".officeDelete", function ( ) {
            var oID = $(this).attr("data-id");
            var title = $("#officeTable-row" + oID).find("td").eq(1).text( );

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
                            $(".officeTable").DataTable().ajax.reload();
                            swal("Done!", title + " has been successfully deleted!", "success");
                            return;
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/company/deleteOffice", data);
            });
            return false;
        });
    });
</script>

<div class="tab-pane fade show active" id="officeList">
    <div class="list-action-btns office-list-action-btns">
        <ul class="icons-list">
            <li>
                <a type="button" class="btn bg-purple-400 btn-labeled"
                   data-backdrop="static" data-keyboard="false"
                   data-toggle="modal" data-target="#modalOffice">
                    <b><i class="icon-file-plus2"></i></b> <?LANG_CREATE_NEW_OFFICE?>
                </a>
            </li>
        </ul>
    </div>

    <table class="table table-hover datatable officeTable">
        <thead>
        <tr>
            <th>Office Name</th>
            <th>Address</th>
            <th>Country</th>
            <th>Opening Hour</th>
            <th>Closing Hour</th>
            <th>Total Employee</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>

<div id="modalOffice" class="modal fade">
    <div class="modal-dialog modal-med2">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title">Create New Office</h6>
            </div>

            <form id="saveOffice" name="saveOffice" method="post" action="">
                <input type="hidden" id="officeID" name="officeID" value="0" />
                <div class="modal-body overflow-y-visible">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Office Name:</label>
                                <input type="text" name="officeName" id="officeName" class="form-control" value=""
                                       placeholder="Enter Office Name" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Office Address:</label>
                                <input type="text" name="officeAddress" id="officeAddress" class="form-control" value=""
                                       placeholder="Enter Office Address" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Office Country:</label>
                                <?TPL_COUNTRY_LIST?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Office Type:</label>
                                <?TPL_OFFICE_TYPE_LIST?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Opening Hour:</label>
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                    </span>
                                    <input type="text" class="form-control" id="openTime" name="openTime" placeholder="" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label>Closing Hour:</label>
                            <div class="input-group">
                                <span class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                    </span>
                                <input type="text" class="form-control" id="closeTime" name="closeTime" placeholder="" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="modal-footer-btn">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="saveApplyLeave">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>