@php
    function convertToPersianNumber($str){
        $english = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');

        $convertedStr = str_replace($english, $persian, $str);
        return $convertedStr;
    }
@endphp


@extends('main')

@section('content')
    <div class="row tile_count">
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> تعداد مشتریان</span>
            <div class="count">{{ convertToPersianNumber($people_count) }}</div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-key"></i> تعداد سریال‌ها</span>
            <div class="count">{{ convertToPersianNumber($serials_count) }}</div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-key"></i> سریال‌های مصرف شده</span>
            <div class="count">{{ convertToPersianNumber($serials_check_0_count) }}</div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-key"></i>  سریال‌های مصرف نشده</span>
            <div class="count">{{ convertToPersianNumber($serials_check_1_count) }}</div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-table"></i> تعداد گزارشات</span>
            <div class="count green">{{ convertToPersianNumber($reports_count) }}</div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-money"></i> تخفیف‌ ثبت نام (ریال)</span>
            <div class="count">{{ convertToPersianNumber(number_format($setting->value)) }}</div>
        </div>


    </div>

@stop

