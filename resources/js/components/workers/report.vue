<template>
    <div>
        <Spinner v-if="loading" />
        <!-- Datatables -->
        <div v-else>
            <div class="card">
                <div class="card-header hideMeInPrint">
                    <a class="btn btn-warning text-light float-right" style="margin-top: 30px" @click="$router.go(-1)">
                        <i :class="
                            $root.$data.codies.default_lang == 'ar'
                                ? 'fa fa-arrow-right'
                                : 'fa fa-arrow-left'
                        "></i>
                    </a>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label>{{ __("Report") }}</label>
                                <select v-model="period" class="form-control">
                                    <option value="0">
                                        {{ __("daily_report") }}
                                    </option>
                                    <option value="1">
                                        {{ __("monthly_report") }}
                                    </option>
                                    <option :selected="worker_id" value="2">
                                        {{ __("period_report") }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label>{{ __("Worker Name") }}</label>
                                <select class="form-control" v-model="worker_id">
                                    <option selected value="">
                                        {{ __("Worker Name") }}
                                    </option>
                                    <option v-for="(worker, index) in workers" :key="index" :value="worker.id"
                                        class="border-bottom">
                                        {{ worker.name }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group">
                                <label>{{ __("Per_Page") }}</label>

                                <select v-model="perPage" class="form-control">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="25">25</option>
                                    <option value="20">20</option>
                                    <option :value="exportData.length">
                                        {{ exportData.length }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-2" v-if="period == '2'">
                            <div class="form-group">
                                <label>{{ __("From") }}</label>
                                <date-picker class="form-control" v-model="from" id="from" :wrap="true"
                                    :config="configs.wrap" required :placeholder="__('From')">
                                </date-picker>
                            </div>
                        </div>
                        <div class="col-2" v-if="period == '2'">
                            <div class="form-group">
                                <label>{{ __("To") }}</label>
                                <date-picker class="form-control" v-model="to" id="to" :wrap="true" :config="configs.wrap"
                                    required :placeholder="__('To')">
                                </date-picker>
                            </div>
                        </div>
                        <div v-if="user.is_admin" class="col-3">
                            <div class="form-group">
                                <label>{{ __("Branch_id") }}</label>
                                <select v-model="branch_id" class="form-control">
                                    <option :value="null">
                                        {{ __("Branch_id") }}
                                    </option>

                                    <option v-for="branch in branches" :value="branch.id">
                                        {{ branch.mixins_name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-3 text-center">
                            <a class="btn btn-app mx-2" @click="downloads('xlsx', 'bills', false)">
                                <span class="badge bg-success">{{
                                    exportData.length
                                }}</span>
                                <i class="fa fa-file-excel-o"></i>
                            </a>
                            <a class="btn d-none" @click="print('xlsx', 'bills')">
                                <span class="badge bg-success">{{
                                    exportData.length
                                }}</span>
                                <i class="fa fa-file-pdf-o"></i>
                            </a>
                            <button @click="getBill" class="btn btn-app btn-success" type="submit">
                                {{ __("View") }}
                            </button>
                            <button @click="downloads('xlsx', 'bills', true)" class="btn btn-app btn-success" type="submit">
                                {{ __("Print") }}
                            </button>
                        </div>
                        <div class="col-3"></div>
                    </div>
                </div>
                <div id="printMe" class="card-body pos-section text-center py-0 my-0">
                    <p class="hide">{{ customer_name }}</p>
                    <p class="hide" v-if="from">
                        تقرير الموظفين من{{
                            moment(from).format("DD-MM-YYYY")
                        }}
                        إلى {{ moment(to).format("DD-MM-YYYY") }}
                    </p>

                    <table id="bills" class="text-center">
                        <thead>
                            <tr>
                                <th>{{ __("Code") }}</th>
                                <th>{{ __("Type Name") }}</th>
                                <th>{{ __("Worker Name") }}</th>
                                <th>
                                    {{ __("Table Number") }}
                                </th>
                                <th>
                                    {{ __("commission") }}
                                </th>
                                <th>
                                    {{ __("reserve_date") }}
                                </th>
                                <th>
                                    {{ __("end_reserve_date") }}
                                </th>
                                <th>{{ __("Unit") }}</th>
                                <th>{{ __("Total") }}</th>
                                <th>{{ __("Notes") }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="type in bills" :key="type.bill_type_id">
                                <td>{{ type.type_id }}</td>
                                <td>
                                    {{ type.type.type_name_ar }}
                                </td>
                                <td>
                                    {{ type.worker ? type.worker.name : "" }}
                                </td>
                                <td>
                                    {{ type.chair ? type.chair.table_no : "" }}
                                </td>
                                <td>{{ type.commission }}</td>
                                <td>{{ type.reserve_date }}</td>
                                <td>{{ type.end_reserve_date }}</td>

                                <td>
                                    {{
                                        type.units
                                        ? type.units.unit.unit_ar_name
                                        : "-"
                                    }}
                                </td>
                                <td>
                                    {{ type.type_total_price }}
                                </td>
                                <td>{{ type.type_note }}</td>
                            </tr>
                        </tbody>

                        <tfoot class="bg-success">
                            <tr>
                                <th>العمولة</th>
                                <td>
                                    {{ commission }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                    <div v-show="bills.length > 0" class="row hideMeInPrint text-center">
                        <ul class="pagination justify-content-center">
                            <li :class="
                                current_page == 1
                                    ? 'page-item disabled'
                                    : 'page-item'
                            ">
                                <a class="page-link" href="#" @click="nextPage(1)">{{ __("First") }}</a>
                            </li>
                            <li :class="
                                current_page == 1
                                    ? 'page-item disabled'
                                    : 'page-item'
                            ">
                                <a class="page-link" href="#" @click="nextPage(current_page - 1)"><i
                                        class="fa fa-arrow-right"></i></a>
                            </li>
                            <li class="page-item d-none" v-for="(i, index) in total" @click="nextPage(i)" :key="index">
                                <a class="page-link" href="#">{{ i }}</a>
                            </li>
                            <li :class="
                                current_page == last_page
                                    ? 'page-item disabled'
                                    : 'page-item'
                            ">
                                <a class="page-link" href="#" @click="nextPage(current_page + 1)"><i
                                        class="fa fa-arrow-left"></i></a>
                            </li>
                            <li :class="
                                current_page == last_page
                                    ? 'page-item disabled'
                                    : 'page-item'
                            ">
                                <a class="page-link" href="#" @click="nextPage(total)">{{ __("Last") }}</a>
                            </li>
                        </ul>
                    </div>
                    <!-- </div>
                    </div> -->
                </div>
            </div>
            <div v-if="toExport" class="export hideMeInPrint">
                <p>جاري تحضير الجداول</p>
            </div>
            <!-- Pay Bill Dialog -->
        </div>
    </div>
</template>

<script>
import Spinner from "../spinner/loading.vue";
import moment from "moment";

export default {
    components: { Spinner },

    async created() {
        if (!User.loggedIn()) {
            await this.$router.push("/");
        }

        this.user = await Auth.getAuth();
        this.mixins = this.user.branch;
        this.branch_id = this.user.branch_id;
        await this.getBill();
        await this.allPayMethods();
        await this.allBranches();
        await this.allWorkers();
    },
    data() {
        return {
            configs: {
                wrap: {
                    allowInputToggle: true,
                },
            },
            column: {
                id: true,
                branch: false,
                sum: false,
                vat: true,
                total: true,
                discount: true,
                date: true,
                note: false,
                user: false,
                customer: false,
                pay: true,
                extra: false,
                paid: false,
                remain: false,
            },
            branches: [],
            branch_id: null,
            toExport: false,
            user: {},
            title: "Bills",
            moment: moment,
            order: "bill_type_id",
            orderType: "DESC",
            payMethods: [],
            pay: null,
            loading: true,
            mixins: {},
            bill: null,
            bills: [],
            exportData: [],
            loadedData: [],
            selected: "",
            period: 0,
            customer_name: "",
            cust_id: null,
            reportName: "",
            total: 1,
            page: 1,
            last_page: "",
            current_page: 1,
            to: null,
            from: null,
            billTypes: [],
            perPage: 10,
            bill_total: 0.0,
            bill_total_cash: 0.0,
            bill_total_card: 0.0,
            bill_total_later: 0.0,
            bill_total_mixed: 0.0,
            bill_total_vat: 0.0,
            bill_total_vat_cash: 0.0,
            bill_total_vat_card: 0.0,
            bill_total_vat_later: 0.0,
            bill_total_vat_mixed: 0.0,
            bill_total_mixed_cash: 0.0,
            bill_total_mixed_card: 0.0,
            customer: {},
            workers: {},
            worker_id: "",
            commission: 0,
        };
    },

    methods: {
        async allWorkers() {
            await axios
                .get("/api/workers")
                .then(({ data }) => (this.workers = data))
                .catch((error) => console.log(error));
        },
        async print() {
            await this.$htmlToPaper("printMe");
            this.bills = this.loadedData;
            this.toExport = false;
        },
        async findCustomer() {
            await axios
                .get("/api/customers/" + this.customer_name)
                .then(async ({ data }) => {
                    if (data.cust_id) {
                        this.customer = data;
                        this.cust_id = data.cust_id;
                        this.customer_name = data.cust_name;
                    } else {
                        this.cust_id = null;
                    }
                })
                .catch((error) => console.log(error));
        },
        async allPayMethods() {
            await axios
                .get("/api/payMethods")
                .then(({ data }) => (this.payMethods = data))
                .catch((error) => console.log(error));
        },
        async allBranches() {
            await axios
                .get("/api/mixins")
                .then(({ data }) => (this.branches = data))
                .catch((error) => console.log(error));
        },
        nextPage(i) {
            this.current_page = i;
            this.getBill();
        },

        async changeOrder(order) {
            this.order = order;
            if (this.orderType == "DESC") {
                this.orderType = "ASC";
            } else {
                this.orderType = "DESC";
            }
            await this.getBill();
        },
        async downloads(type, name, isPrint) {
            this.toExport = true;
            this.bills = this.exportData;
            await setTimeout(async () => {
                if (isPrint) {
                    await this.print();
                } else {
                    await this.download(type, name);
                }
            }, 3000);
        },
        async download(type, name) {
            var wb = XLSX.utils.table_to_book(document.getElementById(name), {
                sheet: "sheet js",
            });
            this.bills = this.loadedData;
            this.toExport = false;

            return XLSX.writeFile(wb, name + "." + type);
        },
        async getBill() {
            this.exportData = [];
            this.bills = [];
            this.loadedData = [];

            this.bill_total_mixed_card = 0.0;
            this.commission = 0.0;
            await axios
                .get(
                    "/worker/report?order=" +
                    this.order +
                    "&orderType=" +
                    this.orderType +
                    "&period=" +
                    this.period +
                    "&to=" +
                    this.to +
                    "&from=" +
                    this.from +
                    "&worker_id=" +
                    this.worker_id
                )
                .then(async (res) => {
                    res.data.forEach((bill) => {
                        if (bill.commission != null) {

                            this.commission += parseFloat(bill.commission);
                        }
                    });
                    await this.mangePagination(res.data);
                    this.loading = false;
                });
        },

        mangePagination(data) {
            if (data.length > 0) {
                this.exportData = data;
                this.total = parseInt(data.length / this.perPage) + 1;
                this.current_page = this.current_page ?? 1;
                this.last_page = this.total;

                for (
                    let i = this.perPage * this.current_page - this.perPage;
                    i < this.perPage * this.current_page;
                    i++
                ) {
                    if (data[i] && data[i].bill_type_id) {
                        this.bills.push(data[i]);
                    }
                }

                this.loadedData = this.bills;
            }
        },
    },
};
</script>
<style>
h1,
p {
    font-family: "Source Sans Pro", sans-serif !important;
}

.export {
    height: 100vh;
    width: 100vw;
    position: absolute;
    z-index: 11111;
    top: 0;
    right: -16px;
    background: transparent;
}

.btn-app {
    min-width: 80px !important;
    height: 40px !important;
    padding: 10px 5px !important;
    background: #28a745 !important;
    color: #fff !important;
    margin-top: 25px;
}

.export p {
    margin: 50vh auto;
    text-align: center;
}

.hide {
    display: none;
}

@media print {
    .hideMeInPrint {
        display: none;
    }
}
</style>
