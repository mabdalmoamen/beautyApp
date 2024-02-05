<template>
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card mb-4">
                <form @keydown.enter.prevent @submit.prevent="update">
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
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
                            {{ __("Edit Offer Information") }}
                        </h6>
                        <button class="btn btn-primary" type="submit">
                            {{ __("Save") }}
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span
                                    id="basic-addon1"
                                    class="input-group-text"
                                >
                                    {{ __("Main Offer type") }}</span
                                >
                            </div>
                            <input
                                readonly
                                aria-describedby="basic-addon1"
                                class="form-control"
                                v-model="main_type.type_name_ar"
                                type="text"
                                required
                            />
                            <a
                                class="btn btn-info btn text-light"
                                @click="showMainType = !showMainType"
                                ><i
                                    class="fas fa-search font-weight-bold text-light"
                                ></i
                            ></a>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span
                                    id="basic-addon2"
                                    class="input-group-text"
                                >
                                    {{ __("Offer Type") }}
                                </span>
                            </div>
                            <input
                                readonly
                                aria-describedby="basic-addon2"
                                class="form-control"
                                v-model="sup_type.type_name_ar"
                                type="text"
                                required
                            />
                            <a
                                class="btn btn-info btn text-light"
                                @click="showSupType = !showSupType"
                                ><i
                                    class="fas fa-search font-weight-bold text-light"
                                ></i
                            ></a>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text">{{
                                    __("Discount Percent")
                                }}</span>
                            </div>
                            <input
                                aria-describedby="basic-addon2"
                                class="form-control"
                                v-model="form.offer_discount_percent"
                                type="text"
                                required
                            />
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text">{{
                                    __("Main Offer Type Count")
                                }}</span>
                            </div>
                            <input
                                aria-describedby="basic-addon2"
                                class="form-control"
                                v-model="form.main_type_count"
                                type="text"
                            />
                        </div>
                    </div>
                </form>
                <div
                    aria-hidden="true"
                    aria-labelledby="exampleModalLabel"
                    :class="
                        showMainType ? 'modal fade d-block show' : 'modal fade'
                    "
                    role="dialog"
                    tabindex="-1"
                >
                    <div
                        class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                        role="document"
                    >
                        <div class="modal-content m-auto">
                            <div class="modal-header">
                                <h5 id="exampleModalLabel" class="modal-title">
                                    إضافة الصنف الرئيسي
                                </h5>
                                <button
                                    aria-label="Close"
                                    class="close"
                                    data-dismiss="modal"
                                    type="button"
                                >
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body min-h-50">
                                <div class="table-responsive">
                                    <input
                                        v-model="typeName"
                                        class="form-control-sm"
                                        placeholder="اسم الصنــــــف "
                                        type="search"
                                    />
                                    <button
                                        class="btn btn-sm btn-info"
                                        @click="findTypeByLike()"
                                    >
                                        <i
                                            class="fa fa-search font-weight-bold text-light"
                                        ></i>
                                    </button>
                                    <table
                                        class="table align-items-center text-center"
                                    >
                                        <thead>
                                            <tr>
                                                <th class="col-header">
                                                    اسم الصنف
                                                </th>
                                                <th class="col-header">
                                                    تحديد
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(
                                                    type, index
                                                ) in products"
                                                :key="index"
                                            >
                                                <td>
                                                    {{ type.type_name_ar }}
                                                </td>
                                                <td>
                                                    <button
                                                        class="btn btn-success btn-sm"
                                                        @click="
                                                            selectMainProduct(
                                                                type
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="fa fa-plus font-weight-bold text-light"
                                                        ></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button
                                    class="btn btn-secondary"
                                    @click="
                                        showMainType = !showMainType;
                                        typeName = '';
                                    "
                                    type="button"
                                >
                                    إغلاق
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    id="exampleModal"
                    aria-hidden="true"
                    aria-labelledby="exampleModalLabel"
                    :class="
                        showSupType ? 'modal fade d-block show' : 'modal fade'
                    "
                    role="dialog"
                    tabindex="-1"
                >
                    <div
                        class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                        role="document"
                    >
                        <div class="modal-content m-auto">
                            <div class="modal-header">
                                <h5 class="modal-title">اضافة صنف العرض</h5>
                                <button
                                    aria-label="Close"
                                    class="close"
                                    data-dismiss="modal"
                                    type="button"
                                >
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body min-h-50">
                                <div class="col-lg-12 mb-4">
                                    <div class="table-responsive">
                                        <input
                                            v-model="typeName"
                                            class="form-control-sm"
                                            placeholder="اسم الصنــــــف "
                                            type="search"
                                        />
                                        <button
                                            class="btn btn-sm btn-info"
                                            @click="findTypeByLike()"
                                        >
                                            <i
                                                class="fa fa-search font-weight-bold text-light"
                                            ></i>
                                        </button>
                                        <table
                                            class="table align-items-center text-ceneter"
                                        >
                                            <thead>
                                                <tr>
                                                    <th class="col-header">
                                                        اسم الصنف
                                                    </th>
                                                    <th class="col-header">
                                                        تحديد
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr
                                                    v-for="(
                                                        type, index
                                                    ) in products"
                                                    :key="index"
                                                >
                                                    <td>
                                                        {{ type.type_name_ar }}
                                                    </td>
                                                    <td>
                                                        <button
                                                            class="btn btn-success btn-sm"
                                                            @click="
                                                                selectSupProduct(
                                                                    type
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fa fa-plus font-weight-bold text-light"
                                                            ></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button
                                    class="btn btn-secondary"
                                    @click="
                                        showSupType = !showSupType;
                                        typeName = '';
                                    "
                                    type="button"
                                >
                                    إغلاق
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
export default {
    async created() {
        if (!User.loggedIn()) {
            this.$router.push({ name: "/" });
        }
        this.user = await Auth.getAuth();
        this.form.branch_id = this.user.branch_id;

        let id = this.$route.params.id;
        axios
            .get("/api/offers/" + id)
            .then(({ data }) => {
                this.form = data;
                this.sup_type = data.offer_type;
                this.main_type = data.main_offer_type;
                console.log(data);
            })
            .catch((error) => console.log(error));
    },
    data() {
        return {
            user: {},
            typeName: "",
            showMainType: false,
            showSupType: false,
            sup_type: {},
            main_type: {},
            form: {
                main_type: null,
                sup_type: null,
                offer_discount_percent: null,
                main_type_count: null,
            },
            products: [],
            errors: {},
        };
    },

    methods: {
        async findTypeByLike() {
            await axios
                .get("/api/action/like/" + this.typeName)
                .then(({ data }) => {
                    this.products = data;
                })
                .catch((error) => console.log(error));
        },
        selectMainProduct(type) {
            this.main_type = type;
            this.showMainType = !this.showMainType;
            this.typeName = "";
        },
        selectSupProduct(type) {
            this.sup_type = type;
            this.showSupType = !this.showSupType;
            this.typeName = "";
        },
        update() {
            this.form.main_type = this.main_type.type_id;
            this.form.sup_type = this.sup_type.type_id;

            let id = this.$route.params.id;
            axios
                .patch("/api/offers/" + id, this.form)
                .then(() => {
                    this.$router.push({ name: "offers" });
                    Notification.success();
                })
                .catch((error) => (this.errors = error.response.data.errors));
        },
    },
};
</script>

<style type="text/css"></style>
