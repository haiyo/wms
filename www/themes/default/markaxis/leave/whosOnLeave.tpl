<div class="card">
    <div class="card-header bg-transparent header-elements-inline">
        <span class="dashboard-header text-uppercase font-size-sm font-weight-semibold"><?LANG_WHOS_ON_LEAVE?></span>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-12 on-leave-header"><?LANG_TODAY?> <?TPLVAR_DAY?>
                <span class="badge bg-dark count-pill ml-5"><?TPLVAR_TODAY_COUNT?></span>
            </div>
            <div class="col-md-12">
                <ul class="media-list">
                    <!-- BEGIN DYNAMIC BLOCK: noUserToday -->
                    <li class="media text-muted">
                        <?LANG_NOT_TODAY?>
                    </li>
                    <!-- END DYNAMIC BLOCK: noUserToday -->
                    <!-- BEGIN DYNAMIC BLOCK: userToday -->
                    <li class="media">
                        <a href="#" class="mr-3 position-relative">
                            <img src="<?TPLVAR_PHOTO?>" width="48" height="48" class="rounded-circle" alt="">
                            <!--<span class="badge badge-info badge-pill badge-float border-2 border-white"></span>-->
                        </a>
                    </li>
                    <!-- END DYNAMIC BLOCK: userToday -->
                </ul>
            </div>
        </div>


        <div class="row mb-0">
            <div class="col-md-12 on-leave-header"><?LANG_TOMORROW?> <?TPLVAR_TOMORROW_DAY?>
                <span class="badge bg-dark count-pill ml-5"><?TPLVAR_TOMORROW_COUNT?></span>
            </div>
            <div class="col-md-12">
                <ul class="media-list">
                    <!-- BEGIN DYNAMIC BLOCK: noUserTomorrow -->
                    <li class="media text-muted">
                        <?LANG_NOT_TOMORROW?>
                    </li>
                    <!-- END DYNAMIC BLOCK: noUserTomorrow -->
                    <!-- BEGIN DYNAMIC BLOCK: userTomorrow -->
                    <li class="media">
                        <a href="#" class="mr-3 position-relative">
                            <img src="<?TPLVAR_PHOTO?>" width="48" height="48" class="rounded-circle" alt="">
                        </a>
                    </li>
                    <!-- END DYNAMIC BLOCK: userTomorrow -->
                </ul>
            </div>
        </div>
    </div>
</div>