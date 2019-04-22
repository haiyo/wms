<script>
    $(document).ready(function( ) {
        var groupColumn = 1;
        var designationTable = $(".designationTable").DataTable({
            "processing": true,
            "serverSide": true,
            "fnCreatedRow": function(nRow, aData, iDataIndex) {
                $(nRow).attr("id", 'row' + aData['dID']);
                $(nRow).addClass("group-" + aData['parentID']);
            },
            ajax: {
                url: Aurora.ROOT_URL + "admin/employee/getDesignationResults",
                type: "POST",
                data: function ( d ) {
                    d.ajaxCall = 1;
                    d.csrfToken = Aurora.CSRF_TOKEN;
                }
            },
            initComplete: function( settings, json){
                console.log(json);
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
                data: 'dID',
                render: function (data, type, full, meta) {
                    return '<input type="checkbox" class="dt-checkboxes check-input" name="id[]" value="' + $('<div/>').text(data).html() + '">';
                }
            },{
                targets:[1],
                visible:false,
                data:'idParentTitle'
            },{
                targets:[2],
                orderable:true,
                width:'160px',
                data:'title'
            },{
                targets:[3],
                orderable:true,
                width:'400px',
                data:'descript'
            },{
                targets:[4],
                orderable:true,
                width:'100px',
                data:'empCount',
                className:"text-center",
            },{
                targets:[5],
                orderable:false,
                searchable:false,
                width:'100px',
                className:"text-center",
                data:'pcID',
                render: function(data, type, full, meta) {
                    var name = full["name"];
                    var statusText = full['suspended'] == 1 ? "Unsuspend Employee" : "Suspend Employee"

                    return '<div class="list-icons">' +
                           '<div class="list-icons-item dropdown">' +
                           '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                           '<i class="icon-menu9"></i></a>' +
                           '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm dropdown-employee" x-placement="bottom-end">' +
                           '<a class="dropdown-item" data-backdrop="static" data-keyboard="false">' +
                           '<i class="icon-pencil5"></i> Edit Designation</a>' +
                           '<div class="divider"></div>' +
                           '<a class="dropdown-item" id="menuSetStatus' + full['userID'] + '">' +
                           '<i class="icon-bin"></i> Delete Designation</a>' +
                           '</div>' +
                           '</div>' +
                           '</div>';
                }
            }],
            select: {
                "style": "multi"
            },
            order:[[groupColumn,"asc"]],
            dom:'<"datatable-header"f><"datatable-scroll"t><"datatable-footer"ilp>',
            language: {
                search:'',
                searchPlaceholder: 'Search Designation',
                lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of Rows:</span> _MENU_',
                paginate:{'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;'}
            },
            drawCallback: function ( settings ) {
                $(".designationTable [type=checkbox]").uniform();

                var api = this.api();
                var rows = api.rows({page:'current'}).nodes();
                var last = null;

                api.column(groupColumn, {page:'current'}).data().each( function ( group, i ) {
                    if( last !== group ) {
                        var idTitle = group.split("-");

                        var menu = '<div class="list-icons">' +
                                   '<div class="list-icons-item dropdown">' +
                                   '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                                   '<i class="icon-menu9"></i></a>' +
                                   '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm dropdown-employee" x-placement="bottom-end">' +
                                   '<a class="dropdown-item" data-toggle="modal" data-target="#modalPermission" data-backdrop="static" ' +
                                   'data-keyboard="false">' +
                                   '<i class="icon-pencil5"></i> Edit Group</a>' +
                                   '<div class="divider"></div>' +
                                   '<a class="dropdown-item" href="#">' +
                                   '<i class="icon-bin"></i> Delete Group</a>' +
                                   '</div>' +
                                   '</div>' +
                                   '</div>';

                        $(rows).eq(i).before('<tr  data-id="' + idTitle[0] + '" class="group parentGroupLit groupShow">' +
                                                '<td class="text-center details-control">' +
                                                '<i class="icon-enlarge7" id="groupIco-' + idTitle[0] + '"></i></td>' +
                                                '<td colspan="3" class="details-control">' + idTitle[1] + '</td>' +
                                                '<td class="text-center">' + menu + '</td>' +
                                              '</tr>');
                        last = group;
                    }
                });
            },
            preDrawCallback: function() {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
            }
        });

        $(".designation-list-action-btns").insertAfter("#designationList .dataTables_filter");

        $("#designationList tbody").on("click", "td.details-control", function( ) {
            var id = $(this).parent( ).attr("data-id");

            if( !$(this).parent( ).hasClass("groupShow") ) {
                $(".group-" + id).removeClass("hide");
                $(this).parent( ).addClass("groupShow parentGroupLit");
                $("#groupIco-" + id).removeClass("icon-shrink7").addClass("icon-enlarge7");
            }
            else {
                $(".group-" + id).addClass("hide");
                $(this).parent( ).removeClass("groupShow parentGroupLit");
                $("#groupIco-" + id).removeClass("").addClass("icon-shrink7");
            }
        });

        // Alternative pagination
        $('#designationList .datatable-pagination').DataTable({
            pagingType: "simple",
            language: {
                paginate: {'next': 'Next &rarr;', 'previous': '&larr; Prev'}
            }
        });

        // Datatable with saving state
        $('#designationList .datatable-save-state').DataTable({
            stateSave: true
        });

        // Scrollable datatable
        $('#designationList .datatable-scroll-y').DataTable({
            autoWidth: true,
            scrollY: 300
        });

        // Highlighting rows and columns on mouseover
        var lastIdx = null;

        $("#designationList .datatable tbody").on("mouseover", "td", function() {
            var colIdx = designationTable.cell(this).index().column;

            if (colIdx !== lastIdx) {
                $(designationTable.cells().nodes()).removeClass('active');
                $(designationTable.column(colIdx).nodes()).addClass('active');
            }
        }).on('mouseleave', function() {
            $(designationTable.cells().nodes()).removeClass("active");
        });

        // Enable Select2 select for the length option
        $("#designationList .dataTables_length select").select2({
            minimumResultsForSearch: Infinity,
            width: "auto"
        });

        $("#modalGroup").on("shown.bs.modal", function(e) {
            $("#groupTitle").focus( );
        });

        $("#saveGroup").validate({
            rules: {
                groupTitle: { required: true }
            },
            messages: {
                groupTitle: "Please enter a Group Title."
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
                    $(".modal-footer").prepend(error);
            },
            submitHandler: function( ) {
                var data = {
                    bundle: {
                        data: Aurora.WebService.serializePost("#saveGroup"),
                        group: true
                    },
                    success: function( res ) {
                        var obj = $.parseJSON( res );
                        if( obj.bool == 0 ) {
                            swal("error", obj.errMsg);
                            return;
                        }
                        else {
                            $(".designationTable").DataTable().ajax.reload();
                            $("#groupTitle").val("");

                            swal({
                                title: $("#groupTitle").val( ) + " has been successfully created!",
                                text: "What do you want to do next?",
                                type: 'success',
                                confirmButtonClass: 'btn btn-success',
                                cancelButtonClass: 'btn btn-danger',
                                buttonsStyling: false,
                                showCancelButton: true,
                                confirmButtonText: "Create Another Group",
                                cancelButtonText: "Close Window",
                                reverseButtons: true
                            }, function( isConfirm ) {
                                if( isConfirm === false ) {
                                    $("#modalGroup").modal("hide");
                                }
                                else {
                                    setTimeout(function() {
                                        $("#groupTitle").focus( );
                                    }, 500);
                                }
                            });
                        }
                    }
                };
                Aurora.WebService.AJAX( "admin/employee/saveDesignation", data );
            }
        });

        $("#saveDesignation").validate({
            rules: {
                designationTitle: { required: true }
            },
            messages: {
                designationTitle: "Please enter a Designation Title."
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
                    $(".modal-footer").prepend(error);
            },
            submitHandler: function( ) {
                var data = {
                    bundle: {
                        data: Aurora.WebService.serializePost("#saveDesignation"),
                        group: false
                    },
                    success: function( res ) {
                        var obj = $.parseJSON( res );
                        if( obj.bool == 0 ) {
                            swal("error", obj.errMsg);
                            return;
                        }
                        else {
                            $(".designationTable").DataTable().ajax.reload();
                            $("#groupTitle").val("");

                            swal({
                                title: $("#designationTitle").val( ) + " has been successfully created!",
                                text: "What do you want to do next?",
                                type: 'success',
                                confirmButtonClass: 'btn btn-success',
                                cancelButtonClass: 'btn btn-danger',
                                buttonsStyling: false,
                                showCancelButton: true,
                                confirmButtonText: "Create Another Designation",
                                cancelButtonText: "Close Window",
                                reverseButtons: true
                            }, function( isConfirm ) {
                                if( isConfirm === false ) {
                                    $("#modalDesignation").modal("hide");
                                }
                                else {
                                    setTimeout(function() {
                                        $("#designationTitle").focus( );
                                    }, 500);
                                }
                            });
                        }
                    }
                };
                Aurora.WebService.AJAX( "admin/employee/saveDesignation", data );
            }
        });
    });
</script>

<div class="tab-pane fade" id="designationList">
    <div class="list-action-btns designation-list-action-btns">
        <ul class="icons-list">
            <li>
                <a type="button" class="btn bg-purple-400 btn-labeled"
                   data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#modalGroup">
                    <b><i class="icon-file-plus2"></i></b> <?LANG_CREATE_NEW_DESIGNATION_GROUP?>
                </a>&nbsp;&nbsp;&nbsp;
                <a type="button" class="btn bg-purple-400 btn-labeled"
                   data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#modalDesignation">
                    <b><i class="icon-file-plus2"></i></b> <?LANG_CREATE_NEW_DESIGNATION?>
                </a>&nbsp;&nbsp;&nbsp;
                <button type="button" class="btn bg-purple-400 btn-labeled dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <b><i class="icon-stack3"></i></b> Bulk Action <span class="caret"></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right dropdown-employee">
                    <li><a href="#" id="payItemBulkDelete"><i class="icon-bin"></i> Delete Selected Designations</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <table class="table table-hover datatable datatableGroup tableLayoutFixed designationTable">
        <thead>
        <tr>
            <th></th>
            <th></th>
            <th>Designation Group / Title</th>
            <th>Description</th>
            <th>No. of Employee</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>
<div id="modalGroup" class="modal fade">
    <div class="modal-dialog modal-med">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title">Create New Designation Group</h6>
            </div>

            <div class="modal-body overflow-y-visible">
                <form id="saveGroup" name="saveGroup" method="post" action="">
                    <input type="hidden" id="groupID" name="groupID" value="0" />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Designation Group Title:</label>
                                <input type="text" name="groupTitle" id="groupTitle" class="form-control" value=""
                                       placeholder="Enter Group Title" />
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Discard</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="modalDesignation" class="modal fade">
    <div class="modal-dialog modal-med">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title">Create New Designation</h6>
            </div>

            <div class="modal-body overflow-y-visible">
                <form id="saveDesignation" name="saveDesignation" method="post" action="">
                    <input type="hidden" id="designationID" name="designationID" value="0" />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Designation Title:</label>
                                <input type="text" name="designationTitle" id="designationTitle" class="form-control" value=""
                                       placeholder="Enter Designation Title" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Designation Description:</label>
                                <textarea id="designationDescript" name="designationDescript" rows="5" cols="4"
                                          placeholder="Enter Designation Description" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Designation Group:</label>
                                <?TPL_DESIGNATION_GROUP_LIST?>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Discard</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>