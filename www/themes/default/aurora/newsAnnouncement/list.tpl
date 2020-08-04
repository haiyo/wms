
<div class="tab-pane fade show" id="naList">
    <div class="list-action-btns na-list-action-btns">
        <ul class="icons-list">
            <li>
                <a type="button" class="btn bg-purple-400 btn-labeled" data-toggle="modal" data-target="#modalNA">
                    <b><i class="mi-description"></i></b> <?LANG_CREATE_NEW_CONTENT?></a>&nbsp;&nbsp;&nbsp;
            </li>
        </ul>
    </div>

    <table class="table table-hover datatable naTable">
        <thead>
        <tr>
            <th>Title</th>
            <th>Content Type</th>
            <th>Author</th>
            <th>Date Created</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<div id="modalNA" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><?LANG_CREATE_NEW_CONTENT?></h6>
            </div>

            <form id="saveNA" name="saveNA" class="saveNA" method="post" action="">
                <div class="modal-body overflow-y-visible">
                    <input type="hidden" id="naID" name="naID" value="0" />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?LANG_SELECT_CONTENT_TYPE?>: <span class="requiredField">*</span></label>
                                <label for="contentType" generated="true" class="error errorLabel"></label>
                                <?TPLVAR_CONTENT_TYPE_LIST?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?LANG_TITLE?>: <span class="requiredField">*</span></label>
                                <label for="naTitle" generated="true" class="error errorLabel"></label>
                                <input type="text" name="naTitle" id="naTitle" class="form-control" value=""
                                       placeholder="Enter title for this content" />
                            </div>
                        </div>

                        <div class="col-md-12 pb-10">
                            <div class="form-group">
                                <label>Content: <span class="requiredField">*</span></label>
                                <label for="naContent" generated="true" class="error errorLabel"></label>
                                <div class="form-group">
                                    <div class="col-md-12 p-0">
                                        <textarea name="naContent" id="naContent" rows="4" cols="4"></textarea>
                                    </div>
                                </div>
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
