
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