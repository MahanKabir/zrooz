@extends('main')

@section('content')
    <style>
        .text_color_blue{
            all: unset;
            color: #73879c;
            -webkit-text-fill-color: #73879c;
            cursor: pointer;
        }
    </style>
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

                        <th>
                            <form action="{{ route('report_search') }}" method="get">
                                @if(isset($_GET['search']))
                                    <input type="hidden" name="search" value="{{ $_GET['search'] }}">
                                @endif
                                <input type="hidden" name="sortBy" value="created_at">
                                <button type="submit" class="text_color_blue">تاریخ</button>
                            </form>
                        </th>
                        <th>
                            <form action="{{ route('report_search') }}" method="get">
                                @if(isset($_GET['search']))
                                    <input type="hidden" name="search" value="{{ $_GET['search'] }}">
                                @endif
                                <input type="hidden" name="sortBy" value="action">
                                <button type="submit" class="text_color_blue">عملیات</button>
                            </form>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <div class="container">

                        @foreach($reports as $report)
                            <tr>

                                <td>{{ \Morilog\Jalali\Jalalian::forge($report->created_at)->ago() }}</td>
                                <td>{{ $report->action }}</td>

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
