<template>
    <div class="row justify-content-center">
        <div class="card mb-4">
            <div class="accordion-item">
                <h2 class="accordion-header card-header" id="headingTwo">
                    <div
                        class="w-100 d-flex justify-content-between"
                    >
                        <h6 class="m-0 font-weight-bold text-primary">
                            <button
                                class="collapsed btn btn-secondary font-weight-bold text-light"
                                @click="show = !show"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo"
                                aria-expanded="false"
                                aria-controls="collapseTwo"
                            >
                                {{ __("Expenses Report") }}
                                <i
                                    v-if="show"
                                    class="fa fa-angle-double-down"
                                ></i>
                                <i v-else="" class="fa fa-angle-double-up"></i>
                            </button>
                        </h6>

                        <i
                            class="fas fa-file-excel text-success hideMeInPrint"
                            style="cursor: pointer"
                            onclick="download('xlsx','expenses');"
                        ></i>
                    </div>
                </h2>
                <div
                    id="collapseTwo"
                    :class="
                        show
                            ? 'accordion-collapse collapse show'
                            : 'accordion-collapse collapse'
                    "
                    aria-labelledby="headingTwo"
                    data-bs-parent="#accordionExample"
                >
                    <div class="accordion-body px-0">
                        <div class="card-body">
                            <div class="table-responsive table-wrapper">
                                <table
                                    id="expenses"
                                    class="text-center table-bordered"
                                >
                                    <thead>
                                        <tr>
                                            <th
                                                class="col-header"
                                                style="width: 15%"
                                            >
                                                {{ __("Code") }}
                                            </th>
                                            <th
                                                class="col-header"
                                                style="width: 15%"
                                            >
                                                {{ __("Title") }}
                                            </th>
                                            <th
                                                class="col-header"
                                                style="width: 15%"
                                            >
                                                {{ __("Cost") }}
                                            </th>
                                            <th
                                                class="col-header"
                                                style="width: 15%"
                                            >
                                                {{ __("Bill Icon") }}
                                            </th>
                                            <th
                                                class="col-header"
                                                style="width: 15%"
                                            >
                                                {{ __("Date") }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="expense in expenses"
                                            class="ErrorRow"
                                        >
                                            <td>
                                                {{ expense.id }}
                                            </td>
                                            <td>
                                                {{ expense.expense_title }}
                                            </td>
                                            <td>
                                                {{ expense.expense_cost }}
                                            </td>
                                            <td>
                                                <img
                                                    :src="expense.expense_icon"
                                                    class="card-img-top w-25 h-25 float-left ml-auto"
                                                />
                                            </td>
                                            <td>
                                                {{ expense.expense_date }}
                                            </td>
                                        </tr>
                                    </tbody>
                                    <Calculation
                                        :calc="calcExpense"
                                        colspan="1"
                                    />
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Calculation from "./calculation.vue";
export default {
    name: "Expenses",
    props: ["expenses", "hideMe", "calcExpense"],
    created() {
        if (!User.loggedIn()) {
            this.$router.push("/");
        }
    },
    data() {
        return {
            selected: "",
            show: false,
        };
    },
    components: { Calculation },
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
