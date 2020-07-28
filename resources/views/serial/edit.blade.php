@extends('main')

@section('content')

    <h2>ویرایش سریال</h2>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('serial_update', $serial->id) }}" method="post">
        @csrf
        {{ method_field('PUT') }}
        <div class="form-group">
            <label for="id_serial">شماره سریال:</label>
            <input class="form-control" type="text" name="serial" id="id_serial" value="{{ $serial->serial }}">
        </div>
        <div class="form-group">
            <label for="id_value01">تخفیف مشتری :</label>
            <input class="form-control" type="text" name="value01" id="id_value01" value="{{ $serial->value01 }}">
        </div>
        <div class="form-group">
            <label for="id_value02">تخفیف معرف :</label>
            <input class="form-control" type="text" name="value02" id="id_value02" value="{{ $serial->value02 }}">
        </div>
        <button class="btn btn-success col-12">ثبت</button>

    </form>

@stop
