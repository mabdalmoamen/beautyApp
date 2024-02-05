<template>
    <div class="row">
        <!-- Datatables -->
        <div v-show="!loading" class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div
                        class="d-flex align-items-center justify-content-between"
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
                            {{ __("Suppliers") }}
                        </h6>
                        <router-link
                            v-show="user.create_supplier"
                            class="m-0 font-weight-bold text-primary"
                            to="/create/supplier"
                            >{{ __("Create") }}
                        </router-link>
                        <img
                            alt="Card image cap"
                            class="card-img-top img-circle"
                            onclick="download('xlsx','suppliers');"
                            src="backend/img/reports/excel.png"
                            style="width: 35px; height: 35px; cursor: pointer"
                        />
                        <input
                            v-model="searchTerm"
                            class="form-control-sm"
                            :placeholder="__('Supplier Name')"
                            type="text"
                        />
                    </div>
                </div>
                <div id="body" class="table-responsive">
                    <table
                        v-if="suppliers.length > 0"
                        id="suppliers"
                        class="text-center table-bordered"
                    >
                        <thead>
                            <tr>
                                <th
                                    v-show="
                                        user.edit_supplier ||
                                        user.delete_supplier
                                    "


                                >
                                    {{ __('Settings') }}
                                </th>
                                <th  >
                                    {{__('Code')}}
                                </th>
                                <th  >
                                    {{__('Supplier Name')}}
                                </th>
                                <th  >
                                    {{__('Mobile')}}
                                </th>
                                <th  >
                                     {{ __('Total Withdrawals') }}
                                </th>
                                <th  >
                                     {{ __('Total Paid') }}
                                </th>
                                <th  >
                                     {{ __('Total Remain') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="supplier in filterSearch">
                                <td>
                                    <router-link
                                        v-show="user.edit_supplier"
                                        :to="{
                                            name: 'edit-supplier',
                                            params: {
                                                id: supplier.supplier_id,
                                            },
                                        }"
                                        class="btn btn-sm btn-primary"
                                        ><i class="fa fa-edit"></i>
                                    </router-link>
                                    <a
                                        v-show="user.delete_supplier"
                                        class="btn btn-sm btn-danger"
                                        @click="
                                            deletesupplier(supplier.supplier_id)
                                        "
                                        ><i class="fa fa-trash"></i
                                    ></a>
                                </td>
                                <td>{{ supplier.supplier_id }}</td>
                                <td>
                                    {{ supplier.supplier_name }}
                                </td>
                                <td>
                                    {{ supplier.supplier_mobile }}
                                </td>
                                <td>
                                    {{ supplier.supplier_total_withdrawals }}
                                </td>
                                <td>
                                    {{ supplier.supplier_total_paid }}
                                </td>
                                <td>
                                    {{ supplier.supplier_total_remain }}
                                </td>
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

        <Spinner v-show="loading" :title="title" />
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
        this.user = await Auth.getAuth();

        this.allSuppliers();
    },

    data() {
        return {
            user: {},
            title: "Suppliers",
            suppliers: [],
            searchTerm: "",
            loading: true,
            total: 1,
            page: 1,
            current_page: "",
            supplier_pay: "",
        };
    },
    computed: {
        filterSearch() {
            return this.suppliers.filter((supplier) => {
                return supplier.supplier_name.match(this.searchTerm);
            });
        },
    },
    methods: {
        allSuppliers() {
            axios
                .get("/api/suppliers")
                .then(({ data }) => {
                    if (data.length >= 0) {
                        this.loading = false;
                        this.suppliers = data;
                    }
                })
                .catch((error) => console.log(error));
        },

        nextPage(i) {
            this.page = i;
            this.allsuppliers();
        },
        pay(supplier) {
            if (supplier.supplier_total_remain > 0) {
                if (this.supplier_pay > 0) {
                    axios
                        .get(
                            "/api/supplierPay/" +
                                supplier.supplier_id +
                                "/" +
                                this.supplier_pay
                        )
                        .then(() => {
                            Notification.success();
                            $("#closeModal").click();
                        })
                        .catch(
                            (error) =>
                                (this.errors = error.response.data.errors)
                        );
                } else {
                    Notification.customMsg(
                        "error",
                        "topRight",
                        "يرجى كتابة مبلغ اكبر من 0"
                    );
                }
            } else {
                Notification.customMsg(
                    "warning",
                    "topRight",
                    "تم دفع حساب المورد بالكامل"
                );
            }
        },
        deletesupplier(id) {
            if (confirm("هل تريد الحذف؟لايمكن الاستعاده مره اخرى.")) {
                axios
                    .delete("/api/suppliers/" + id)
                    .then(() => {
                        this.suppliers = this.suppliers.filter((supplier) => {
                            return supplier.supplier_id != id;
                        });
                        Notification.successMsg("تم الحذف بنجاح");
                    })
                    .catch((error) => {
                        Notification.errorMsg("لايمكن حذف مورد له معاملات");
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
