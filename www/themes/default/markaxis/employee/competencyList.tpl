
<div class="tab-pane fade" id="competencyList">
    <div class="list-action-btns competency-list-action-btns">
        <ul class="icons-list">
            <li>
                <a type="button" class="btn bg-purple-400 btn-labeled" data-backdrop="static" data-keyboard="false"
                   data-toggle="modal" data-target="#modalCompetency">
                    <b><i class="icon-file-plus2"></i></b> <?LANG_CREATE_NEW_COMPETENCY?>
                </a>&nbsp;&nbsp;&nbsp;
                <button type="button" class="btn bg-purple-400 btn-labeled dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <b><i class="icon-stack3"></i></b> Bulk Action <span class="caret"></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right dropdown-employee">
                    <li><a href="#" id="competencyBulkDelete"><i class="icon-bin"></i> Delete Selected Competencies</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <table class="table table-hover datatable tableLayoutFixed competencyTable">
        <thead>
        <tr>
            <th></th>
            <th>Competency</th>
            <th>Description</th>
            <th>No. of Employee</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>
<div id="modalCompetency" class="modal fade">
    <div class="modal-dialog modal-med">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><?LANG_CREATE_NEW_COMPETENCY?></h6>
            </div>

            <form id="saveCompetency" name="saveCompetency" method="post" action="">
                <div class="modal-body overflow-y-visible">
                    <input type="hidden" id="competencyID" name="competencyID" value="0" />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Competency:</label>
                                <input type="text" name="competency" id="competency" class="form-control" value=""
                                       placeholder="Enter Competency" />
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Competency Description:</label>
                                <textarea id="competencyDescript" name="competencyDescript" rows="5" cols="4"
                                          placeholder="Enter Competency Description" class="form-control"></textarea>
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