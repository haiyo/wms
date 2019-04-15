
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
                targets: 0,
                checkboxes: {
                    selectRow: true
                },
                width: '10px',
                orderable: false,
                searchable : false,
                data: 'piID',
                render: function (data, type, full, meta) {
                    return '<input type="checkbox" class="dt-checkboxes check-input" name="id[]" value="' + $('<div/>').text(data).html() + '">';
                }
            },{
                targets: [1],
                orderable: true,
                width: '300px',
                data: 'title'
            }, {
                targets: [2],
                orderable: true,
                width: '100px',
                data: 'basic',
                className : "text-center",
                render: function(data, type, full, meta) {
                    if( data == 0 ) {
                        return '<span id="basic' + full['piID'] + '" class="label label-pending">No</span>';
                    }
                    else {
                        return '<span id="basic' + full['piID'] + '" class="label label-success">Yes</span>';
                    }
                }
            }, {
                targets: [3],
                orderable: true,
                width: '100px',
                data: 'deduction',
                className : "text-center",
                render: function(data, type, full, meta) {
                    if( data == 0 ) {
                        return '<span id="deduction' + full['piID'] + '" class="label label-pending">No</span>';
                    }
                    else {
                        return '<span id="deduction' + full['piID'] + '" class="label label-success">Yes</span>';
                    }
                }
            }, {
                targets: [4],
                orderable: true,
                width: '200px',
                data: 'taxGroups',
                render: function( data, type, full, meta ) {
                    var groups = '<div class="tax-group-item">';

                    for( var i=0; i<data.length; i++ ) {
                        groups += '<span class="badge badge-primary badge-criteria">' + data[i].title + '</span> ';
                    }
                    return groups + '</div>';
                }

            }, {
                targets: [5],
                orderable: false,
                searchable: false,
                width: '100px',
                className: "text-center",
                data: 'piID',
                render: function( data, type, full, meta ) {
                    return '<div class="list-icons">' +
                            '<div class="list-icons-item dropdown">' +
                            '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                            '<i class="icon-menu9"></i></a>' +
                            '<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right" x-placement="bottom-end">' +
                            '<a class="dropdown-item" data-id="' + data + '" data-toggle="modal" data-target="#modalPayItem">' +
                            '<i class="icon-user"></i> Edit Pay Item</a>' +
                            '<div class="divider"></div>' +
                            '<a class="dropdown-item">' +
                            '<i class="icon-exit3"></i> Delete Pay Item</a>' +
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
        }).on('mouseleave', function() {
            $(payItemTable.cells().nodes()).removeClass("active");
        });

        $("#itemTaxGroup").multiselect({includeSelectAllOption: true});

        $("#modalPayItem").on("show.bs.modal", function(e) {
            var $invoker = $(e.relatedTarget);
            var piID = $invoker.attr("data-id");

            if( piID ) {
                var data = {
                    bundle: {
                        trID: piID
                    },
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if (obj.bool == 0) {
                            swal("error", obj.errMsg);
                            return;
                        }
                        else {
                            $("#payItemTitle").val( obj.data.title );
                            /*$("#ruleTitle").val( obj.data.title );
                            $("#group").val( obj.data.tgID ).trigger("change");
                            $("#country").val( obj.data.country ).trigger("change");*/
                        }
                    }
                }
                Aurora.WebService.AJAX( "admin/payroll/getPayItem/" + piID, data );
            }
            else {
                /*$("#trID").val(0);
                $("#ruleTitle").val("");
                $("#group").val(0).trigger("change");
                $("#country").val("").trigger("change");
                $("#city").val("").trigger("change");
                $("#state").val("").trigger("change");
                $("#applyType").val("salaryDeduction").trigger("change");
                $("#applyValueType").val("percentage").trigger("change");
                $("#applyValue").val("");*/
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

    <table class="table table-hover datatable payItemTable">
        <thead>
        <tr>
            <th></th>
            <th>Pay Item Title</th>
            <th>Basic Salary</th>
            <th>Deduction</th>
            <th>Tax Groups</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>
<div id="modalPayItem" class="modal fade">
    <div class="modal-dialog modal-med">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><?LANG_CREATE_NEW_PAY_ITEM?></h6>
            </div>

            <div class="modal-body overflow-y-visible">
                <form id="savePayItem" name="savePayItem" method="post" action="">
                    <input type="hidden" id="piID" name="piID" value="0" />
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
                                        <button class="btn btn-dark" type="button">None</button>
                                        <button class="btn btn-light" type="button">Basic Salary</button>
                                    </span>
                                    <span class="input-group-append">
                                        <button class="btn btn-light" type="button">Deduction</button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Select Tax Group(s):</label>
                                <?TPL_TAX_GROUP_LIST?>
                                </select>
                            </div>
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