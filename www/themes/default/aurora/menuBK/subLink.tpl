<div class="dropdown-menu">
    <!-- BEGIN DYNAMIC BLOCK: dropdownLink -->
    <a href="<?TPLVAR_ROOT_URL?><?TPLVAR_URL?>" class="dropdown-item"><?LANG_LINK?></a>
    <!-- END DYNAMIC BLOCK: dropdownLink -->
    <?TPL_SUB_MENU?>
</div>


    <div class="dropdown-menu">
        <a href="#"><?LANG_LINK?><</a>

        <div class="dropdown-submenu">
            <a href="#" class="dropdown-item dropdown-toggle">Has child</a>

            <div class="dropdown-menu">
                <a href="#" class="dropdown-item">Third level</a>

                <div class="dropdown-submenu">
                    <a href="#" class="dropdown-item dropdown-toggle">Has child</a>
                    <div class="dropdown-menu">
                        <a href="#" class="dropdown-item">Fourth level</a>
                        <a href="#" class="dropdown-item">Fourth level</a>
                    </div>
                </div>
                <a href="#" class="dropdown-item">Third level</a>
            </div>
        </div>

        <a href="#" class="dropdown-item">Second level</a>
    </div>