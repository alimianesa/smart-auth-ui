@extends('layouts.app')

@section('content')

    <div style="margin: 10% 35% 10% 35%; direction: rtl;text-align: center">
        <div class="card">
            <h5 class="card-header bg-dark text-light">رمز عبور</h5>

            <form action="/password" method="POST">
                <div style="margin: 7% 5% 0 5%; direction: rtl;text-align: center">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="password" name="password" class="form-control"  placeholder="رمز عبور">
                    </div>
                    <div style="margin: 6% 0 5% 0; direction: rtl;text-align: center">
                        <button type="submit" class="btn btn-outline-dark" style="width: 40%;border-radius: 14px">ثبت</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
