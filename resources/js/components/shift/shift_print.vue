<template>
    <div v-if="shift && shift.current_user && shift.recived_user">
        <button id="shiftBtn" class="btn btn-info text-light d-none" data-target="#shiftModal" data-toggle="modal"
            @click="report">
            <i class="fas fa-ellipsis-v"></i>
        </button>
        <div id="shiftModal" aria-hidden="true" aria-labelledby="shiftModal" class="modal fade" role="dialog" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content m-auto">
                    <div class="modal-header">
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="printMe" class="modal-body">
                        <div class="pos-section">
                            <!--End InvoiceTop-->
                            <div id="table">
                                <div v-if="loaded" class="alert alert-warning text-center">
                                    جاري تجهيز تقرير الاصناف
                                </div>
                                <table v-else class="text-center">
                                    <thead>
                                        <tr>
                                            <th>{{ __("Type Name") }}</th>
                                            <th>{{ __("Count") }}</th>

                                            <th>
                                                {{ __("total_sill_price") }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="types.length > 0">
                                        <tr v-for="type in types">
                                            <td>
                                                {{ type.type.type_name_ar }}
                                            </td>
                                            <td>{{ type.count }}</td>
                                            <td>{{ type.price }}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot v-if="types.length > 0">
                                        <tr>
                                            <th>الاجمالي</th>
                                            <td>{{ total_cost }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <table id="resultTable" class="text-center w-100">
                                    <tbody>
                                        <tr>
                                            <th>تاريخ بداية الشيفت</th>

                                            <td>{{ shift.starter_date }}</td>
                                        </tr>
                                        <tr>
                                            <th>مسئول الشيفت</th>

                                            <td>
                                                {{ shift.current_user.name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>المبلغ المحول</th>

                                            <td>
                                                {{ format(shift.transfer) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>نقدي</th>

                                            <td>{{ format(shift.cash) }}</td>
                                        </tr>
                                        <tr>
                                            <th>اجل</th>

                                            <td>{{ format(shift.later) }}</td>
                                        </tr>
                                        <tr>
                                            <th>بطاقة</th>

                                            <td>{{ format(shift.card) }}</td>
                                        </tr>
                                        <tr>
                                            <th>عجز</th>

                                            <td :class="
                                                shift.deficit > 0
                                                    ? 'bg-warning text-light'
                                                    : ''
                                            ">
                                                {{ format(shift.deficit) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>زيادة</th>

                                            <td :class="
                                                shift.increase > 0
                                                    ? 'bg-danger text-light'
                                                    : ''
                                            ">
                                                {{ format(shift.increase) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>متبقي</th>

                                            <td>{{ format(shift.remain) }}</td>
                                        </tr>
                                        <tr>
                                            <th>تاريخ نهاية الشفت</th>

                                            <td>{{ shift.end_date }}</td>
                                        </tr>
                                        <tr>
                                            <th>الموظف المستلم</th>

                                            <td>
                                                {{ shift.recived_user.name }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table v-if="!loaded" class="text-center w-100">
                                    <tbody>
                                        <tr>
                                            <th>اجمالي جميع الفواتير</th>
                                            <th>
                                                {{
                                                    format(calcBills.total ?? 0)
                                                }}
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>اجمالي الضريبة</th>
                                            <th>
                                                {{ format(calcBills.Vat ?? 0) }}
                                            </th>
                                        </tr>
                                        <tr v-if="mixins.country == 2">
                                            <th>
                                                اجمالي جميع الفواتير المعالجة
                                            </th>
                                            <th>
                                                {{
                                                    format(
                                                        calcProcess.total ?? 0
                                                    )
                                                }}
                                            </th>
                                        </tr>
                                        <tr v-if="mixins.country == 2">
                                            <th>اجمالي الضريبة المعالجة</th>
                                            <th>
                                                {{
                                                    format(calcProcess.Vat ?? 0)
                                                }}
                                            </th>
                                        </tr>
                                        <tr v-if="mixins.country == 2">
                                            <th>اجمالي المصروفات</th>
                                            <th>
                                                {{
                                                    format(
                                                        calcExpense.total ?? 0
                                                    )
                                                }}
                                            </th>
                                        </tr>
                                        <tr v-if="mixins.country == 2">
                                            <th>اجمالي ضريبة المصروفات</th>
                                            <th>
                                                {{
                                                    format(calcExpense.Vat ?? 0)
                                                }}
                                            </th>
                                        </tr>
                                        <tr v-if="mixins.country == 2">
                                            <th>
                                                الفرق بين الفواتير الاساسية
                                                والمعالجة والمصروفات
                                            </th>
                                            <th>
                                                {{
                                                    format(
                                                        format(
                                                            calcBills.total
                                                        ) -
                                                        format(
                                                            calcProcess.total
                                                        ) -
                                                        format(
                                                            calcExpense.total
                                                        )
                                                    )
                                                }}
                                            </th>
                                        </tr>
                                        <tr v-if="mixins.country == 2">
                                            <th>
                                                الفرق بين ضريبة الفواتير
                                                الاساسية والمعالجة والمصروفات
                                            </th>
                                            <th>
                                                {{
                                                    format(
                                                        format(calcBills.Vat) -
                                                        format(
                                                            calcProcess.Vat
                                                        ) -
                                                        format(
                                                            calcExpense.Vat
                                                        )
                                                    )
                                                }}
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                                <!--End Table-->
                            </div>

                            <!--End InvoiceBot-->
                        </div>
                        <!--End Invoice-->
                    </div>

                    <div class="modal-footer text-center">
                        <button id="print" class="btn btn-secondary" data-dismiss="modal" type="button">
                            إغلاق
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
    props: ["shift"],

    async created() {
        if (!User.loggedIn()) {
            this.$router.push("/");
        }
        let user = await Auth.getAuth();
        this.user = user;
        this.mixins = user.branch;
        this.period = "period";
    },

    data() {
        return {
            moment: moment,
            period: "period",
            types: [],
            total_cost: 0.0,
            user: {},
            mixins: {},
            calcBills: [],
            calcPur: [],
            calcExpense: [],
            calcProcess: [],
            loaded: true,
        };
    },

    methods: {
        format(num) {
            return parseFloat(num).toFixed(this.mixins.digit);
        },
        async printOne() {
            this.$htmlToPaper("printMe");
        },
        add(type) {
            this.total_cost = 0.0;
            let count = type.type_count;
            let rQty = type.total_return_qty;
            count -= rQty;
            let price = count * type.type_price;
            const found = this.types.some(
                (el) => parseInt(el.type.type_id) === parseInt(type.type_id)
            );
            if (!found) {
                this.types.push({ price, count, type: type.type });
            } else {
                this.types.filter((el) => {
                    if (parseInt(el.type.type_id) === parseInt(type.type_id)) {
                        el.count += count;
                        el.price += price;
                    }
                });
            }
            this.types.forEach((el) => {
                let vat = 0;
                if (
                    !this.mixins.mixins_price_include_vat &&
                    this.mixins.fixed_vat
                ) {
                    let vatVal = this.mixins.mixins_vat_val;
                    vat = el.price * (vatVal / 100.0);
                }
                this.total_cost += el.price + vat;

            });
        },
        async report() {
            await this.veiwCalcReport();

            this.types = [];
            await axios
                .get(
                    "/RTypes?period=" +
                    this.period +
                    "&branch_id=" +
                    this.user.branch_id +
                    "&from=" +
                    this.shift.starter_date +
                    "&to=" +
                    this.shift.end_date
                )
                .then((res) => {
                    res.data.forEach((el) => {
                        this.add(el);
                    });
                    this.loaded = false;
                });
        },
        async veiwCalcReport() {
            await this.calcExpenseFunc();
            await this.calc();
            await this.calcProcessFunc();
            await this.calcPurFunc();
        },
        async calcPurFunc() {
            await axios
                .get(
                    "/api/purbill/calc/" +
                    this.period +
                    "/" +
                    this.shift.starter_date +
                    "/" +
                    this.shift.end_date
                )
                .then(({ data }) => {
                    this.calcPur = data;
                })
                .catch((error) => console.log(error));
        },

        async calcProcessFunc() {
            await axios
                .get(
                    "/api/process/calc/" +
                    this.period +
                    "/" +
                    this.shift.starter_date +
                    "/" +
                    this.shift.end_date
                )
                .then(({ data }) => {
                    this.calcProcess = data;
                })
                .catch((error) => console.log(error));
        },
        async calcExpenseFunc() {
            await axios
                .get(
                    "/api/expense/calc/" +
                    this.period +
                    "/" +
                    this.shift.starter_date +
                    "/" +
                    this.shift.end_date
                )
                .then(({ data }) => {
                    this.calcExpense = data;
                })
                .catch((error) => console.log(error));
        },

        async calc() {
            await axios
                .get(
                    "/api/bill/calc/" +
                    this.period +
                    "/" +
                    this.shift.starter_date +
                    "/" +
                    this.shift.end_date
                )
                .then(({ data }) => {
                    this.calcBills = data;
                })
                .catch((error) => console.log(error));
        },
    },
};
</script>

<style scoped></style>
