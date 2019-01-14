<fieldset style="display:none;">
    <legend class="text-semibold">Q &amp; A</legend>

    <div class="row">
        <div class="col-md-6">
            <!-- BEGIN DYNAMIC BLOCK: col1 -->
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <p><?TPLVAR_QUESTION?></p>
                        <div class="<?TPLVAR_HIDE_RADIO?>">
                            <label class="radio-inline">
                                <input type="radio" class="styled <?TPLVAR_NEED_INFO?>" id="qs<?TPLVAR_QS_ID?>_1" name="qs[<?TPLVAR_QS_ID?>]"
                                       data-id="<?TPLVAR_QS_ID?>" value="<?TPLVAR_YES?>" />
                                <?LANG_YES?>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" class="styled <?TPLVAR_NEED_INFO?>" id="qs<?TPLVAR_QS_ID?>_2" name="qs[<?TPLVAR_QS_ID?>]"
                                       data-id="<?TPLVAR_QS_ID?>" value="<?TPLVAR_NO?>" />
                                <?LANG_NO?>
                            </label>
                        </div>
                    </div>
                    <div id="infoWrapper_<?TPLVAR_QS_ID?>" class="form-group hide">
                        <textarea id="info_<?TPLVAR_QS_ID?>" name="info[<?TPLVAR_QS_ID?>]" rows="3" cols="5"
                                  placeholder="Please provide more information." class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <!-- END DYNAMIC BLOCK: col1 -->
        </div>

        <div class="col-md-6">
            <!-- BEGIN DYNAMIC BLOCK: col2 -->
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <p><?TPLVAR_QUESTION?></p>
                        <div class="<?TPLVAR_HIDE_RADIO?>">
                            <label class="radio-inline">
                                <input type="radio" class="styled <?TPLVAR_NEED_INFO?>" id="qs<?TPLVAR_QS_ID?>_1" name="qs[<?TPLVAR_QS_ID?>]"
                                       data-id="<?TPLVAR_QS_ID?>" value="<?TPLVAR_YES?>" />
                                <?LANG_YES?>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" class="styled <?TPLVAR_NEED_INFO?>" id="qs<?TPLVAR_QS_ID?>_2" name="qs[<?TPLVAR_QS_ID?>]"
                                       data-id="<?TPLVAR_QS_ID?>" value="<?TPLVAR_NO?>" />
                                <?LANG_NO?>
                            </label>
                        </div>
                    </div>
                    <div id="infoWrapper_<?TPLVAR_QS_ID?>" class="form-group hide">
                        <textarea id="info_<?TPLVAR_QS_ID?>" name="info[<?TPLVAR_QS_ID?>]" rows="3" cols="5"
                                  placeholder="Please provide more information." class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <!-- END DYNAMIC BLOCK: col2 -->
        </div>
    </div>
</fieldset>