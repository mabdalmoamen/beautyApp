<template>
    <div>
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
                            {{ __("Units") }}
                        </h6>
                        <router-link
                            class="m-0 font-weight-bold text-primary"
                            to="/create/unit"
                            >{{ __("Create") }}</router-link
                        >
                        <img
                            onclick="download('xlsx','units');"
                            style="width: 35px; height: 35px; cursor: pointer"
                            class="card-img-top img-circle"
                            src="backend/img/reports/excel.png"
                            alt="Card image cap"
                        />
                        <input
                            v-model="searchTerm"
                            class="form-control-sm"
                            :placeholder="__('Unit Name Ar')"
                            type="text"
                        />
                    </div>
                    <div id="body" class="table-responsive">
                        <table
                            v-if="units.length > 0"
                            id="units"
                            class="text-center table-bordered"
                        >
                            <thead>
                                <tr>
                                    <th
                                        v-show="
                                            user.edit_unit || user.delete_unit
                                        "
                                        class="col-header"
                                        style="width: 15%"
                                    >
                                        {{ __("Settings") }}
                                    </th>

                                    <th class="col-header" style="width: 15%">
                                        {{ __("Unit Name Ar") }}
                                    </th>
                                    <th class="col-header" style="width: 15%">
                                        {{ __("Unit Name En") }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="unit in filterSearch"
                                    class="ErrorRow"
                                >
                                    <td>
                                        <button
                                            @click="EditUnit = unit"
                                            type="button"
                                            class="btn btn-primary"
                                            data-toggle="modal"
                                            data-target="#exampleModal"
                                            v-show="user.edit_unit"
                                        >
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <a
                                            v-show="user.delete_unit"
                                            class="btn btn-sm btn-danger"
                                            @click="deleteAction(unit.unit_id)"
                                            ><i class="fa fa-trash"></i
                                        ></a>
                                    </td>
                                    <td>{{ unit.unit_ar_name }}</td>
                                    <td>{{ unit.unit_en_name }}</td>
                                </tr>
                            </tbody>
                            <tfoot></tfoot>
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
        <div
            class="modal fade"
            id="exampleModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            {{ __("Edit Unit Information") }}
                        </h5>
                        <button
                            id="close"
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <Edit :unit="EditUnit"></Edit>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Spinner from "../spinner/loading.vue";
import Edit from "./edit";

export default {
    components: { Spinner, Edit },
    async created() {
        if (!User.loggedIn()) {
            this.$router.push("/");
        }
        this.user = await Auth.getAuth();

        this.allUnits();
    },
    data() {
        return {
            user: {},
            title: "Units",
            units: [],
            searchTerm: "",
            loading: true,
            EditUnit: "",
        };
    },
    computed: {
        filterSearch() {
            return this.units.filter((unit) => {
                return unit.unit_ar_name.match(this.searchTerm);
            });
        },
    },
    methods: {
        allUnits() {
            axios
                .get("/api/mainunits")
                .then(({ data }) => {
                    if (data.length >= 0) {
                        this.loading = false;
                        this.units = data;
                    }
                })
                .catch((error) => console.log(error));
        },

        deleteAction(id) {
            if (confirm("هل تريد الحذف؟لايمكن الاستعاده مره اخرى.")) {
                axios
                    .delete("/api/mainunits/" + id)
                    .then(() => {
                        this.units = this.units.filter((unit) => {
                            return unit.unit_id != id;
                        });
                        Notification.successMsg("تم الحذف بنجاح");
                    })
                    .catch(() => {
                        Notification.errorMsg("لايمكن حذف عملية مرتبطة بأصناف");
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
