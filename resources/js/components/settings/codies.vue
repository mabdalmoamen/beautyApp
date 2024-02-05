<template>
    <div>
        <div
            v-if="userRole.is_user == 100"
            class="row d-flex justify-content-center"
        >
            <div class="col-10">
                <!-- Form Basic -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form
                            @keydown.enter.prevent
                            @submit.prevent="saveChanges"
                        >
                            <div
                                class="card-header d-flex justify-content-between"
                            >
                                <h5>يجب اختيار الجداول المراد حذفها</h5>
                                <button
                                    class="btn btn-danger"
                                    type="submit"
                                    :disabled="list.length <= 0"
                                >
                                    حفظ
                                </button>
                            </div>
                            <div class="row">
                                <div
                                    class="col-2"
                                    v-for="(table, index) of tables"
                                >
                                    <div class="form-group float-right">
                                        <div
                                            class="custom-control custom-switch"
                                        >
                                            <input
                                                type="checkbox"
                                                class="custom-control-input"
                                                :id="table.table"
                                                @change="
                                                    addToTables(
                                                        table.table,
                                                        index
                                                    )
                                                "
                                            />
                                            <label
                                                class="custom-control-label"
                                                :for="table.table"
                                            >
                                                {{
                                                    __(
                                                        table.table.split(
                                                            ","
                                                        )[0]
                                                    )
                                                }}</label
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Spinner from "../spinner/loading.vue";
import Cookie from "../../Helpers/Cookie";

export default {
    async created() {
        this.jsPrint = localStorage.getItem("jsPrint");
        await axios
            .get("/api/users/" + localStorage.getItem("user_id"))
            .then(({ data }) => (this.userRole = data))
            .catch((error) => console.log(error));
        this.userRole = await Auth.getAuth();

        let id = this.$route.params.id;
        await axios
            .get("/api/mixins/" + this.userRole.branch_id)
            .then(({ data }) => (this.mixins = data))
            .catch((err) => console.log(err));
    },
    data() {
        return {
            mixins: {},
            jsPrint: "",
            userRole: {},
            tables: [
                {
                    table: "bills,bill_types,shifts,offers,mixins_item_request,mixins_type_stock",
                },
                { table: "customer_pay" },
                { table: "customers,customer_pay" },
                { table: "expenses" },
                { table: "mixins_main_types" },
                { table: "mixins_suppliers" },
                { table: "mixins_type_stock,gusto_stocks,gusto_type_stock" },
                { table: "offers" },
                { table: "returns,return_types" },
                { table: "shifts" },
                { table: "tables_bill,table_types" },
                { table: "tables,tables_bill,table_types" },

                {
                    table: "types,type_units,offers,mixins_type_stock,mixins_item_request,gusto_type_stock",
                },

                { table: "units,type_units" },
                { table: "users" },
            ],
            list: [],
        };
    },
    methods: {
        addToTables(table, i) {
            if (this.list.includes(table)) {
                this.$delete(this.list, i);
            } else {
                this.list.push(table);
            }
        },

        saveChanges() {
            axios
                .get("/api/codies/" + this.list)
                .then(async () => {
                    Notification.success();
                })
                .catch((error) => (this.errors = error.response.data.errors));
        },
        showDropDown() {
            this.isShow = !this.isShow;
        },
        save() {
            let id = 1;
            axios
                .patch("/api/mixins/" + id, this.mixins)
                .then(async () => {
                    //   await this.$router.push({ name: "/" });
                    await location.reload(true);
                    Notification.success();
                })
                .catch((error) => (this.errors = error.response.data.errors));
        },
    },
};
</script>
<style scoped>
input {
    float: right;
}

label {
    float: left;
}
</style>
