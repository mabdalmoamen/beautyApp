@extends('layout.app')

@section('content')
    <div class="card col-12" style="overflow-x: scroll">
        <div class="card-header">
            <div class="alert alert-danger " style="display: none">يجب تحديد فتره (من-الى) </div>
            <form name="form" class="needs-validation mt-2 hideMeInPrint" method="GET" action="RTypes">
                <div class="form-row justify-content-center">
                    <div class="col-md-2">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"
                                for="from">{{ __('lang.From') }}</label>
                            <div class="col-sm-8">
                                <input class="form-control " type="date" name="from" id="from"
                                    placeholder="{{ __('lang.From') }}" value="{{ request('from') }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="to">{{ __('lang.To') }}</label>
                            <div class="col-sm-8">
                                <input class="form-control " type="date" name="to" id="to"
                                    placeholder="{{ __('lang.To') }}" value="{{ request('to') }}">
                            </div>
                        </div>
                    </div>
                    @if ($categories)
                        <div class="col-md-2">
                            <div class="input-group">
                                <select class="form-control " name="cat_id">
                                    <option value="">كل الاصناف الرئيسية</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->main_type_id }}"
                                            @if (request('cat_id') == $cat->main_type_id) selected="selected" @endif>
                                            {{ $cat->main_type_title_ar }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    @endif
                    <div class="col-md-2">
                        <div class="input-group">
                            <select class="form-control " name="period">
                                <option value="daily"@if (request('period') == 'daily') selected="selected" @endif>
                                    {{ __('lang.Daily') }} </option>
                                <option value="monthly" @if (request('period') == 'monthly') selected="selected" @endif>
                                    {{ __('lang.Monthly') }}</option>
                                <option value="period" @if (request('period') == 'period') selected="selected" @endif>
                                    {{ __('lang.Period') }}</option>
                            </select>

                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group row">
                            <label class="col-sm-6 col-form-label"
                                for="type_id">{{ __('lang.Code') }}</label>
                            <div class="col-sm-6">
                                <input class="form-control " type="text" name="type_id" id="type_id"
                                    value="{{ request('type_id') }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <button class="btn btn-success" type="submit">
                            {{ __('lang.View') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="body">

            <table id="types-table" class="table dataTable text-center">
                <tbody>
                    <thead>
                        <tr>
                            <th>كود الصنف</th>
                            <th>اسم الصنف</th>
                            <th>الكمية</th>
                            {{-- <th>الاجمالي بسعر البيع</th> --}}
                        </tr>
                    </thead>
                    @if ($types)
                        @foreach ($types as $type)
                            <tr>
                                <td>{{ $type['type']['type_id'] }}</td>
                                <td>{{ $type['type']['type_name_ar'] }}</td>
                                <td>{{ $type['count'] }}</td>
                                {{-- <td>{{ $type['count'] * $type['type']['type_sill_price'] }}</td> --}}
                            </tr>
                        @endforeach
                    @endif

                </tbody>
            </table>
        </div>

    </div>

@endsection

@section('scripts')
    <script>
        $(function() {
            function getUrlParameter(name) {
                name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                    results = regex.exec(location.search);
                return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
            }
            if (getUrlParameter('period') == 'period' && getUrlParameter('to') === '' &&
                getUrlParameter(
                    'from') === '') {
                $('.alert-danger').css('display', 'block');

            }
            $('select').on('change', function(e) {
                $('.alert-danger').fadeOut();
                document.forms['form'].submit();

            });

        })
    </script>
    @isset($sill_price)
        <script>
            $(function() {
                var table = document.getElementById("types-table");
                var footer = table.createTFoot();
                footer.classList.add('text-center');
                var row = footer.insertRow(0);
                footer.innerHTML = `<tr> <th <th > الاجمالي بسعر البيع</th> <th > ` +
                    {!! json_encode(round($sill_price ?? '', 2)) !!} +
                    ` </th> </tr><tr> <th <th > الاجمالي بسعر الشراء </th> <th <th >` +
                    {!! json_encode(round($purchases_price ?? '', 2)) !!} +
                    ` </tr><tr></th> `;

            })
        </script>
    @endisset
@endsection
