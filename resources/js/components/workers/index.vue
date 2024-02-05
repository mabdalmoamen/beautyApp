<template>
    <div>
        <div class="row">
            <!-- Datatables -->
            <div v-if="!loading" class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div
                            class="d-flex flex-row align-items-center justify-content-between"
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
                                {{ __("Workers") }}
                            </h6>
                            <router-link
                                class="m-0 font-weight-bold text-primary"
                                to="/create/worker"
                                >{{ __("Create") }}</router-link
                            >
                            <img
                                onclick="download('xlsx','workers');"
                                style="
                                    width: 35px;
                                    height: 35px;
                                    cursor: pointer;
                                "
                                class="card-img-top img-circle"
                                src="backend/img/reports/excel.png"
                                alt="Card image cap"
                            />
                            <input
                                v-model="searchTerm"
                                class="form-control-sm"
                                :placeholder="__('Worker Name')"
                                type="text"
                            />
                        </div>
                    </div>
                    <div id="body" class="table-responsive">
                        <table
                            v-if="workers.length > 0"
                            id="workers"
                            class="text-center table-bordered"
                        >
                            <thead>
                                <tr>
                                    <th>
                                        {{ __("Settings") }}
                                    </th>
                                    <th>
                                        {{ __("Code") }}
                                    </th>
                                    <th>
                                        {{ __("Worker Name") }}
                                    </th>
                                    <th>
                                        {{ __("Mobile") }}
                                    </th>
                                    <th>
                                        {{ __("commission") }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(worker, i) in filterSearch"
                                    :key="i"
                                >
                                    <td>
                                        <a
                                            v-show="worker.pin_code"
                                            class="btn btn-success"
                                            @click="printBarcode(worker)"
                                            ><i class="fa fa-print"></i
                                        ></a>
                                        <router-link
                                            :to="{
                                                name: 'edit-worker',
                                                params: {
                                                    id: worker.id,
                                                },
                                            }"
                                            class="btn btn-sm btn-primary"
                                            ><i class="fa fa-edit"></i>
                                        </router-link>
                                        <a
                                            class="btn btn-sm btn-danger"
                                            @click="deleteAction(worker.id)"
                                            ><i class="fa fa-trash"></i
                                        ></a>
                                    </td>
                                    <td>{{ worker.id }}</td>
                                    <td>{{ worker.name }}</td>
                                    <td>{{ worker.mobile }}</td>
                                    <td>
                                        {{ worker.commission }}
                                        {{
                                            worker.is_percent_commission
                                                ? "%"
                                                : ""
                                        }}
                                    </td>
                                </tr>
                                <div id="printMe" class="d-none">
                                    <span class="d-block">{{
                                        currentWorker.name
                                    }}</span>

                                    <img class="barcode" />
                                </div>
                            </tbody>
                        </table>
                        <p v-else class="text-center">
                            {{ __("No Data Yet") }}
                        </p>
                    </div>
                </div>
            </div>
            <!-- DataTable with Hover -->

            <Spinner v-else :title="title" />
        </div>
    </div>
</template>

<script>
import Spinner from "../spinner/loading.vue";
export default {
    components: { Spinner },
    async created() {
        if (!User.loggedIn()) {
            this.$router.push("newBill");
        }
        await this.allworkers();
        await axios
            .get("/api/barcodes/" + 2)
            .then(({ data }) => {
                this.barcode = data;
            })
            .catch((error) => console.log(error));
    },
    data() {
        return {
            title: "Workers",
            workers: [],
            searchTerm: "",
            loading: true,
            total: 1,
            page: 1,
            current_page: "",
            last_page: "",
            barcode: {},
            currentWorker: {},
        };
    },
    computed: {
        filterSearch() {
            return this.workers.filter((worker) => {
                return worker.name.match(this.searchTerm);
            });
        },
    },
    methods: {
        setcurrentWorker(worker) {
            this.currentWorker = worker;
        },
        async printBarcode(worker) {
            await this.setcurrentWorker(worker);
            let barcode = worker.pin_code;
            if (
                worker.pin_code == null ||
                worker.pin_code === "" ||
                worker.pin_code.length === 0
            ) {
                barcode = worker.id;
            }
            JsBarcode(".barcode", barcode, {
                textAlign: this.barcode.textAlign,
                textPosition: this.barcode.textPosition,
                font: this.barcode.font,
                fontOptions: this.barcode.fontOptions,
                textMargin: this.barcode.textMargin,
                format: this.barcode.format,
                displayValue: this.barcode.displayValue,
                height: this.barcode.height,
                width: this.barcode.width,
                fontSize: this.barcode.fontSize,
                background: this.barcode.background,
                lineColor: this.barcode.lineColor,
                margin: this.barcode.margin,
                marginLeft: this.barcode.marginLeft,
                marginTop: this.barcode.marginTop,
                marginBottom: this.barcode.marginBottom,
                marginRight: this.barcode.marginRight,
                flat: this.barcode.flat,
            });
            this.$htmlToPaper("printMe");
        },
        allworkers() {
            axios
                .get("/api/workers")
                .then(({ data }) => {
                    console.log(data);
                    if (data.length >= 0) {
                        this.loading = false;
                        this.workers = data;
                    }
                })
                .catch((error) => console.log(error));
        },

        nextPage(i) {
            this.page = i;
            this.allworkers();
        },
        deleteAction(id) {
            if (confirm("هل تريد الحذف؟لايمكن الاستعاده مره اخرى.")) {
                axios
                    .delete("/api/workers/" + id)
                    .then(() => {
                        this.workers = this.workers.filter((worker) => {
                            return worker.id != id;
                        });
                        Notification.successMsg("تم الحذف بنجاح");
                    })
                    .catch(() => {
                        Notification.errorMsg("لايمكن الحذف");
                    });
            }
        },
    },
};
</script>
<style>
a,
a:hover {
    text-decoration: none;
    font-weight: bolder;
}

.bg-info {
    width: 100%;
    height: 100%;
    position: absolute;
    overflow: hidden;
}

.spinner-border {
    margin: 50vh auto !important;
}

table.table-fit {
    width: auto !important;
    table-layout: auto !important;
}

table.table-fit thead th,
table.table-fit tfoot th {
    width: auto !important;
}

table.table-fit tbody td,
table.table-fit tfoot td {
    width: auto !important;
}
</style>
