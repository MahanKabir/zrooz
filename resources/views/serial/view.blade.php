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


    <div class="card">
        <div class="card-header">

            <h2>مشاهده سریال‌ها</h2>

            <form action="{{ route('serial_search') }}" method="get">
                @csrf
                <div class="input-group">
                    <input class="form-control" type="search" name="search" value="{{ request('search') }}">
                    <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary">جستجو</button>
                </span>
                </div>

            </form>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th><a href="{{ route('serial_sb_serial') }}">شماره سریال</a></th>
                        <th><a href="{{ route('serial_sb_val01') }}">تخفیف مشتری (ریال)</a></th>
                        <th><a href="{{ route('serial_sb_val02') }}">تخفیف معرف (ریال)</a></th>
                        <th><a href="#">باطل شده؟</a></th>
                        <th><a href="{{ route('serial_sb_created_at') }}">تاریخ درج</a></th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <div class="container">
                        @foreach($serials as $serial)
                            <tr>
                                <td>{{ convertToPersianNumber($serial->serial) }}</td>
                                <td>{{ convertToPersianNumber(number_format($serial->value01)) }}</td>
                                <td>{{ convertToPersianNumber(number_format($serial->value02)) }}</td>
                                <td>
                                        @if($serial->check == 0)
                                        بله
                                        @else

                                        خیر
                                        @endif
                                </td>
                                <td>{{ convertToPersianNumber(\Morilog\Jalali\Jalalian::forge($serial->created_at)->format('%A، %d %B %y')) }}</td>

                                <td>
                                    <div class="container-fluid">
                                        <div class="row">
                                            @if($serial->check == 1)

                                                <div class="col-sm-5 col-md-5">

                                                    <form action="{{ route('serial_edit', $serial->id) }}" method="post">
                                                        @csrf
                                                        {{ method_field('GET') }}

                                                        <button class="btn btn-primary" type="submit">ویرایش</button>
                                                    </form>

                                                </div>
                                            @endif

                                            @if($serial->check == 0)
                                                <div class="col-sm-5 col-md-5">
                                                    <button class="btn btn-danger disabled" type="submit">باطل</button>
                                                </div>
                                                @else
                                                <div class="col-sm-5 col-md-5">
                                                    <form action="{{ route('serial_destroy', $serial->id) }}" method="post">
                                                        @csrf
                                                        <button class="btn btn-danger" type="submit">باطل</button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </div>

                    </tbody>
                </table>

            </div>
        </div>

    </div>
    {{ $serials->links() }}

@stop

