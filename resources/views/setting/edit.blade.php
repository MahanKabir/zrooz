@extends('main')
@section('content')

    <form class="form-group" action="{{ route('setting_name_update', $setting->id) }}" method="post">
        @csrf
        <label for="id_name">نام فروشگاه: </label>
        <div class="input-group">
            <input class="form-control" type="text" name="name" id="id_name" value="{{ $setting->name }}">
            <span class="input-group-btn">
                <button class="btn btn-success" type="submit">ثبت تغییر</button>
            </span>
        </div>
    </form>



    <form class="form-group" action="{{ route('setting_value_update', $setting->id) }}" method="post">
        @csrf
        <label for="id_value">تخفیف ثبت نام: </label>
        <div class="input-group">
            <input class="form-control" type="text" name="value" id="id_value" value="{{ $setting->value }}">
            <span class="input-group-btn">
                <button class="btn btn-success" type="submit">ثبت تغییر</button>
            </span>
        </div>
    </form>

    <form class="form-group" action="{{ route('setting_password_update') }}" method="post">
        @csrf
        <label for="id_password">پسورد جدید: </label>
        <div class="input-group">
            <input class="form-control" type="password" name="password" id="id_password" placeholder="پسورد جدید را وارد کنید">
            <span class="input-group-btn">
                <button class="btn btn-success" type="submit">ثبت تغییر</button>
            </span>
        </div>
    </form>

    @stop
