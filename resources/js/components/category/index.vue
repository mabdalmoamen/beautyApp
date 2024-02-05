<template>
    <div class="row">
        <!-- Datatables -->
        <div v-if="!loading" class="col-lg-12">
            <div class="card mb-4">
                <div
                    class="card-header d-flex flex-row align-items-center justify-content-between"
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
                        {{ __("Categories") }}
                    </h6>
                    <router-link
                        class="m-0 font-weight-bold text-primary"
                        to="/create/mainType"
                        >{{__('Create')}}</router-link
                    >

                    <input
                        v-model="searchTerm"
                        class="form-control-sm"
                        v-bind:placeholder="__('Category Name ar')"
                        type="text"
                    />
                </div>
                <div class="table-responsive">
                    <table
                        v-if="mainTypes.length > 0"
                        id="categories"
                        class="text-center table-bordered"
                    >
                        <thead>
                            <tr>
                                <th class="col-header" style="width: 15%">
                                    {{ __("Settings") }}
                                </th>


                                <th class="col-header" style="width: 15%">
                                    {{ __("Category Name ar") }}
                                </th>
                                <th class="col-header" style="width: 15%">
                                    {{ __("Category Name En") }}
                                </th>
                                <th class="col-header" style="width: 15%">
                                    {{ __("Select Printer") }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(mainType, index) in filterSearch"
                                :key="index"
                                class="ErrorRow"
                            >
                                <td>
                                    <router-link
                                        :to="{
                                            name: 'edit-mainType',
                                            params: {
                                                id: mainType.main_type_id,
                                            },
                                        }"
                                        class="btn btn-sm btn-primary"
                                        ><i class="fa fa-edit"></i>
                                    </router-link>
                                    <a
                                        class="btn btn-sm btn-danger"
                                        @click="
                                            deleteAction(mainType.main_type_id)
                                        "
                                        ><i class="fa fa-trash"></i
                                    ></a>
                                </td>
                                <td>
                                    {{ mainType.main_type_title_ar }}
                                </td>
                                <td>
                                    {{ mainType.main_type_title_en }}
                                </td>
                                <td>
                                    {{ mainType.printer_name }}
                                </td>
                            </tr>
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                    <p v-else class="text-center">
                        {{ __("No Data Yet") }}
                    </p>
                    <div
                        v-show="mainTypes.length > 0"
                        class="row d-none text-center"
                    >
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
                                    >البداية</a
                                >
                            </li>
                            <li class="page-item">
                                <a
                                    class="page-link"
                                    href="#"
                                    @click="nextPage(current_page - 1)"
                                    >السابق</a
                                >
                            </li>
                            <li
                                class="page-item d-none"
                                v-for="(i, index) in total"
                                :key="index"
                                @click="nextPage(i)"
                            >
                                <a class="page-link" href="#">{{ i }}</a>
                            </li>
                            <li class="page-item">
                                <a
                                    class="page-link"
                                    href="#"
                                    @click="nextPage(current_page + 1)"
                                    >التالي</a
                                >
                            </li>
                            <li
                                :class="
                                    page == total + 1
                                        ? 'page-item disabled'
                                        : 'page-item'
                                "
                            >
                                <a
                                    class="page-link"
                                    href="#"
                                    @click="nextPage(total + 1)"
                                    >الاخير</a
                                >
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- DataTable with Hover -->
    </div>
</template>

<script>
export default {
    created() {
        if (!User.loggedIn()) {
            this.$router.push("/");
        }
        this.allmainTypes();
    },
    data() {
        return {
            mainTypes: [],
            searchTerm: "",
            loading: true,
            title: "Category",
            total: 1,
            page: 1,
            current_page: "",
        };
    },
    computed: {
        filterSearch() {
            return this.mainTypes.filter((mainType) => {
                return mainType.main_type_title_ar.match(this.searchTerm);
            });
        },
    },
    methods: {
        allmainTypes() {
            axios
                .get("/api/mainTypes")
                .then(({ data }) => {
                    if (data.length >= 0) {
                        this.loading = false;
                        this.mainTypes = data;
                    }
                })
                .catch((error) => console.log(error));
        },

        nextPage(i) {
            this.page = i;
            this.allmainTypes();
        },
        deleteAction(id) {
            if (confirm("هل تريد الحذف؟لايمكن الاستعاده مره اخرى.")) {
                axios
                    .delete("/api/mainTypes/" + id)
                    .then(() => {
                        this.mainTypes = this.mainTypes.filter((mainType) => {
                            return mainType.main_type_id != id;
                        });
                        Notification.successMsg("تم الحذف بنجاح");
                    })
                    .catch((err) => {
                        Notification.errorMsg(
                            "لايمكن حذف صنف رئيسي مرتبط بأصناف"
                        );
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
