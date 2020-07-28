@extends('main')

@section('content')

    <h2>ویرایش اطلاعات مشتری</h2>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('person_update', $person->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{ method_field('PUT') }}


        <div class="form-group">
            <label for="id_name">نام و نام خانوادگی:</label>
            <input class="form-control" type="text" name="name" id="id_name" value="{{ $person->name }}">
        </div>
        <div class="form-group">
            <label for="id_code">کد ملی:</label>
            <input class="form-control" type="text" name="code" id="id_code" value="{{ $person->code }}">
        </div>
        <div class="form-group">
            <label for="id_phone">شماره تلفن همراه:</label>
            <input class="form-control" type="text" name="phone" id="id_phone" value="{{ $person->phone }}">
        </div>
        <div class="form-group">
            <label for="id_email">ایمیل:</label>
            <input class="form-control" type="text" name="email" id="id_email" value="{{ $person->email }}">
        </div>
        <div class="form-group">
            <label for="id_value">تخفیف مشتری:</label>
            <input class="form-control" type="text" name="value" id="id_value" value="{{ $person->value }}">
        </div>
        <div class="form-group">
            <label for="id_address">نشانی:</label>
            <input class="form-control" type="text" name="address" id="id_address" value="{{ $person->address }}">
        </div>

        <button class="btn btn-success col-12">ویرایش</button>

    </form>

@stop
