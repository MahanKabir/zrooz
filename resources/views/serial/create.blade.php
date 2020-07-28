@extends('main')

@section('content')
    <h2>ثبت سریال</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('serial_store') }}" method="post">
        @csrf
            <div class="form-group">
                <label for="id_serial">شماره سریال:</label>
                <input class="form-control" type="text" name="serial" id="id_serial">
            </div>
            <div class="form-group">
                <label for="id_value01">تخفیف مشتری (ریال):</label>
                <input class="form-control" type="text" name="value01" id="id_value01">
            </div>
            <div class="form-group">
                <label for="id_value02">تخفیف معرف (ریال):</label>
                <input class="form-control" type="text" name="value02" id="id_value02">
            </div>
        <button class="btn btn-success col-12">ثبت</button>
    </form>

    <script type="text/javascript">
        document.body.onload = function () {
            document.getElementById('id_serial').value = Math.floor(Math.random()*10000000000000000) + 1;
        };
    </script>
@stop
