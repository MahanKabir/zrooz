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
    <h2>نتایج جستجو</h2>
    <div class="card">
        <div class="card-header">
            <form action="{{ route('person_search') }}" method="get">
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
                        <th>
                            <form action="{{ route('person_search') }}" method="get">
                                @if(isset($_GET['search']))
                                    <input type="hidden" name="search" value="{{ $_GET['search'] }}">
                                @endif
                                <input type="hidden" name="sortBy" value="name">
                                <button type="submit" class="text_color_blue">نام</button>
                            </form>
                        </th>
                        <th>
                            <form action="{{ route('person_search') }}" method="get">
                                @if(isset($_GET['search']))
                                    <input type="hidden" name="search" value="{{ $_GET['search'] }}">
                                @endif
                                <input type="hidden" name="sortBy" value="code">
                                <button type="submit" class="text_color_blue">کد ملی</button>
                            </form>
                        </th>
                        <th>
                            <form action="{{ route('person_search') }}" method="get">
                                @if(isset($_GET['search']))
                                    <input type="hidden" name="search" value="{{ $_GET['search'] }}">
                                @endif
                                <input type="hidden" name="sortBy" value="phone">
                                <button type="submit" class="text_color_blue">شماره تلفن همراه</button>
                            </form>
                        </th>
                        <th>
                            <form action="{{ route('person_search') }}" method="get">
                                @if(isset($_GET['search']))
                                    <input type="hidden" name="search" value="{{ $_GET['search'] }}">
                                @endif
                                <input type="hidden" name="sortBy" value="email">
                                <button type="submit" class="text_color_blue">تخفیف مشتری (ریال)</button>
                            </form>
                        </th>
                        <th>
                            <form action="{{ route('person_search') }}" method="get">
                                @if(isset($_GET['search']))
                                    <input type="hidden" name="search" value="{{ $_GET['search'] }}">
                                @endif
                                <input type="hidden" name="sortBy" value="created_at">
                                <button type="submit" class="text_color_blue">تاریخ ثبت</button>
                            </form>
                        </th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <div class="container">

                        @foreach($people as $person)
                            <tr>
                                <td>{{ $person->name }}</td>
                                <td>{{ $person->code }}</td>
                                <td>{{ $person->phone }}</td>
                                <td>{{ number_format($person->value) }}</td>
                                <td>{{ \Morilog\Jalali\Jalalian::forge($person->created_at)->format('%A, %d %B %y') }}</td>
                                <td>
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-sm-4 col-md-4">
                                                <a href="{{ route('person_confirm') }}" class="btn btn-primary">کد تایید</a>
                                            </div>
                                            <div class="col-sm-4 col-md-4">
                                                <form action="{{ route('person_edit', $person->id) }}" method="post">
                                                    @csrf
                                                    <button class="btn btn-primary" type="submit">ویرایش</button>
                                                </form>
                                            </div>
                                            <div class="col-sm-4 col-md-4">
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
    @php
        $input = [];
        if(isset($_GET['sortBy'])){
            array_merge($input, ['sortBy' => $_GET['sortBy']]);
        }
        if(isset($_GET['search'])){
            array_merge($input, ['search' => $_GET['search']]);
        }
    @endphp
    {{ $people->appends(request()->input())->links($input) }}
@stop
