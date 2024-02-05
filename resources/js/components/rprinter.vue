<template>
    <div v-if="bill && mixins && bill.last_return">
        <a
            id="Rbtn"
            class="btn btn-info text-light d-none"
            data-target="#AllprintModal"
            data-toggle="modal"
            ><i class="fas fa-ellipsis-v"></i
        ></a>
        <div
            id="AllprintModal"
            aria-hidden="true"
            aria-labelledby="RprintModal"
            class="modal fade"
            role="dialog"
            tabindex="-1"
        >
            <div
                class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                role="document"
                v-for="(return_types, i) in bill.returns"
                :key="i"
            >
                <div class="modal-content m-auto">
                    <div
                        :id="'printMe' + return_types.return_id"
                        class="modal-body"
                    >
                        <div id="invoice-POS" class="pos-section">
                            <div id="top" style="text-align: center">
                                <div class="logo">
                                    <img
                                        :src="mixins.mixins_logo"
                                        style="
                                            width: 50px;
                                            height: 50px;
                                            border-radius: 50%;
                                        "
                                    />
                                </div>
                                <div class="info">
                                    <h5>{{ mixins.mixins_name }}</h5>
                                </div>
                                <div class="info">
                                    <h5>{{ mixins.mixins_adress }}</h5>
                                </div>
                                <div class="info">
                                    <h5>{{ mixins.mixins_mobile }}</h5>
                                </div>
                                <!--End Info-->
                                <div
                                    v-if="bill.customer != null"
                                    class="text-center"
                                >
                                    <small
                                        v-if="
                                            bill.customer.cust_vat_num &&
                                            mixins.mixins_vat_val > 0
                                        "
                                    >
                                        اشعار فاتورة ضريبية
                                    </small>
                                    <small v-else-if="mixins.mixins_vat_val > 0"
                                        >اشعار فاتورة ضريبية مبسطة
                                    </small>
                                </div>
                                <div v-else class="text-center">
                                    <small v-if="mixins.mixins_vat_val > 0">
                                        اشعار فاتورة ضريبية مبسطة</small
                                    >
                                </div>
                                <small>{{ return_types.return_id }}</small>
                            </div>
                            <!--End InvoiceTop-->

                            <div id="bot">
                                <div id="table">
                                    <table
                                        id="resultTable"
                                        class="text-center w-100"
                                    >
                                        <tr>
                                            <td class="no-border">
                                                رقم الفاتوره
                                            </td>
                                            <td class="no-border">
                                                {{ bill.id }}
                                            </td>
                                            <td class="no-border">
                                                تاريخ الفاتوره
                                            </td>
                                            <td class="no-border">
                                                {{ return_types.returns_date }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="no-border">
                                                مستخدم النظام
                                            </td>
                                            <td class="no-border">
                                                {{ return_types.user.name }}
                                            </td>
                                            <td
                                                class="no-border"
                                                v-if="bill.pay_methods != null"
                                            >
                                                طريقة الدفع
                                            </td>
                                            <td
                                                class="no-border"
                                                v-if="bill.pay_methods != null"
                                            >
                                                {{
                                                    bill.pay_methods
                                                        .pay_method_name
                                                }}
                                            </td>
                                        </tr>
                                        <tr v-if="bill.customer">
                                            <td class="no-border">
                                                اسم العميل
                                            </td>
                                            <td class="no-border">
                                                {{ bill.customer.cust_name }}
                                            </td>
                                            <td class="no-border">
                                                هاتف العميل
                                            </td>
                                            <td class="no-border">
                                                {{ bill.customer.cust_mobile }}
                                            </td>
                                        </tr>
                                        <tr
                                            v-if="
                                                bill.customer &&
                                                bill.customer.cust_address
                                            "
                                        >
                                            <td class="no-border">
                                                عنوان العميل
                                            </td>

                                            <td class="no-border">
                                                {{ bill.customer.cust_address }}
                                            </td>
                                            <td class="no-border">
                                                رصيد العميل
                                            </td>

                                            <td class="no-border">
                                                {{ bill.customer.cust_balance }}
                                            </td>
                                        </tr>

                                        <tbody v-if="bill.returns">
                                            <tr>
                                                <th style="width: 40%">
                                                    اسم الصنف
                                                </th>
                                                <th style="width: 20%">
                                                    العدد
                                                </th>
                                                <th style="width: 20%">
                                                    السعر
                                                </th>
                                                <th style="width: 20%">
                                                    الاجمالي
                                                </th>
                                            </tr>
                                            <tr
                                                v-for="(
                                                    product, index
                                                ) in return_types.return_types"
                                                :key="index"
                                            >
                                                <td class="font-weight-bold">
                                                    {{
                                                        product.type
                                                            .type_name_ar
                                                    }}
                                                </td>
                                                <td class="font-weight-bold">
                                                    {{ product.returned_qty }}
                                                </td>
                                                <td class="font-weight-bold">
                                                    {{ product.type_price }}
                                                </td>

                                                <td class="font-weight-bold">
                                                    {{ product.returned_total }}
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot v-if="return_types">
                                            <tr>
                                                <td
                                                    colspan="2"
                                                    class="no-border"
                                                >
                                                    المجموع:
                                                </td>
                                                <td
                                                    colspan="2"
                                                    class="no-border"
                                                >
                                                    {{ return_types.sum }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    colspan="2"
                                                    class="no-border"
                                                >
                                                    ضريبة القيمة المضافة ({{
                                                        bill.vat
                                                    }}%):
                                                    <small
                                                        class="d-block"
                                                        v-if="
                                                            mixins.mixins_price_include_vat
                                                        "
                                                        >الاسعار شاملة
                                                        الضريبة</small
                                                    >
                                                </td>
                                                <td
                                                    colspan="2"
                                                    class="no-border"
                                                >
                                                    {{ return_types.vat }}
                                                </td>
                                            </tr>
                                            <tr v-if="mixins.smoken_vat">
                                                <td
                                                    colspan="2"
                                                    class="no-border"
                                                >
                                                    ضريبة التبغ :
                                                </td>
                                                <td
                                                    colspan="2"
                                                    class="no-border"
                                                >
                                                    100%
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    colspan="2"
                                                    class="no-border"
                                                >
                                                    الاجمالي:
                                                </td>
                                                <td
                                                    colspan="2"
                                                    class="no-border"
                                                >
                                                    {{ return_types.total }}
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!--End Table-->
                            </div>
                            <div
                                v-if="
                                    mixins.mixins_name != null &&
                                    !mixins.mixins_name.isEmpty &&
                                    mixins.contruct_no != null &&
                                    !mixins.mixins_name.contruct_no
                                "
                                class="text-center mt-1"
                            >
                                <img :src="qr" height="120" />
                            </div>
                            <!--End InvoiceBot-->
                        </div>

                        <!--End Invoice-->
                    </div>

                    <div class="modal-footer text-center">
                        <button
                            id="print"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                            type="button"
                        >
                            إغلاق
                        </button>
                        <button
                            id="Rprinter"
                            class="btn btn-success"
                            @click="print('printMe' + return_types.return_id)"
                        >
                            طباعة
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Invoice } from "@axenda/zatca";

export default {
    async created() {
        let user = await Auth.getAuth();
        this.mixins = user.branch;
    },
    props: ["bill", "qr"],
    data() {
        return {
            isDone: false,
            mixins: {},
        };
    },
    methods: {
        print(id) {
            this.$htmlToPaper(id);
        },
    },
};
</script>

<style scoped></style>
