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
            <h2>مشاهده گزارشات</h2>
            <form action="{{ route('report_search') }}" method="get">
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

                        <th><a href="{{ route('report_created_at') }}">تاریخ</a></th>
                        <th><a href="{{ route('report_action') }}">عملیات</a></th>
                    </tr>
                    </thead>
                    <tbody>
                    <div class="container">

                        @foreach($reports as $report)
                            <tr>

                                <td>{{ convertToPersianNumber(\Morilog\Jalali\Jalalian::forge($report->created_at)->ago()) }}</td>
                                <td>{{ convertToPersianNumber($report->action) }}</td>

                            </tr>
                        @endforeach
                    </div>

                    </tbody>
                </table>
            </div>
        </div>

    </div>


    @php
        $input = [];
        if(isset($_GET['sortBy'])){
            array_merge($input, ['sortBy' => $_GET['sortBy']]);
        }
        if(isset($_GET['search'])){
            array_merge($input, ['search' => $_GET['search']]);
        }
    @endphp
    {{ $reports->appends(request()->input())->links($input) }}

@stop
