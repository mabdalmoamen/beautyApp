<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/cashier.js') }}"></script>
    <link href="{{ asset('css/print.css') }}" rel="stylesheet">

</head>

<body class="pos-section" id="card">
    <table class="text-center w-100">
        <tr>
            <td>
                مستخدم النظام
            </td>
            <td>
                {{ $bills->user->name }}
            </td>
        </tr>
        <tr>
            <td>
                رقم الطلب
            </td>
            <td class="orderNum">
            </td>

            <td>
                تاريخ الفاتورة
            </td>
            <td>
                {{ $bills->bill_date }}
            </td>
        </tr>

    </table>
    <table id="kitchenTable" class="text-center w-100">
        @if ($mixins->country == 2)
            <thead>
                <tr>
                    <th>
                        اسم الصنف
                    </th>
                    <th>العملية</th>
                    <th>الموظف</th>

                </tr>
            </thead>
        @endif
        <tbody>
            @foreach ($bills->tableType as $bill)
                @if (!$bill->is_print)
                    <tr id="{{ 'type' . $bill->type->type_id }}">
                        <td style="display: none">
                            {{ $bill->type->mainType->main_type_id }}
                        </td>
                        <td>
                            {{ $bill->type->type_name_ar }}
                            <small>{{ $bill->type_note }}</small>
                        </td>
                        <td class="text-center">
                            {{ $bill->chair->table_no }}
                        </td>
                        <td class="text-center">
                            {{ $bill->worker->name }}
                        </td>
                        <td class="text-center">
                            {{ $bill->units ? $bill->units->unit->unit_ar_name : '' }}
                        </td>
                        <td>
                            {{$bill->reserve_date}}
                        </td>
                    </tr>
                @endif
            @endforeach


        </tbody>
    </table>
    <script>
        var mixins = {!! json_encode($mixins) !!};
        if (mixins.active_distributing) {
            $(document).ready(function() {
                $('.orderNum').text(localStorage.getItem('orderNum'));
                var bills = {!! json_encode($bills->tableType) !!};
                var printersArr = new Array();
                bills.map((type) => {
                    if (!type.is_print) {
                        var link = type.type.main_type;
                        printersArr.push(link);
                    }
                });
                if (printersArr.length > 0) {
                    codiesDistributing(printersArr);
                }

            });
        }
    </script>
</body>

</html>
