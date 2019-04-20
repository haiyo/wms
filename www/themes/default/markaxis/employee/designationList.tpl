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
                data:'parentTitle'
            },{
                targets:[2],
                orderable:true,
                width:'250px',
                data:'title'
            },{
                targets:[3],
                orderable:true,
                width:'350px',
                data:'descript'
            },{
                targets:[4],
                orderable:true,
                width:'150px',
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
                           '<a class="dropdown-item" data-href="<?TPLVAR_ROOT_URL?>admin/employee/view">' +
                           '<i class="icon-pencil5"></i> Edit Designation</a>' +
                           '<div class="divider"></div>' +
                           '<a class="dropdown-item" id="menuSetStatus' + full['userID'] + '" href="#" onclick="return setResign(' + data + ', \'' + name + '\')">' +
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
                    if( group !== null && last !== group ) {
                        var idTitle = group.split("-");

                        $(rows).eq(i).before('<tr  data-id="' + idTitle[0] + '" class="group parentGroupLit details-control groupShow">' +
                                                '<td class="text-center">' +
                                                '<i class="icon-enlarge7" id="groupIco-' + idTitle[0] + '"></i></td>' +
                                                '<td colspan="4">' + idTitle[1] + '</td></tr>');
                        last = group;
                    }
                });
            },
            preDrawCallback: function() {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
            }
        });

        $(".designation-list-action-btns").insertAfter("#designationList .dataTables_filter");

        $("#designationList tbody").on("click", "tr.details-control", function( ) {
            var id = $(this).attr("data-id");

            if( !$(this).hasClass("groupShow") ) {
                $(".group-" + id).removeClass("hide");
                $(this).addClass("groupShow parentGroupLit");
                $("#groupIco-" + id).removeClass("icon-shrink7").addClass("icon-enlarge7");
            }
            else {
                $(".group-" + id).addClass("hide");
                $(this).removeClass("groupShow parentGroupLit");
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
    });
</script>

<div class="tab-pane fade" id="designationList">
    <div class="list-action-btns designation-list-action-btns">
        <ul class="icons-list">
            <li>
                <a type="button" class="btn bg-purple-400 btn-labeled"
                   data-toggle="modal" data-target="#modalAddPayrun">
                    <b><i class="icon-file-plus2"></i></b> <?LANG_ADD_NEW_DESIGNATION?>
                </a>
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
<div id="modalAddPayrun" class="modal fade">
    <div class="modal-dialog modal-med">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title">Create New Pay Run</h6>
            </div>

            <div class="modal-body overflow-y-visible">
                <form id="savePayrun" name="savePayrun" method="post" action="">
                    <input type="hidden" id="prID" name="prID" value="0" />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>How often will you pay your employees?</label>
                                <?TPL_PAY_PERIOD_LIST?>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Pay Run Name:</label>
                                <input type="text" name="payrunName" id="payrunName" class="form-control" value=""
                                       placeholder="For e.g: Monthly Full-time Employee, Weekly Part-time Employee" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Start Date:</label>
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                    </span>
                                    <input type="text" class="form-control pickadate-start" id="startDate" name="startDate" placeholder="" />
                                </div>
                                <span class="help-block startDateHelp"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label>First Payment Date:</label>
                            <div class="input-group">
                                <span class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                </span>
                                <input type="text" class="form-control pickadate-firstPayment" id="firstPayment" name="firstPayment" placeholder="" />
                            </div>
                            <span class="help-block firstPaymentHelp"></span>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>