@extends('main')

@section('content')

    <h2>تکمیل پروفایل</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('person_store') }}" method="post" enctype="multipart/form-data">
        @csrf

            <div class="form-group">
                <label for="id_name">نام و نام خانوادگی:</label>
                <input class="form-control" type="text" name="name" id="id_name">
            </div>
            <div class="form-group">
                <label for="id_code">کد ملی:</label>
                <input class="form-control" type="text" name="code" id="id_code">
            </div>
            <div class="form-group">
                <label for="id_phone">شماره تلفن همراه:</label>
                <input class="form-control" type="text" name="phone" id="id_phone">
            </div>
            <div class="form-group">
                <label for="id_email">ایمیل:</label>
                <input class="form-control" type="text" name="email" id="id_email">
            </div>
            <div class="form-group">
                <label for="id_value">تخفیف مشتری:</label>
                <input class="form-control" type="text" name="value" id="id_value">
            </div>

            <div class="form-group">
                <label for="id_address">نشانی:</label>
                <input class="form-control" type="text" name="address" id="id_address">
            </div>
            <button class="btn btn-success col-12">ثبت</button>
    </form>

@stop
