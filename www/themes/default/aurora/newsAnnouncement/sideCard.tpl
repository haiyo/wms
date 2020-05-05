<div class="card">
    <div class="card-header bg-transparent header-elements-inline">
        <span class="dashboard-header text-uppercase font-size-sm font-weight-semibold">News &amp; Announcement &nbsp;-&nbsp;
            <a href="<?TPLVAR_ROOT_URL?>admin/newsAnnouncement/list">Manage</a></a>
        </span>
    </div>

    <div class="card-body">
        <ul class="media-list">
            <!-- BEGIN DYNAMIC BLOCK: noList -->
            <li class="media media-list-body">
                <div class="media-body text-muted">
                    <?LANG_NO_NEWS_OR_ANNOUNCEMENT?>
                </div>
            </li>
            <!-- END DYNAMIC BLOCK: noList -->
            <!-- BEGIN DYNAMIC BLOCK: list -->
            <li class="media media-list-body">
                <div class="mr-5 mt-5 position-relative">
                    <i class="mi-<?TPLVAR_ICO?> mi-2x"></i>
                </div>

                <div class="media-body">
                    <div class="d-flex justify-content-between"><?TPLVAR_DATE?></div>
                    <a data-id="<?TPLVAR_NAID?>" data-toggle="modal" data-target="#modalContent"><?TPLVAR_TITLE?></a>
                </div>
            </li>
            <!-- END DYNAMIC BLOCK: list -->
        </ul>
    </div>
</div>