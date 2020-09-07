<fieldset>
    <legend class="text-semibold"><?LANG_PERSONAL_INFORMATION?></legend>
    <div class="row">
        <div class="col-md-3">
            <label><?LANG_FIRST_NAME?>: <span class="text-danger-400">*</span></label>
            <input type="text" name="fname" id="fname" placeholder="Julia" class="form-control" value="<?TPLVAR_FNAME?>" />
        </div>
        <div class="col-md-3">
            <label><?LANG_LAST_NAME?>: <span class="text-danger-400">*</span></label>
            <input type="text" name="lname" id="lname" placeholder="Koh" class="form-control" value="<?TPLVAR_LNAME?>" />
        </div>
        <div class="col-md-3">
            <label><?LANG_SSN?>:</label>
            <input type="text" name="nric" id="nric" placeholder="0000000001" class="form-control" value="<?TPLVAR_NRIC?>" />
        </div>
        <div class="col-md-3">
            <label><?LANG_NATIONALITY?>:</label>
            <?TPL_NATIONALITY_LIST?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <label><?LANG_PRIMARY_EMAIL?>: <span class="text-danger-400">*</span></label>
            <input type="text" name="email1" id="email1" class="form-control" placeholder="julia@email.com" value="<?TPLVAR_EMAIL1?>" />
        </div>
        <div class="col-md-3">
            <label><?LANG_SECONDARY_EMAIL?>:</label>
            <input type="email" name="email2" id="email2" class="form-control" placeholder="julia@email.com" value="<?TPLVAR_EMAIL2?>" />
        </div>
        <div class="col-md-6">
            <label><?LANG_DATE_OF_BIRTH?>:</label>
            <div class="form-group">
                <div class="col-md-4 no-padding-left">
                    <div class="form-group">
                        <?TPL_DOB_MONTH_LIST?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <?TPL_DOB_DAY_LIST?>
                    </div>
                </div>
                <div class="col-md-4 no-padding-right">
                    <div class="form-group">
                        <input type="number" name="dobYear" class="form-control" placeholder="<?LANG_YEAR?>" value="<?TPLVAR_DOB_YEAR?>" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <label><?LANG_HOME_OFFICE_PHONE?>:</label>
            <input type="text" class="form-control" name="phone" data-mask="(999) 999-9999" placeholder="<?LANG_ENTER_PHONE?>" value="<?TPLVAR_PHONE?>" />
        </div>
        <div class="col-md-3">
            <label><?LANG_MOBILE_PHONE?>:</label>
            <input type="text" class="form-control" name="mobile" data-mask="(999) 999-9999" placeholder="<?LANG_ENTER_PHONE?>" value="<?TPLVAR_MOBILE?>" />
        </div>
        <div class="col-md-3">
            <label><?LANG_COUNTRY_BIRTH?>:</label>
            <?TPL_COUNTRY_LIST?>
        </div>
        <div class="col-md-3">
            <label class="display-block"><?LANG_GENDER?>:</label>
            <?TPL_GENDER_RADIO?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <label><?LANG_PREFERRED_LANGUAGE?>:</label>
            <?TPL_LANGUAGE_LIST?>
        </div>
        <div class="col-md-3">
            <label><?LANG_PRIMARY_ADDRESS?>:</label>
            <input type="text" name="address1" placeholder="Ring street 12" class="form-control" value="<?TPLVAR_ADDRESS1?>" />
        </div>
        <div class="col-md-2">
            <label><?LANG_ZIP_CODE?>:</label>
            <input type="number" name="postal" placeholder="520733" class="form-control" value="<?TPLVAR_POSTAL?>" />
        </div>
        <div class="col-md-2">
            <label><?LANG_STATE_PROVINCE?>:</label>
            <select name="state" data-placeholder="<?LANG_SELECT_STATE?>" placeholder="<?LANG_SELECT_STATE?>" id="state" class="form-control select ">
                <option value=""><?LANG_SELECT_STATE?></option>
            </select>
        </div>
        <div class="col-md-2">
            <label><?LANG_CITY?>:</label>
            <select name="city" data-placeholder="<?LANG_SELECT_CITY?>" placeholder="<?LANG_SELECT_CITY?>" id="city" class="form-control select ">
                <option value=""><?LANG_SELECT_CITY?></option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <label><?LANG_RELIGION?>:</label>
            <?TPL_RELIGION_LIST?>
        </div>
        <div class="col-md-3">
            <label class="display-block"><?LANG_RACE?>:</label>
            <?TPL_RACE_LIST?>
        </div>
        <div class="col-md-2">
            <label><?LANG_MARITAL_STATUS?>:</label>
            <?TPL_MARITAL_LIST?>
        </div>
        <div class="col-md-2">
            <label class="display-block"><?LANG_HAVE_CHILDREN?>:</label>
            <?TPL_CHILDREN_RADIO?>
        </div>
    </div>

    <div id="haveChildren" class="row hide">
        <div class="col-md-12">
            <h7 class="mb-0 ml-10 font-weight-bold"><?LANG_ENTER_CHILDREN_INFO?>:</h7>
            <div class="card">
                <div id="childWrapper" class="card-body">
                    <div id="addChildren">
                        <!-- BEGIN DYNAMIC BLOCK: children -->
                        <div id="childRowWrapper_<?TPLVAR_ID?>">
                            <div id="childRow_<?TPLVAR_ID?>" class="col-md-12 childRow">
                                <input type="hidden" id="ucID_<?TPLVAR_ID?>" name="ucID_<?TPLVAR_ID?>" value="<?TPLVAR_UCID?>" />
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><?LANG_CHILD_FULL_NAME?>: <span class="text-danger-400">*</span></label>
                                        <input type="text" name="childName_<?TPLVAR_ID?>" id="childName_<?TPLVAR_ID?>"
                                               placeholder="<?LANG_CHILD_FULL_NAME?>" class="form-control childName" value="<?TPLVAR_CHILD_NAME?>" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><?LANG_COUNTRY_BIRTH?>: <span class="text-danger-400">*</span></label>
                                        <?TPL_CHILD_COUNTRY?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label><?LANG_DATE_OF_BIRTH?>:</label>
                                    <div class="form-group">
                                        <div class="col-md-4 no-padding-left">
                                            <div class="form-group">
                                                <?TPL_CHILD_DOB_MONTH_LIST?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?TPL_CHILD_DOB_DAY_LIST?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="number" name="childDobYear_<?TPLVAR_ID?>" class="form-control childDobYear"
                                                       placeholder="<?LANG_YEAR?>" value="<?TPLVAR_CHILD_YEAR?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-1 addChildrenCol">
                                            <div class="form-group">
                                                <a href="<?TPLVAR_ID?>" class="removeChildren">
                                                    <i id="plus_<?TPLVAR_ID?>" class="icon-minus-circle2"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END DYNAMIC BLOCK: children -->
                    </div>
                    <div style="float:left;padding:0px 20px 10px 20px;">
                        <a type="button" class="btn bg-purple-400 btn-labeled btn-lg btn-block addChildren" data-toggle="modal" data-target="#modalApplyLeave">
                            <b><i class="icon-file-plus2"></i></b> <?LANG_ADD_MORE_CHILDREN?></a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div id="childTemplate" class="hide">
        <div id="childRow_{id}" class="col-md-12 childRow">
            <input type="hidden" id="ucID_{id}" name="ucID_{id}" value="" />
            <div class="col-md-3">
                <div class="form-group">
                    <label><?LANG_CHILD_FULL_NAME?>: <span class="text-danger-400">*</span></label>
                    <input type="text" name="childName_{id}" id="childName_{id}" placeholder="<?LANG_CHILD_FULL_NAME?>"
                           class="form-control childName" value="" />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label><?LANG_COUNTRY_BIRTH?>: <span class="text-danger-400">*</span></label>
                    <?TPL_CHILD_COUNTRY?>
                </div>
            </div>
            <div class="col-md-6">
                <label><?LANG_DATE_OF_BIRTH?>:</label>
                <div class="form-group">
                    <div class="col-md-4 no-padding-left">
                        <div class="form-group">
                            <?TPL_CHILD_DOB_MONTH_LIST?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <?TPL_CHILD_DOB_DAY_LIST?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="number" name="childDobYear_{id}" class="form-control childDobYear" placeholder="<?LANG_YEAR?>" value="" />
                        </div>
                    </div>
                    <div class="col-md-1 addChildrenCol">
                        <div class="form-group">
                            <a href="{id}" class="removeChildren"><i id="plus_{id}" class="icon-minus-circle2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h7 class="mb-0 ml-10 font-weight-bold">HRMSCloud <?LANG_ACCOUNT_LOGIN?>:</h7>
            <input id="username" style="display:none" type="text" name="fakeusername" />
            <input id="password" style="display:none" type="password" name="fakepassword" />
            <div class="card">
                <div class="card-body">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><?LANG_LOGIN_USERNAME?>:</label>
                            <input type="text" id="loginUsername" name="loginUsername" placeholder="juliakoh" class="form-control" value="<?TPLVAR_USERNAME?>" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><?LANG_LOGIN_PASSWORD?>:</label>
                            <div class="input-group">
                                <input type="password" id="loginPassword" name="loginPassword" class="form-control" autocomplete="new-password" />
                                <span class="input-group-append">
                                <button class="btn btn-light" type="button" id="autoGenPwd" onclick="copyText()"><?LANG_AUTO_GENERATE?></button>
                            </span>
                                <span class="input-group-append">
                                <button class="btn btn-light" type="button" id="showPwd"> <i class="icon-eye"></i></button>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group hide" id="capsLockWarn">
                            <label></label>
                            <div class="input-group text-muted" style="margin-top: 14px;">
                                <?LANG_CAPS_LOCK_ON?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</fieldset>