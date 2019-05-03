<script>
    $(document).ready(function( ) {
        var groupColumn = 1;
        var designationTable = $(".designationTable").DataTable({
            "processing": true,
            "serverSide": true,
            "fnCreatedRow": function(nRow, aData, iDataIndex) {
                $(nRow).attr("id", 'designationTable-row' + aData['dID']);
                $(nRow).addClass("designationRow-" + aData['parentID']);
            },
            ajax: {
                url: Aurora.ROOT_URL + "admin/employee/getDesignationResults",
                type: "POST",
                data: function ( d ) {
                    d.ajaxCall = 1;
                    d.csrfToken = Aurora.CSRF_TOKEN;
                }
            },
            initComplete: function( settings, json) {
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
                    return '<input type="checkbox" class="dt-checkboxes check-input" name="dID[]" value="' + $('<div/>').text(data).html() + '">';
                }
            },{
                targets:[1],
                visible:false,
                data:'idParentTitle'
            },{
                targets:[2],
                orderable:true,
                width:'160px',
                data:'title',
                render: function( data, type, full, meta ) {
                    return '<span id="designationTitle' + full['dID'] + '">' + data + '</span>';
                }
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
                render: function( data, type, full, meta ) {
                    if( data > 0 ) {
                        return '<a data-role="designation" data-id="' + full['dID'] + '" data-toggle="modal" data-target="#modalEmployee">' + data + '</a>';
                    }
                    else {
                        return data;
                    }
                }
            },{
                targets:[5],
                orderable:false,
                searchable:false,
                width:'100px',
                className:"text-center",
                data:'dID',
                render: function( data, type, full, meta ) {
                    return '<div class="list-icons">' +
                           '<div class="list-icons-item dropdown">' +
                           '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" ' +
                           'aria-expanded="false">' +
                           '<i class="icon-menu9"></i></a>' +
                           '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm dropdown-employee" ' +
                           'x-placement="bottom-end">' +
                           '<a class="dropdown-item designationEdit" data-id="' + data + '" data-toggle="modal" data-target="#modalDesignation" ' +
                           'data-backdrop="static" data-keyboard="false">' +
                           '<i class="icon-pencil5"></i> Edit Designation</a>' +
                           '<div class="divider"></div>' +
                           '<a class="dropdown-item designationDelete" data-id="' + data + '">' +
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
                                   '<a href="#" class="list-icons-item dropdown-toggle caret-0" ' +
                                   'data-toggle="dropdown" aria-expanded="false">' +
                                   '<i class="icon-menu9"></i></a>' +
                                   '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm dropdown-employee" ' +
                                   'x-placement="bottom-end">' +
                                   '<a class="dropdown-item group designationEdit" data-toggle="modal" data-target="#modalGroup" ' +
                                   'data-backdrop="static" data-keyboard="false" data-id="' + idTitle[0] + '">' +
                                   '<i class="icon-pencil5"></i> Edit Group</a>' +
                                   '<div class="divider"></div>' +
                                   '<a class="dropdown-item group designationDelete" data-id="' + idTitle[0] + '">' +
                                   '<i class="icon-bin"></i> Delete Group</a>' +
                                   '</div>' +
                                   '</div>' +
                                   '</div>';

                        $(rows).eq(i).before('<tr id="designationTable-row' + idTitle[0] + '" data-id="' + idTitle[0] + '" ' +
                                                'class="group parentGroupLit groupShow">' +
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
                $(this).find("tbody tr").slice(-3).find(".dropdown, .btn-group").removeClass("dropup");
            }
        });

        $(".designation-list-action-btns").insertAfter("#designationList .dataTables_filter");

        $("#designationList tbody").on("click", "td.details-control", function( ) {
            var id = $(this).parent( ).attr("data-id");

            if( !$(this).parent( ).hasClass("groupShow") ) {
                $(".designationRow-" + id).removeClass("hide");
                $(this).parent( ).addClass("groupShow parentGroupLit");
                $("#groupIco-" + id).removeClass("icon-shrink7").addClass("icon-enlarge7");
            }
            else {
                $(".designationRow-" + id).addClass("hide");
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
            if( typeof designationTable.cell(this).index() == "undefined" ) return;

            var colIdx = designationTable.cell(this).index().column;

            if( colIdx !== lastIdx ) {
                $(designationTable.cells( ).nodes( )).removeClass('active');
                $(designationTable.column(colIdx).nodes( )).addClass('active');
            }
        }).on('mouseleave', function( ) {
            $(designationTable.cells( ).nodes( )).removeClass("active");
        });

        // Enable Select2 select for the length option
        $("#designationList .dataTables_length select").select2({
            minimumResultsForSearch: Infinity,
            width: "auto"
        });

        $("#modalGroup").on("shown.bs.modal", function(e) {
            $("#groupTitle").focus( );
        });

        $("#modalDesignation").on("shown.bs.modal", function(e) {
            $("#designationTitle").focus( );
        });

        $("#modalGroup").on("show.bs.modal", function(e) {
            var $invoker = $(e.relatedTarget);
            var dID = $invoker.attr("data-id");

            if( dID ) {
                var data = {
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if (obj.bool == 0) {
                            swal("error", obj.errMsg);
                            return;
                        }
                        else {
                            $("#groupID").val( obj.data.dID );
                            $("#groupTitle").val( obj.data.title );
                        }
                    }
                }
                Aurora.WebService.AJAX( "admin/employee/getDesignation/" + dID, data );
            }
            else {
                $("#groupID").val(0);
                $("#groupTitle").val("");
            }
        });

        $("#modalDesignation").on("show.bs.modal", function(e) {
            var $invoker = $(e.relatedTarget);
            var dID = $invoker.attr("data-id");

            if( dID ) {
                var data = {
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if (obj.bool == 0) {
                            swal("error", obj.errMsg);
                            return;
                        }
                        else {
                            $("#designationID").val( obj.data.dID );
                            $("#designationTitle").val( obj.data.title );
                            $("#designationDescript").val( obj.data.descript );
                            $("#dID").val( obj.data.parent ).trigger("change");
                        }
                    }
                }
                Aurora.WebService.AJAX( "admin/employee/getDesignation/" + dID, data );
            }
            else {
                $("#designationID").val(0);
                $("#designationTitle").val("");
                $("#designationDescript").val("");
                $("#dID").val("").trigger("change");
            }
        });

        $("#modalEmployee").on("show.bs.modal", function(e) {
            var $invoker = $(e.relatedTarget);

            if( $invoker.attr("data-role") == "designation" ) {
                var dID = $invoker.attr("data-id");

                $(this).find(".modal-body").load( Aurora.ROOT_URL + 'admin/employee/getCountList/designation/' + dID, function() {
                    $(".modal-title").text( $("#designationTitle" + dID).text( ) );
                });
            }
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
                    $(".modal-footer").append(error);
            },
            submitHandler: function( ) {
                var data = {
                    bundle: {
                        data: Aurora.WebService.serializePost("#saveGroup"),
                        group: 1
                    },
                    success: function( res ) {
                        var obj = $.parseJSON( res );
                        if( obj.bool == 0 ) {
                            swal("error", obj.errMsg);
                            return;
                        }
                        else {
                            $(".designationTable").DataTable().ajax.reload();

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
                                $("#groupID").val(0);
                                $("#groupTitle").val("");

                                // Update designation selectlist
                                $("#dID").select2("destroy").remove( );
                                $("#groupUpdate").html( obj.groupListUpdate );
                                $("#dID").select2( );

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
                    $(".modal-footer").append(error);
            },
            submitHandler: function( ) {
                var data = {
                    bundle: {
                        data: Aurora.WebService.serializePost("#saveDesignation"),
                        group: 0
                    },
                    success: function( res ) {
                        var obj = $.parseJSON( res );
                        if( obj.bool == 0 ) {
                            swal("error", obj.errMsg);
                            return;
                        }
                        else {
                            $(".designationTable").DataTable().ajax.reload();

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
                                $("#designationID").val(0);
                                $("#designationTitle").val("");
                                $("#designationDescript").val("");
                                $("#dID").val("").trigger("change");

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

        $(document).on("click", ".designationDelete", function ( ) {
            var id = $(this).attr("data-id");
            var title = $("#designationTable-row" + id).find("td").eq(1).text( );
            var dID = new Array( );
            dID.push( id );

            var text = "This action cannot be undone once deleted.";
            var group = 0;

            if( $(this).hasClass("group") ) {
                text = "All designations under this group will be deleted!";
                group = 1;
            }

            swal({
                title: "Are you sure you want to delete " + title + "?",
                text: text,
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
                        data: dID,
                        group: group
                    },
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if (obj.bool == 0) {
                            swal("Error!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            $(".designationTable").DataTable().ajax.reload();
                            $("#dID").select2("destroy").remove( );
                            $("#groupUpdate").html( obj.groupListUpdate );
                            $("#dID").select2( );
                            swal("Done!", title + " has been successfully deleted!", "success");
                            return;
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/employee/deleteDesignation", data);
            });
            return false;
        });

        $("#designationBulkDelete").on("click", function ( ) {
            var dID = new Array( );
            $("input[name='dID[]']:checked").each(function(i) {
                dID.push( $(this).val( ) );
            });

            if( dID.length == 0 ) {
                swal({
                    title: "No Designation Selected",
                    type: "info"
                });
            }
            else {
                swal({
                    title: "Are you sure you want to delete the selected designations?",
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
                            data: dID
                        },
                        success: function(res) {
                            var obj = $.parseJSON(res);
                            if (obj.bool == 0) {
                                swal("Error!", obj.errMsg, "error");
                                return;
                            }
                            else {
                                $(".designationTable").DataTable( ).ajax.reload( );
                                swal("Done!", obj.count + " items has been successfully deleted!", "success");
                                return;
                            }
                        }
                    };
                    Aurora.WebService.AJAX("admin/employee/deleteDesignation", data);
                });
            }
            return false;
        });

        $("#orphanGroupDelete").on("click", function ( ) {
            swal({
                title: "Are you sure you want to delete all orphan groups?",
                text: "All groups with empty designation will be deleted.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Confirm Delete",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function( isConfirm ) {
                if( isConfirm === false ) return;

                var data = {
                    success: function(res) {
                        var obj = $.parseJSON(res);
                        if (obj.bool == 0) {
                            swal("Error!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            if( obj.count > 0 ) {
                                $("#dID").select2("destroy").remove( );
                                $("#groupUpdate").html( obj.groupListUpdate );
                                $("#dID").select2( );
                                swal("Done!", obj.count + " orphan groups has been successfully deleted!", "success");
                            }
                            else {
                                swal("Done!", "There are currently no orphan group.", "success");
                            }
                            return;
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/employee/deleteOrphanGroups", data);
            });
            return false;
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
                    <li><a id="orphanGroupDelete"><i class="icon-bin"></i> Delete Orphan Groups</a></li>
                    <li><a id="designationBulkDelete"><i class="icon-bin"></i> Delete Selected Designations</a></li>
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

            <form id="saveGroup" name="saveGroup" method="post" action="">
                <div class="modal-body overflow-y-visible">
                    <input type="hidden" id="groupID" name="groupID" value="0" />
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Designation Group Title:</label>
                            <input type="text" name="groupTitle" id="groupTitle" class="form-control" value=""
                                   placeholder="Enter Group Title" />
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                        <label><strong>Note:</strong> Newly created group will not appear in the table list until
                            a designation has been assigned to it.</label>
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
<div id="modalDesignation" class="modal fade">
    <div class="modal-dialog modal-med">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title">Create New Designation</h6>
            </div>

            <form id="saveDesignation" name="saveDesignation" method="post" action="">
                <div class="modal-body overflow-y-visible">
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
                                <div id="groupUpdate"><?TPL_DESIGNATION_GROUP_LIST?></div>
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