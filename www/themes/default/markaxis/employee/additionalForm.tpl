<fieldset style="display:none;">
    <legend class="text-semibold"><?LANG_ADDITIONAL_INFO?></legend>

    <div class="row">
        <div class="col-md-6">
            <label class="display-block">Applicant Resume:</label>
            <input type="file" name="resume" class="file-styled">
            <span class="help-block">Accepted formats: pdf, doc. Max file size 2Mb</span>
        </div>

        <div class="col-md-6">
            <label>Recruitment Source:</label>
            <?TPL_RS_LIST?>
        </div>
    </div>

    <div id="econtact">
        <!-- BEGIN DYNAMIC BLOCK: econtact -->
        <div class="row econtact-row">
            <div class="col-md-3">
                <input type="hidden" id="ecID_<?TPLVAR_INDEX?>" name="ecID_<?TPLVAR_INDEX?>" value="<?TPLVAR_ECID?>" />
                <label>Emergency Contact Name <span class="econtact-count"><?TPLVAR_COUNT?></span>:</label>
                <input type="text" class="form-control" name="eName_<?TPLVAR_INDEX?>" placeholder="Enter name" value="<?TPLVAR_NAME?>" />
            </div>

            <div class="col-md-3">
                <label>Relationship:</label>
                <?TPL_ERS_LIST?>
            </div>

            <div class="col-md-3">
                <label>Home Phone:</label>
                <input type="text" class="form-control" name="ePhone_<?TPLVAR_INDEX?>" data-mask="(999) 999-9999"
                       placeholder="Enter phone #" value="<?TPLVAR_PHONE?>" />
            </div>

            <div class="col-md-3">
                <label>Mobile Phone:</label>
                <input type="text" class="form-control" name="eMobile_<?TPLVAR_INDEX?>" data-mask="(999) 999-9999"
                       placeholder="Enter phone #" value="<?TPLVAR_MOBILE?>" />
            </div>
        </div>
        <!-- END DYNAMIC BLOCK: econtact -->
    </div>

    <div class="row">
        <div class="col-md-12">
            <a href="#" class="btn bg-blue" id="addMoreContact">Add More Contact <i class="icon-arrow-right14 ml-2"></i></a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <label>Additional Notes:</label>
            <textarea name="notes" rows="6" cols="5" placeholder="If you want to add any info, do it here." class="form-control"><?TPLVAR_NOTES?></textarea>
        </div>
    </div>
</fieldset>