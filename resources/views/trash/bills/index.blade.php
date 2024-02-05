@extends('layout.app')

@section('content')
    <div class="card">
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>{{ __('lang.Code') }}</th>
                    <th>{{ __('lang.Sum') }}</th>
                    <th>{{ __('lang.Vat') }}</th>
                    <th>{{ __('lang.Total') }}</th>
                    <th>{{ __('lang.Deleted Date') }}</th>
                    <th>{{ __('lang.Reset') }}</th>
                    <th>{{ __('lang.Delete') }}</th>

                </tr>

            <tbody>
                @foreach ($bills as $bill)
                    <tr>
                        <td>{{ $bill->bill_no }}</td>
                        <td>{{ $bill->bill_sum }}</td>
                        <td>{{ $bill->bill_vat_val }}</td>
                        <td>{{ $bill->bill_total }}</td>
                        <td>{{ $bill->delete_date }}</td>
                        <td>
                            <a class="btn btn-danger" href="{{ route('restore.bill') }}"
                                onclick="event.preventDefault();
                                                     document.getElementById('restore_{{ $bill->bill_no }}').submit();">
                                {{ __('lang.Reset') }}
                            </a>

                            <form id="restore_{{ $bill->bill_no }}" action="{{ route('restore.bill') }}" method="POST" class="d-none">
                                <input bill="hidden" name="bill_no" value="{{ $bill->bill_no }}" />
                                @csrf
                            </form>
                        </td>
                         <td>
                            <a class="btn btn-danger" href="{{ route('delete.bill') }}"
                                onclick="event.preventDefault();
                                                     document.getElementById('delete_{{ $bill->bill_no }}').submit();">
                                {{ __('lang.Delete') }}
                            </a>

                            <form id="delete_{{ $bill->bill_no }}" action="{{ route('delete.bill') }}" method="POST" class="d-none">
                                <input bill="hidden" name="id" value="{{ $bill->bill_no }}" />
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
