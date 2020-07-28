<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>

    <link rel="apple-touch-icon" sizes="57x57" href="/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <link href='https://cdn.fontcdn.ir/Font/Persian/Yekan/Yekan.css' rel='stylesheet' type='text/css'>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="fontiran.com:license" content="Y68A9">
    <link rel="icon" href="../build/images/favicon.ico" type="image/ico" />
    <title>فروشگاه {{ $setting->name }}</title>

    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/bootstrap-rtl.min.css" rel="stylesheet">

    <link href="/css/font-awesome.min.css" rel="stylesheet">

    <link href="/css/nprogress.css" rel="stylesheet">

    <link href="/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">

    <link href="/css/green.css" rel="stylesheet">

    <link href="/css/daterangepicker.css" rel="stylesheet">

    <link href="/css/custom.min.css" rel="stylesheet">
</head>
<style>

    body{
        font-family: Yekan
    }
    table.table tbody tr td,
    table.table thead tr th,
    table.table thead {
        border-left: 1px solid lightgray;
        border-right: 1px solid lightgray;
    }

    .btns{
        width: 100%;
        background-color: #0d86ff;
    }

</style>


<body class="nav-md">

@include('sweet::alert')
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col hidden-print">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="{{ route('person_sb_name') }}" class="site_title"><span>فروشگاه {{ $setting->name }}</span></a>

                </div>

                {{--Sidebar--}}
                @include('sidebar')

                <div class="sidebar-footer hidden-small">
                    <a href="{{ route('setting_name_edit', $setting->id) }}" data-toggle="tooltip" data-placement="top" title="تنظیمات">
                        <span class="fa fa-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="تمام صفحه" onclick="toggleFullScreen();">
                        <span class="fa fa-desktop" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="قفل" class="lock_btn">
                        <span class="fa fa-lock" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="خروج" href="{{ route('logout') }}">
                        <span class="fa fa-sign-out" aria-hidden="true"></span>
                    </a>
                </div>

            </div>
        </div>

        @include('header')


        <div class="right_col" role="main">

            @yield('content')
        </div>


        <footer class="hidden-print">
            <div class="pull-left">
{{--                فروشگاه لباس <a href="http://localhost:8000/" target="_blank">{{ $object->name }}</a> قدرت گرفته توسط <a href="https://jangal.co/" target="_blank">جنگل افزار کاسپین</a>--}}
            </div>
            <div class="clearfix"></div>
        </footer>

    </div>
</div>
<div id="lock_screen">
    <table>
        <tr>
            <td>
                <div class="clock"></div>
                <span class="unlock">
<span class="fa-stack fa-5x">
<i class="fa fa-square-o fa-stack-2x fa-inverse"></i>
<i id="icon_lock" class="fa fa-lock fa-stack-1x fa-inverse"></i>
</span>
</span>
            </td>
        </tr>
    </table>
</div>

@include('footer')

</body>
</html>
