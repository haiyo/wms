
<fieldset style="display:none;">
    <legend class="text-semibold">Education</legend>
    <input type="hidden" id="eduEdit" name="eduEdit" value="" />
    <input type="hidden" id="eduID" name="eduID" value="" />
    <div id="education" style="min-height:420px;">


        <div class="row">
            <div class="col-md-6">
                <label>School / Institutions / University:</label>
                <input type="text" id="eduSchool" name="eduSchool" placeholder="School / University name" class="form-control" />
            </div>

            <div class="col-md-6">
                <label>Country:</label>
                <?TPL_EDU_COUNTRY_LIST?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label>Degree Level:</label>
                <input type="text" id="eduLevel" name="eduLevel" placeholder="N' Level, O' Level, Diploma, Bachelor, Master etc." class="form-control">
            </div>

            <div class="col-md-3">
                <label>From:</label>
                <div class="form-group">
                    <div class="col-md-6 no-padding-left">
                        <div class="form-group">
                            <?TPL_EDU_FROM_MONTH_LIST?>
                        </div>
                    </div>
                    <div class="col-md-6 no-padding-right">
                        <div class="form-group">
                            <input type="number" id="eduFromYear" name="eduFromYear" class="form-control" placeholder="Year" value="<?TPLVAR_EDU_FROM_YEAR?>" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <label>To:</label>
                <div class="form-group">
                    <div class="col-md-6 no-padding-left">
                        <div class="form-group">
                            <?TPL_EDU_TO_MONTH_LIST?>
                        </div>
                    </div>
                    <div class="col-md-6 no-padding-right">
                        <div class="form-group">
                            <input type="number" id="eduToYear" name="eduToYear" class="form-control" placeholder="Year" value="<?TPLVAR_EDU_TO_YEAR?>" />
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-6">
                <label>Specialization:</label>
                <input type="text" id="eduSpecialize" name="eduSpecialize" placeholder="Design, Development etc." class="form-control">
            </div>

            <div class="col-md-6">
                <label class="display-block">Certificate:</label>
                <div class="input-group">
                    <input type="text" id="eduCertificate" name="eduCertificate" class="form-control" readonly="readonly" />
                    <input type="hidden" id="eduUID" name="eduUID" class="form-control" />
                    <input type="hidden" id="eduHashName" name="eduHashName" class="form-control" />
                    <input type="hidden" id="eduIndex" name="eduIndex" value="" />
                    <span class="input-group-append">
                            <button class="btn btn-light" type="button" data-toggle="modal" data-target="#uploadEduModal">
                                Upload &nbsp;<i class="icon-file-plus"></i>
                            </button>
                        </span>
                </div>
            </div>
        </div>

        <div id="uploadEduModal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h6 class="modal-title">Upload Certificate</h6>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>

                    <div class="modal-body">
                        <div class="col-lg-12">
                            <input type="file" class="eduFileInput" multiple="multiple" data-fouc />
                            <span class="help-block">Accepted formats: pdf, doc. Max file size <?TPLVAR_MAX_ALLOWED?></span>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div id="saveEduUpload" class="col-lg-12" style="margin-top: 30px;display:none;">
                            <input type="hidden" id="eduIDModal" name="eduIDModal" value="" />
                            <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                            <button type="button" class="btn bg-primary" id="eduSaveUploaded">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="appendEdu">
            <div class="col-md-6">
                <a href="#" class="btn bg-blue" id="addMoreEdu">Add More Education <i class="icon-plus22 ml-2"></i></a>
            </div>
        </div>

        <div id="eduList" class="row" style="margin-top:25px;margin-bottom:25px;">
            <!-- BEGIN DYNAMIC BLOCK: education -->
            <div id="education_<?TPLVAR_INDEX?>" class="education">
                <input type="hidden" id="eduSchool_<?TPLVAR_INDEX?>" name="eduSchool_<?TPLVAR_INDEX?>" value="<?TPLVAR_SCHOOL?>" />
                <input type="hidden" id="eduCountry_<?TPLVAR_INDEX?>" name="eduCountry_<?TPLVAR_INDEX?>" value="<?TPLVAR_COUNTRY?>" />
                <input type="hidden" id="eduLevel_<?TPLVAR_INDEX?>" name="eduLevel_<?TPLVAR_INDEX?>" value="<?TPLVAR_LEVEL?>" />
                <input type="hidden" id="eduSpecialize_<?TPLVAR_INDEX?>" name="eduSpecialize_<?TPLVAR_INDEX?>" value="<?TPLVAR_SPECIALIZE?>" />
                <input type="hidden" id="eduFromMonth_<?TPLVAR_INDEX?>" name="eduFromMonth_<?TPLVAR_INDEX?>" value="<?TPLVAR_FROM_MONTH?>" />
                <input type="hidden" id="eduFromYear_<?TPLVAR_INDEX?>" name="eduFromYear_<?TPLVAR_INDEX?>" value="<?TPLVAR_FROM_YEAR?>" />
                <input type="hidden" id="eduToMonth_<?TPLVAR_INDEX?>" name="eduToMonth_<?TPLVAR_INDEX?>" value="<?TPLVAR_TO_MONTH?>" />
                <input type="hidden" id="eduToYear_<?TPLVAR_INDEX?>" name="eduToYear_<?TPLVAR_INDEX?>" value="<?TPLVAR_TO_YEAR?>" />
                <input type="hidden" id="eduCertificate_<?TPLVAR_INDEX?>" name="eduCertificate_<?TPLVAR_INDEX?>" value="" />
                <input type="hidden" id="eduFileName_<?TPLVAR_INDEX?>" name="eduFileName_<?TPLVAR_INDEX?>" value="<?TPLVAR_FILENAME?>" />
                <input type="hidden" id="eduHashName_<?TPLVAR_INDEX?>" name="eduHashName_<?TPLVAR_INDEX?>" value="" />
                <input type="hidden" id="eduID_<?TPLVAR_INDEX?>" name="eduID_<?TPLVAR_INDEX?>" value="<?TPLVAR_EDU_ID?>" />
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div id="eduFileIcoWrapper_<?TPLVAR_INDEX?>"  class="mr-3" style="color:inherit;display:<?TPLVAR_SHOW_FILE?>">
                                    <a id="eduFileIco_<?TPLVAR_INDEX?>" href="<?TPLVAR_ROOT_URL?>admin/file/view/<?TPLVAR_UID?>/<?TPLVAR_HASHNAME?>"
                                       title="<?TPLVAR_FILENAME?>" target="_blank">
                                        <i class="icon-file-text2 text-success-400 icon-2x mt-1"></i></a>
                                </div>
                                <div class="media-body">
                                    <h6 class="media-title font-weight-semibold"><a href="#" class="text-default"><?TPLVAR_SCHOOL?></a></h6>
                                    <?TPLVAR_LEVEL?>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between" style="display: flex!important;">
                            <span class="text-muted">
                                <?TPLVAR_FROM_DATE?> - <?TPLVAR_TO_DATE?>
                            </span>
                            <span class="text-muted ml-2">
                           <div class="list-icons">
                              <div class="list-icons-item dropdown">
                                 <a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">
                                     <i class="icon-menu9"></i></a>
                                 <div class="dropdown-menu dropdown-menu-right dropdown-menu-sm" x-placement="bottom-end">
                                     <a class="dropdown-item eduEdit" data-id="<?TPLVAR_INDEX?>">
                                         <i class="icon-pencil5"></i> Edit School</a>
                                     <a id="eduUploadCert_<?TPLVAR_INDEX?>" class="dropdown-item eduUploadCert" data-toggle="modal"
                                        data-target="#uploadEduModal" data-index="<?TPLVAR_INDEX?>" data-edu-id="<?TPLVAR_EDU_ID?>" style="display:<?TPLVAR_SHOW_UPLOAD?>">
                                         <i class="icon-file-plus"></i> Upload Certificate</a>
                                     <a id="eduDeleteCert_<?TPLVAR_INDEX?>"class="dropdown-item eduDeleteCert"
                                         data-index="<?TPLVAR_INDEX?>"
                                         data-edu-id="<?TPLVAR_EDU_ID?>"
                                         data-uid="<?TPLVAR_UID?>"
                                         data-hashname="<?TPLVAR_HASHNAME?>"
                                         data-filename="<?TPLVAR_FILENAME?>"
                                         style="display:<?TPLVAR_SHOW_DELETE_FILE?>">
                                         <i class="icon-file-minus"></i> Delete Certificate</a>
                                     <a class="dropdown-item eduDelete" data-title="<?TPLVAR_SCHOOL?>"
                                        data-id="<?TPLVAR_INDEX?>"
                                        data-edu-id="<?TPLVAR_EDU_ID?>">
                                         <i class="icon-bin"></i> Delete School
                                     </a>
                                 </div>
                              </div>
                           </div>
                        </span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END DYNAMIC BLOCK: education -->
        </div>
    </div>
</fieldset>