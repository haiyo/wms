<fieldset>
    <legend class="text-semibold"><?LANG_ENTITLEMENT_STRUCTURE?></legend>

    <div class="row">
        <div class="col-md-11 text-center">
            <h5><?LANG_LEAVE_STRUCTURE_HEADER?></h5>
        </div>
    </div>

    <div id="structureWrapper">
        <!-- BEGIN DYNAMIC BLOCK: structure -->
        <div id="structureRowWrapper_<?TPLVAR_ID?>">
            <input type="hidden" id="lsID_<?TPLVAR_ID?>" name="lsID_<?TPLVAR_ID?>" value="" />
            <div class="row structureRow">
                <div class="col-md-2">
                    &nbsp;
                </div>
                <div class="col-md-2">
                    <label><?LANG_EMPLOYEE_START_MONTH?>:</label>
                    <input type="text" name="start_<?TPLVAR_ID?>" id="start_<?TPLVAR_ID?>" class="form-control" value="<?TPLVAR_START?>"
                           placeholder="0" />
                </div>
                <div class="col-md-2">
                    <label><?LANG_EMPLOYEE_END_MONTH?>:</label>
                    <input type="text" name="end_<?TPLVAR_ID?>" id="end_<?TPLVAR_ID?>" class="form-control" value="<?TPLVAR_END?>"
                           placeholder="3" />
                </div>
                <div class="col-md-3">
                    <label><?LANG_ELIGIBLE_DAYS_LEAVES?>:</label>
                    <input type="text" name="days_<?TPLVAR_ID?>" id="days_<?TPLVAR_ID?>" class="form-control" value="<?TPLVAR_DAYS?>"
                           placeholder="2" />
                </div>
                <div class="col-md-1">
                    <div class="form-group addCol">
                        <a href="<?TPLVAR_ID?>" class="addStructure"><i id="plus_<?TPLVAR_ID?>" class="icon-plus-circle2"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- END DYNAMIC BLOCK: structure -->
    </div>

    <div id="structureTemplate" class="hide">
        <input type="hidden" id="lsID_{id}" name="lsID_{id}" value="" />
        <div class="row structureRow">
            <div class="col-md-2">
                &nbsp;
            </div>
            <div class="col-md-2">
                <label><?LANG_EMPLOYEE_START_MONTH?>:</label>
                <input type="text" name="start_{id}" id="start_{id}" class="form-control" value=""
                       placeholder="0" />
            </div>
            <div class="col-md-2">
                <label><?LANG_EMPLOYEE_END_MONTH?>:</label>
                <input type="text" name="end_{id}" id="end_{id}" class="form-control" value=""
                       placeholder="3" />
            </div>
            <div class="col-md-3">
                <label><?LANG_ELIGIBLE_DAYS_LEAVES?>:</label>
                <input type="text" name="days_{id}" id="days_{id}" class="form-control" value=""
                       placeholder="2" />
            </div>
            <div class="col-md-1">
                <div class="form-group addCol">
                    <a href="{id}" class="addStructure"><i id="plus_{id}" class="icon-plus-circle2"></i></a>
                </div>
            </div>
        </div>
    </div>

</fieldset>