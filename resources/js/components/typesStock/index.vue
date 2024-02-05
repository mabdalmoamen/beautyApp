<template>
    <div class="row">
        <!-- Datatables -->
        <div v-if="!loading" class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div
                        class="d-flex align-items-center justify-content-between"
                    >
                        <a
                            class="btn btn-warning text-light float-right"
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
                            {{ __("All Stock") }}
                        </h6>
                        <router-link
                            class="m-0 font-weight-bold text-primary"
                            to="/create/gusto/stock"
                            >{{ __("Create") }}</router-link
                        >
                        <button
                            class="btn btn-primary"
                            onclick="download('xlsx');"
                            type="submit"
                        >
                            <i class="fa fa-file-excel"></i>
                        </button>

                        <h6
                            class="m-0 font-weight-bold text-primary float-left"
                        >
                            <div id="search">
                                <input
                                    id="filter"
                                    class="form-control-sm"
                                    name="filter"
                                    type="text"
                                    value=""
                                />
                            </div>
                        </h6>
                    </div>
                </div>
                <div id="body" class="table-responsive">
                    <table
                        v-if="gustoStocks.length > 0"
                        id="resultTable"
                        class="text-center table-bordered"
                    >
                        <thead>
                            <tr>
                                <th class="col-header" style="width: 15%">
                                    {{ __("Settings") }}
                                </th>

                                <th class="col-header" style="width: 15%">
                                    {{ __("Stock Name") }}
                                </th>
                                <th class="col-header" style="width: 15%">
                                    {{ __("Type Name") }}
                                </th>
                                <th class="col-header" style="width: 15%">
                                    {{ __("Operation") }}
                                </th>
                                <th class="col-header" style="width: 15%">
                                    {{ __("Decrease From Stock") }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(gustoStock, index) in gustoStocks"
                                :key="index"
                                class="ErrorRow"
                            >
                                <td>
                                    <router-link
                                        :to="{
                                            name: 'edit-gusto-stock',
                                            params: {
                                                id: gustoStock.id,
                                            },
                                        }"
                                        class="btn btn-sm btn-primary"
                                        ><i class="fa fa-edit"></i>
                                    </router-link>
                                    <a
                                        class="btn btn-sm btn-danger"
                                        @click="deleteAction(gustoStock.id)"
                                        ><i class="fa fa-trash"></i
                                    ></a>
                                </td>
                                <td>
                                    {{ gustoStock.stock_id.title }}
                                </td>

                                <td>
                                    {{ gustoStock.type_id.type_name_ar }}
                                </td>
                                <td>
                                    {{ gustoStock.unit_id.unit_ar_name }}
                                </td>
                                <td>{{ gustoStock.mount }}جم</td>
                            </tr>
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
</template>

<script>
import Spinner from "./../spinner/loading.vue";
export default {
    components: { Spinner },
    async created() {
        if (!User.loggedIn()) {
            this.$router.push("/");
        }
        await this.allgustoStocks();
    },
    data() {
        return {
            title: "المخزون",
            gustoStocks: [],
            searchTerm: "",
            loading: true,
        };
    },
    computed: {
        filterSearch() {
            return this.gustoStocks.filter((gustoStock) => {
                return gustoStock.id.match(this.searchTerm);
            });
        },
    },
    methods: {
        allgustoStocks() {
            axios
                .get("/api/gusto/stocks?page=" + this.page)
                .then(({ data }) => {
                    if (data.length >= 0) {
                        this.loading = false;
                        this.gustoStocks = data;
                    }
                })
                .catch((error) => console.log(error));
        },

        nextPage(i) {
            this.page = i;
            this.allgustoStocks();
        },
        deleteAction(id) {
            if (confirm("هل تريد الحذف؟لايمكن الاستعاده مره اخرى.")) {
                axios
                    .delete("/api/gusto/stocks/" + id)
                    .then(() => {
                        this.gustoStocks = this.gustoStocks.filter(
                            (gustoStock) => {
                                return gustoStock.id != id;
                            }
                        );
                        Notification.successMsg("تم الحذف بنجاح");
                    })
                    .catch((err) => {
                        Notification.errorMsg("لا يمكن الحذف");
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
