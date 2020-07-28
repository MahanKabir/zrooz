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
            <h2>نتایج جستجو</h2>

            <form action="{{ route('serial_search') }}" method="get">
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
                            <form action="{{ route('serial_search') }}" method="get">
                                @if(isset($_GET['search']))
                                    <input type="hidden" name="search" value="{{ $_GET['search'] }}">
                                @endif
                                <input type="hidden" name="sortBy" value="serial">
                                <button type="submit" class="text_color_blue">شماره سریال</button>
                            </form>
                        </th>

                        <th>
                            <form action="{{ route('serial_search') }}" method="get">
                                @if(isset($_GET['search']))
                                    <input type="hidden" name="search" value="{{ $_GET['search'] }}">
                                @endif
                                <input type="hidden" name="sortBy" value="value01">
                                <button type="submit" class="text_color_blue">تخفیف مشتری (ریال)</button>
                            </form>
                        </th>
                        <th>
                            <form action="{{ route('serial_search') }}" method="get">
                                @if(isset($_GET['search']))
                                    <input type="hidden" name="search" value="{{ $_GET['search'] }}">
                                @endif
                                <input type="hidden" name="sortBy" value="value02">
                                <button type="submit" class="text_color_blue">تخفیف معرف (ریال)</button>
                            </form>
                        </th>
                        <th>باطل شده؟</th>
                        <th>
                            <form action="{{ route('serial_search') }}" method="get">
                                @if(isset($_GET['search']))
                                    <input type="hidden" name="search" value="{{ $_GET['search'] }}">
                                @endif
                                <input type="hidden" name="sortBy" value="created_at">
                                <button type="submit" class="text_color_blue">تاریخ درج</button>
                            </form>
                        </th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <div class="container">

                        @foreach($serials as $serial)
                            <tr>
                                <td>{{ $serial->serial }}</td>
                                <td>{{ number_format($serial->value01) }}</td>
                                <td>{{ number_format($serial->value02) }}</td>
                                <td>
                                    @if($serial->check == 0)
                                        خیر
                                    @else
                                        بله
                                    @endif
                                </td>
                                <td>{{ \Morilog\Jalali\Jalalian::forge($serial->created_at)->format('%A, %d %B %y') }}</td>
                                <td>
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-sm-5 col-md-5">
                                                <form action="{{ route('serial_edit', $serial->id) }}" method="post">
                                                    @csrf
                                                    <button class="btn btn-primary" type="submit">ویرایش</button>
                                                </form>
                                            </div>
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
    @php
        $input = [];
        if(isset($_GET['sortBy'])){
            array_merge($input, ['sortBy' => $_GET['sortBy']]);
        }
        if(isset($_GET['search'])){
            array_merge($input, ['search' => $_GET['search']]);
        }
    @endphp
    {{ $serials->appends(request()->input())->links($input) }}



@stop
