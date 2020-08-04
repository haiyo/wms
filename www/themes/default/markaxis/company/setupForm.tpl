
<div class="panel panel-flat">
    <div class="panel-body">
        <div class="sidebar sidebar-secondary sidebar-default">
            <div class="sidebar-content profile-content">

                <div class="sidebar-category">

                    <div class="thumbnail no-padding">
                        <div id="thumb" class="thumb">
                            <div class="defPhoto">
                                <img src="<?TPLVAR_ROOT_URL?>themes/default/assets/images/company_logo.png" class="<?TPLVAR_DEF_PHOTO?>" />
                            </div>
                            <div class="caption-overflow">
                                <span>
                                    <a href="" class="btn bg-success-400 btn-icon btn-xs file-btn">
                                        <i class="icon-plus2"></i>
                                        <input type="file" id="upload" value="Choose a file" accept="image/*" />
                                    </a>
                                </span>
                            </div>
                            <!-- BEGIN DYNAMIC BLOCK: photo -->
                            <div class="photo-wrap">
                                <div class="photo">
                                    <a href="#" class="deletePhoto"><i class="icon-bin"></i></a>
                                    <img src="<?TPLVAR_ROOT_URL?>www/mars/user/photo/<?TPLVAR_PHOTO?>" />
                                </div>
                            </div>
                            <!-- END DYNAMIC BLOCK: photo -->
                            <div class="upload-demo-wrap">
                                <a href="#" class="upload-cancel">&times;</a>
                                <div id="upload-demo">
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>


        <div class="content-wrapper side-content-wrapper rp">
            <form id="employeeForm" class="stepy" action="#">
                <input type="hidden" id="userID" name="userID" value="<?TPLVAR_USERID?>" />


                <fieldset>
                    <legend class="text-semibold">Company Settings</legend>

                    <div class="row">
                        <div class="col-md-3">
                            <label>Company Registration Number: <span class="text-danger-400">*</span></label>
                            <input type="text" name="companyRegNo" id="companyRegNo" placeholder="Official registration number"
                                   class="form-control" value="<?TPLVAR_REG_NUMBER?>" />
                        </div>

                        <div class="col-md-3">
                            <label>Company Name: <span class="text-danger-400">*</span></label>
                            <input type="text" name="companyName" id="companyName" placeholder="Example Corporation"
                                   class="form-control" value="<?TPLVAR_NAME?>" />
                        </div>

                        <div class="col-md-3">
                            <label>Company Address: <span class="text-danger-400">*</span></label>
                            <input type="text" name="companyAddress" id="companyAddress" placeholder="111 San Francisco, CA 94110"
                                   class="form-control" value="<?TPLVAR_ADDRESS?>" />
                        </div>

                        <div class="col-md-3">
                            <label>Company Email:</label>
                            <input type="text" name="companyEmail" id="companyEmail" placeholder="example@company.com"
                                   class="form-control" value="<?TPLVAR_EMAIL?>" />
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <label>Company Phone:</label>
                            <input type="text" name="companyPhone" id="companyPhone" placeholder="+65 111 1111"
                                   class="form-control" value="<?TPLVAR_PHONE?>" />
                        </div>

                        <div class="col-md-3">
                            <label>Company Website: <span class="text-danger-400">*</span></label>
                            <input type="text" name="companyWebsite" id="companyWebsite" class="form-control"
                                   placeholder="http://www.example.com" value="<?TPLVAR_WEBSITE?>" />
                        </div>

                        <div class="col-md-3">
                            <label>Company Type:</label>
                            <?TPL_TYPE_LIST?>
                        </div>

                        <div class="col-md-3">
                            <label>Main Operation Country:</label>
                            <?TPL_COUNTRY_LIST?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Company Description:</label>
                                <textarea id="companyDescription" name="companyDescription" rows="5" cols="4"
                                          placeholder="Describe the nature of business of your company" class="form-control" aria-invalid="false"></textarea>
                            </div>
                        </div>
                    </div>

                </fieldset>

                <fieldset>
                    <legend class="text-semibold">Employee Working Shift</legend>

                    <div class="row">
                        <div class="col-md-11 text-center">
                            <h5><?LANG_LEAVE_STRUCTURE_HEADER?></h5>
                        </div>
                    </div>

                    <div id="childWrapper" class="card-body">
                        <div id="childRowWrapper_0">
                            <div id="childRow_0" class="col-md-12 childRow">
                                <input type="hidden" id="ucID_0" name="ucID_0" value="14">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Shift Title: <span class="text-danger-400">*</span></label>
                                        <input type="text" name="childName_2" id="childName_2" placeholder="Day or Night Shift" class="form-control" value="">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Start Time: <span class="text-danger-400">*</span></label>
                                        <input type="text" name="childName_2" id="childName_2" placeholder="" class="form-control" value="">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>End Time: <span class="text-danger-400">*</span></label>
                                        <input type="text" name="childName_2" id="childName_2" placeholder="" class="form-control" value="">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <label class="display-block">Holiday Must Apply Leave:</label>

                                    <label class="radio-inline">
                                        <div class="choice" id="uniform-children1"><span class="checked"><input type="radio" class="styled " id="children1" name="children" value="1" checked="checked"></span></div>
                                        Yes
                                    </label>
                                    <label class="radio-inline">
                                        <div class="choice" id="uniform-children2"><span><input type="radio" class="styled " id="children2" name="children" value="0"></span></div>
                                        No
                                    </label>
                                </div>

                                <div class="col-md-2">
                                    <label class="display-block">Hourly Paid:</label>

                                    <label class="radio-inline">
                                        <div class="choice" id="uniform-children1"><span class="checked"><input type="radio" class="styled " id="children1" name="children" value="1" checked="checked"></span></div>
                                        Yes
                                    </label>
                                    <label class="radio-inline">
                                        <div class="choice" id="uniform-children2"><span><input type="radio" class="styled " id="children2" name="children" value="0"></span></div>
                                        No
                                    </label>
                                </div>

                                <div class="col-md-1 addChildrenCol">
                                    <div class="form-group">
                                        <a href="0" class="removeChildren"><i id="plus_0" class="icon-minus-circle2"></i></a>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div id="childRowWrapper_2">
                            <div id="childRow_2" class="col-md-12 childRow">
                                <input type="hidden" id="ucID_2" name="ucID_2" value="">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Shift Title: <span class="text-danger-400">*</span></label>
                                        <input type="text" name="childName_2" id="childName_2" placeholder="Day or Night Shift" class="form-control" value="">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Start Time: <span class="text-danger-400">*</span></label>
                                        <input type="text" name="childName_2" id="childName_2" placeholder="" class="form-control" value="">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>End Time: <span class="text-danger-400">*</span></label>
                                        <input type="text" name="childName_2" id="childName_2" placeholder="" class="form-control" value="">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <label class="display-block">Holiday Must Apply Leave:</label>

                                    <label class="radio-inline">
                                        <div class="choice" id="uniform-children1"><span class="checked"><input type="radio" class="styled " id="children1" name="children" value="1" checked="checked"></span></div>
                                        Yes
                                    </label>
                                    <label class="radio-inline">
                                        <div class="choice" id="uniform-children2"><span><input type="radio" class="styled " id="children2" name="children" value="0"></span></div>
                                        No
                                    </label>
                                </div>

                                <div class="col-md-2">
                                    <label class="display-block">Hourly Paid:</label>

                                    <label class="radio-inline">
                                        <div class="choice" id="uniform-children1"><span class="checked"><input type="radio" class="styled " id="children1" name="children" value="1" checked="checked"></span></div>
                                        Yes
                                    </label>
                                    <label class="radio-inline">
                                        <div class="choice" id="uniform-children2"><span><input type="radio" class="styled " id="children2" name="children" value="0"></span></div>
                                        No
                                    </label>
                                </div>

                                <div class="col-md-1 addChildrenCol">
                                    <div class="form-group">
                                        <a href="0" class="removeChildren"><i id="plus_0" class="icon-minus-circle2"></i></a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </fieldset>

                <fieldset>
                    <legend class="text-semibold">Financial Settings</legend>
                </fieldset>


                <button type="button" class="btn bg-purple-400 stepy-finish btn-ladda" data-style="slide-right">
                    <span class="ladda-label">Submit <i class="icon-check position-right"></i></span>
                </button>
            </form>
        </div>

    </div>
</div>
