<template>
    <div class="row">
        <!-- Datatables -->
        <div class="col-lg-12" v-if="!loading">
            <div class="card mb-4" id="allReport">
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
                        {{ __("Process Report") }}
                    </h1>

                    <i
                        class="fas fa-file-excel text-success hideMeInPrint fa-2x"
                        style="cursor: pointer"
                        onclick="download('xlsx','allReport');"
                    ></i>

                    <button
                        class="btn btn-success"
                        onclick="window.print()"
                        type="submit"
                    >
                        {{ __("Print") }}
                    </button>

                    <h6 class="m-0 font-weight-bold text-primary float-left">
                        <select
                            v-model="perPage"
                            class="form-control-sm text-center"
                        >
                            <option value="25">25</option>
                            <option value="100">100</option>
                            <option value="200">200</option>
                            <option value="500">500</option>
                            <option value="1000">1000</option>
                            <option value="2000">2000</option>
                            <option value="3000">3000</option>
                            <option value="4000">4000</option>
                            <option value="5000">5000</option>
                        </select>
                    </h6>
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
                <div class="table-responsive table-wrapper">
                    <Process :process="process" :calcProcess="calcProcess" />
                </div>
            </div>
        </div>
        <div v-else><MixinsSpinner :title="title" /></div>
    </div>
</template>

<script>
import Process from "./process.vue";
import MixinsSpinner from "../spinner/loading.vue";

export default {
    components: { Process, MixinsSpinner },
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

            calcProcess: [],
            loading: false,
        };
    },
    methods: {
        nextPage(i) {
            this.page = i;
            this.allBills();
        },
        veiwReport() {
            this.allProcessBills();
            this.calcProcessFunc();
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
                    this.loading = false;
                    this.calcProcess = data;
                })
                .catch((error) => console.log(error));
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
            console.log(this.process);
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
