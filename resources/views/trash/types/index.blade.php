@extends('layout.app')

@section('content')
    <div class="card">
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>{{ __('lang.Code') }}</th>
                    <th>{{ __('lang.Barcode') }}</th>
                    <th>{{ __('lang.Type Name') }}</th>
                    <th>{{ __('lang.Sill Price') }}</th>
                    <th>{{ __('lang.Reset') }}</th>

                </tr>
            <tbody>
                @foreach ($types as $type)
                    <tr>
                        <td>{{ $type->type_id }}</td>
                        <td>{{ $type->type_barcode }}</td>
                        <td>{{ $type->type_name_ar }}</td>
                        <td>{{ $type->type_sill_price }}</td>
                        <td>
                            <a class="btn btn-danger text-light" href="{{ route('restore') }}"
                                onclick="event.preventDefault();
                                                     document.getElementById('restore_{{ $type->type_id }}').submit();">
                                {{ __('lang.Reset') }}
                            </a>

                            <form id="restore_{{ $type->type_id }}" action="{{ route('restore') }}" method="POST"
                                class="d-none">
                                <input type="hidden" name="type_id" value="{{ $type->type_id }}" />
                                @csrf
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            </thead>

        </table>
    </div>
@endsection
