<script>
    $(document).ready(function( ) {
        var departmentTable = $(".departmentTable").DataTable({
            "processing": true,
            "serverSide": true,
            "fnCreatedRow": function(nRow, aData, iDataIndex) {
                $(nRow).attr('id', 'departmentTable-row' + aData['dID']);
            },
            ajax: {
                url: Aurora.ROOT_URL + "admin/company/getDepartmentResults",
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
                    return '<span id="departName' + full['dID'] + '">' + data + '</span>';
                }
            },{
                targets: [1],
                orderable: true,
                width: '320px',
                data: 'managers',
                render: function( data, type, full, meta ) {
                    var groups = '<div class="group-item">';

                    for( var obj in data ) {
                        groups += '<span class="badge badge-primary badge-criteria">' + data[obj].name + '</span> ';
                    }
                    return groups + '</div>';
                }
            },{
                targets: [2],
                orderable: true,
                width: '150px',
                data: 'empCount',
                className : "text-center",
                render: function( data, type, full, meta ) {
                    if( data > 0 ) {
                        return '<a data-role="department" data-id="' + full['dID'] + '" data-toggle="modal" data-target="#modalEmployee">' + data + '</a>';
                    }
                    else {
                        return data;
                    }
                }
            },{
                targets: [3],
                orderable: false,
                searchable : false,
                width: '100px',
                className : "text-center",
                data: 'dID',
                render: function(data, type, full, meta) {
                    return '<div class="list-icons">' +
                            '<div class="list-icons-item dropdown">' +
                            '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                            '<i class="icon-menu9"></i></a>' +
                            '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm dropdown-employee" x-placement="bottom-end">' +
                            '<a class="dropdown-item departmentEdit" data-id="' + data + '" data-toggle="modal" data-target="#modalDepartment" ' +
                            'data-backdrop="static" data-keyboard="false">' +
                            '<i class="icon-pencil5"></i> Edit Department</a>' +
                            '<div class="divider"></div>' +
                            '<a class="dropdown-item departmentDelete" data-id="' + data + '">' +
                            '<i class="icon-bin"></i> Delete Department</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                }
            }],
            order: [],
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                search: '',
                searchPlaceholder: 'Search Department',
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

        $(".department-list-action-btns").insertAfter("#departmentList .dataTables_filter");

        // Alternative pagination
        $('#departmentList .datatable-pagination').DataTable({
            pagingType: "simple",
            language: {
                paginate: {'next': 'Next &rarr;', 'previous': '&larr; Prev'}
            }
        });

        // Datatable with saving state
        $('#departmentList .datatable-save-state').DataTable({
            stateSave: true
        });

        // Scrollable datatable
        $('#departmentList .datatable-scroll-y').DataTable({
            autoWidth: true,
            scrollY: 300
        });

        // Highlighting rows and columns on mouseover
        var lastIdx = null;

        $("#departmentList .datatable tbody").on("mouseover", "td", function() {
            if( typeof departmentTable.cell(this).index() == "undefined" ) return;
            var colIdx = departmentTable.cell(this).index().column;

            if (colIdx !== lastIdx) {
                $(departmentTable.cells().nodes()).removeClass('active');
                $(departmentTable.column(colIdx).nodes()).addClass('active');
            }
        }).on('mouseleave', function() {
            $(departmentTable.cells().nodes()).removeClass("active");
        });

        // Enable Select2 select for the length option
        $("#departmentList .dataTables_length select").select2({
            minimumResultsForSearch: Infinity,
            width: "auto"
        });

        var markaxisUSuggest = new MarkaxisUSuggest( true );

        $("#modalDepartment").on("show.bs.modal", function(e) {
            var $invoker = $(e.relatedTarget);
            var dID = $invoker.attr("data-id");
            markaxisUSuggest.clearToken( );

            if( dID ) {
                var data = {
                    success: function(res) {
                        var obj = $.parseJSON(res);

                        if( obj.bool == 0 ) {
                            swal( "error", obj.errMsg );
                            return;
                        }
                        else {
                            $("#departmentID").val( obj.data.dID );
                            $("#departmentName").val( obj.data.name );
                            markaxisUSuggest.getSuggestToken("admin/company/getSuggestToken/" + obj.data.dID);
                        }
                    }
                }
                Aurora.WebService.AJAX( "admin/company/getDepartment/" + dID, data );
            }
            else {
                $("#departmentID").val(0);
                $("#departmentName").val("");
            }
        });

        $("#modalDepartment").on("shown.bs.modal", function(e) {
            $("#departmentName").focus( );
        });

        $("#modalEmployee").on("show.bs.modal", function(e) {
            var $invoker = $(e.relatedTarget);

            if( $invoker.attr("data-role") == "department" ) {
                var dID = $invoker.attr("data-id");

                $(this).find(".modal-body").load( Aurora.ROOT_URL + 'admin/company/getCountList/department/' + dID, function() {
                    $(".modal-title").text( $("#departName" + dID).text( ) );
                });
            }
        });

        $("#saveDepartment").validate({
            rules: {
                departmentName: { required: true }
            },
            messages: {
                departmentName: "Please enter a Department Name."
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
                        data: Aurora.WebService.serializePost("#saveDepartment")
                    },
                    success: function( res ) {
                        var obj = $.parseJSON( res );
                        if( obj.bool == 0 ) {
                            swal("error", obj.errMsg);
                            return;
                        }
                        else {
                            $(".departmentTable").DataTable().ajax.reload();

                            swal({
                                title: $("#departmentName").val( ) + " has been successfully created!",
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
                                $("#departmentID").val(0);
                                $("#departmentName").val("");
                                markaxisUSuggest.clearToken( );

                                if( isConfirm === false ) {
                                    $("#modalDepartment").modal("hide");
                                }
                                else {
                                    setTimeout(function() {
                                        $("#departmentName").focus( );
                                    }, 500);
                                }
                            });
                        }
                    }
                };
                Aurora.WebService.AJAX( "admin/company/saveDepartment", data );
            }
        });

        $(document).on("click", ".departmentDelete", function ( ) {
            var dID = $(this).attr("data-id");
            var title = $("#departName" + dID).text( );

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
                        data: dID
                    },
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if( obj.bool == 0 ) {
                            swal("Error!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            $(".departmentTable").DataTable( ).ajax.reload( );
                            swal("Done!", title + " has been successfully deleted!", "success");
                            return;
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/company/deleteDepartment", data);
            });
            return false;
        });
    });
</script>

<div class="tab-pane fade" id="departmentList">
    <div class="list-action-btns department-list-action-btns">
        <ul class="icons-list">
            <li>
                <a type="button" class="btn bg-purple-400 btn-labeled"
                   data-toggle="modal" data-target="#modalDepartment">
                    <b><i class="icon-file-plus2"></i></b> <?LANG_CREATE_NEW_DEPARTMENT?>
                </a>
            </li>
        </ul>
    </div>

    <table class="table table-hover datatable departmentTable">
        <thead>
        <tr>
            <th>Department Name</th>
            <th>Manager</th>
            <th>No. of Employee</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>
<div id="modalDepartment" class="modal fade">
    <div class="modal-dialog modal-med2">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title">Create New Department</h6>
            </div>

            <form id="saveDepartment" name="saveDepartment" method="post" action="">
                <input type="hidden" id="departmentID" name="departmentID" value="0" />
                <div class="modal-body overflow-y-visible">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Department Name:</label>
                                <input type="text" name="departmentName" id="departmentName" class="form-control" value=""
                                       placeholder="Enter Department Name" />
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Department Manager(s):</label>
                                <input type="text" name="managers" class="form-control tokenfield-typeahead suggestList"
                                       placeholder="Enter Manager's Name" value=""
                                       autocomplete="off" data-fouc />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="modal-footer-btn">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Discard</button>
                        <button type="submit" class="btn btn-primary" id="saveApplyLeave">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>