<!-- Page header -->
<div class="page-header page-header-default">
    <div class="page-header-content dashboard-header-content">

        <div class="page-title">
            <h3><i class="<?TPLVAR_PAGE_ICON?> position-left"></i> <?LANG_PAGE_TITLE?></h3>
        </div>
    </div>

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li ><a href="<?TPLVAR_ROOT_URL?>admin"><i class="icon-home2 mr-2 position-left"></i> <?LANG_HOME?></a></li>
            <!-- BEGIN DYNAMIC BLOCK: breadcrumbs -->
            <li class="<?TPLVAR_ACTIVE?>"><a href="<?TPLVAR_LINK?>"><i class="<?TPLVAR_ICON?> mr-2 position-left"></i> <?LANG_TEXT?></a></li>
            <!-- END DYNAMIC BLOCK: breadcrumbs -->
        </ul>

        <ul class="breadcrumb-elements">
            <!-- BEGIN DYNAMIC BLOCK: headerLinks -->
            <li><a href="<?TPLVAR_LINK?>" class="<?TPLVAR_CLASSNAME?>"
                   data-toggle="<?TPLVAR_DATA_TOGGLE?>"
                   data-target="#<?TPLVAR_DATA_TARGET?>"><i class="<?TPLVAR_ICON?> position-left"></i> <?LANG_TEXT?></a></li>
            <!-- END DYNAMIC BLOCK: headerLinks -->
        </ul>
    </div>
</div>
<div id="modalSupport" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><?LANG_TELL_US_WHATS_WRONG?></h6>
            </div>

            <form id="supportForm" name="supportForm" method="post" action="">
                <div class="modal-body overflow-y-visible">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?LANG_SUBJECT?>:</label>
                                <input type="text" name="supportSubject" id="supportSubject" class="form-control" value=""
                                       placeholder="<?LANG_ENTER_SUBJECT?>" />
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?LANG_DESCRIPTION?>:</label>
                                <textarea id="supportDescript" name="supportDescript" rows="8" cols="4"
                                          placeholder="<?LANG_ENTER_DESCRIPTION?>" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="display-block"><?LANG_UPLOAD_SCREENSHOT?>:</label>
                                <div class="input-group">
                                    <input type="file" class="fileSupportInput" data-fouc />
                                    <span class="help-block"><?LANG_ACCEPTED_FORMATS?> <?TPLVAR_MAX_ALLOWED?></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="modal-footer-btn">
                        <button type="button" class="btn btn-link" data-dismiss="modal"><?LANG_CANCEL?></button>
                        <button type="submit" class="btn btn-primary" id="sendSupport"><?LANG_SUBMIT?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /page header -->