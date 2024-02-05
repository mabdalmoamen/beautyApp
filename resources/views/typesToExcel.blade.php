@extends('layout.app')

@section('content')
    <div class="card">


        <div class="body">

            {!! $dataTable->table() !!}

        </div>

    </div>
@endsection
@section('datatable-script')
    {!! $dataTable->scripts() !!}
@endsection
