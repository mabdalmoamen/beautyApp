<template>
    <div id="PrintMeAll">
        <!-- Datatables -->
        <div v-if="!loading" class="card" id="allReport">
            <div class="card-header hideMeInPrint">
                <div class="hideMeInPrint w-100 d-flex justify-content-between">
                    <a class="btn btn-warning text-light" @click="$router.go(-1)">
                        <i :class="$root.$data.codies.default_lang == 'ar'
                            ? 'fa fa-arrow-right'
                            : 'fa fa-arrow-left'
                            "></i>
                    </a>
                    <h1 class="text-center my-0 btn-sm d-block">
                        {{
                            period == "daily"
                            ? __("Today Report")
                            : period == "monthly"
                                ? __("Monthly Report")
                                : __("Period Report")
                        }}
                    </h1>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                        {{ __("Details") }}
                    </button>
                    <i class="fas fa-file-excel text-success hideMeInPrint fa-2x" style="cursor: pointer"
                        onclick="download('xlsx','allReport');"></i>

                    <button class="btn btn-success" @click="printAll()" type="submit">
                        {{ __("Print") }}
                    </button>

                    <form class="needs-validation mt-2 hideMeInPrint" v-if="!period" @submit.prevent="veiwReport">
                        <div class="form-row">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <div class="input-group-prepend input-sm">
                                        <span for="from" class="input-group-text">{{ __("From") }}</span>
                                    </div>
                                    <date-picker v-model="reportPeriod.form" id="from" :wrap="true" :config="configs.wrap"
                                        required :placeholder="__('From')">
                                    </date-picker>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <div class="input-group-prepend float-right input-sm">
                                        <span class="input-group-text" for="to">{{ __("To") }}</span>
                                    </div>
                                    <date-picker v-model="reportPeriod.to" id="to" :wrap="true" :config="configs.wrap"
                                        required :placeholder="__('To')">
                                    </date-picker>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-success" type="submit">
                                    {{ __("View") }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <Bills :bills="bills" :calcBills="calcBills" />
                <div v-show="bills.length > 0" class="row text-center">
                    <ul class="pagination justify-content-center">
                        <li :class="page == 1 ? 'page-item disabled' : 'page-item'
                            ">
                            <a class="page-link" href="#" @click="nextPage(1)">{{ __("First") }}</a>
                        </li>
                        <li :class="page == 1 ? 'page-item disabled' : 'page-item'
                            ">
                            <a class="page-link" href="#" @click="nextPage(current_page - 1)"><i
                                    class="fa fa-arrow-right"></i></a>
                        </li>
                        <li class="page-item d-none" v-for="(i, index) in total" @click="nextPage(i)" :key="index">
                            <a class="page-link" href="#">{{ i }}</a>
                        </li>
                        <li :class="page == last_page
                            ? 'page-item disabled'
                            : 'page-item'
                            ">
                            <a class="page-link" href="#" @click="nextPage(current_page + 1)"><i
                                    class="fa fa-arrow-left"></i></a>
                        </li>
                        <li :class="page == last_page
                            ? 'page-item disabled'
                            : 'page-item'
                            ">
                            <a class="page-link" href="#" @click="nextPage(total + 1)">{{ __("Last") }}</a>
                        </li>
                    </ul>
                </div>
                <hr />
                <PurachaseBills :purachaseBills="purachaseBills" :calcPur="calcPur" />

                <hr />

                <Expenses :expenses="expenses" :calcExpense="calcExpense" />
                <hr />

                <div>
                    <Process :process="process" :calcProcess="calcProcess" />
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">
                                تفاصيل
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body pos-section">
                            <div class="card">
                                <div id="PrintMe" class="card-body table-responsive">
                                    <table id="invoice-POS" class="pos-section">
                                        <tbody>
                                            <tr>
                                                <th>اجمالي جميع الفواتير</th>
                                                <th>
                                                    {{
                                                        format(
                                                            calcBills.total ?? 0
                                                        )
                                                    }}
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>اجمالي الضريبة</th>
                                                <th>
                                                    {{
                                                        format(
                                                            calcBills.Vat ?? 0
                                                        )
                                                    }}
                                                </th>
                                            </tr>
                                            <tr v-if="mixins.country == 2">
                                                <th>
                                                    اجمالي جميع الفواتير
                                                    المعالجة
                                                </th>
                                                <th>
                                                    {{
                                                        format(
                                                            calcProcess.total ??
                                                            0
                                                        )
                                                    }}
                                                </th>
                                            </tr>
                                            <tr v-if="mixins.country == 2">
                                                <th>اجمالي الضريبة المعالجة</th>
                                                <th>
                                                    {{
                                                        format(
                                                            calcProcess.Vat ?? 0
                                                        )
                                                    }}
                                                </th>
                                            </tr>
                                            <tr v-if="mixins.country == 2">
                                                <th>اجمالي المصروفات</th>
                                                <th>
                                                    {{
                                                        format(
                                                            calcExpense.total ??
                                                            0
                                                        )
                                                    }}
                                                </th>
                                            </tr>
                                            <tr v-if="mixins.country == 2">
                                                <th>اجمالي ضريبة المصروفات</th>
                                                <th>
                                                    {{
                                                        format(
                                                            calcExpense.Vat ?? 0
                                                        )
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
                                                    الاساسية والمعالجة
                                                    والمصروفات
                                                </th>
                                                <th>
                                                    {{
                                                        format(
                                                            format(
                                                                calcBills.Vat
                                                            ) -
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
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="printer" class="btn btn-success" @click="print()">
                                طباعة
                            </button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Spinner v-else />
    </div>
</template>

<script>
import Bills from "./bills";
import PurachaseBills from "./purachaseBills";
import Expenses from "./expenses.vue";
import Process from "./process.vue";
import Spinner from "../spinner/loading.vue";
import datePicker from "../date/index";
import "pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css";

export default {
    components: {
        Bills,
        PurachaseBills,
        Expenses,
        Process,
        Spinner,
        datePicker,
    },
    async created() {
        if (!User.loggedIn()) {
            this.$router.push("/");
        }
        this.user = await Auth.getAuth();
        this.mixins = this.user.branch;
        this.period = this.$route.params.period;
        console.log(this.period);
        await this.veiwReport();
        this.loading = false;
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
            title: "Reports",
            bills: [],
            purachaseBills: [],
            expenses: [],
            process: [],
            searchTerm: "",
            period: false,
            reportName: "",
            hideMe: false,
            reportPeriod: {
                to: null,
                form: null,
            },
            total: 1,
            page: 1,
            current_page: "",
            last_page: "",
            perPage: 25,
            calcBills: [],
            calcPur: [],
            calcExpense: [],
            calcProcess: [],
            loading: true,
        };
    },
    methods: {
        print() {
            this.$htmlToPaper("PrintMe");
        },
        printAll() {
            window.print();
        },
        nextPage(i) {
            this.page = i;
            this.allBills();
        },
        veiwReport() {
            this.allBills();
            this.allExpenses();
            this.calc();
            this.calcExpenseFunc();
            this.allProcessBills();
            this.calcProcessFunc();
            this.allPurachaseBills();
            this.calcPurFunc();
        },
        async calcPurFunc() {
            await axios
                .get(
                    "/api/purbill/calc/" +
                    this.period +
                    "/" +
                    this.reportPeriod.form +
                    "/" +
                    this.reportPeriod.to
                )
                .then(({ data }) => {
                    this.calcPur = data;
                })
                .catch((error) => console.log(error));
        },
        allPurachaseBills() {
            if (
                this.reportPeriod.form != null &&
                this.reportPeriod.to != null
            ) {
                axios
                    .get(
                        "/api/bill/purchases/report/period/" +
                        this.reportPeriod.form +
                        "/" +
                        this.reportPeriod.to
                    )
                    .then(({ data }) => {
                        if (data.length > 0) {
                            this.purachaseBills = data;
                        }
                    })
                    .catch((error) => console.log(error));
            } else {
                axios
                    .get(
                        "/api/bill/purchases/report/" +
                        this.period +
                        "/" +
                        this.reportPeriod.form +
                        "/" +
                        this.reportPeriod.to
                    )
                    .then(({ data }) => {
                        if (data.length > 0) {
                            // this.loading = false;

                            this.purachaseBills = data;
                        }
                    })
                    .catch((error) => console.log(error));
            }
        },
        async calcProcessFunc() {
            await axios
                .get(
                    "/api/process/calc/" +
                    this.period +
                    "/" +
                    this.reportPeriod.form +
                    "/" +
                    this.reportPeriod.to
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
                    this.reportPeriod.form +
                    "/" +
                    this.reportPeriod.to
                )
                .then(({ data }) => {
                    this.calcExpense = data;
                    console.log(this.calcExpense);
                })
                .catch((error) => console.log(error));
        },

        async calc() {
            await axios
                .get(
                    "/api/bill/calc/" +
                    this.period +
                    "/" +
                    this.reportPeriod.form +
                    "/" +
                    this.reportPeriod.to
                )
                .then(({ data }) => {
                    this.calcBills = data;
                })
                .catch((error) => console.log(error));
        },
        allBills() {
            if (
                this.reportPeriod.form != null &&
                this.reportPeriod.to != null
            ) {
                axios
                    .get(
                        "/api/bill/report/period/" +
                        this.reportPeriod.form +
                        "/" +
                        this.reportPeriod.to +
                        "/" +
                        this.perPage +
                        "?page=" +
                        this.page
                    )
                    .then(({ data }) => {
                        if (data.data.length >= 0) {
                            this.total = parseInt(data.total / data.per_page);
                            this.current_page = data.current_page;
                            this.last_page = data.last_page;
                            this.bills = data.data;
                        }
                    })
                    .catch((error) => console.log(error));
            } else {
                axios
                    .get(
                        "/api/bill/report/" +
                        this.period +
                        "/" +
                        this.reportPeriod.form +
                        "/" +
                        this.reportPeriod.to +
                        "/" +
                        this.perPage +
                        "?page=" +
                        this.page
                    )
                    .then(({ data }) => {
                        if (data.data.length >= 0) {
                            this.total = parseInt(data.total / data.per_page);
                            this.current_page = data.current_page;
                            this.last_page = data.last_page;
                            this.bills = data.data;
                        }
                    })
                    .catch((error) => console.log(error));
            }
        },

        allExpenses() {
            if (
                this.reportPeriod.form != null &&
                this.reportPeriod.to != null
            ) {
                axios
                    .get(
                        "/api/expense/report/period/" +
                        this.reportPeriod.form +
                        "/" +
                        this.reportPeriod.to
                    )
                    .then(({ data }) => {
                        if (data.length > 0) {
                            this.expenses = data;
                        }
                    })
                    .catch((error) => console.log(error));
            } else {
                axios
                    .get(
                        "/api/expense/report/" +
                        this.period +
                        "/" +
                        this.reportPeriod.form +
                        "/" +
                        this.reportPeriod.to
                    )
                    .then(({ data }) => {
                        if (data.length > 0) {
                            // this.loading = false;

                            this.expenses = data;
                        }
                    })
                    .catch((error) => console.log(error));
            }
        },
        allProcessBills() {
            if (
                this.reportPeriod.form != null &&
                this.reportPeriod.to != null
            ) {
                axios
                    .get(
                        "/api/process/report/period/" +
                        this.reportPeriod.form +
                        "/" +
                        this.reportPeriod.to
                    )
                    .then(({ data }) => {
                        if (data.length > 0) {
                            this.process = data;
                        }
                    })
                    .catch((error) => console.log(error));
            } else {
                axios
                    .get(
                        "/api/process/report/" +
                        this.period +
                        "/" +
                        this.reportPeriod.form +
                        "/" +
                        this.reportPeriod.to
                    )
                    .then(({ data }) => {
                        if (data.length > 0) {
                            // this.loading = false;

                            this.process = data;
                        }
                    })
                    .catch((error) => console.log(error));
            }
        },

        format(num) {
            return parseFloat(num).toFixed(this.mixins.digit);
        },
    },
};
</script>
<style>
input {
    border: 1px solid #c4c4c4;
    border-radius: 5px;
    background-color: #fff;
    padding: 3px 5px;
    box-shadow: inset 0 3px 6px rgba(0, 0, 0, 0.1);
}

.card {
    padding: 0 !important;
}

@media print {
    .hideMeInPrint {
        display: none;
    }
}
</style>
