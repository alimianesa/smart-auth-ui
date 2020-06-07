@extends('layouts.app')

@section('content')

    <div style="margin: 0 15% 0 15%">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div style="margin: 10% 35% 10% 35%; direction: rtl;text-align: center">
        <div class="card">
            <h5 class="card-header bg-dark text-light">ورود یا ثبت نام</h5>

            <form action="/register" method="POST">
                <div style="margin: 7% 5% 0 5%; direction: rtl;text-align: center">
                    {{ csrf_field() }}
                    <input type="hidden" name="country_code" value="+98">
                    <div class="form-group">
                        <input type="number" name="phone_number" class="form-control" placeholder=" شماره تلفن بدون +98">
                    </div>
                    <div class="form-group">
                        <input type="number" name="card_number" class="form-control"  placeholder="کد ملی">
                    </div>
                </div>
                <div style="margin: 6% 0 5% 0; direction: rtl;text-align: center">
                    <button type="submit" class="btn btn-outline-dark" style="width: 40%;border-radius: 14px">ثبت</button>
                </div>
            </form>
        </div>
    </div>

@endsection
