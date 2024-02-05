@extends('layout.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card text-center">
                    @isset($res)
                        <div class="alert alert-success">{{ $res }}</div>
                    @endisset

                    <div class="card-header">
                        <h6>رقيم</h6>
                    </div>
                    <div class="body text-center">
                        <a class="btn btn-warning" href="{{ route('updated') }}"> بحث عن تحديث
                        </a>

                    </div>

                </div>
            </div>
        </div>
    @endsection
