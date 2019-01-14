<fieldset>
    <legend class="text-semibold">Personal Information</legend>

    <div class="row">
        <div class="col-md-3">
            <label>First Name: <span class="text-danger-400">*</span></label>
            <input type="text" name="fname" id="fname" placeholder="Julia" class="form-control" value="<?TPLVAR_FNAME?>" />
        </div>

        <div class="col-md-3">
            <label>Last Name: <span class="text-danger-400">*</span></label>
            <input type="text" name="lname" id="lname" placeholder="Koh" class="form-control" value="<?TPLVAR_LNAME?>" />
        </div>

        <div class="col-md-3">
            <label>SSN / NRIC:</label>
            <input type="text" name="nric" id="nric" placeholder="0000000001" class="form-control" value="<?TPLVAR_NRIC?>" />
        </div>

        <div class="col-md-3">
            <label>Nationality:</label>
            <?TPL_NATIONALITY_LIST?>
        </div>

    </div>

    <div class="row">
        <div class="col-md-3">
            <label>Email Address (Primary): <span class="text-danger-400">*</span></label>
            <input type="text" name="email1" id="email1" class="form-control" placeholder="julia@email.com" value="<?TPLVAR_EMAIL1?>" />
        </div>

        <div class="col-md-3">
            <label>Email Address (Secondary):</label>
            <input type="email" name="email2" id="email2" class="form-control" placeholder="julia@email.com" value="<?TPLVAR_EMAIL2?>" />
        </div>

        <div class="col-md-6">
            <label>Date of Birth:</label>
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
                        <input type="number" name="dobYear" class="form-control" placeholder="Year" value="<?TPLVAR_DOB_YEAR?>" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <label>Home / Office Phone:</label>
            <input type="text" class="form-control" name="phone" data-mask="(999) 999-9999" placeholder="Enter phone #" value="<?TPLVAR_PHONE?>" />
        </div>

        <div class="col-md-3">
            <label>Mobile Phone:</label>
            <input type="text" class="form-control" name="mobile" data-mask="(999) 999-9999" placeholder="Enter phone #" value="<?TPLVAR_MOBILE?>" />
        </div>

        <div class="col-md-3" style="margin-right:20px;">
            <label>Country of Birth:</label>
            <?TPL_COUNTRY_LIST?>
        </div>

        <div class="col-md-2">
            <label class="display-block">Gender:</label>
            <?TPL_GENDER_RADIO?>
        </div>
    </div>


    <div class="row">

        <div class="col-md-3">
            <label>Address (Primary):</label>
            <input type="text" name="address1" placeholder="Ring street 12" class="form-control" value="<?TPLVAR_ADDRESS1?>" />
        </div>

        <div class="col-md-3">
            <label>Address (Secondary):</label>
            <input type="text" name="address2" placeholder="Ring street 12" class="form-control" value="<?TPLVAR_ADDRESS2?>" />
        </div>

        <div class="col-md-2">
            <label>Postal / ZIP Code:</label>
            <input type="number" name="postal" placeholder="520733" class="form-control" value="<?TPLVAR_POSTAL?>" />
        </div>

        <div class="col-md-2">
            <label>State:</label>
            <select name="state" data-placeholder="Select State" placeholder="Select State" id="state" class="form-control select ">
                <option value="">Select State</option>
            </select>
        </div>

        <div class="col-md-2">
            <label>City:</label>
            <select name="city" data-placeholder="Select City" placeholder="Select City" id="city" class="form-control select ">
                <option value="">Select City</option>
            </select>
        </div>

    </div>

    <div class="row">

        <div class="col-md-3">
            <label>Religion:</label>
            <?TPL_RELIGION_LIST?>
        </div>

        <div class="col-md-3">
            <label class="display-block">Race:</label>
            <?TPL_RACE_LIST?>
        </div>

        <div class="col-md-2">
            <label>Marital Status:</label>
            <?TPL_MARITAL_LIST?>
        </div>

        <div class="col-md-2">
            <label class="display-block">Have Children(s)?:</label>
            <?TPL_CHILDREN_RADIO?>
        </div>

    </div>


    <div id="haveChildren" class="row hide">
        <h6 class="mb-0 ml-10 font-weight-bold">Enter Children(s) Information:</h6>

        <div class="card">
            <div id="childWrapper" class="card-body">
                <!-- BEGIN DYNAMIC BLOCK: children -->
                <div id="childRowWrapper_<?TPLVAR_ID?>">
                    <div id="childRow_<?TPLVAR_ID?>" class="col-md-12 childRow">
                        <input type="hidden" id="ucID_<?TPLVAR_ID?>" name="ucID_<?TPLVAR_ID?>" value="<?TPLVAR_UCID?>" />
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Child's Full Name: <span class="text-danger-400">*</span></label>
                                <input type="text" name="childName_<?TPLVAR_ID?>" id="childName_<?TPLVAR_ID?>"
                                       placeholder="Child's Full Name" class="form-control" value="<?TPLVAR_CHILD_NAME?>" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Country of Birth: <span class="text-danger-400">*</span></label>
                                <?TPL_CHILD_COUNTRY?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label>Date of Birth:</label>
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
                                        <input type="number" name="childDobYear_<?TPLVAR_ID?>" class="form-control" placeholder="Year" value="<?TPLVAR_CHILD_YEAR?>" />
                                    </div>
                                </div>

                                <div class="col-md-1 addChildrenCol">
                                    <div class="form-group">
                                        <a href="<?TPLVAR_ID?>" class="removeChildren"><i id="plus_<?TPLVAR_ID?>" class="icon-minus-circle2"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END DYNAMIC BLOCK: children -->
            </div>
        </div>
    </div>

    <div id="childTemplate" class="hide">
        <div id="childRow_{id}" class="col-md-12 childRow">
            <input type="hidden" id="ucID_{id}" name="ucID_{id}" value="" />
            <div class="col-md-3">
                <div class="form-group">
                    <label>Child's Full Name: <span class="text-danger-400">*</span></label>
                    <input type="text" name="childName_{id}" id="childName_{id}" placeholder="Child's Full Name"
                           class="form-control" value="" />
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label>Country of Birth: <span class="text-danger-400">*</span></label>
                    <?TPL_CHILD_COUNTRY?>
                </div>
            </div>

            <div class="col-md-6">
                <label>Date of Birth:</label>
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
                            <input type="number" name="childDobYear_{id}" class="form-control" placeholder="Year" value="" />
                        </div>
                    </div>

                    <div class="col-md-1 addChildrenCol">
                        <div class="form-group">
                            <a href="{id}" class="addChildren"><i id="plus_{id}" class="icon-plus-circle2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <h6 class="mb-0 ml-10 font-weight-bold">HRMS Account Login:</h6>
        <input id="username" style="display:none" type="text" name="fakeusername" />
        <input id="password" style="display:none" type="password" name="fakepassword" />
        <div class="card">
            <div class="card-body">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Login Username:</label>
                        <input type="text" id="loginUsername" name="loginUsername" placeholder="juliakoh" class="form-control" value="<?TPLVAR_USERNAME?>" />
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Login Password:</label>
                        <div class="input-group">
                            <input type="password" id="loginPassword" name="loginPassword" class="form-control" autocomplete="new-password" />
                            <span class="input-group-append">
                                <button class="btn btn-light" type="button" id="showPwd"> <i class="icon-eye"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</fieldset>
<script>
    $(document).ready(function( ) {
        $(".childSelect").select2("destroy");

        // Editing with existing children
        if( $("#children1").is(":checked") ) {
            $("#haveChildren").removeClass("hide");
        }

        $('input:radio[name="children"]').change(function( ) {
            if( $(this).val( ) == 1 ) {
                $("#haveChildren").removeClass("hide");

                if( $("#childWrapper .childRow").length == 0 ) {
                    addChildren();
                }
            }
            else {
                if( !$("#haveChildren").hasClass("hide") ) {
                    $("#haveChildren").addClass("hide");
                }
            }
        });

        if( $(".childRow").length > 0 ) {
            addChildren();
        }

        function addChildren( ) {
            var length = $("#childWrapper .childRow").length;
            var child = $("#childTemplate").html( );
            child = child.replace(/\{id\}/g, length );
            $("#childWrapper").append( '<div id="childRowWrapper_' + length + '">' + child + "</div>" );
            $("#childCountry_" + length).select2( );
            $("#childDobMonth_" + length).select2( );
            $("#childDobDay_" + length).select2( );

            var id = $("#childWrapper .childRow").length-2;
            $("#plus_" + id).attr( "class", "icon-minus-circle2" );
            $("#plus_" + id).parent().attr( "class", "removeChildren" );
        }

        $(document).on( "click", ".addChildren", function ( ) {
            addChildren( );
            return false;
        });

        $(document).on( "click", ".removeChildren", function ( ) {
            var id = $(this).attr("href");
            $("#childRowWrapper_" + id).addClass("childRow").html("").hide();

            if( $("#childWrapper .childRow").length == 0 ) {
                $("#children2").click( );
                $.uniform.update();
            }
            return false;
        });
    });
</script>