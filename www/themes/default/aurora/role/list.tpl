<script>

 $(document).ready( function( ) {

     $(".deleteRoleMenu:first").prev( ).remove( );
     $(".deleteRoleMenu:first").remove( );

     $(document).on("click", ".definePerm", function (e) {
         var roleID = $(this).attr("href");

         $("#roleID").val( roleID );
         getPerms( roleID );
         $(".open").parent().click();

         $('html, body').animate({
             scrollTop: $("#permListTable").offset().top-90
         }, 1000);
         return false;
     });


     $("#modal_role").on("show.bs.modal", function( e ) {
         var roleID = $(e.relatedTarget).attr("data-roleID");

         if( roleID == 0 ) {
             $(".modal-title").text( "Create New Role" );
         }
         else {
             $(".modal-title").text( "Edit Existing Role" );
         }

         $(this).find(".modal-body").load(Aurora.ROOT_URL + 'admin/role/roleForm/' + roleID, function() {

             $("#modal_role").on("shown.bs.modal", function() {
                 $("#roleTitle").focus();

                 $("#userRole-validate").validate({
                     rules: {
                         roleTitle: { required: true }
                     },
                     messages: {
                         roleTitle: "Please enter a Role Title" //Aurora.i18n.LoginRes.LANG_ENTER_VALID_EMAIL
                     },
                     submitHandler: function( ) {
                         var data = {
                             bundle: {
                                 "editRoleID": $("#editRoleID").val( ),
                                 "roleTitle": $("#roleTitle").val( ),
                                 "roleDescript": $("#roleDescript").val( )
                             },
                             success: function( res ) {
                                 var obj = $.parseJSON( res );

                                 if( obj.bool == 0 ) {
                                     alert(obj.errMsg);
                                 }
                                 else {
                                     if( $("#editRoleID").val( ) == 0 ) {
                                         var lastRow = $("#roleTable tr:last").clone();
                                         lastRow.find(".roleTitle").text(obj.roleTitle);
                                         lastRow.find(".roleDescript").text(obj.roleDescript);
                                         lastRow.find(".roleTitle").attr("id", "roleTitle" + obj.roleID);
                                         lastRow.find(".roleDescript").attr("id", "roleDescript" + obj.roleID);
                                         lastRow.find(".definePerm").attr("href", obj.roleID);
                                         lastRow.find(".editRole").attr("data-roleID", obj.roleID);
                                         lastRow.find(".deleteRole").attr("href", obj.roleID);


                                         $("#roleTable tbody").append(lastRow);
                                     }
                                     else {
                                         $("#roleTitle" + obj.roleID).text( obj.roleTitle );
                                         $("#roleDescript" + obj.roleID).text( obj.roleDescript );
                                     }
                                 }
                                 $("#roleTitle").val("");
                                 $("#roleDescript").val("");
                                 $("#modal_role").modal("hide");
                             }
                         };
                         Aurora.WebService.AJAX( "admin/role/saveRole", data );
                     }
                 });
             });
         });
     });

     $("#saveAll").click(function( ) {
         var checked = []
         $(".switch:checked").each(function( ) {
             checked.push(parseInt($(this).val()));
         });

         var data = {
             bundle: {
                 "roleID": $("#roleID").val( ),
                 "perms": checked
             },
             success: function( res ) {
                 swal("Done!", "Permissions saved!", "success");
             }
         };
         Aurora.WebService.AJAX( "admin/rolePerm/savePerms", data );
     });

     function getPerms( roleID ) {
         var data = {
             bundle: {
                 "roleID": roleID
             },
             success: function( res ) {
                 $("#defineTitle").text( $("#roleTitle" + roleID).text( ) );

                 var perms = $.parseJSON( res );

                 $(".switch").bootstrapSwitch('disabled',false);
                 $(".switch").bootstrapSwitch('state', false);
                 $.each(perms, function(index, value) {
                     $("#perm_" + value['permID']).bootstrapSwitch('state', true);
                 });

                 if( roleID == 1 ) {
                     $(".switch").bootstrapSwitch('disabled',true);
                 }
             }
         };
         Aurora.WebService.AJAX( "admin/rolePerm/getPerms", data );
     }

     getPerms(1);

     $(document).on("click", ".deleteRole", function (e) {
         var roleID = $(this).attr("href");
         var roleTitle = $("#roleTitle" + roleID).text( );

         swal({
             title: "Are you sure you want to delete the role: " + roleTitle + "?",
             text: "This action is irreversible and all permission settings related to this role will be lost!",
             type: "warning",
             showCancelButton: true,
             confirmButtonColor: "#DD6B55",
             confirmButtonText: "Confirm Delete",
             closeOnConfirm: false
         }, function (isConfirm) {
             if (!isConfirm) return;

             var data = {
                 bundle: {
                     "roleID": roleID,
                 },
                 success: function (res) {
                     var obj = $.parseJSON(res);
                     if (obj.bool == 0) {
                         alert(obj.errMsg);
                         return;
                     }
                     else {
                         $("#roleRow" + roleID).fadeOut("slow");
                         swal("Done!", roleTitle + " has been successfully deleted!", "success");
                         return;
                     }
                 }
             };
             Aurora.WebService.AJAX("admin/rolePerm/delete", data);
         });
         return false;
     });
 });
</script>

<div class="panel panel-flat">
    <div class="panel-heading">

        <div class="row">
            <div class="col-md-2 col-md-push-10">
                <div class="text-center">
                    <ul class="icons-list">
                        <li>
                            <button type="button" class="btn bg-purple-400 btn-labeled" data-roleID="0" data-toggle="modal" data-target="#modal_role">
                                <b><i class="icon-reading"></i></b> Create New Role
                            </button>
                        </li>
                    </ul>
                </div></div>
            <div class="col-md-10 col-md-pull-2"><div>
                    The following are the list of Roles available in your system. Click on the Action button to define each Role's permissions
                    to your preference.
                </div>
            </div>
        </div>


    </div>

    <div class="panel-body">

        <table id="roleTable" class="table" style="margin-bottom: 50px;">
            <thead>
            <tr>
                <th class="col-lg-2">Role Name</th>
                <th>Descriptions</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <!-- BEGIN DYNAMIC BLOCK: roleList -->
            <tr id="roleRow<?TPLVAR_ROLE_ID?>">
                <td id="roleTitle<?TPLVAR_ROLE_ID?>" class="roleTitle"><?TPLVAR_ROLE_TITLE?></td>
                <td id="roleDescript<?TPLVAR_ROLE_ID?>" class="roleDescript"><?TPLVAR_ROLE_DESCRIPT?></td>
                <td class="text-center"><ul class="action icons-list">
                        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-menu9"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="#" class="editRole" data-roleID="<?TPLVAR_ROLE_ID?>" data-toggle="modal" data-target="#modal_role"><i class="icon-pencil5"></i> Edit Role</a></li>
                                <li><a href="<?TPLVAR_ROLE_ID?>" class="definePerm"><i class="icon-checkbox-checked"></i> Define Permissions</a></li>
                                <li class="divider"></li>
                                <li class="deleteRoleMenu"><a href="<?TPLVAR_ROLE_ID?>" class="deleteRole"><i class="icon-trash"></i> Delete Role</a></li>
                            </ul>
                        </li>
                    </ul></td>
            </tr>
            <!-- END DYNAMIC BLOCK: roleList -->
            </tbody>
        </table>

        <div id="permListTable" class="tabbable">
            <ul class="nav nav-tabs nav-tabs-highlight">
                <li class="active"><a href="#highlighted-tab1" data-toggle="tab">Define Permissions (<strong id="defineTitle"></strong>)</a></li>
                <!--<li><a href="#highlighted-tab2" data-toggle="tab">Positions Management</a></li>-->
            </ul>

            <div class="tab-content">
                <input type="hidden" id="roleID" value="1" />
                <div class="tab-pane active" id="highlighted-tab1">


                    <table class="table">
                        <thead>
                        <tr>
                            <th class="col-lg-3">Type</th>
                            <th class="col-lg-8">Description</th>
                            <th class="col-lg-1">Permission</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?TPL_PERM_LIST?>
                        </tbody>
                    </table>
                    <div class="text-right" style="margin-top:30px;margin-right:28px;">
                        <button type="button" class="btn btn-primary">Reset To Previous &nbsp; <i class="icon-undo ml-2"></i></button> &nbsp; &nbsp; &nbsp;
                        <button type="button" id="saveAll" class="btn btn-primary">Save All Permissions &nbsp;&nbsp; <i class="icon-paperplane ml-2"></i></button>
                    </div>

                </div>

                <div class="tab-pane" id="highlighted-tab2">
                    Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid laeggin.
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modal_role" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-med">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

            </div>
        </div>
    </div>
</div>