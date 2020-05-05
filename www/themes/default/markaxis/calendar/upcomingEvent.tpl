<div class="card">
    <div class="card-header bg-transparent header-elements-inline">
                    <span class="dashboard-header text-uppercase font-size-sm font-weight-semibold">Upcoming Events &nbsp;-&nbsp;
                        <a href="<?TPLVAR_ROOT_URL?>admin/calendar">View Calendar</a></a>
                    </span>
    </div>

    <div class="card-body">
        <ul class="media-list">
            <!-- BEGIN DYNAMIC BLOCK: noEvent -->
            <li class="media media-list-body">
                <div class="media-body text-muted">
                    <?LANG_NO_UPCOMING_EVENT?>
                </div>
            </li>
            <!-- END DYNAMIC BLOCK: noEvent -->
            <!-- BEGIN DYNAMIC BLOCK: event -->
            <li class="media media-list-body">
                <div class="mr-3 mt-5 position-relative">
                    <i class="mi-event-note mi-2x"></i>
                </div>

                <div class="media-body">
                    <div class="d-flex justify-content-between">
                        <a href="#"><?TPLVAR_DATE?></a>
                    </div>
                    <?TPLVAR_TITLE?>
                </div>
            </li>
            <!-- END DYNAMIC BLOCK: event -->
        </ul>
    </div>
</div>