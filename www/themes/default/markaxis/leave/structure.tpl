<div id="structureRowWrapper_<?TPLVAR_ID?>">
    <!-- BEGIN DYNAMIC BLOCK: row -->
    <div class="row structureRow">
        <div class="col-md-4">
            <label><?LANG_EMPLOYEE_START_MONTH?>:</label>
            <input type="text" name="start_<?TPLVAR_ID?>" id="start_<?TPLVAR_ID?>"
                   class="form-control" value="<?TPLVAR_START?>" placeholder="0" />
        </div>
        <div class="col-md-4">
            <label><?LANG_EMPLOYEE_END_MONTH?>:</label>
            <input type="text" name="end_<?TPLVAR_ID?>" id="end_<?TPLVAR_ID?>"
                   class="form-control" value="<?TPLVAR_END?>" placeholder="3" />
        </div>
        <div class="col-md-3">
            <label><?LANG_ELIGIBLE_DAYS_LEAVES?>:</label>
            <input type="text" name="days_<?TPLVAR_ID?>" id="days_<?TPLVAR_ID?>"
                   class="form-control" value="<?TPLVAR_DAYS?>" placeholder="2" />
        </div>
        <div class="col-md-1">
            <div class="form-group addCol">
                <a href="<?TPLVAR_ID?>" class="addStructure"><i id="plus_<?TPLVAR_ID?>" class="icon-plus-circle2"></i></a>
            </div>
        </div>
    </div>
    <!-- END DYNAMIC BLOCK: row -->
</div>