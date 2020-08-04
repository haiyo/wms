<fieldset style="display:none;">
    <legend class="text-semibold">Employment History</legend>
    <input type="hidden" id="expEdit" name="expEdit" value="" />
    <input type="hidden" id="expID" name="expID" value="" />
    <div id="experience" style="min-height:420px;">


        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Company:</label>
                    <input type="text" id="expCompany" name="expCompany" placeholder="Company name" class="form-control">
                </div>

                <div class="form-group">
                    <label>Designation:</label>
                    <input type="text" id="expDesignation" name="expDesignation" placeholder="Designation" class="form-control">
                </div>

                <div class="col-md-6 no-padding-left">
                    <label>From:</label>
                    <div class="form-group">
                        <div class="col-md-6 no-padding-left">
                            <div class="form-group">
                                <?TPL_EXP_FROM_MONTH_LIST?>
                            </div>
                        </div>
                        <div class="col-md-6 no-padding-right">
                            <div class="form-group">
                                <input type="number" id="expFromYear" name="expFromYear" class="form-control" placeholder="Year" value="<?TPLVAR_EXP_FROM_YEAR?>" />
                            </div>
                        </div>


                    </div>
                </div>

                <div class="col-md-6 no-padding-right">
                    <label>To:</label>
                    <div class="form-group">
                        <div class="col-md-6 no-padding-left">
                            <div class="form-group">
                                <?TPL_EXP_TO_MONTH_LIST?>
                            </div>
                        </div>
                        <div class="col-md-6 no-padding-right">
                            <div class="form-group">
                                <input type="number" id="expToYear" name="expToYear" class="form-control" placeholder="Year" value="<?TPLVAR_EXP_TO_YEAR?>" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Brief Description:</label>
                    <textarea id="expDescription" name="expDescription" rows="5" cols="4" placeholder="Tasks and responsibilities" class="form-control"></textarea>
                </div>

                <label class="display-block">Testimonial:</label>
                <!--<input id="testimonial" name="testimonial" type="file" class="file-styled" />
                <span class="help-block">Accepted formats: pdf, doc. Max file size 2Mb</span>-->

                <div class="input-group">
                    <input type="text" id="expTestimonial" name="expTestimonial" class="form-control upload-control" readonly="readonly" />
                    <input type="hidden" id="expUID" name="expUID" class="form-control" />
                    <input type="hidden" id="expHashName" name="expHashName" class="form-control" />
                    <input type="hidden" id="expIndex" name="expIndex" value="" />
                    <span class="input-group-append">
                            <button class="btn btn-light" type="button" data-toggle="modal" data-target="#uploadExpModal">
                                Upload &nbsp;<i class="icon-file-plus"></i>
                            </button>
                        </span>
                </div>
            </div>
        </div>

        <div id="uploadExpModal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h6 class="modal-title">Upload Testimonial</h6>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>

                    <div class="modal-body">
                        <div class="col-lg-12">
                            <input type="file" class="expFileInput" multiple="multiple" data-fouc />
                            <span class="help-block">Accepted formats: pdf, doc. Max file size <?TPLVAR_MAX_ALLOWED?></span>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div id="saveExpUpload" class="col-lg-12" style="margin-top: 30px;display:none;">
                            <input type="hidden" id="expIDModal" name="expIDModal" value="" />
                            <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                            <button type="button" class="btn bg-primary" id="expSaveUploaded">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="appendExp">
            <div class="col-md-6">
                <a href="#" class="btn bg-blue" id="addMoreExp">Add More Experience <i class="icon-plus22 ml-2"></i></a>
            </div>
        </div>

        <div id="expList" class="row" style="margin-top:25px;margin-bottom:25px;">
            <!-- BEGIN DYNAMIC BLOCK: experience -->
            <div id="experience_<?TPLVAR_INDEX?>" class="experience">
                <input type="hidden" id="expCompany_<?TPLVAR_INDEX?>" name="expCompany_<?TPLVAR_INDEX?>" value="<?TPLVAR_COMPANY?>" />
                <input type="hidden" id="expPosition_<?TPLVAR_INDEX?>" name="expPosition_<?TPLVAR_INDEX?>" value="<?TPLVAR_POSITION?>" />
                <input type="hidden" id="expFromMonth_<?TPLVAR_INDEX?>" name="expFromMonth_<?TPLVAR_INDEX?>" value="<?TPLVAR_FROM_MONTH?>" />
                <input type="hidden" id="expFromYear_<?TPLVAR_INDEX?>" name="expFromYear_<?TPLVAR_INDEX?>" value="<?TPLVAR_FROM_YEAR?>" />
                <input type="hidden" id="expToMonth_<?TPLVAR_INDEX?>" name="expToMonth_<?TPLVAR_INDEX?>" value="<?TPLVAR_TO_MONTH?>" />
                <input type="hidden" id="expToYear_<?TPLVAR_INDEX?>" name="expToYear_<?TPLVAR_INDEX?>" value="<?TPLVAR_TO_YEAR?>" />
                <input type="hidden" id="expDescription_<?TPLVAR_INDEX?>" name="expDescription_<?TPLVAR_INDEX?>" value="<?TPLVAR_DESCRIPTION?>" />
                <input type="hidden" id="expID_<?TPLVAR_INDEX?>" name="expID_<?TPLVAR_INDEX?>" value="<?TPLVAR_EXP_ID?>" />
                <input type="hidden" id="expTestimonial_<?TPLVAR_INDEX?>" name="expTestimonial_<?TPLVAR_INDEX?>" value="" />
                <input type="hidden" id="expFileName_<?TPLVAR_INDEX?>" name="expFileName_<?TPLVAR_INDEX?>" value="<?TPLVAR_FILENAME?>" />
                <input type="hidden" id="expHashName_<?TPLVAR_INDEX?>" name="expHashName_<?TPLVAR_INDEX?>" value="" />

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div id="expFileIcoWrapper_<?TPLVAR_INDEX?>"  class="mr-3" style="color:inherit;display:<?TPLVAR_SHOW_FILE?>">
                                    <a id="expFileIco_<?TPLVAR_INDEX?>" href="<?TPLVAR_ROOT_URL?>admin/file/view/<?TPLVAR_UID?>/<?TPLVAR_HASHNAME?>"
                                       title="<?TPLVAR_FILENAME?>" target="_blank">
                                        <i class="icon-file-text2 text-success-400 icon-2x mt-1"></i></a>
                                </div>
                                <div class="media-body">
                                    <h6 class="media-title font-weight-semibold"><a href="#" class="text-default"><?TPLVAR_COMPANY?></a></h6>
                                    <?TPLVAR_POSITION?>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between" style="display: flex!important;">
                            <span class="text-muted"><?TPLVAR_FROM_DATE?> - <?TPLVAR_TO_DATE?></span>
                            <span class="text-muted ml-2">
                                <div class="list-icons">
                                    <div class="list-icons-item dropdown">
                                 <a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">
                                     <i class="icon-menu7"></i></a>
                                     <div class="dropdown-menu dropdown-menu-right dropdown-menu-sm" x-placement="bottom-end">
                                         <a class="dropdown-item expEdit" data-id="<?TPLVAR_INDEX?>">
                                             <i class="icon-pencil5"></i> Edit Company</a>
                                         <a id="expUploadTest_<?TPLVAR_INDEX?>" class="dropdown-item expUploadTest" data-toggle="modal"
                                            data-target="#uploadExpModal" data-index="<?TPLVAR_INDEX?>" data-exp-id="<?TPLVAR_EXP_ID?>" style="display:<?TPLVAR_SHOW_UPLOAD?>">
                                             <i class="icon-file-plus"></i> Upload Testimonial</a>
                                         <a id="expDeleteTest_<?TPLVAR_INDEX?>"class="dropdown-item expDeleteTest"
                                            data-index="<?TPLVAR_INDEX?>"
                                            data-exp-id="<?TPLVAR_EXP_ID?>"
                                            data-uid="<?TPLVAR_UID?>"
                                            data-hashname="<?TPLVAR_HASHNAME?>"
                                            data-filename="<?TPLVAR_FILENAME?>"
                                            style="display:<?TPLVAR_SHOW_DELETE_FILE?>">
                                             <i class="icon-file-minus"></i> Delete Testimonial</a>
                                         <a class="dropdown-item expDelete" data-title="<?TPLVAR_COMPANY?>"
                                            data-id="<?TPLVAR_INDEX?>"
                                            data-exp-id="<?TPLVAR_EXP_ID?>">
                                             <i class="icon-bin"></i> Delete Company
                                         </a>
                                     </div>
                                  </div>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END DYNAMIC BLOCK: experience -->
        </div>
    </div>
</fieldset>