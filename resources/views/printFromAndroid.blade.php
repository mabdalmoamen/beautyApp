<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    {{-- Print --}}
    <link href="{{ asset('/backend/vendor/bootstrap/css/bootstrap.rtl.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('css/print.css') }}" rel="stylesheet" type="text/css" />

</head>

<body>
    <div id="printMe" class="modal-body">
        <div id="invoice-POS" class="pos-section">
            <div id="top" style="text-align: center">
                <div class="logo text-center">
                    <img :src="mixins.mixins_logo"
                        :style="{
                            width: mixins.logo_width + 'px',
                            height: mixins.logo_height + 'px',
                            borderRadius: '50%',
                        }" />
                </div>
                <div class="info">
                    <span class="m-0">
                        {{ $mixins->mixins_name }}
                    </span>
                </div>
                <div class="info">
                    <span class="m-0">
                        {{ $mixins->contruct_no }}
                    </span>
                </div>
                <div class="info">
                    <span class="m-0">
                        {{ $mixins->mixins_adress }}
                    </span>
                </div>
                <div class="info">
                    <span class="m-0">
                        {{ $mixins->mixins_mobile }}
                    </span>
                </div>
                <!--End Info-->
                @if ($bill->customer != null && $mixins->country == 2)

                    <div class="text-center">
                        @if ($bill->customer->cust_vat_num && $mixins->mixins_vat_val > 0)
                            <small>
                                فاتورة ضريبية
                            </small>
                        @elseif ($mixins->mixins_vat_val > 0)
                            <small>فاتورة ضريبية مبسطة</small>
                        @endif
                    </div>
                @else
                    <div class="text-center">
                        @if ($mixins->mixins_vat_val > 0 && $mixins->contruct_no)
                            <small>
                                فاتورة ضريبية مبسطة</small>
                        @endif

                    </div>
                @endif

            </div>
            <!--End InvoiceTop-->
            <div id="bot">
                <div id="table">
                    <table id="resultTable" class="text-center w-100">
                        <tr>
                            <td colspan="3" class="no-border">
                                رقم الفاتورة
                            </td>
                            <td colspan="3" class="no-border">
                                {{ $bill->id }}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="3" class="no-border">
                                تاريخ الفاتورة
                            </td>
                            <td colspan="3" class="no-border">
                                {{ $bill->bill_date }}
                            </td>
                        </tr>
                        @if ($bill->sale)
                            <tr>
                                <td colspan="3" class="no-border">
                                    نوع الطلب
                                </td>
                                <td colspan="3" class="no-border">
                                    {{ $bill->sale->sill_type_name }}
                                </td>
                            </tr>
                        @endif

                        <tr>
                            <td colspan="3" class="no-border">
                                مستخدم النظام
                            </td>
                            <td colspan="3" class="no-border">
                                {{ $bill->user->name }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="no-border">
                                طريقة الدفع
                            </td>
                            <td colspan="3" class="no-border">
                                {{ $bill->payMethods->pay_method_name }}
                            </td>
                        </tr>
                        @if ($bill->table)
                            <tr>
                                <td colspan="3" class="no-border">
                                    رقم الطاولة
                                </td>
                                <td colspan="3" class="no-border">
                                    {{ $bill->table->table_no }}
                                </td>
                            </tr>
                        @endif
                        @if ($bill->customer && $bill->customer->cust_name)
                            <tr>
                                <td colspan="3" class="no-border">
                                    اسم العميل
                                </td>
                                <td colspan="3" class="no-border">
                                    {{ $bill->customer->cust_name }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="no-border">
                                    هاتف العميل
                                </td>
                                <td colspan="3" class="no-border">
                                    {{ $bill->customer->cust_mobile }}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3" class="no-border">
                                    عنوان العميل
                                </td>

                                <td colspan="3" class="no-border">
                                    {{ $bill->customer->cust_address }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="no-border">
                                    الرقم الضريبي للعميل
                                </td>
                                <td colspan="3" class="no-border">
                                    {{ $bill->customer->cust_vat_num }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="no-border">
                                    رصيد العميل
                                </td>

                                <td colspan="3" class="no-border">
                                    {{ $bill->customer->cust_balance }}
                                </td>
                            </tr>
                        @endif
                        <td colspan="6">
                            <hr class="hr-line" />
                        </td>

                        <tr class="text-center">
                            <th>اسم الصنف</th>
                            <th>العدد</th>
                            <th>العملية</th>
                            <th>السعر</th>
                            <th>الخصم</th>
                            <th>الاجمالي</th>
                        </tr>
                        @foreach ($bill->billType as $type)
                            <tr>
                                <td>
                                    {{ $type->type->type_name_ar }}
                                    <small class="d-block text-wrap">{{ $type->type_note }}</small>
                                </td>
                                <td class="text-center">
                                    {{ $type->type_count }}
                                </td>
                                <td class="text-center">
                                    {{ $type->units ? $type->units->unit->unit_ar_name : '-' }}
                                </td>

                                <td class="text-center">
                                    {{ $type->type_price }}
                                </td>
                                <td class="text-center">
                                    {{ $type->type_discount }}
                                </td>
                                <td class="text-center">
                                    {{ $type->type_total_price }}
                                </td>
                            </tr>
                        @endforeach

                        <td colspan="6">
                            <hr class="hr-line" />
                        </td>

                        <tr>
                            <td colspan="3" class="no-border">
                                {{ $bill->sale &&
                                $bill->sale->cost > 0 &&
                                $bill->sum_after_discount > 0 &&
                                $bill->sum_after_discount != $bill->bill_sum
                                    ? ' المجموع الجزئي:'
                                    : ' المجموع:' }}
                            </td>
                            <td colspan="3" class="no-border">
                                {{ $bill->bill_sum }}
                            </td>
                        </tr>
                        @if ($bill->bill_discount > 0 && $bill->offer_discount == 0)
                            <tr>
                                <td colspan="3" class="no-border">
                                    الخصم ({{ $bill->bill_discount }}%):
                                </td>

                                <td colspan="3" class="no-border">
                                    {{ $bill->bill_discount_percent }}
                                </td>
                            </tr>
                        @endif

                        @if ($bill->offer_discount > 0)
                            <tr>
                                <td colspan="3" class="no-border">
                                    خصم عرض
                                    {{ $mixins->offer_percenet }} %
                                </td>

                                <td colspan="3" class="no-border">
                                    {{ $bill->offer_discount }}
                                </td>
                            </tr>
                        @endif
                        @if ($bill->sale && $bill->sale->cost > 0)
                            <tr>
                                <td colspan="3" class="no-border">
                                    طلب:
                                    {{ $bill->sale->sill_type_name }}:
                                </td>

                                <td colspan="3" class="no-border">
                                    {{ $bill->sale->cost }}
                                </td>
                            </tr>
                        @endif

                        @if ($bill->bill_extra > 0)
                            <tr>
                                <td colspan="3" class="no-border">
                                    الاضافي:
                                </td>
                                <td colspan="3" class="no-border">
                                    {{ $bill->bill_extra }}
                                </td>
                            </tr>
                        @endif
                        @if ($bill->sum_after_discount > 0 && $bill->sum_after_discount != $bill->bill_sum)
                            <tr>
                                <td colspan="3" class="no-border">
                                    المجموع:
                                </td>
                                <td colspan="3" class="no-border">
                                    {{ $bill->sum_after_discount }}
                                </td>
                            </tr>
                        @endif
                        @if ($bill->bill_vat_val > 0)
                            <tr>
                                <td colspan="3" class="no-border">
                                    ضريبة القيمة المضافة ({{ $bill->vat }}%):
                                    @if ($mixins->mixins_price_include_vat)
                                        <small class="d-block">الاسعار
                                            شاملة
                                            الضريبة</small>
                                    @endif
                                </td>
                                <td colspan="3" class="no-border">
                                    {{ $bill->bill_vat_val }}
                                </td>
                            </tr>
                        @endif

                        @if ($mixins->smoken_vat)
                            <tr>
                                <td colspan="3" class="no-border">
                                    ضريبة التبغ :
                                </td>
                                <td colspan="3" class="no-border">
                                    100%
                                </td>
                            </tr>
                        @endif

                        @if ($bill->bill_paid_val != $bill->bill_total && $bill->payMethods && $bill->payMethods->id != 4)
                            <tr>
                                <td colspan="3" class="no-border">
                                    المدفوع:
                                </td>
                                <td colspan="3" class="no-border">
                                    {{ $bill->bill_paid_val }}
                                </td>
                            </tr>
                        @elseif ($bill->payMethods && $bill->payMethods->id == 4)
                            <tr>
                                <td colspan="3" class="no-border">
                                    المدفوع كاش :
                                </td>
                                <td colspan="3" class="no-border">
                                    {{ $bill->cash }}
                                </td>
                            </tr>
                        @endif
                        @if ($bill->bill_remain_val != 0 && $bill->payMethods && $bill->payMethods->id != 4)
                            <tr>
                                <td colspan="3" class="no-border">
                                    الباقي:
                                </td>
                                <td colspan="3" class="no-border">
                                    {{ $bill->bill_remain_val }}
                                </td>
                            </tr>
                        @elseif ($bill->payMethods && $bill->payMethods->id == 4)
                            <tr>
                                <td colspan="3" class="no-border">
                                    المدفوع شبكة:
                                </td>
                                <td colspan="3" class="no-border">
                                    {{ $bill->card }}
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td colspan="3" class="no-border">
                                الاجمالي:
                            </td>
                            <td colspan="3" class="no-border">
                                {{ $bill->bill_total }}
                                <small style="display: block">
                                    {{ $bill->billTotal }}</small>
                            </td>
                        </tr>
                        @if ($bill->total_returned > 0)
                            <tr>
                                <td colspan="3" class="no-border">
                                    مجموع المرتجعات:
                                </td>
                                <td colspan="3" class="no-border">
                                    {{ $bill->return_sum }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="no-border">
                                    ضريبة القيمة المضافة
                                    للمترجعات({{ $mixins->mixins_vat_val }}%):
                                </td>
                                <td colspan="3" class="no-border">
                                    {{ $bill->return_vat }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="no-border">
                                    اجمالي المرتجعات:
                                </td>
                                <td colspan="3" class="no-border">
                                    {{ $bill->total_returned }}
                                </td>
                            </tr>
                        @endif
                    </table>
                </div>
                <!--End Table-->
                @if ($mixins->mixins_note)
                    <div>
                        <ul class="navbar-nav row text-center">

                            <li class="col-12">
                                <span>{!! collect($mixins->mixins_note)->implode(',') !!}</span>

                            </li>


                        </ul>
                    </div>
                @endif
            </div>
            @if ($mixins->mixins_name != null && $mixins->contruct_no != null && $mixins->country == 2)
                <div class="text-center">
                    <img id="qr" src="" height="120" />
                </div>
            @endif
            <!--End InvoiceBot-->
            <div class="footer text-center text-wrap">
                {{ $bill->bill_notes }}
            </div>
            @if ($mixins->country == 2)
                <div class="footer text-center"
                    style="
                                    font-size: 8px;
                                    font-weight: bolder;
                                    margin-top: 3px;
                                ">
                    كوديز للحلول البرمجية
                    <i class="fa fa-phone"></i>
                    +966557179844 -
                    <i class="fa fa-phone"></i> +966561420027 .
                </div>
            @else
                <div class="footer text-center"
                    style="
                                    font-size: 8px;
                                    font-weight: bolder;
                                    margin-top: 3px;
                                ">
                    كوديز للحلول البرمجية
                    <i class="fa fa-phone"></i>
                    01002208627 -
                    <i class="fa fa-phone"></i> 01009199086 .
                </div>
            @endif
        </div>

    </div>
    <!--End Invoice-->


    </div>

    <script>
        let qr = localStorage.getItem('qr')
        document.getElementById("qr").src = qr;
        var mixins = {!! json_encode($mixins) !!};

        for (
            var count = 0; count < mixins.printer_count; count++
        ) {
            window.print()
        }
    </script>

</body>

</html>
