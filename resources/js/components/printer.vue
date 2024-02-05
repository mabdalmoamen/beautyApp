<template>
    <div v-if="bill && mixins">
        <a id="btn" class="btn btn-info text-light d-none" data-target="#printModal" data-toggle="modal"><i
                class="fas fa-ellipsis-v"></i></a>
        <div id="printModal" aria-hidden="true" aria-labelledby="printModal" class="modal" role="dialog" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content m-auto">
                    <div class="modal-header">
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="printMe" class="modal-body">
                        <div id="invoice-POS" class="pos-section">
                            <div style="text-align: center">
                                <div class="text-center">
                                    <img :src="mixins.mixins_logo" :style="{
                                        width: mixins.logo_width + 'px',
                                        height: mixins.logo_height + 'px',

                                    }" />
                                </div>
                                <div class="info">
                                    <span class="m-0">
                                        {{ mixins.mixins_name }}
                                    </span>
                                </div>
                                <div class="info">
                                    <span class="m-0">
                                        {{ mixins.contruct_no }}
                                    </span>
                                </div>
                                <div class="info">
                                    <span class="m-0">
                                        {{ mixins.mixins_adress }}
                                    </span>
                                </div>
                                <div class="info">
                                    <span class="m-0">
                                        {{ mixins.mixins_mobile }}
                                    </span>
                                </div>
                                <!--End Info-->
                                <div v-if="bill.customer != null &&
                                    mixins.country == 2
                                    " class="text-center">
                                    <span v-if="bill.customer.cust_vat_num &&
                                        mixins.mixins_vat_val > 0
                                        ">
                                        فاتورة ضريبية
                                    </span>
                                    <span v-else="mixins.mixins_vat_val > 0">فاتورة ضريبية مبسطة</span>
                                </div>
                                <div v-else class="text-center">
                                    <span v-if="mixins.mixins_vat_val > 0 &&
                                        mixins.contruct_no
                                        ">
                                        فاتورة ضريبية مبسطة</span>
                                </div>
                            </div>
                            <!--End InvoiceTop-->
                            <div id="bot">
                                <div id="table">
                                    <table id="resultTable" class="text-center w-100">
                                        <tbody>
                                            <tr>
                                                <td>رقم الفاتورة</td>
                                                <td>
                                                    {{ bill.id }}
                                                </td>

                                                <td>رقم الطلب</td>
                                                <td>
                                                    {{ orderNum }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>تاريخ الفاتورة</td>
                                                <td>
                                                    {{
                                                        moment(
                                                            bill.bill_date
                                                        ).format(
                                                            "DD-MM-YYY HH:mm:ss"
                                                        )
                                                    }}
                                                </td>

                                                <td v-if="bill.user != null">
                                                    مستخدم النظام
                                                </td>
                                                <td v-if="bill.user != null">
                                                    {{ bill.user.name }}
                                                </td>
                                            </tr>

                                            <tr v-if="bill.customer &&
                                                bill.customer.cust_name
                                                ">
                                                <td>اسم العميل</td>
                                                <td>
                                                    {{
                                                        bill.customer.cust_name
                                                    }}
                                                </td>
                                                <td v-if="bill.customer.points && mixins.active_point"> عدد النقاط</td>
                                                <td v-if="bill.customer.points && mixins.active_point">
                                                    {{
                                                        bill.customer.points
                                                    }}
                                                </td>
                                            </tr>
                                            <tr v-if="bill.customer &&
                                                    bill.customer.cust_mobile
                                                    ">
                                                <td>هاتف العميل</td>
                                                <td>
                                                    {{
                                                        bill.customer
                                                            .cust_mobile
                                                    }}
                                                </td>
                                                <td v-if="bill.customer.points && mixins.active_point"> قيمة النقاط</td>
                                                <td v-if="bill.customer.points && mixins.active_point">
                                                    {{
                                                        bill.customer.points * mixins.point_price
                                                    }}
                                                </td>
                                            </tr>

                                            <tr v-if="bill.customer &&
                                                    bill.customer.cust_address
                                                    ">
                                                <td>عنوان العميل</td>

                                                <td>
                                                    {{
                                                        bill.customer
                                                            .cust_address
                                                    }}
                                                </td>
                                            </tr>
                                            <tr v-if="bill.customer &&
                                                    bill.customer.cust_vat_num
                                                    ">
                                                <td>الرقم الضريبي للعميل</td>
                                                <td>
                                                    {{
                                                        bill.customer
                                                            .cust_vat_num
                                                    }}
                                                </td>
                                            </tr>
                                            <tr v-if="bill.customer &&
                                                    bill.customer.cust_balance
                                                    ">
                                                <td>رصيد العميل</td>

                                                <td>
                                                    {{
                                                        bill.customer
                                                            .cust_balance
                                                    }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="text-center w-100">
                                        <thead>
                                            <tr>
                                                <th>بيان</th>
                                                <th>عملية</th>
                                                <th>اجمالي</th>
                                                <th>موظف\ة</th>
                                                <th>كرسي</th>
                                                <th>الوقت</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(
                                                                                                                                                                                                    type, index
                                                                                                                                                                                                ) in bill.bill_type"
                                                :key="index" :class="type.returned
                                                    ? 'text-decoration-line-through '
                                                    : ''
                                                    ">
                                                <td class="text-center">
                                                    {{ type.type.type_name_ar }}
                                                    <small class="d-block text-wrap">{{
                                                        type.type_note
                                                    }}</small>
                                                </td>

                                                <td class="text-center">
                                                    {{
                                                        type.units
                                                        ? type.units.unit
                                                            .unit_ar_name
                                                        : "-"
                                                    }}
                                                </td>

                                                <td>
                                                    {{ type.type_total_price }}
                                                </td>
                                                <td>
                                                    {{ type.worker ? type.worker.name : '' }}
                                                </td>
                                                <td>
                                                    {{ type.chair ? type.chair.table_no : '' }}
                                                </td>
                                                <td>
                                                    {{
                                                        moment(
                                                            type.reserve_date
                                                        ).format(
                                                            "hh:mmA"
                                                        )
                                                    }}
                                                </td>
                                            </tr>
                                            <td colspan="2" v-if="bill.pay_methods != null">
                                                طريقة الدفع
                                            </td>
                                            <td colspan="2" v-if="bill.pay_methods != null">
                                                {{
                                                    bill.pay_methods
                                                        .pay_method_name
                                                }}
                                            </td>
                                            <tr>
                                                <td colspan="2">
                                                    {{
                                                        bill.sum_after_discount >
                                                        0 &&
                                                        bill.sum_after_discount !=
                                                        bill.bill_sum
                                                        ? " المجموع الجزئي:"
                                                        : " المجموع قبل الضريبة:"
                                                    }}
                                                </td>
                                                <td colspan="2">
                                                    {{ bill.bill_sum }}
                                                </td>
                                            </tr>
                                            <tr v-if="bill.bill_discount > 0 &&
                                                bill.offer_discount == 0
                                                ">
                                                <td colspan="2">
                                                    الخصم ({{
                                                        bill.bill_discount
                                                    }}%):
                                                </td>

                                                <td colspan="2">
                                                    {{
                                                        bill.bill_discount_percent
                                                    }}
                                                </td>
                                            </tr>

                                            <tr v-if="bill.offer_discount > 0">
                                                <td colspan="2">
                                                    خصم عرض
                                                    {{ mixins.offer_percenet }}
                                                    %
                                                </td>

                                                <td colspan="2">
                                                    {{ bill.offer_discount }}
                                                </td>
                                            </tr>

                                            <tr v-if="bill.bill_extra > 0">
                                                <td colspan="2">الاضافي:</td>
                                                <td colspan="2">
                                                    {{ bill.bill_extra }}
                                                </td>
                                            </tr>
                                            <tr v-if="bill.sum_after_discount >
                                                0 &&
                                                bill.sum_after_discount !=
                                                bill.bill_sum
                                                ">
                                                <td colspan="2">المجموع:</td>
                                                <td colspan="2">
                                                    {{
                                                        bill.sum_after_discount
                                                    }}
                                                </td>
                                            </tr>
                                            <tr v-if="bill.bill_vat_val > 0">
                                                <td colspan="2">
                                                    ضريبة القيمة المضافة ({{
                                                        bill.vat
                                                    }}%):
                                                    <small class="d-block" v-if="mixins.mixins_price_include_vat
                                                            ">الاسعار شاملة
                                                        الضريبة</small>
                                                </td>
                                                <td colspan="2">
                                                    {{ bill.bill_vat_val }}
                                                </td>
                                            </tr>
                                            <tr v-if="mixins.smoken_vat">
                                                <td colspan="2">
                                                    ضريبة التبغ :
                                                </td>
                                                <td colspan="2">100%</td>
                                            </tr>
                                            <tr v-if="bill.bill_paid_val !=
                                                bill.bill_total &&
                                                bill.pay_methods &&
                                                bill.pay_methods.id != 4
                                                ">
                                                <td colspan="2">المدفوع:</td>
                                                <td colspan="2">
                                                    {{ bill.bill_paid_val }}
                                                </td>
                                            </tr>
                                            <tr v-else-if="bill.pay_methods &&
                                                bill.pay_methods.id == 4
                                                ">
                                                <td colspan="2">
                                                    المدفوع كاش :
                                                </td>
                                                <td colspan="2">
                                                    {{ bill.cash }}
                                                </td>
                                            </tr>
                                            <tr v-if="bill.bill_remain_val != 0 &&
                                                bill.pay_methods &&
                                                bill.pay_methods.id != 4
                                                ">
                                                <td colspan="2">الباقي:</td>
                                                <td colspan="2">
                                                    {{ bill.bill_remain_val }}
                                                </td>
                                            </tr>
                                            <tr v-else-if="bill.pay_methods &&
                                                bill.pay_methods.id == 4
                                                ">
                                                <td colspan="2">
                                                    المدفوع شبكة:
                                                </td>
                                                <td colspan="2">
                                                    {{ bill.card }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">الاجمالي:</td>
                                                <td colspan="2">
                                                    {{ bill.bill_total }}
                                                    <!-- <small style="display: block">
                                                    {{ bill.billTotal }}</small
                                                > -->
                                                </td>
                                            </tr>
                                            <tr v-if="bill.return_sum > 0">
                                                <td colspan="2">
                                                    مجموع المرتجعات:
                                                </td>
                                                <td colspan="2">
                                                    {{ bill.return_sum }}
                                                </td>
                                            </tr>
                                            <tr v-if="bill.return_vat > 0">
                                                <td colspan="2">
                                                    ضريبة القيمة المضافة
                                                    للمترجعات({{
                                                        mixins.mixins_vat_val
                                                    }}%):
                                                </td>
                                                <td colspan="2">
                                                    {{ bill.return_vat }}
                                                </td>
                                            </tr>
                                            <tr v-if="bill.total_returned > 0">
                                                <td colspan="2">
                                                    اجمالي المرتجعات:
                                                </td>
                                                <td colspan="2">
                                                    {{ bill.total_returned }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!--End Table-->
                                <div v-if="mixins.mixins_note">
                                    <ul class="navbar-nav row text-center">
                                        <li class="col-12"
                                            v-for="(
                                                                                                                                                                                                note, index
                                                                                                                                                                                            ) in mixins.mixins_note.split(',')"
                                            :key="index">
                                            {{ note }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div v-if="mixins.mixins_name != null &&
                                !mixins.mixins_name.isEmpty &&
                                mixins.contruct_no != null &&
                                mixins.country == 2
                                " class="text-center mt-1">
                                <img :src="qr" height="120" />
                            </div>
                            <!--End InvoiceBot-->
                            <div v-if="bill.bill_notes" class="footer text-center text-wrap">
                                {{ bill.bill_notes }}
                            </div>
                            <div v-if="mixins.country == 2" class="footer text-center"
                                style="
                                                                                                                                                                                    font-size: 8px;
                                                                                                                                                                                    font-weight: bolder;
                                                                                                                                                                                    margin-top: 3px;
                                                                                                                                                                                ">
                                تقنيات اليوم للحلول البرمجية
                                <i class="fa fa-phone"></i>
                                +966557179844 -
                                <i class="fa fa-phone"></i> +966561420027 .
                            </div>
                            <div v-else class="footer text-center"
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
                        </div>
                        <!--End Invoice-->
                    </div>
                    <div id="tokitchenModal" class="pos-section" style="visibility: hidden" v-if="isSendToKetchen">
                        <iframe id="printFrame" name="display-frame-print"></iframe>

                        <!--End Invoice-->
                        <br />
                        <a id="distributedir" target="display-frame-print" class="btn btn-success"
                            :href="'/printTokitchendir/' + bill.bill_no">{{ __("PrintOnly") }}</a>
                    </div>
                    <div class="modal-footer text-center">
                        <button id="print" class="btn btn-secondary" data-dismiss="modal" type="button">
                            إغلاق
                        </button>
                        <button id="printer" class="btn btn-success d-none" @click="print()">
                            طباعة
                        </button>
                        <button class="btn btn-success" @click="printOne()">
                            طباعة
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";

export default {
    props: ["bill", "qr", "isSendToKetchen"],

    async created() {
        if (!User.loggedIn()) {
            this.$router.push("/");
        }
        let user = await Auth.getAuth();
        this.mixins = user.branch;

        this.orderNum = localStorage.getItem("orderNum");
    },
    updated() {
        this.orderNum = localStorage.getItem("orderNum");
    },
    data() {
        return {
            isDone: false,
            mixins: {},
            moment: moment,
            isclicked: false,
            mydata: [],
            billTotal: "",
            orderNum: 0,
        };
    },

    methods: {
        printOne() {
            this.$htmlToPaper("printMe");
        },
        handlePrint() {
            var sOption = "toolbar=no,location=no,width=302,directories=yes,menubar=no,scrollbars=yes";
            var winPrint = window.open("", "", sOption);
            winPrint.document.open();
            winPrint.document.write("<html>");
            winPrint.document.write(`<head>
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link href="${window.location.origin}/backend/vendor/bootstrap/css/bootstrap.rtl.css" rel="stylesheet" type="text/css">
                <link href="${window.location.origin}/backend/vendor/bootstrap/css/bootstrap.rtl.css" rel="stylesheet" type="text/css"  media="print">
                 <link href="${window.location.origin}/css/print.css" rel="stylesheet" type="text/css" >
                <link href="${window.location.origin}/css/print.css" rel="stylesheet" type="text/css" media="print">
            `);

            winPrint.document.write("<body ><div class='pos-section zoom'> ");
            winPrint.document.write('<input class=" text-center m-auto  btn-info hideBtn" type="button" value="طباعة" onclick="window.focus(); window.print();window.close(); return false;"');
            winPrint.document.write(
                document.getElementById("printMe").innerHTML
            );

            winPrint.document.write("</div></body></html>");
            winPrint.document.close();

            winPrint.focus();


        },
        async print() {
            for (var count = 0; count < this.mixins.printer_count; count++) {
                this.$htmlToPaper('printMe');
            }
        },
    },
};
</script>

<style scoped>
</style>
