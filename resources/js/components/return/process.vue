<template>
    <div>
        <div v-if="!loading">
            <!--Start Selected Items-->
            <div class="selected text-center">
                <div class="card mb-4 text-center">
                    <div class="card-header">
                        <div
                            class="d-flex align-items-center justify-content-between hideMeInPrint"
                        >
                            <a
                                class="btn btn-warning text-light"
                                @click="$router.go(-1)"
                            >
                                <i
                                    :class="
                                        $root.$data.codies.default_lang == 'ar'
                                            ? 'fa fa-arrow-right'
                                            : 'fa fa-arrow-left'
                                    "
                                ></i>
                            </a>
                            <h6 class="m-0 font-weight-bold text-primary">
                                {{ __("Process Bill") }}
                            </h6>

                            <h6
                                class="m-0 font-weight-bold text-primary float-left"
                            >
                                <input
                                    class="form-control"
                                    :placeholder="__('Bill Number')"
                                    type="text"
                                    v-model="bill_id"
                                    @keyup="findBill()"
                                />
                            </h6>
                            <h6
                                class="m-0 font-weight-bold text-primary float-left d-none"
                            >
                                <input
                                    class="form-control-sm w-75"
                                    :placeholder="__('Barcode')"
                                    type="text"
                                    v-model="barcode"
                                    @keyup="findBillByTypeId()"
                                />
                            </h6>

                            <form
                                v-show="!period"
                                class="needs-validation"
                                @submit.prevent="allBills"
                            >
                                <div class="form-row">
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <div
                                                class="input-group-prepend"
                                                style="width: 50px !important"
                                            >
                                                <span
                                                    id="validationTooltipUsernamePrepend"
                                                    class="input-group-text"
                                                    >{{ __("From") }}</span
                                                >
                                            </div>
                                            <date-picker
                                                v-model="reportPeriod.from"
                                                id="to"
                                                :wrap="true"
                                                :config="configs.wrap"
                                                required
                                            >
                                            </date-picker>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <div
                                                class="input-group-prepend float-right"
                                                style="width: 50px !important"
                                            >
                                                <span
                                                    class="input-group-text"
                                                    for="to"
                                                    >{{ __("To") }}</span
                                                >
                                            </div>
                                            <date-picker
                                                v-model="reportPeriod.to"
                                                id="to"
                                                :wrap="true"
                                                :config="configs.wrap"
                                                required
                                            >
                                            </date-picker>
                                        </div>
                                    </div>
                                    <button
                                        class="btn btn-success font-weight-bold text-light btn-sm"
                                        type="submit"
                                    >
                                        {{ __("View") }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body w-100 text-center">
                        <div
                            class="table-responsive"
                            id="printMeReport"
                            style="height: 50vh"
                        >
                            <table
                                id="resultTable"
                                class="text-center sortTable"
                                style="
                                    cellpadding: 20px;
                                    cellspacing: 0px;
                                    width: 100%;
                                "
                            >
                                <thead>
                                    <tr>
                                        <th style="width: 5%">
                                            {{ __("Bill Number") }}
                                        </th>
                                        <th style="width: 10%">
                                            {{ __("Sum") }}
                                        </th>
                                        <th style="width: 10%">
                                            {{ __("Vat") }}
                                        </th>
                                        <th style="width: 10%">
                                            {{ __("Total") }}
                                        </th>
                                        <th style="width: 5%">
                                            {{ __("Discount") }}
                                        </th>
                                        <th style="width: 10%">
                                            {{ __("Paid") }}
                                        </th>
                                        <th style="width: 10%">
                                            {{ __("Remain") }}
                                        </th>
                                        <th style="width: 20%">
                                            {{ __("Bill Date") }}
                                        </th>
                                        <th style="width: 5%">
                                            {{ __("Pay Methods") }}
                                        </th>
                                        <th style="width: 10%">
                                            {{ __("Customer Name") }}
                                        </th>
                                        <th style="width: 10%">
                                            {{ __("User Name") }}
                                        </th>
                                        <th style="width: 10%">
                                            {{ __("Notes") }}
                                        </th>
                                        <th
                                            class="hideMeInPrint"
                                            style="width: 10%"
                                        >
                                            {{ __("Print") }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="bill in bills"
                                        :key="bill.bill_no"
                                        @click="
                                            showBillDetails(bill);
                                            selected = bill.bill_no;
                                        "
                                    >
                                        <td
                                            :class="
                                                selected === bill.bill_no
                                                    ? 'selected'
                                                    : ''
                                            "
                                        >
                                            {{ bill.id }}
                                        </td>
                                        <td
                                            :class="
                                                selected === bill.bill_no
                                                    ? 'selected'
                                                    : ''
                                            "
                                        >
                                            {{ bill.bill_sum }}
                                        </td>
                                        <td
                                            :class="
                                                selected === bill.bill_no
                                                    ? 'selected'
                                                    : ''
                                            "
                                        >
                                            ({{ bill.vat }}%)
                                            {{ bill.bill_vat_val }}
                                        </td>
                                        <td
                                            :class="
                                                selected === bill.bill_no
                                                    ? 'selected'
                                                    : ''
                                            "
                                        >
                                            {{ bill.bill_total }}
                                        </td>
                                        <td
                                            :class="
                                                selected === bill.bill_no
                                                    ? 'selected'
                                                    : ''
                                            "
                                        >
                                            {{ bill.bill_discount }}
                                        </td>
                                        <td
                                            :class="
                                                selected === bill.bill_no
                                                    ? 'selected'
                                                    : ''
                                            "
                                        >
                                            {{ bill.bill_paid_val }}
                                        </td>
                                        <td
                                            :class="
                                                selected === bill.bill_no
                                                    ? 'selected'
                                                    : ''
                                            "
                                        >
                                            {{ bill.bill_remain_val }}
                                        </td>
                                        <td
                                            :class="
                                                selected === bill.bill_no
                                                    ? 'selected'
                                                    : ''
                                            "
                                        >
                                            {{ bill.bill_date }}
                                        </td>
                                        <td
                                            :class="
                                                selected === bill.bill_no
                                                    ? 'selected'
                                                    : ''
                                            "
                                        >
                                            {{
                                                bill.pay_methods.pay_method_name
                                            }}
                                        </td>
                                        <td
                                            :class="
                                                selected === bill.bill_no
                                                    ? 'selected'
                                                    : ''
                                            "
                                        >
                                            {{
                                                bill.customer
                                                    ? bill.customer.cust_name
                                                    : ""
                                            }}
                                        </td>
                                        <td
                                            :class="
                                                selected === bill.bill_no
                                                    ? 'selected'
                                                    : ''
                                            "
                                        >
                                            {{
                                                bill.user ? bill.user.name : ""
                                            }}
                                        </td>
                                        <td
                                            :class="
                                                selected === bill.bill_no
                                                    ? 'selected'
                                                    : ''
                                            "
                                        >
                                            {{ bill.bill_notes }}
                                        </td>
                                        <td>
                                            <button
                                                :disabled="!bill.returned"
                                                class="btn btn-sm btn-success"
                                                @click="print(bill)"
                                            >
                                                <i
                                                    class="fa fa-print text-light"
                                                ></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div
                                v-show="bills.length > 0"
                                class="row text-center d-none"
                            >
                                <ul class="pagination justify-content-center">
                                    <li
                                        :class="
                                            page == 1
                                                ? 'page-item disabled'
                                                : 'page-item'
                                        "
                                    >
                                        <a
                                            class="page-link"
                                            href="#"
                                            @click="nextPage(1)"
                                            >{{ __("First") }}</a
                                        >
                                    </li>
                                    <li
                                        :class="
                                            page == 1
                                                ? 'page-item disabled'
                                                : 'page-item'
                                        "
                                    >
                                        <a
                                            class="page-link"
                                            href="#"
                                            @click="nextPage(current_page - 1)"
                                            ><i class="fa fa-arrow-right"></i
                                        ></a>
                                    </li>
                                    <li
                                        class="page-item d-none"
                                        v-for="(i, index) in total"
                                        @click="nextPage(i)"
                                    >
                                        <a class="page-link" href="#">{{
                                            i
                                        }}</a>
                                    </li>
                                    <li
                                        :class="
                                            page == last_page
                                                ? 'page-item disabled'
                                                : 'page-item'
                                        "
                                    >
                                        <a
                                            class="page-link"
                                            href="#"
                                            @click="nextPage(current_page + 1)"
                                            ><i class="fa fa-arrow-left"></i
                                        ></a>
                                    </li>
                                    <li
                                        :class="
                                            page == last_page
                                                ? 'page-item disabled'
                                                : 'page-item'
                                        "
                                    >
                                        <a
                                            class="page-link"
                                            href="#"
                                            @click="nextPage(total + 1)"
                                            >{{ __("Last") }}</a
                                        >
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div
                        class="card-footer d-flex align-items-center justify-content-between hideMeInPrint"
                    >
                        <form
                            class="table-responsive d-flex align-items-center"
                            v-if="form != null"
                            direction="rtl"
                            @submit.prevent="saveBill"
                        >
                            <table class="table-bordered">
                                <tbody>
                                    <tr>
                                        <td>
                                            <b>{{ __("Sum") }}:</b>
                                        </td>
                                        <td>
                                            {{ format(returnBill.sum) }}
                                        </td>
                                        <td>
                                            <b> {{ __("Vat") }}:</b>
                                        </td>
                                        <td>
                                            {{ format(returnBill.vat) }}
                                        </td>
                                        <td>
                                            <b> {{ __("Total") }}:</b>
                                        </td>
                                        <td>
                                            {{ format(returnBill.total) }}
                                        </td>
                                        <td>
                                            <button
                                                class="btn btn-success font-weight-bold text-light"
                                                type="submit"
                                            >
                                                {{ __("Save") }}
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>

                <div style="min-height: 50vh">
                    <div class="w-100 table-wrapper">
                        <div id="pagewrap" class="row">
                            <div id="body" class="col-sm-12">
                                <table class="text-center">
                                    <thead>
                                        <tr>
                                            <th
                                                class="col-header"
                                                style="width: 50%"
                                            >
                                                {{ __("Type Name") }}
                                            </th>
                                            <th
                                                class="col-header"
                                                style="width: 10%"
                                            >
                                                {{ __("Count") }}
                                            </th>
                                            <th
                                                class="col-header"
                                                style="width: 10%"
                                            >
                                                {{ __("Sill Price") }}
                                            </th>
                                            <th
                                                class="col-header"
                                                style="width: 10%"
                                            >
                                                {{ __("Return Count") }}
                                            </th>
                                            <th
                                                class="col-header"
                                                style="width: 10%"
                                            >
                                                {{ __("Total Returend") }}
                                            </th>
                                            <th
                                                class="col-header"
                                                style="width: 10%"
                                            >
                                                {{ __("Total") }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(
                                                product, index
                                            ) in form.bill_type"
                                            :key="index"
                                        >
                                            <td
                                                class="font-weight-bold"
                                                :style="
                                                    product.has_Offer
                                                        ? 'color:red!important'
                                                        : ''
                                                "
                                            >
                                                {{ product.type.type_name_ar }}
                                            </td>
                                            <td class="font-weight-bold">
                                                {{ product.type_count }}
                                            </td>
                                            <td class="font-weight-bold">
                                                {{ product.type_price }}
                                            </td>
                                            <td class="font-weight-bold">
                                                <button
                                                    v-if="
                                                        product.total_return_qty !=
                                                        product.type_count
                                                    "
                                                    class="btn-sm mx-2 btn-warning"
                                                    @click="
                                                        decrement(
                                                            product,
                                                            index
                                                        )
                                                    "
                                                >
                                                    -
                                                </button>
                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    min="0"
                                                    v-if="
                                                        product.total_return_qty !=
                                                        product.type_count
                                                    "
                                                    v-model="
                                                        product.returned_qty
                                                    "
                                                    @keyup="
                                                        onChangeCount(product)
                                                    "
                                                    class="btn-sm text-center"
                                                    style="width: 70px"
                                                />
                                                <b v-else>{{
                                                    product.returned_qty
                                                }}</b>
                                                <button
                                                    v-if="
                                                        product.total_return_qty !=
                                                        product.type_count
                                                    "
                                                    class="btn-sm mx-2 btn-success"
                                                    :disabled="
                                                        product.has_Offer
                                                    "
                                                    @click="increment(product)"
                                                >
                                                    +
                                                </button>
                                            </td>

                                            <td class="font-weight-bold">
                                                <b class="btn text-bold">{{
                                                    product.returned_total
                                                }}</b>
                                            </td>
                                            <td class="font-weight-bold">
                                                {{ product.type_total_price }}
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody
                                        v-if="form.returns"
                                        v-for="(
                                            return_types, i
                                        ) in form.returns"
                                        :key="i"
                                    >
                                        <tr>
                                            <td
                                                colspan="6"
                                                class="font-weight-bold text-right"
                                            >
                                                {{ return_types.returns_date }}
                                                <hr class="my-0 bg-warning" />
                                            </td>
                                        </tr>
                                        <tr
                                            v-for="(
                                                product, index
                                            ) in return_types.return_types"
                                            :key="index"
                                        >
                                            <td
                                                class="font-weight-bold text-light bg-secondary"
                                            >
                                                {{ product.type.type_name_ar }}
                                            </td>
                                            <td
                                                class="font-weight-bold text-light bg-secondary text-light"
                                            >
                                                {{ product.returned_qty }}
                                            </td>
                                            <td
                                                class="font-weight-bold text-light bg-secondary text-light"
                                            >
                                                {{ product.type_price }}
                                            </td>
                                            <td
                                                class="font-weight-bold text-light bg-secondary text-light"
                                            >
                                                {{ product.returned_qty }}
                                            </td>
                                            <td
                                                class="font-weight-bold text-light bg-secondary text-light"
                                            >
                                                {{ product.returned_total }}
                                            </td>
                                            <td
                                                class="font-weight-bold text-light bg-secondary text-light"
                                            >
                                                {{ product.type_total_price }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Selected Items-->

            <div>
                <Rprinter :bill="bill" :qr="qr" :isSendToKetchen="false" />
            </div>
        </div>
        <Spinner v-else :title="title" />
    </div>
</template>

<script>
import { Invoice } from "@axenda/zatca";
import Rprinter from "../rprinter";
import Spinner from "../spinner/loading.vue";
import datePicker from "../date/index";
import "pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css";
import moment from "moment";

export default {
    components: { Rprinter, Spinner, datePicker },
    async created() {
        if (!User.loggedIn()) {
            await this.$router.push("/");
        }
        this.user = await Auth.getAuth();
        this.mixins = this.user.branch;

        this.reportPeriod.from = moment().add(-5, "days").format("yyyy-MM-DD");
        this.reportPeriod.to = moment().add(0, "days").format("yyyy-MM-DD");
        await this.allBills();
        await this.allPayMethods();
        this.reportPeriod.from = moment().add(-5, "days");
        this.reportPeriod.to = moment().add(0, "days");
    },

    data() {
        return {
            configs: {
                wrap: {
                    allowInputToggle: true,
                },
            },
            mixins: {},

            user: {},
            title: "Processing",
            searchTypes: [],
            showSearchTypeModal: false,
            output: null,
            qr: "",
            selected: null,
            isNewbill: true,
            isPrint: false,
            loading: false,
            products: [],
            payMethods: [],
            categories: [],
            category: {},
            customers: [],
            customer: {},
            search: "",
            id: "",
            searchName: "",
            typeName: "",
            isPercentDiscount: false,
            type: {},
            bill_id: "",
            barcode: "",
            bill: {},
            cart: [],
            form: {},
            bills: [],
            searchTerm: "",
            period: false,
            reportName: "",
            hideMe: false,
            total: 1,
            page: 1,
            current_page: "",
            lats_page: "",
            reportPeriod: {
                to: null,
                from: null,
            },
            last_page: 0,
            returnBill: {
                sum: 0.0,
                total: 0.0,
                vat: 0.0,
                cart: [],
                prevtype: [],
            },

            billTypes: [],
            typeUnit: {},
        };
    },
    methods: {
        async findBillToPrint(bill_no) {
            await axios
                .get("/api/bills/" + bill_no)
                .then(async ({ data }) => {
                    this.bill = data;
                })

                .catch((error) => console.log(error));
        },

        async print(bill) {
            await this.findBillToPrint(bill.bill_no);
            if (this.bill != null) {
                const invoice = new Invoice({
                    sellerName: this.mixins_name,
                    vatRegistrationNumber: this.contruct_no,
                    invoiceTimestamp: this.bill.returns.returns_date,
                    invoiceTotal: this.bill.returns.total,
                    invoiceVatTotal: this.bill.returns.vat,
                });
                this.qr = await invoice.render();
            }
            $("#Rbtn").click();
        },

        async allPayMethods() {
            await axios
                .get("/api/payMethods")
                .then(({ data }) => (this.payMethods = data))
                .catch((error) => console.log(error));
        },
        async findBill() {
            await axios
                .get("api/action/findBillById/" + this.bill_id)
                .then(async ({ data }) => {
                    if (data.length >= 0) {
                        this.bills = data;
                    } else {
                        Notification.customMsg(
                            "warning",
                            "topRight",
                            "لا يوجد فاتورة بهذا الرقم"
                        );
                    }
                })
                .catch((err) => console.log(err));
        },
        async findBillByTypeId() {
            await axios
                .get("api/action/findBillWithTypeId/" + this.barcode)
                .then(async ({ data }) => {
                    this.bills = [];
                    data.bill_type.map((bill) => {
                        this.bills.push(bill.bill);
                    });
                })
                .catch((err) => console.log(err));
        },

        async decrement(product, index) {
            if (product.returned_qty < 1) {
                product.returned_qty = 0;
                product.returned_total =
                    product.returned_qty * parseFloat(product.type_sill_price);
                this.$delete(this.cart, index);
            } else {
                product.returned_qty--;
            }
            if (
                Number(product.returned_qty) +
                    Number(product.total_return_qty) >
                product.type_count
            ) {
                product.returned_qty =
                    product.type_count - product.total_return_qty;
            }
            await this.calcSum();

            await this.calcTotalTypeCost(product);
        },
        format(num) {
            return parseFloat(num).toFixed(this.mixins.digit);
        },
        calcVat(total) {
            this.returnBill.vat = 0;
            if (!this.mixins.fixed_vat) {
                this.cart.filter((product) => {
                    this.returnBill.vat =
                        parseFloat(this.returnBill.vat) +
                        (product.returned_total * product.type_vat) / 100.0;
                });
                return;
            }
            if (this.form.vat > 0 && this.mixins.fixed_vat) {
                this.returnBill.vat = 0.0;
                let vatVal = this.form.vat;
                this.returnBill.vat = (Number(total) * Number(vatVal)) / 100.0;
            }
        },
        async increment(product) {
            if (this.cart.includes(product)) {
                if (
                    Number(product.returned_qty) +
                        Number(product.total_return_qty) >=
                    product.type_count
                ) {
                    product.returned_qty =
                        product.type_count - product.total_return_qty;
                    return;
                }
                if (product.returned_qty == product.type_count) {
                    product.returned_qty = product.type_count;
                } else {
                    product.returned_qty++;
                }
            } else {
                product.returned_qty = 1;
                this.cart.push(product);
            }

            await this.calcTotalTypeCost(product);
        },
        onChangeCount(product) {
            if (
                product.returned_qty <= 1 ||
                product.returned_qty > product.type_count
            ) {
                product.returned_qty = 1;
            }
            if (
                Number(product.returned_qty) +
                    Number(product.total_return_qty) >
                product.type_count
            ) {
                product.returned_qty =
                    product.type_count - product.total_return_qty;
            }
            this.calcTotalTypeCost(product);
        },
        onChangeTypeCost(product) {
            if (product.type_price < product.minimum_sill_price) {
                product.type_price = product.minimum_sill_price;
            }
            this.calcTotalTypeCost(product);
        },
        async findUnit(product) {
            await axios
                .get("/api/units/" + product.sell_unit)
                .then(({ data }) => {
                    this.typeUnit = data;
                })
                .catch((error) => console.log(error));
        },
        async calcUnitPrice(product) {
            if (product.sell_unit !== null) {
                await this.findUnit(product);
                if (product.type_stock !== null) {
                    var totalNofUnit =
                        this.typeUnit.no_of_unit *
                        parseFloat(
                            product.type.type_stock.mixins_type_stock +
                                product.returned_qty
                        );
                    product.calc_count =
                        totalNofUnit / this.typeUnit.no_of_unit;
                }
            }
        },
        async calcTotalTypeCost(product) {
            if (this.use_type_uints) {
                await this.calcUnitPrice(product);
            }
            product.returned_total =
                product.returned_qty * parseFloat(product.type_price);
            await this.calcDef(product);
        },
        async calcDef(product) {
            if (parseFloat(product.type_discount_value) > 0) {
                product.total_type_cost =
                    (product.type_count - product.returned_qty) *
                    product.type_sill_price;
                product.total_type_cost =
                    product.total_type_cost - product.type_discount_value;
                await this.calcSum();
                return;
            }

            product.total_type_cost =
                (product.type_count - product.returned_qty) *
                parseFloat(product.type_sill_price);
            await this.calcSum();
        },
        async calcSum() {
            this.returnBill.sum = 0;
            this.cart.filter((product) => {
                product.returned_total =
                    parseFloat(product.returned_total) -
                    parseFloat(product.type_discount);
                this.returnBill.sum =
                    parseFloat(this.returnBill.sum) +
                    parseFloat(product.returned_total);
            });
            if (this.form.is_included && this.form.vat > 0) {
                this.returnBill.sum =
                    this.returnBill.sum / (1 + this.form.vat / 100.0);
            }

            await this.calcTotal();
        },
        async calcTotal() {
            this.returnBill.total = 0;
            this.returnBill.total = this.returnBill.sum;
            this.returnBill.total =
                parseFloat(this.returnBill.total) -
                parseFloat(this.returnBill.total) *
                    (parseFloat(this.form.bill_discount) / 100.0);

            if (this.form.customer != null) {
                this.returnBill.total =
                    parseFloat(this.returnBill.total) -
                    parseFloat(this.returnBill.total) *
                        (parseFloat(this.form.customer.cust_discount_percent) /
                            100.0);
            }
            this.calcVat(this.returnBill.total);

            this.returnBill.total =
                parseFloat(this.returnBill.total) +
                parseFloat(this.returnBill.vat);

            //Form number
            this.returnBill.vat = this.format(this.returnBill.vat);

            this.returnBill.sum = this.format(this.returnBill.sum);
            if (this.mixins.smoken_vat) {
                this.returnBill.total = this.returnBill.total * 2;
            }
            this.returnBill.total = this.format(this.returnBill.total);
        },
        async saveBill() {
            let isValid = true;
            if (this.cart.length <= 0) {
                isValid = false;
                Notification.customMsg(
                    "error",
                    "topRight",
                    "لايمكن حفظ فاتورة بدون أصناف"
                );
                return;
            }
            if (this.form.total <= 0) {
                isValid = false;
                Notification.customMsg(
                    "error",
                    "topRight",
                    "لايمكن حفظ فاتورة قيمتها صفر"
                );
                return;
            }

            if (isValid) await this.saveValidBill();
        },
        async saveValidBill() {
            this.returnBill.cart = this.cart;
            this.returnBill.prevtype = this.form.bill_type;
            this.returnBill.process_bills = true;
            this.returnBill.user_id = this.user.id;
            this.returnBill.pay = this.form.bill_paid_type;
            if (this.returnBill.cart.length > 0) {
                await axios
                    .patch("api/bills/" + this.form.bill_no, this.returnBill)
                    .then(async (data) => {
                        Notification.success();
                        this.clearAll();
                        this.allBills();
                        // this.bill_id = this.form.id;
                        // this.findBill();
                    })
                    .catch((error) => {
                        console.log(error);
                        Notification.errorMsg(error.response.data.error);
                    });
            } else {
                Notification.error();
            }
        },
        clearAll() {
            this.form = {};
            this.form.bill_type = [];
            this.cart = [];
            this.returnBill = {
                sum: 0.0,
                total: 0.0,
                vat: 0.0,
                cart: [],
                prevtype: [],
            };
            this.customer = {};
            this.search = "";
            this.isPrint = false;
        },

        nextPage(i) {
            this.page = i;
            this.allBills();
        },
        printMe() {
            this.$htmlToPaper("printMeReport");
        },
        allBills() {
            this.reportPeriod.from = moment(this.reportPeriod.from).format(
                "yyyy-MM-DD"
            );
            this.reportPeriod.to = moment(this.reportPeriod.to).format(
                "yyyy-MM-DD"
            );

            axios
                .get(
                    "/api/bill/report/" +
                        this.period +
                        "/" +
                        this.reportPeriod.from +
                        "/" +
                        this.reportPeriod.to +
                        "/25"
                )
                .then(({ data }) => {
                    if (data != null && data.data.length >= 0) {
                        this.loading = false;
                        this.total = parseInt(data.total / data.per_page);
                        this.current_page = data.current_page;
                        this.bills = data.data;
                        this.last_page = data.last_page;
                    }
                })
                .catch((error) => console.log(error));
        },
        async showBillDetails(bill) {
            this.clearAll();
            this.form = bill;
        },
    },
};
</script>
<style scoped>
b.btn {
    float: right;
}

.fa {
    cursor: pointer;
}

:root {
    --secondary: linear-gradient(221deg, #8743ff, #4136f1 60%);
    --body: #eaf2ff;
    --card: #fff;
    --text: #000;
    --price: #4136f1;
}

body {
    /*background: var(--secondary);*/
    transition: background 0.3s;
    gap: 20px;
    font-family: "Poppins", sans-serif;
}

.newBill .card {
    background: var(--card);
    font-family: "Poppins", sans-serif;
    display: flex;
    color: var(--text);
    flex-direction: column;
    align-items: flex-start;
    transition: transform 0.3s, background 0.3s;
}

.newBill .card-header {
    font-weight: bolder;
}

.newBill .card img {
    width: 160px;
    height: 120px;
    border-radius: 14px;
    object-fit: cover;
}

.newBill .card__title {
    margin-top: 16px;
    font-size: 15px;
    font-weight: 400;
    transition: color 0.3s;
}

.newBill .card__shop {
    width: 100%;
    margin-top: auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.newBill .card__shop__action span {
    color: #fff;
    font-size: 26px;
}
</style>
