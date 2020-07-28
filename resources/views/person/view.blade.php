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
    <h2>مشاهده مشتری‌ها</h2>
    <div class="card">
        <div class="card-header">
            <form action="{{ route('person_search') }}" method="get">
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
                <table class="table table-striped table-sm bg-light">
                    <thead>
                    <tr>
                        <th><b><a href="{{ route('person_sb_code') }}">نام</a></b></th>
                        <th><a href="{{ route('person_sb_phone') }}">شماره تلفن همراه</a></th>
                        <th><a href="{{ route('person_sb_email') }}">تخفیف مشتری (ریال)</a></th>
                        <th><a href="{{ route('person_sb_email') }}">کد معرفی</a></th>
                        <th><a href="{{ route('person_sb_code') }}">کد معرف</a></th>

                        <th><a href="{{ route('person_sb_created_at') }}">تاریخ ثبت</a></th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <div class="container">
                        @foreach($persons as $person)
                            <tr>
                                <td>{{ $person->name }}</td>
                                <td>{{ convertToPersianNumber($person->phone) }}</td>
                                <td>{{ convertToPersianNumber(number_format($person->value)) }}</td>
                                <td>{{ convertToPersianNumber($person->individual) }}</td>
                                <td>@if($person->parent == "")
                                ندارد
                                @else
                                {{ convertToPersianNumber($person->parent) }}
                                @endif
                                </td>

                                <td>{{ convertToPersianNumber(\Morilog\Jalali\Jalalian::forge($person->created_at)->format('%A، %d %B %y')) }}</td>
                                <td>
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-sm-3 col-md-3">
                                                <a href="{{ route('person_confirm' , $person->id) }}" class="btn btn-primary">کد تایید</a>
                                            </div>
                                            <div class="col-sm-3 col-md-3">
                                                <form action="{{ route('person_edit', $person->id) }}" method="post">
                                                    @csrf
                                                    {{ method_field('GET') }}
                                                    <button class="btn btn-primary" type="submit">ویرایش</button>
                                                </form>
                                            </div>
                                            <div class="col-sm-3 col-md-3">
                                                <form action="{{ route('person_destroy', $person->id) }}" method="post">
                                                    @csrf
                                                    <button class="btn btn-danger" type="submit">حذف</button>
                                                </form>
                                            </div>
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

    {{ $persons->links() }}

@stop
