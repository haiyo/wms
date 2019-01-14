<div class="card">
    <div class="card-body">
        <form id="userRole-validate" action="#">
            <input type="hidden" id="editRoleID" value="<?TPLVAR_ROLE_ID?>" />
            <div class="form-group row">
                <label class="col-lg-3 col-form-label">Role Title:</label>
                <div class="col-lg-9">
                    <input type="text" id="roleTitle" name="roleTitle" class="form-control" placeholder="Enter a Role Title" value="<?TPLVAR_ROLE_TITLE?>" required="required" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 col-form-label">Description:</label>
                <div class="col-lg-9">
                    <textarea id="roleDescript" rows="5" cols="5" class="form-control" placeholder="Enter description of this role"><?TPLVAR_ROLE_DESCRIPT?></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                <button type="submit" class="btn bg-primary" id="saveRole">Save Role &nbsp;&nbsp;<i class="icon-paperplane ml-2"></i></button>
            </div>
        </form>
    </div>
</div>