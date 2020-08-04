
<div class="sidebar sidebar-secondary sidebar-default">
    <div class="sidebar-content profile-content">

        <div class="sidebar-category">

            <div class="thumbnail no-padding">
                <div id="thumb" class="thumb">
                    <div class="defPhoto <?TPLVAR_DEF_PHOTO?>">
                        <img src="<?TPLVAR_ROOT_URL?>themes/default/assets/images/silhouette.jpg" />
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
                            <img src="<?TPLVAR_PHOTO?>" />
                        </div>
                    </div>
                    <!-- END DYNAMIC BLOCK: photo -->
                    <div class="upload-demo-wrap">
                        <a href="#" class="upload-cancel">&times;</a>
                        <div id="upload-demo">
                        </div>
                    </div>
                </div>

                <div class="caption text-center">
                    <h5 class="text-semibold no-margin">
                        <!-- BEGIN DYNAMIC BLOCK: name -->
                        <span id="employeeName"><?TPLVAR_FNAME?> <?TPLVAR_LNAME?></span>
                        <!-- END DYNAMIC BLOCK: name -->
                        <!-- BEGIN DYNAMIC BLOCK: designation -->
                        <small class="display-block"><?TPLVAR_DESIGNATION?></small></h5>
                    <!-- END DYNAMIC BLOCK: designation -->
                </div>

                <div class="text-center">
                    <!-- BEGIN DYNAMIC BLOCK: phone -->
                    <p><i class="icon-phone2"></i> <?TPLVAR_PHONE?></p>
                    <!-- END DYNAMIC BLOCK: phone -->
                    <!-- BEGIN DYNAMIC BLOCK: mobile -->
                    <p><i class="icon-mobile"></i> <?TPLVAR_MOBILE?></p>
                    <!-- END DYNAMIC BLOCK: mobile -->
                    <!-- BEGIN DYNAMIC BLOCK: email -->
                    <p><i class="icon-mail5"></i> <?TPLVAR_EMAIL?></p>
                    <!-- END DYNAMIC BLOCK: email -->
                </div>
            </div>

        </div>
    </div>
</div>


<div class="side-content-wrapper rp">
    <form id="employeeForm" class="stepy" action="#">
        <input type="hidden" id="userID" name="userID" value="<?TPLVAR_USERID?>" />
        <?TPL_FORM?>
        <div id="buttonWrapper" class="pr-15 text-right">
            <button type="submit" class="btn bg-purple-400 btn-ladda" data-style="slide-right">
                <span class="ladda-label">Submit <i class="icon-check position-right"></i></span>
            </button>
        </div>
    </form>
</div>