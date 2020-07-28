<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

    <div class="menu_section">
        <ul class="nav side-menu">
            <li><a href="{{ route('main') }}"><i class="fa fa-dashboard"></i> میزکار </a></li>
            <li><a><i class="fa fa-key"></i> سریال‌ها <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('serial_create') }}">افزودن</a></li>
                    <li><a href="{{ route('serial_sb_serial') }}">همه</a></li>
                    <li><a href="{{ route('pdf') }}" target="_blank"> نسخه PDF </a></li>
                </ul>
            </li>
            <li><a><i class="fa fa-user"></i> مشتری‌ها <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('person_create') }}">افزودن</a></li>
                    <li><a href="{{ route('person_sb_name') }}">همه</a></li>
                </ul>
            </li>
            <li><a href="{{ route('report_created_at') }}"><i class="fa fa-table"></i> گزارشات </a></li>
        </ul>
    </div>
</div>
