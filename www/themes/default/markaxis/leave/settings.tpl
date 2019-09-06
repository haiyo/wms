<style>
    .payroll-nav {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        padding-left: 0;
        margin-top:20px;
        margin-bottom: 0;
        list-style: none;
    }
    .nav-tabs .nav-item {
        margin-bottom: -1px;
        min-width: 150px;
        text-align: center;
    }
    .nav-justified .nav-item {
        -ms-flex-preferred-size: 0;
        flex-basis: 0;
        -ms-flex-positive: 1;
        flex-grow: 1;
        text-align: center;
    }
    .nav-link {
        display:block;
        padding: 9px 38px !important;
        position: relative;
        transition: all ease-in-out .15s;
        font-size:16px;
    }
    .nav-link.active {
        font-weight:500;
    }
    .nav-tabs .nav-link {
        border: 1px solid transparent;
        border-top-left-radius: .1875em;
        border-top-right-radius: .1875em;
    }

    nav-tabs-bottom .nav-link, .nav-tabs-highlight .nav-link, .nav-tabs-top .nav-link {
        position: relative;
    }
    .nav-tabs-highlight .nav-link {
        border-top-color: transparent;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
    .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
        color: #333;
        background-color: #fff;
        border-color: #ddd #ddd #fff;
    }
    .nav-tabs-bottom .nav-link:before, .nav-tabs-highlight .nav-link:before, .nav-tabs-top .nav-link:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        transition: background-color ease-in-out .15s;
    }
    .nav-tabs-highlight .nav-link:before {
        height: 2px;
        top: -1px;
        left: -1px;
        right: -1px;
    }
    .nav-tabs-highlight .nav-link.active:before {
        background-color: #2196f3;
    }
    .justify-content-center {
        -ms-flex-pack: center!important;
        justify-content: center!important;
    }
</style>

<ul class="nav nav-tabs nav-tabs-highlight payroll-nav justify-content-center">
    <li class="nav-item"><a href="#leaveTypeList" class="nav-link active" data-toggle="tab">Leave Types</a></li>
    <li class="nav-item"><a href="#holidayList" class="nav-link" data-toggle="tab">Holidays</a></li>
</ul>
<div class="tab-content">
    <?TPL_FORM?>
</div>