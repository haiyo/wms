
<div class="tab-pane fade show" id="loaList">
    <div class="list-action-btns loa-list-action-btns">
        <ul class="icons-list">
            <li>
                <a type="button" class="btn bg-purple-400 btn-labeled" data-toggle="modal" data-target="#modalLOA">
                    <b><i class="mi-description"></i></b> <?LANG_CREATE_NEW_LOA?></a>&nbsp;&nbsp;&nbsp;
            </li>
        </ul>
    </div>

    <table class="table table-hover datatable loaTable">
        <thead>
        <tr>
            <th><?LANG_FOR_DESIGNATION?></th>
            <th><?LANG_LAST_UPDATED_BY?></th>
            <th><?LANG_LAST_UPDATED?></th>
            <th><?LANG_ACTIONS?></th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<div id="modalLOA" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><?LANG_CREATE_NEW_LOA?></h6>
            </div>

            <form id="saveLOA" name="saveLOA" class="saveLOA" method="post" action="">
                <div class="modal-body overflow-y-visible">
                    <input type="hidden" id="loaID" name="loaID" value="0" />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?LANG_FOR_WHICH_DESIGNATION?>: <span class="requiredField">*</span></label>
                                <?TPL_DESIGNATION_LIST?>
                            </div>
                        </div>

                        <div class="col-md-12 pb-10">
                            <div class="form-group">
                                <label><?LANG_CONTENT?>: <span class="requiredField">*</span></label>
                                <div class="form-group">
                                    <div class="col-md-12 p-0">
                                        <textarea name="loaContent" id="loaContent" rows="4" cols="4"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="modal-footer-btn">
                        <button type="button" class="btn btn-link" data-dismiss="modal"><?LANG_CANCEL?></button>
                        <button type="submit" class="btn btn-primary"><?LANG_SAVE_CHANGES?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
