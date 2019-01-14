
<script>
    $(function() {
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,basicWeek,basicDay'
            },
            defaultDate: '2018-03-12',
            navLinks: true, // can click day/week names to navigate views
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: [
                {
                    title: 'All Day Event',
                    start: '2018-03-01'
                },
                {
                    title: 'Long Event',
                    start: '2018-03-07',
                    end: '2018-03-10'
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: '2018-03-09T16:00:00'
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: '2018-03-16T16:00:00'
                },
                {
                    title: 'Conference',
                    start: '2018-03-11',
                    end: '2018-03-13'
                },
                {
                    title: 'Meeting',
                    start: '2018-03-12T10:30:00',
                    end: '2018-03-12T12:30:00'
                },
                {
                    title: 'Lunch',
                    start: '2018-03-12T12:00:00'
                },
                {
                    title: 'Meeting',
                    start: '2018-03-12T14:30:00'
                },
                {
                    title: 'Happy Hour',
                    start: '2018-03-12T17:30:00'
                },
                {
                    title: 'Dinner',
                    start: '2018-03-12T20:00:00'
                },
                {
                    title: 'Birthday Party',
                    start: '2018-03-13T07:00:00'
                },
                {
                    title: 'Click for Google',
                    url: 'http://google.com/',
                    start: '2018-03-28'
                }
            ]
        });
    });
</script>
<style>
    @media (min-width: 768px) {
        .justify-content-md-center {
            -ms-flex-pack: center !important;
            justify-content: center !important;
        }
    }
    .sidebar-light {
        background-color: #fff;
        color: #333;
        border-right: 1px solid rgba(0,0,0,.125);
        background-clip: content-box;
    }
    .sidebar-component {
        border: 1px solid transparent;
        border-radius: .1875em;
        box-shadow: 0 1px 2px rgba(0,0,0,.05);
    }
    .sidebar-component.sidebar-light {
        border-color: rgba(0,0,0,.125);
    }
    .sidebar:not(.bg-transparent) .card {
        border-width: 0;
        margin-bottom: 0;
        border-radius: 0;
        box-shadow: none;
    }
    .sidebar:not(.bg-transparent) .card:not([class*=bg-]):not(.fixed-top) {
        background-color: transparent;
    }
    .card-header {
        padding: .9375rem 1.25em;
        margin-bottom: 0;
        background-color: rgba(0,0,0,.02);
        border-bottom: 1px solid rgba(0,0,0,.125);
    }
    .header-elements-inline {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        -ms-flex-pack: justify;
        justify-content: space-between;
        -ms-flex-wrap: nowrap;
        flex-wrap: nowrap;
    }
    .card-header:first-child {
        border-radius: .125em .125em 0 0;
    }
    .form-group-feedback {
        position: relative;
    }
    .form-control-feedback {
        position: absolute;
        top: 0;
        color: #333;
        padding-left: .875em;
        padding-right: .875em;
        line-height: 2.8em;
        min-width: 1rem;
    }
    .form-group-feedback-right .form-control-feedback {
        right: 0;
    }

    @media (min-width: 768px) {
        .sidebar-expand-md.sidebar-component-left {
            margin-right: 1.25em;
        }
    }
    @media (min-width: 768px) {
        .sidebar-expand-md.sidebar-component {
            display: block;
        }
    }
    .d-md-flex .sidebar {
        -ms-flex: 0 0 auto;
        flex: 0 0 auto;
        width:320px;
    }
    .col-6 {
        -ms-flex: 0 0 50%;
        flex: 0 0 50%;
        max-width: 50%;
    }
    .row {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: -.625em;
        margin-left: -.625em;
    }
    .row-tile div[class*=col]+div[class*=col] .btn {
        border-left: 0;
    }
    .no-gutters {
        margin-right: 0 !important;
        margin-left: 0 !important;
    }
    .no-gutters>.col, .no-gutters>[class*=col-] {
        padding-right: 0 !important;
        padding-left: 0 !important;
    }
    .row-tile div[class*=col] .btn {
        border-radius: 0;
    }
    .row-tile div[class*=col]:first-child .btn:first-child {
        border-top-left-radius: .1875em;
    }
    .nav-sidebar .nav-item-header {
        padding: .75em 2.9em;
        margin-top: .5em;
    }
    .sidebar-light .nav-sidebar .nav-item-header {
        color: rgba(51,51,51,.5);
    }
    .nav {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        padding-left: 0;
        margin-bottom: 0;
        list-style: none;
    }
    .nav-sidebar {
        -ms-flex-direction: column;
        flex-direction: column;
    }
    .nav-sidebar .nav-item:not(.nav-item-divider) {
        margin-bottom: 1px;
    }
    .nav-sidebar .nav-link {
        position: relative;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: start;
        align-items: flex-start;
        padding:.75em 2.9em;
        transition: background-color ease-in-out .15s,color ease-in-out .15s;
    }
    .nav-sidebar>.nav-item>.nav-link {
        font-weight: 500;
    }
    .sidebar-light .nav-sidebar .nav-link {
        color: rgba(51,51,51,.85);
    }
    .nav-sidebar .nav-link i {
        margin-right: 1.25em;
        margin-top: .12502em;
        margin-bottom: .12502em;
        top: 0;
    }
    .p-0 {
        padding: 0!important;
    }
    .mb-2, .my-2 {
        margin-bottom:1.625em!important;
    }
    .rounded-round {
        border-radius: 100px!important;
    }
    .form-control-datepicker {
        margin-top:20px;
    }
</style>
<script>
    $(document).ready(function( ) {
        $('.form-control-datepicker').datepicker();
    });
</script>
<div class="d-md-flex">
    <div class="sidebar sidebar-light sidebar-component sidebar-component-left sidebar-expand-md">

        <!-- Sidebar content -->
        <div class="sidebar-content">

            <!-- Sidebar search -->
            <div class="card">
                <div class="card-header bg-transparent header-elements-inline">
                    <span class="text-uppercase font-size-sm font-weight-semibold">Event search</span>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="#">
                        <div class="form-group-feedback form-group-feedback-right">
                            <input type="search" class="form-control" placeholder="Search">
                            <div class="form-control-feedback">
                                <i class="icon-search4 font-size-base text-muted"></i>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /sidebar search -->


            <!-- Sub navigation -->
            <div class="card mb-2">
                <div class="card-header bg-transparent header-elements-inline">
                    <span class="text-uppercase font-size-sm font-weight-semibold">View Event Types</span>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <ul class="nav nav-sidebar" data-nav-type="accordion">
                        <li class="nav-item-header"></li>
                        <li class="nav-item">
                            <a href="#" class="nav-link"><i class="icon-files-empty"></i> View Only My Events</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="icon-file-plus"></i>
                                Colleague Events
                                <span class="badge bg-dark badge-pill ml-auto">28</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link"><i class="icon-file-check"></i> Include Birthdays</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="icon-reading"></i>
                                Include Holidays
                                <span class="badge bg-info badge-pill ml-auto">86</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="icon-make-group"></i>
                                Sync from Google Cal
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /sub navigation -->

        </div>
        <!-- /sidebar content -->

    </div>


    <div class="panel panel-flat" style="width:100%;border-bottom:0px;">
        <div class="panel-heading" style="padding-top:0px;">
            <!--<h5 class="panel-title">Employee List<a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>-->
        </div>

        <div id="calendar"></div>


    </div>

</div>