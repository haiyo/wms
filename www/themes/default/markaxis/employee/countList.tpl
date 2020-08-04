
<div class="row">
    <div class="col-md-4">
        <img src="<?TPLVAR_IMAGE?>" width="150" />
    </div>
    <div class="col-md-8">
        <div class="mb-10">
            <h5 class="text-semibold no-margin">
                <?TPLVAR_FNAME?> <?TPLVAR_LNAME?>
            </h5>
            <div class="text-muted"><?TPLVAR_DESIGNATION?></div>
            <!-- BEGIN DYNAMIC BLOCK: deptName -->
            <div class="badge bg-green-600"><?TPLVAR_DEPARTMENT?></div>
            <!-- END DYNAMIC BLOCK: deptName -->
        </div>
        <div><i class="icon-mail5"></i> <?TPLVAR_EMAIL?></div>
        <!-- BEGIN DYNAMIC BLOCK: mobile -->
        <div><i class="icon-mobile"></i> <?TPLVAR_MOBILE?></div>
        <!-- END DYNAMIC BLOCK: mobile -->
    </div>
</div>