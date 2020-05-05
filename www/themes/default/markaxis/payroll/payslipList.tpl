<script>
    $(document).ready(function( ) {
        var claimTable = $(".claimTable").DataTable({
            "processing": true,
            "serverSide": true,
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id', 'claimTable-row' + aData['ecID']);
            },
            ajax: {
                url: Aurora.ROOT_URL + "admin/payroll/getPayslipResults",
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
                data: "period"
            },{
                targets: [1],
                orderable: true,
                searchable: false,
                width: "180px",
                data: "paymentMethod"
            },{
                targets: [2],
                orderable: true,
                searchable: false,
                width: "100px",
                data: "bankName"
            },{
                targets: [3],
                orderable: true,
                searchable: false,
                width: "110px",
                data: "bankName",
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
            }/*,{
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
            }*/],
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
            <th>Pay Period</th>
            <th>Payment Method</th>
            <th>Bank Name</th>
            <th>Payslip</th>
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
                                    <div class="col-md-12 p-0">
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