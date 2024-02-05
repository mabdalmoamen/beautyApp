<template>
    <div class="row">
        <!-- Datatables -->
        <div v-if="!loading" class="col-lg-12">
            <div class="card mb-4">
                <div
                    class="card-header d-flex flex-row align-items-center justify-content-between"
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
                        {{ __("Sales Types") }}
                    </h6>
                    <router-link
                        class="m-0 font-weight-bold text-primary"
                        to="/create/sale"
                        >{{ __("Create") }}</router-link
                    >
                    <img
                        onclick="download('xlsx','salesTypes');"
                        style="width: 35px; height: 35px; cursor: pointer"
                        class="card-img-top img-circle"
                        src="backend/img/reports/excel.png"
                        alt="Card image cap"
                    />
                </div>
                <div id="body" class="table-responsive">
                    <table
                        v-if="salesTypes.length > 0"
                        id="salesTypes"
                        class="text-center table-bordered"
                    >
                        <thead>
                            <tr>
                                <th class="col-header" style="width: 15%">
                                    {{ __("Settings") }}
                                </th>

                                <th class="col-header" style="width: 15%">
                                    {{ __("Title") }}
                                </th>
                                <th class="col-header" style="width: 15%">
                                    {{ __("Cost") }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(salesType, i) in filterSearch" :key="i">
                                <td>
                                    <router-link
                                        :to="{
                                            name: 'edit-sale',
                                            params: {
                                                id: salesType.id,
                                            },
                                        }"
                                        class="btn btn-sm btn-primary"
                                        ><i class="fa fa-edit"></i>
                                    </router-link>
                                    <a
                                        class="btn btn-sm btn-danger"
                                        @click="deleteAction(salesType.id)"
                                        ><i class="fa fa-trash"></i
                                    ></a>
                                </td>
                                <td>
                                    {{ salesType.sill_type_name }}
                                </td>
                                <td>
                                    {{ salesType.cost }}
                                </td>
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
import Spinner from "../spinner/loading.vue";
export default {
    components: { Spinner },
    async created() {
        if (!User.loggedIn()) {
            this.$router.push("/");
        }
        await this.allSalesType();
    },
    data() {
        return {
            title: "salesTypes",
            salesTypes: [],
            searchTerm: "",
            loading: true,
        };
    },
    computed: {
        filterSearch() {
            return this.salesTypes.filter((salesType) => {
                return salesType.sill_type_name.match(this.searchTerm);
            });
        },
    },
    methods: {
        allSalesType() {
            axios
                .get("/api/saleType")
                .then(({ data }) => {
                    if (data.length >= 0) {
                        this.loading = false;
                        this.salesTypes = data;
                    }
                })
                .catch((error) => console.log(error));
        },

        deleteAction(id) {
            if (confirm("هل تريد الحذف؟لايمكن الاستعاده مره اخرى.")) {
                axios
                    .delete("/api/saleType/" + id)
                    .then(() => {
                        this.salesTypes = this.salesTypes.filter(
                            (salesType) => {
                                return salesType.id != id;
                            }
                        );
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
