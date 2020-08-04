
        <div class="col-sm-2">
            <div class="card userCard">
                <div class="card-img-actions">
                    <img class="card-img-top img-fluid" src="<?TPLVAR_PHOTO?>" alt="">
                </div>

                <div class="card-body text-center">
                    <h6 class="font-weight-semibold mb-0"><?TPLVAR_NAME?></h6>
                    <div class="text-muted cardDesignation"><?TPLVAR_DESIGNATION?></div>

                    <!-- BEGIN DYNAMIC BLOCK: deptName -->
                    <div class="badge bg-green-600"><?TPLVAR_DEPARTMENT?></div>
                    <!-- END DYNAMIC BLOCK: deptName -->

                    <!-- BEGIN DYNAMIC BLOCK: moreDeptName -->
                    <div class="badge bg-grey-600" data-toggle="tooltip" data-placement="top" data-html="true"
                         title="<?TPLVAR_MORE_DEPT?>">More Departments</div>
                    <!-- END DYNAMIC BLOCK: moreDeptName -->

                    <div class="d-block text-wrap contactText"><i class="icon-mail5"></i> <?TPLVAR_EMAIL?></div>

                    <!-- BEGIN DYNAMIC BLOCK: mobile -->
                    <div class="d-block text-wrap contactText"><i class="icon-mobile"></i> <?TPLVAR_MOBILE?></div>
                    <!-- END DYNAMIC BLOCK: mobile -->
                </div>
            </div>
        </div>