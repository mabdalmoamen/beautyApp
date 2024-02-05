<template>
    <div class="row">
        <!-- Datatables -->
        <div class="col-lg-12" v-if="!loading">
            <div class="card" id="allReport">
                <div
                    class="card-header d-flex flex-row align-items-center justify-content-between hideMeInPrint"
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
                    <h1 class="text-center my-0 d-block">
                        {{ __("Bills Reports") }}
                    </h1>

                    <i
                        class="fas fa-file-excel text-success hideMeInPrint fa-2x"
                        style="cursor: pointer"
                        onclick="download('xlsx','bills');"
                    ></i>

                    <button
                        class="btn btn-success"
                        onclick="window.print()"
                        type="submit"
                    >
                        {{ __("Print") }}
                    </button>

                    <form
                        class="needs-validation mt-2 hideMeInPrint"
                        v-show="!period"
                        @submit.prevent="veiwReport"
                    >
                        <div class="form-row">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <div class="input-group-prepend input-sm">
                                        <span
                                            class="input-group-text"
                                            id="validationTooltipUsernamePrepend"
                                            >{{ __("From") }}</span
                                        >
                                    </div>
                                    <input
                                        type="date"
                                        class="form-control"
                                        v-model="reportPeriod.form"
                                        id="validationTooltipUsername"
                                        placeholder="Username"
                                        aria-describedby="validationTooltipUsernamePrepend"
                                        required
                                    />
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <div
                                        class="input-group-prepend float-right input-sm"
                                    >
                                        <span
                                            class="input-group-text"
                                            for="to"
                                            >{{ __("To") }}</span
                                        >
                                    </div>
                                    <input
                                        type="date"
                                        class="form-control"
                                        v-model="reportPeriod.to"
                                        placeholder="Username"
                                        aria-describedby="validationTooltipUsernamePrepend"
                                        required
                                    />
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
                <div class="card-body">
                    <Bills :bills="bills" :calcBills="calcBills" />
                    <div v-show="bills.length > 0" class="row text-center">
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
                                :key="index"
                            >
                                <a class="page-link" href="#">{{ i }}</a>
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
        </div>
        <div v-else><MixinsSpinner :title="title" /></div>
    </div>
</template>

<script>
import Bills from "./bills";
import PurachaseBills from "./purachaseBills";
import Expenses from "./expenses.vue";
import Process from "./process.vue";
import MixinsSpinner from "../spinner/loading.vue";

export default {
    components: {
        Bills,
        PurachaseBills,
        Expenses,
        Process,
        MixinsSpinner,
    },
    async created() {
        if (!User.loggedIn()) {
            this.$router.push("/");
        }
        this.user = await Auth.getAuth();
        this.mixins = this.user.branch;

        this.period = this.$route.params.period;

        await this.veiwReport();
    },
    data() {
        return {
            user: {},
            title: "Reports",
            bills: [],

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

            loading: false,
            mixins: {},
        };
    },
    methods: {
        nextPage(i) {
            this.page = i;
            this.allBills();
        },
        veiwReport() {
            this.allBills();
            this.calc();
            this.loading = true;
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
                    this.loading = false;
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
                            this.loading = false;
                            this.total = parseInt(data.total / data.per_page);
                            this.current_page = data.current_page;
                            this.bills = data.data;
                            this.last_page = data.last_page;
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
                        console.log(data);
                        if (data.data.length >= 0) {
                            this.loading = false;
                            this.total = parseInt(data.total / data.per_page);
                            this.current_page = data.current_page;
                            this.bills = data.data;
                        }
                    })
                    .catch((error) => console.log(error));
            }
            console.log("data");
        },

        hideMeInPrint() {
            this.hideMe = !this.hideMe;
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
