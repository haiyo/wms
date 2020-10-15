
<div class="tab-pane" id="taxes">
    <div class="panel-heading">
        <h5 class="panel-title">&nbsp;<a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li>
                    <a type="button" class="btn bg-purple-400 btn-labeled"
                       data-backdrop="static" data-keyboard="false"
                       data-toggle="modal" data-target="#modalTaxGroup">
                        <b><i class="icon-folder-plus"></i></b> <?LANG_CREATE_NEW_TAX_GROUP?>
                    </a>
                </li>
                <li>
                    <a type="button" class="btn bg-purple-400 btn-labeled" data-toggle="modal"
                       data-backdrop="static" data-keyboard="false"
                       data-target="#modalTaxRule">
                        <b><i class="icon-library2"></i></b> <?LANG_CREATE_NEW_TAX_RULE?>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="groupList">
        <div class="list-group list-group-root border-top border-top-grey border-bottom border-bottom-grey mb-20">
            <!-- BEGIN DYNAMIC BLOCK: noGroup -->
            <div class="blankCanvasNotice">
                <h6>Hooray! <?LANG_NO_TAX?>!</h6>
            </div>
            <!-- END DYNAMIC BLOCK: noGroup -->
            <?TPL_GROUP_TREE_LIST?>

            <div id="taxRulesWrapper"></div>
        </div>
    </div>

</div>

<div id="modalTaxGroup" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><?LANG_CREATE_NEW_TAX_GROUP?></h6>
            </div>

            <form id="saveTaxGroup" name="saveTaxGroup" method="post" action="">
                <div class="modal-body">
                    <input type="hidden" id="tgID" name="tgID" value="0" />
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?LANG_TAX_GROUP_TITLE?>:</label>
                                <input type="text" name="groupTitle" id="groupTitle" class="form-control" value=""
                                       placeholder="<?LANG_ENTER_TAX_GROUP_TITLE?>" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?LANG_OFFICE?>:</label>
                                <?TPL_OFFICE_LIST?>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?LANG_DESCRIPTION?>:</label>
                                <textarea name="groupDescription" id="groupDescription" rows="6" cols="5"
                                          placeholder="<?LANG_ENTER_TAX_GROUP_DESCRIPTION?>" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?LANG_PARENT?>:</label>
                                <select name="parent" id="parent" data-placeholder="" data-id=""
                                        class="form-control select select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-checkbox-group">
                                <input type="checkbox" class="dt-checkboxes check-input" id="selectable" name="selectable" value="1" />
                                <label for="selectable" class="ml-5"><?LANG_ALLOW_SELECTION?></label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <input type="checkbox" class="dt-checkboxes check-input" id="summary" name="summary" value="1" />
                            <label for="summary" class="ml-5"><?LANG_DISPLAY_SUMMARY?></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="modal-footer-btn">
                        <button type="button" class="btn btn-link" data-dismiss="modal"><?LANG_CANCEL?></button>
                        <button type="submit" class="btn btn-primary"><?LANG_SUBMIT?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modalTaxRule" class="modal fade">
    <div class="modal-dialog modal-xl overflow-y-visible">
        <div class="modal-content overflow-y-visible">
            <form id="saveTaxRule" name="saveTaxRule" method="post" action="">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><?LANG_CREATE_NEW_TAX_RULE?></h6>
            </div>

            <div class="modal-body overflow-y-visible">
                <input type="hidden" id="trID" name="trID" value="0" />
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?LANG_TAX_RULE_TITLE?>: <span class="text-danger-400">*</span></label>
                            <input type="text" name="ruleTitle" id="ruleTitle" class="form-control" value=""
                                   placeholder="<?LANG_ENTER_TAX_RULE_TITLE?>" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?LANG_APPLY_WHICH_COUNTRY?>: <span class="text-danger-400">*</span></label>
                            <?TPL_COUNTRY_LIST?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?LANG_BELONG_TO_GROUP?>:</label>
                            <select name="group" id="group" data-placeholder="" data-id=""
                                    class="form-control select select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                        </div>
                    </div>

                    <div class="col-md-3"></div>
                    <div id="multi-select-wrapper" class="col-md-9"></div>

                    <div class="col-md-12">
                        <div class="card">
                            <div id="rulesWrapper" class="card-body" style="padding: 12px;">
                            </div>
                        </div>
                    </div>

                    <div id="criteriaTemplate" class="hide">
                        <div id="criteriaRow_{id}" class="col-md-3 criteriaRow criteriaFirstCol">
                            <div class="form-group">
                                <label><?LANG_SELECT_CRITERIA?>: <span class="text-danger-400">*</span></label>
                                <select name="criteria_{id}" id="criteria_{id}" data-placeholder="" data-id="{id}"
                                        class="form-control select select2-hidden-accessible criteria" tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    <optgroup label="<?LANG_COMPUTING_VARIABLE?>">
                                        <option value="age"><?LANG_AGE_GROUP?></option>
                                        <option value="ordinary"><?LANG_ORDINARY?></option>
                                        <option value="payItem"><?LANG_PAY_ITEM?></option>
                                        <option value="workforce"><?LANG_TOTAL_WORKFORCE?></option>
                                        <option value="allPayItem"><?LANG_ALL_PAY_ITEM?></option>
                                    </optgroup>

                                    <optgroup label="<?LANG_OTHER_EMPLOYEE_VARIABLES?>">
                                        <option value="confirmation"><?LANG_CONFIRMATION_DATE?></option>
                                        <option value="competency"><?LANG_COMPETENCY?></option>
                                        <option value="contract"><?LANG_CONTRACT_TYPE?></option>
                                        <option value="designation"><?LANG_DESIGNATION?></option>
                                        <option value="race"><?LANG_RACE?></option>
                                        <option value="gender"><?LANG_GENDER?></option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div id="computingTemplate" class="hide">
                        <div class="col-md-5">
                            <input type="hidden" id="tcID_{id}" name="tcID_{id}" value="" />
                            <div class="form-group">
                                <label><?LANG_COMPUTING?>:</label>
                                <select name="computing_{id}" id="computing_{id}" data-placeholder=""
                                        class="form-control select select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                    <option value="lt"><?LANG_LESS_THAN?></option>
                                    <option value="gt"><?LANG_GREATER_THAN?></option>
                                    <option value="lte"><?LANG_LESS_THAN_OR_EQUAL?></option>
                                    <option value="ltec"><?LANG_LESS_THAN_OR_EQUAL_AND_CAPPED?></option>
                                    <option value="gte"><?LANG_GREATER_THAN_OR_EQUAL?></option>
                                    <option value="eq"><?LANG_EQUAL?></option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?LANG_AMOUNT_TYPE?>:</label>
                                <select name="valueType_{id}" id="valueType_{id}" data-placeholder=""
                                        class="form-control select select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                    <option value="percentage"><?LANG_PERCENTAGE?></option>
                                    <option value="fixed" selected><?LANG_FIXED_INTEGER?></option>
                                </select>
                            </div>
                        </div>

                        <div id="col_{id}" class="col-md-2">
                            <div class="form-group">
                                <label><?LANG_VALUE?>:</label>
                                <input type="number" class="form-control" id="value_{id}" name="value_{id}" placeholder="" />
                            </div>
                        </div>

                        <div class="col-md-1 criteriaLastCol">
                            <div class="form-group addCol">
                                <a href="{id}" class="addCriteria"><i id="plus_{id}" class="icon-plus-circle2"></i></a>
                            </div>
                        </div>
                    </div>

                    <div id="payItemTemplate" class="hide">
                        <div id="col_{id}" class="col-md-5">
                            <input type="hidden" id="tpiID_{id}" name="tpiID_{id}" value="" />
                            <div class="form-group">
                                <label><?LANG_SELECT_PAY_ITEM?>:</label>
                                <?TPL_PAY_ITEM_LIST?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?LANG_AMOUNT_TYPE?>:</label>
                                <select name="valueType_{id}" id="valueType_{id}" data-id="{id}" data-placeholder=""
                                        class="form-control amtType select select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                    <option value="percentage"><?LANG_PERCENTAGE?></option>
                                    <option value="fixed" selected><?LANG_FIXED_INTEGER?></option>
                                    <option value="formula"><?LANG_CUSTOM_FORMULA?></option>
                                </select>
                            </div>
                        </div>

                        <div id="col_{id}" class="col-md-2">
                            <div class="form-group">
                                <label><?LANG_VALUE?>:</label>
                                <input type="number" class="form-control" id="value_{id}" name="value_{id}" placeholder="" />
                            </div>
                        </div>

                        <div class="col-md-1 criteriaLastCol">
                            <div class="form-group addCol">
                                <a href="{id}" class="addCriteria"><i id="plus_{id}" class="icon-plus-circle2"></i></a>
                            </div>
                        </div>
                    </div>

                    <div id="confirmationTemplate" class="hide">
                        <div class="col-md-5">
                            <input type="hidden" id="tcID_{id}" name="tcID_{id}" value="" />
                            <div class="form-group">
                                <label><?LANG_COMPUTING?>:</label>
                                <select name="computing_{id}" id="computing_{id}" data-placeholder=""
                                        class="form-control select select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                    <option value="gt"><?LANG_GREATER_THAN?></option>
                                    <option value="gte" selected><?LANG_GREATER_THAN_OR_EQUAL?></option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?LANG_DATE_TYPE?>:</label>
                                <select name="valueType_{id}" id="valueType_{id}" data-placeholder=""
                                        class="form-control select select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                    <option value="current" selected><?LANG_CURRENT?></option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-1 criteriaLastCol">
                            <div class="form-group addCol">
                                <a href="{id}" class="addCriteria"><i id="plus_{id}" class="icon-plus-circle2"></i></a>
                            </div>
                        </div>
                    </div>

                    <div id="competencyTemplate" class="hide">
                        <div id="col_{id}" class="col-md-11 competency-col">
                            <input type="hidden" id="cID_{id}" name="cID_{id}" value="" />
                            <div class="form-group">
                                <label><?LANG_ENTER_COMPETENCIES?>: <i class="icon-info22 mr-3" data-popup="tooltip" title="" data-html="true"
                                                                     data-original-title="<?LANG_COMPETENCY_INFO?>"></i>
                                    <span class="text-muted">(<?LANG_TYPE_ENTER_NEW_COMPETENCY?>)</span></label>
                                <input type="text" id="competency{template}" name="competency{template}" class="form-control tokenfield-typeahead"
                                       placeholder="<?LANG_ENTER_SKILLSETS_OR_KNOWLEDGE?>"
                                       value="" autocomplete="off" data-fouc />
                            </div>
                        </div>

                        <div class="col-md-1 criteriaLastCol">
                            <div class="form-group addCol">
                                <a href="{id}" class="addCriteria"><i id="plus_{id}" class="icon-plus-circle2"></i></a>
                            </div>
                        </div>
                    </div>

                    <div id="contractTemplate" class="hide">
                        <div id="col_{id}" class="col-md-11">
                            <input type="hidden" id="contractID_{id}" name="contractID_{id}" value="" />
                            <div class="form-group">
                                <label><?LANG_SELECT_CONTRACT_TYPE?>:</label>
                                <?TPL_CONTRACT_LIST?>
                            </div>
                        </div>

                        <div class="col-md-1 criteriaLastCol">
                            <div class="form-group addCol">
                                <a href="{id}" class="addCriteria"><i id="plus_{id}" class="icon-plus-circle2"></i></a>
                            </div>
                        </div>
                    </div>

                    <div id="designationTemplate" class="hide">
                        <div id="col_{id}" class="col-md-11">
                            <input type="hidden" id="designationID_{id}" name="designationID_{id}" value="" />
                            <div class="form-group">
                                <label><?LANG_SELECT_DESIGNATION?>:</label>
                                <?TPL_DESIGNATION_LIST?>
                            </div>
                        </div>

                        <div class="col-md-1 criteriaLastCol">
                            <div class="form-group addCol">
                                <a href="{id}" class="addCriteria"><i id="plus_{id}" class="icon-plus-circle2"></i></a>
                            </div>
                        </div>
                    </div>

                    <div id="raceTemplate" class="hide">
                        <div id="col_{id}" class="col-md-11 test" style="position:static !important;">
                            <input type="hidden" id="raceID_{id}" name="raceID_{id}" value="" />
                            <div class="form-group test">
                                <label><?LANG_SELECT_RACE?>:</label>
                                <?TPL_RACE_LIST?>
                            </div>
                        </div>

                        <div class="col-md-1 criteriaLastCol">
                            <div class="form-group addCol">
                                <a href="{id}" class="addCriteria"><i id="plus_{id}" class="icon-plus-circle2"></i></a>
                            </div>
                        </div>
                    </div>

                    <div id="genderTemplate" class="hide">
                        <div id="col_{id}" class="col-md-11">
                            <input type="hidden" id="genderID_{id}" name="genderID_{id}" value="" />
                            <div class="form-group">
                                <label><?LANG_SELECT_GENDER?>:</label>
                                <div class="form-group p-8">
                                    <?TPL_GENDER_RADIO?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-1 criteriaLastCol">
                            <div class="form-group addCol">
                                <a href="{id}" class="addCriteria"><i id="plus_{id}" class="icon-plus-circle2"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div style="width:100%; margin:15px 0 15px 0;"></div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><?LANG_APPLY_ABOVE_CRITERIA_AS?>:</label>
                            <select name="applyType" id="applyType" data-placeholder="" placeholder=""
                                    class="form-control select select2-hidden-accessible criteria" tabindex="-1" aria-hidden="true">
                                <option value="deductionOR"><?LANG_DEDUCTION_FROM_ORDINARY?></option>
                                <option value="deductionAW"><?LANG_DEDUCTION_FROM_ADDITIONAL?></option>
                                <option value="contribution"><?LANG_EMPLOYER_CONTRIBUTION?></option>
                                <option value="skillLevy"><?LANG_SKILL_DEVELOPMENT_LEVY?></option>
                                <option value="foreignLevy"><?LANG_FOREIGN_WORKER_LEVY?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><?LANG_TYPE_OF_VALUE?>:</label>
                            <select name="applyValueType" id="applyValueType" data-placeholder="" placeholder=""
                                    class="form-control select select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                <option value="percentage"><?LANG_PERCENTAGE?></option>
                                <option value="fixed" selected><?LANG_FIXED_INTEGER?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label><?LANG_VALUE?>: <span class="text-danger-400">*</span></label>
                            <input type="number" class="form-control" id="applyValue" name="applyValue" placeholder="" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><?LANG_CAPPED_AMOUNT_FORMULA?>:</label>
                            <input type="text" class="form-control" id="applyCapped" name="applyCapped" placeholder="" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="modal-footer-btn">
                    <button type="button" class="btn btn-link" data-dismiss="modal"><?LANG_CANCEL?></button>
                    <button type="submit" class="btn btn-primary"><?LANG_SUBMIT?></button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function( ) {
        $(".list-group-item").on("click", function() {
            $(".glyphicon", this).toggleClass("glyphicon-chevron-right")
                                 .toggleClass("glyphicon-chevron-down");
        });

        /*$(document).on( "click", ".multiselect", function ( ) {
            var width = $(this).outerWidth();
            var offset = $(this).offset();

            var test = $(this).offsetParent().width() - $(this).outerWidth() - $(this).position().left;

            console.log( $(this).next().attr("class"))

            $(this).next().width(width);
            $(this).next().addClass("leftImportant");
        });*/

        $(document).on( "click", ".deleteTaxGroup", function ( ) {
            var id = $(this).attr("data-id");
            var title = $("#groupTitle_" + id).text( );

            swal({
                title: "Are you sure you want to delete the tax group " + title + "?",
                text: "All tax groups and tax rules belong to this parent group will be deleted!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Confirm Delete",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function( isConfirm ) {
                if (isConfirm === false) return;

                var data = {
                    bundle: {
                        tgID: id
                    },
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if( obj.bool == 0 ) {
                            swal("Error!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            $("#group_" + id).remove( );
                            swal("Done!", title + " has been successfully deleted!", "success");
                            return;
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/payroll/deleteTaxGroup", data);
            });
        });

        $(document).on( "click", ".deleteTaxRule", function ( ) {
            var id = $(this).attr("data-id");
            var title = $("#taxRuleTitle_" + id).text( );

            swal({
                title: "Are you sure you want to delete the tax rule " + title + "?",
                text: "This action cannot be undone once deleted.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Confirm Delete",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function( isConfirm ) {
                if (isConfirm === false) return;

                var data = {
                    bundle: {
                        trID: id
                    },
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if( obj.bool == 0 ) {
                            swal("Error!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            $("#taxRow_" + id).remove( );
                            swal("Done!", title + " has been successfully deleted!", "success");
                            return;
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/payroll/deleteTaxRule", data);
            });
        });

        var data = {
            success: function (res) {
                var obj = $.parseJSON( res );
                $("#taxRulesWrapper").html( obj.html );

                $.each( $(".taxRow"), function( key, value ) {
                    var parent = $(this).attr("data-parent");

                    if( parent !== 0 ) {
                        $("#expandIcon_" + parent).show( );
                        $(this).prependTo("#item-" + parent);
                    }
                });
            }
        };
        Aurora.WebService.AJAX("admin/payroll/getAllTaxRules/html", data);

        function refreshGroupList( ) {
            var data = {
                success: function( res ) {
                    var res = $.parseJSON(res);

                    groupList = $.map(res, function( obj ) {
                        return {id: obj.id, text: obj.text, level: obj.level};
                    });

                    $("#parent").select2({ data: groupList,
                        formatSelection: function (item) {
                            return item.text
                        },
                        formatResult: function (item) {
                            return item.text
                        },
                        templateResult: formatResult,
                    });

                    $("#group").select2({ data: groupList,
                        formatSelection: function (item) {
                            return item.text
                        },
                        formatResult: function (item) {
                            return item.text
                        },
                        templateResult: formatResult,
                    });
                }
            };
            Aurora.WebService.AJAX("admin/payroll/getGroupList", data);
        }

        refreshGroupList( );

        function formatResult(node) {
            return $('<span style="padding-left:' + (10 * node.level) + 'px;">' + node.text + '</span>');
        }

        $("#country").select2( );
        $("#office").select2({minimumResultsForSearch: Infinity});
        $("#applyType").select2({minimumResultsForSearch: Infinity});
        $("#applyValueType").select2({minimumResultsForSearch: Infinity});

        $(document).on("change", ".amtType", function(e) {
            var id = $(this).attr("data-id");

            if( $(this).val( ) === "formula" ) {
                $("#value_" + id).attr("type", "text");
            }
            else {
                $("#value_" + id).attr("type", "number");
            }
        });

        $(document).on("change", ".criteria", function(e) {
            $(".modal-footer .error").remove( );

            var id = $(this).attr("data-id");
            if( $("#criteriaSet_" + id).length > 0 ) {
                $("#criteriaSet_" + id).remove( );
            }
            if( $(this).val( ) === "age" || $(this).val( ) === "ordinary" ||
                $(this).val( ) === "workforce" || $(this).val( ) === "allPayItem" ) {
                addComputing( $(this) );
            }
            if( $(this).val( ) === "payItem" ) {
                addPayItem( $(this) );
            }
            if( $(this).val( ) === "confirmation" ) {
                addConfirmation( $(this) );
            }
            if( $(this).val( ) === "competency" ) {
                addCompetency( $(this) );
            }
            if( $(this).val( ) === "contract" ) {
                addContract( $(this) );
            }
            if( $(this).val( ) === "designation" ) {
                addDesignation( $(this) );
            }
            if( $(this).val( ) === "race" ) {
                addRace( $(this) );
            }
            if( $(this).val( ) === "gender" ) {
                addGender( $(this) );
            }
            var id = $("#rulesWrapper .criteriaRow").length-1;
            $("#criteriaRow_" + id).find(".addCriteria").show( );
        });

        function addCriteria( ) {
            var length = $("#rulesWrapper .criteriaRow").length;
            var criteria = $("#criteriaTemplate").html( );
            criteria = criteria.replace(/\{id\}/g, length );
            $("#rulesWrapper").append( '<div id="criteriaRowWrapper_' + length + '" class="row">' + criteria + "</div>" );
            $("#criteria_" + length).select2({minimumResultsForSearch: Infinity});
            $("#criteria_" + length).val("age").trigger("change");

            var id = $("#rulesWrapper .criteriaRow").length-2;
            $("#plus_" + id).attr( "class", "icon-minus-circle2" );
            $("#plus_" + id).parent().attr( "class", "removeCriteria" );

            $("#rulesWrapper").animate({ scrollTop: $("#rulesWrapper")[0].scrollHeight}, 1000);
        }

        addCriteria( );

        $(document).on( "click", ".addCriteria", function ( ) {
            addCriteria( );
            return false;
        });

        $(document).on( "click", ".removeCriteria", function ( ) {
            var id = $(this).attr("href");
            $("#criteriaRowWrapper_" + id).addClass("criteriaRow").html("").hide();
            return false;
        });

        function addPayItem( element ) {
            var id = element.attr("data-id");
            var html = $("#payItemTemplate").html( );
            html = html.replace(/\{id\}/g, id );
            $("#criteriaRow_" + id).after( '<div id="criteriaSet_' + id + '" class="col-md-9">' + html + '</div>' );
            $("#payItem_" + id).select2({minimumResultsForSearch:Infinity});
            $("#valueType_" + id).select2({minimumResultsForSearch:Infinity});
        }

        function addComputing( element ) {
            var id = element.attr("data-id");
            var html = $("#computingTemplate").html( );
            html = html.replace(/\{id\}/g, id );
            $("#criteriaRow_" + id).after( '<div id="criteriaSet_' + id + '" class="col-md-9">' + html + '</div>' );
            $("#computing_" + id).select2({minimumResultsForSearch:Infinity});
            $("#valueType_" + id).select2({minimumResultsForSearch:Infinity});
        }

        function addConfirmation( element ) {
            var id = element.attr("data-id");
            var html = $("#confirmationTemplate").html( );
            html = html.replace(/\{id\}/g, id );
            $("#criteriaRow_" + id).after( '<div id="criteriaSet_' + id + '" class="col-md-9">' + html + '</div>' );
            $("#computing_" + id).select2({minimumResultsForSearch:Infinity});
            $("#valueType_" + id).select2({minimumResultsForSearch:Infinity});
        }

        function addContract( element ) {
            if( $("#contract").length > 0 ) {
                if( $(".modal-footer .error").length == 0 )
                    $(".modal-footer").append( '<label id="ruleTitle-error" class="error">You already have one Contract rule.</label>' );
                return false;
            }
            var id = element.attr("data-id");
            var html = $("#contractTemplate").html( );
            html = html.replace(/\{id\}/g, id );
            html = html.replace(/\{template\}/g, "" );
            $("#criteriaRow_" + id).after( '<div id="criteriaSet_' + id + '" class="col-md-9">' + html + '</div>' );
            $("#contract").multiselect({
                includeSelectAllOption: true,
                templates: {
                    button: '<button type="button" class="multiselect dropdown-toggle" data-display="static" data-toggle="dropdown"><span class="multiselect-selected-text"></span></button>'
                },
                onDropdownShown: function( e ) {
                    var $invoker = $("#criteriaSet_" + id);
                    var position = $invoker.position( );
                    var width = $invoker.find(".col-md-11").width( );

                    var multiContainer = $(".multiselect-container");
                    multiContainer.appendTo("#multi-select-wrapper");
                    multiContainer.css( "top", (position.top+71) + "px" );
                    multiContainer.css( "left", "33px" );
                    multiContainer.css( "width", width + "px" );
                }
            });
        }

        function addDesignation( element ) {
            if( $("#designation").length > 0 ) {
                if( $(".modal-footer .error").length == 0 )
                    $(".modal-footer").append( '<label id="ruleTitle-error" class="error">You already have one Designation rule.</label>' );
                return false;
            }
            var id = element.attr("data-id");
            var html = $("#designationTemplate").html( );
            html = html.replace(/\{id\}/g, id );
            html = html.replace(/\{template\}/g, "" );
            $("#criteriaRow_" + id).after( '<div id="criteriaSet_' + id + '" class="col-md-9">' + html + '</div>' );
            $("#designation").multiselect({
                includeSelectAllOption: true,
                templates: {
                    button: '<button type="button" class="multiselect dropdown-toggle" data-display="static" data-toggle="dropdown"><span class="multiselect-selected-text"></span></button>'
                },
                onDropdownShown: function( e ) {
                    var $invoker = $("#criteriaSet_" + id);
                    var position = $invoker.position( );
                    var width = $invoker.find(".col-md-11").width( );

                    var multiContainer = $(".multiselect-container");
                    multiContainer.appendTo("#multi-select-wrapper");
                    multiContainer.css( "top", (position.top+71) + "px" );
                    multiContainer.css( "left", "33px" );
                    multiContainer.css( "width", width + "px" );
                }
            });
        }

        function addRace( element ) {
            if( $("#race").length > 0 ) {
                if( $(".modal-footer .error").length == 0 )
                    $(".modal-footer").append( '<label id="ruleTitle-error" class="error">You already have one Race rule.</label>' );
                return false;
            }
            var id = element.attr("data-id");
            var html = $("#raceTemplate").html( );
            html = html.replace(/\{id\}/g, id );
            html = html.replace(/\{template\}/g, "" );
            $("#criteriaRow_" + id).after( '<div id="criteriaSet_' + id + '" class="col-md-9">' + html + '</div>' );
            $("#race").multiselect({includeSelectAllOption: true});
        }

        function addGender( element ) {
            if( $("#gender1").length > 0 ) {
                if( $(".modal-footer .error").length == 0 )
                    $(".modal-footer").prepend( '<label id="ruleTitle-error" class="error">You already have one Gender rule.</label>' );
                return false;
            }
            var id = element.attr("data-id");
            var html = $("#genderTemplate").html( );
            html = html.replace(/\{id\}/g, id );
            html = html.replace(/\{template\}/g, "" );
            $("#criteriaRow_" + id).after( '<div id="criteriaSet_' + id + '" class="col-md-9">' + html + '</div>' );
            $(".gender").uniform({radioClass: 'choice'});
        }

        function addCompetency( element ) {
            if( $("#competency").length > 0 ) {
                if( $(".modal-footer .error").length == 0 )
                    $(".modal-footer").prepend( '<label id="ruleTitle-error" class="error">You already have one Competency rule.</label>' );
                return false;
            }
            var id = element.attr("data-id");
            var html = $("#competencyTemplate").html( );
            html = html.replace(/\{id\}/g, id );
            html = html.replace(/\{template\}/g, "" );
            $("#criteriaRow_" + id).after( '<div id="criteriaSet_' + id + '" class="col-md-9">' + html + '</div>' );

            // Use Bloodhound engine
            var engine = new Bloodhound({
                remote: {
                    url: Aurora.ROOT_URL + 'admin/competency/getCompetency/%QUERY',
                    wildcard: '%QUERY',
                    filter: function (response) {
                        var tokens = $("#competency").tokenfield("getTokens");

                        return $.map( response, function( d ) {
                            var exists = false;
                            for( var i=0; i<tokens.length; i++ ) {
                                if( d.competency === tokens[i].label ) {
                                    exists = true;
                                    break;
                                }
                            }
                            if( !exists )
                                return { value: d.competency, id: d.cID }
                        });
                    }
                },
                datumTokenizer: function(d) {
                    return Bloodhound.tokenizers.whitespace(d.value);
                },
                queryTokenizer: Bloodhound.tokenizers.whitespace
            });

            // Initialize engine
            engine.initialize();

            // Initialize tokenfield
            $("#competency").tokenfield({
                delimiter: ';',
                typeahead: [null, {
                    displayKey: 'value',
                    highlight: true,
                    source: engine.ttAdapter()
                }]
            });

            var $invoker = $("#criteriaSet_" + id);
            var position = $invoker.position( );
            var width = $invoker.find(".col-md-11").width( );

            var multiContainer = $(".tt-menu");
            multiContainer.appendTo("#multi-select-wrapper");
            multiContainer.css( "top", (position.top+71) + "px" );
            multiContainer.css( "left", "29px" );
            multiContainer.css( "width", width + "px" );

            $("#competency").on('tokenfield:createtoken', function (e) {
                var height = parseInt( $(".tokenfield").height( ) );
                multiContainer.css( "top", (position.top+68+height) + "px" );
            });
        }

        $("#modalTaxGroup").on("shown.bs.modal", function(e) {
            $("#groupTitle").focus( );
        });

        $("#modalTaxGroup").on("show.bs.modal", function(e) {
            var $invoker = $(e.relatedTarget);
            var tgID = $invoker.attr("data-id");

            if( tgID ) {
                var data = {
                    bundle: {
                        tgID: tgID
                    },
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if( obj.bool == 0 ) {
                            swal("error", obj.errMsg);
                            return;
                        }
                        else {
                            $("#modalTaxGroup .modal-title").text("Edit Tax Group");
                            $("#tgID").val( obj.data.tgID );
                            $("#office").val( obj.data.officeID ).trigger("change");
                            $("#groupTitle").val( obj.data.title );
                            $("#groupDescription").val( obj.data.descript );
                            $("#parent").val( obj.data.parent ).trigger("change");

                            if( obj.data.selectable == 1 ) {
                                $("#selectable").prop("checked", true).parent( ).addClass("checked");
                            }
                            else {
                                $("#selectable").prop("checked", false).parent( ).removeClass("checked");
                            }
                            if( obj.data.summary == 1 ) {
                                $("#summary").prop("checked", true).parent( ).addClass("checked");
                            }
                            else {
                                $("#summary").prop("checked", false).parent( ).removeClass("checked");
                            }
                        }
                    }
                }
                Aurora.WebService.AJAX( "admin/payroll/getTaxGroup/" + tgID, data );
            }
            else {
                $("#modalTaxGroup .modal-title").text("Create New Tax Group");
                $("#tgID").val(0);
                $("#office").val("").trigger("change");
                $("#groupTitle").val("");
                $("#groupDescription").val("");
                $("#parent").val(0).trigger("change");
                $("#selectable").prop("checked", false).parent( ).removeClass("checked");
                $("#summary").prop("checked", false).parent( ).removeClass("checked");
            }
        });

        $("#saveTaxGroup").validate({
            rules: {
                groupTitle: { required: true }
            },
            messages: {
                groupTitle: "Please enter a Group Title."
            },
            submitHandler: function( ) {
                var tgID = $("#tgID").val( );

                var data = {
                    bundle: {
                        tgID: tgID,
                        office: $("#office").val( ),
                        groupTitle: $("#groupTitle").val( ),
                        groupDescription: $("#groupDescription").val( ),
                        parent: $("#parent").val( ),
                        selectable: $("#selectable").is(':checked') ? 1 : 0,
                        summary: $("#summary").is(':checked') ? 1 : 0
                    },
                    success: function( res ) {
                        var obj = $.parseJSON( res );
                        if( obj.bool == 0 ) {
                            swal("error", obj.errMsg);
                            return;
                        }
                        else {
                            refreshGroupList( );

                            if( tgID != 0 ) {
                                $("#groupTitle_" + tgID).html( obj.data.title );
                                $("#groupDescription_" + tgID).html( obj.data.descript );
                                $("#group_" + tgID).appendTo( $("#item-" + obj.data.parent) );
                                swal("Done!", obj.data.title + " has been successfully updated!", "success");
                                $("#modalTaxGroup").modal('hide');
                            }
                            else {
                                var data = {
                                    success: function(res) {
                                        var obj2 = $.parseJSON(res);

                                        if( obj2.bool == 0 ) {
                                            swal( "error", obj2.errMsg );
                                            return;
                                        }
                                        if( obj.data.parent == 0 ) {
                                            $(".list-group-root").append( obj2.html );
                                        }
                                        else {

                                            $("#item-" + obj.data.parent).append( obj2.html );
                                            $("#expandIcon_" + obj.data.parent).show( );
                                        }
                                        $(".blankCanvasNotice").hide( );

                                        swal({
                                            title: obj.data.title + " has been successfully created!",
                                            text: "What do you want to do next?",
                                            type: 'success',
                                            confirmButtonClass: 'btn btn-success',
                                            cancelButtonClass: 'btn btn-danger',
                                            buttonsStyling: false,
                                            showCancelButton: true,
                                            confirmButtonText: "Create Another Tax Group",
                                            cancelButtonText: "Close Window",
                                            reverseButtons: true
                                        }, function (isConfirm) {
                                            if( isConfirm === false ) {
                                                $("#modalTaxGroup").modal('hide');
                                            }
                                            else {
                                                $("#groupTitle").val("");
                                                $("#groupDescription").val("");
                                                $("#parent").val(0).trigger("change");

                                                setTimeout(function() {
                                                    $("#groupTitle").focus( );
                                                }, 500);
                                            }
                                        });
                                    }
                                }
                                Aurora.WebService.AJAX("admin/payroll/getTaxGroup/" + obj.data.tgID + "/html", data);
                            }
                        }
                    }
                };
                Aurora.WebService.AJAX( "admin/payroll/saveTaxGroup", data );
            }
        });

        $("#modalTaxRule").on("shown.bs.modal", function(e) {
            $("#ruleTitle").focus( );
        });

        $("#modalTaxRule").on("show.bs.modal", function(e) {
            if( $("#gender1").length > 0 ) {
                $.uniform.restore(".gender");
            }
            $("#rulesWrapper").html("");
            addCriteria( );

            var $invoker = $(e.relatedTarget);
            var trID = $invoker.attr("data-id");

            if( trID ) {
                var data = {
                    bundle: {
                        trID: trID
                    },
                    success: function(res) {
                        var obj = $.parseJSON(res);
                        if( obj.bool == 0 ) {
                            swal("error", obj.errMsg);
                            return;
                        }
                        else {
                            $("#modalTaxRule .modal-title").text("Edit Tax Rule");
                            $("#trID").val( obj.data.trID );
                            $("#ruleTitle").val( obj.data.title );
                            $("#group").val( obj.data.tgID ).trigger("change");
                            $("#country").val( obj.data.countryID ).trigger("change");
                            $("#applyType").val( obj.data.applyType ).trigger("change");
                            $("#applyValueType").val( obj.data.applyValueType ).trigger("change");
                            $("#applyValue").val( obj.data.applyValue );
                            $("#applyCapped").val( obj.data.applyCapped );

                            var criteria=0;

                            if( obj.data.computing ) {
                                for( var i=0; i<obj.data.computing.length; i++ ) {
                                    if( criteria > 0 ) {
                                        addCriteria( );
                                    }
                                    $("#criteria_" + criteria).val( obj.data.computing[i]["criteria"] ).trigger("change");
                                    $("#tcID_" + criteria).val( obj.data.computing[i]["tcID"] );
                                    $("#computing_" + criteria).val( obj.data.computing[i]["computing"] ).trigger("change");
                                    $("#valueType_" + criteria).val( obj.data.computing[i]["valueType"] ).trigger("change");
                                    $("#value_" + criteria).val( obj.data.computing[i]["value"] );
                                    criteria++;
                                }
                            }

                            if( obj.data.payItem ) {
                                for( var i=0; i<obj.data.payItem.length; i++ ) {
                                    if( criteria > 0 ) {
                                        addCriteria( );
                                    }
                                    $("#criteria_" + criteria).val( "payItem" ).trigger("change");
                                    $("#payItem_" + criteria).val( obj.data.payItem[i]["piID"] ).trigger("change");
                                    $("#valueType_" + criteria).val( obj.data.payItem[i]["valueType"] ).trigger("change");
                                    $("#value_" + criteria).val( obj.data.payItem[i]["value"] );
                                    criteria++;
                                }
                            }

                            if( obj.data.competency && obj.data.competency.length > 0 ) {
                                if( criteria > 0 ) {
                                    addCriteria( );
                                }
                                $("#criteria_" + criteria).val("competency").trigger("change");

                                var competency = "";
                                for( var i=0; i<obj.data.competency.length; i++ ) {
                                    competency += obj.data.competency[i]["competency"] + ";";
                                }
                                $("#competency").val( competency ).trigger('change');
                                criteria++;
                            }

                            if( obj.data.contract && obj.data.contract.length > 0 ) {
                                for( var i=0; i<obj.data.contract.length; i++ ) {
                                    if( criteria > 0 ) {
                                        addCriteria( );
                                    }
                                    $("#criteria_" + criteria).val("contract").trigger("change");

                                    for( var i=0; i<obj.data.contract.length; i++ ) {
                                        $("#contract").multiselect( "select", obj.data.contract[i]["contractID"] );
                                    }
                                    criteria++;
                                }
                            }

                            if( obj.data.designation && obj.data.designation.length > 0 ) {
                                for( var i=0; i<obj.data.designation.length; i++ ) {
                                    if( criteria > 0 ) {
                                        addCriteria( );
                                    }
                                    $("#criteria_" + criteria).val("designation").trigger("change");

                                    for( var i=0; i<obj.data.designation.length; i++ ) {
                                        $("#designation").multiselect( "select", obj.data.designation[i]["designationID"] );
                                    }
                                    criteria++;
                                }
                            }

                            if( obj.data.race && obj.data.race.length > 0 ) {
                                if( criteria > 0 ) {
                                    addCriteria( );
                                }
                                $("#criteria_" + criteria).val("race").trigger("change");

                                for( var i=0; i<obj.data.race.length; i++ ) {
                                    $("#race").multiselect( "select", obj.data.race[i]["raceID"] );
                                }
                                criteria++;
                            }

                            if( obj.data.gender && obj.data.gender.length > 0 ) {
                                if( criteria > 0 ) {
                                    addCriteria( );
                                }
                                $("#criteria_" + criteria).val("gender").trigger("change");
                                $("input[name=gender][value=" + obj.data.gender[0]["gender"] + "]").prop('checked', true);
                                $.uniform.update("input[name=gender]");
                                criteria++;
                            }
                        }
                    }
                }
                Aurora.WebService.AJAX( "admin/payroll/getTaxRule/" + trID, data );
            }
            else {
                $("#modalTaxRule .modal-title").text("Create New Tax Rule");
                $("#trID").val(0);
                $("#ruleTitle").val("");
                $("#group").val(0).trigger("change");
                $("#country").val("").trigger("change");
                $("#applyType").val("deductionOR").trigger("change");
                $("#applyValueType").val("percentage").trigger("change");
                $("#applyValue").val("");
                $("#applyCapped").val("");
            }
        });

        $("#saveTaxRule").validate({
            rules: {
                ruleTitle: { required: true }
            },
            messages: {
                ruleTitle: "Please enter a Rule Title."
            },
            highlight: function(element, errorClass) {
                $(element).addClass("border-danger");
            },
            unhighlight: function(element, errorClass) {
                $(element).removeClass("border-danger");
                $(".modal-footer .error").remove();
            },
            // Different components require proper error label placement
            errorPlacement: function(error, element) {
                if( $(".modal-footer .error").length == 0 )
                    $(".modal-footer").append(error);
            },
            submitHandler: function( ) {
                var count = $(".criteria").length;
                var found = false;

                for( var i=0; i<count; i++ ) {
                    if( $("#criteria_" + i).val( ) ) {
                        found = true;
                        break;
                    }
                }
                if( !found ) {
                    $(".modal-footer").prepend( '<label id="ruleTitle-error" class="error">Please provide at least one set of criteria.</label>' );
                }
                else {
                    var formData = Aurora.WebService.serializePost("#saveTaxRule");

                    var data = {
                        bundle: {
                            data: formData
                        },
                        success: function( res ) {
                            var obj = $.parseJSON( res );
                            if( obj.bool == 0 ) {
                                swal("error", obj.errMsg);
                                return;
                            }
                            else {
                                var data = {
                                    success: function( res ) {
                                        var obj2 = $.parseJSON( res );
                                        if( obj2.bool == 0 ) {
                                            swal("error", obj2.errMsg);
                                            return;
                                        }
                                        if( $("#trID").val( ) > 0 ) {
                                            $("#taxRow_" + $("#trID").val( )).replaceWith( obj2.html );

                                            if( obj.data.group == 0 ) {
                                                $("#taxRow_" + $("#trID").val( )).appendTo( $(".list-group-root") );
                                            }
                                            else {
                                                $("#taxRow_" + $("#trID").val( )).appendTo( $("#item-" + obj.data.group) );
                                            }
                                        }
                                        else {
                                            if( obj.data.group == 0 ) {
                                                $(".list-group-root").append( obj2.html );
                                            }
                                            else {
                                                $("#item-" + obj.data.group).append( obj2.html );
                                                $("#expandIcon_" + obj.data.group).show( );
                                            }
                                            $(".blankCanvasNotice").hide( );
                                        }

                                        swal({
                                            title: $("#ruleTitle").val( ) + " has been successfully created!",
                                            text: "What do you want to do next?",
                                            type: 'success',
                                            confirmButtonClass: 'btn btn-success',
                                            cancelButtonClass: 'btn btn-danger',
                                            buttonsStyling: false,
                                            showCancelButton: true,
                                            confirmButtonText: "Create Another Tax Rule",
                                            cancelButtonText: "Close Window",
                                            reverseButtons: true
                                        }, function( isConfirm ) {
                                            if( isConfirm === false ) {
                                                $("#modalTaxRule").modal('hide');
                                            }
                                            else {
                                                setTimeout(function() {
                                                    $("#ruleTitle").focus( );
                                                }, 500);
                                            }
                                        });
                                    }
                                }
                                Aurora.WebService.AJAX( "admin/payroll/getTaxRule/" + obj.data.trID + "/html", data );
                            }
                        }
                    };
                    Aurora.WebService.AJAX( "admin/payroll/saveTaxRule", data );
                }
            }
        });
    });
</script>