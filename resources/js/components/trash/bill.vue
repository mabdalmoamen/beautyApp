<template>
    <div class="card">
        <div class="card-header text-center">
            {{ __("Deleted Bills") }}
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
        </div>
        <div class="card-body">
            <table class="text-center">
                <thead>
                    <tr>
                        <th>{{ __("Code") }}</th>
                        <th>{{ __("Sum") }}</th>
                        <th>{{ __("Vat") }}</th>
                        <th>{{ __("Total") }}</th>
                        <th>{{ __("Deleted Date") }}</th>
                        <th>{{ __("Reset") }}</th>
                        <th>{{ __("Delete") }}</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="bill in bills">
                        <td>{{ bill.bill_no }}</td>
                        <td>{{ bill.bill_sum }}</td>
                        <td>{{ bill.bill_vat_val }}</td>
                        <td>{{ bill.bill_total }}</td>
                        <td>{{ bill.delete_date }}</td>
                        <td>
                            <button
                                class="btn btn-sm btn-danger"
                                @click="restore(bill.bill_no)"
                            >
                                {{ __("Reset") }}
                            </button>
                        </td>
                        <td>
                            <button
                                class="btn btn-danger text-light"
                                @click="deleteEvent(bill.bill_no)"
                            >
                                {{ __("Delete") }}
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
export default {
    async created() {
        await this.deletedBills();
    },
    data() {
        return {
            bills: [],
        };
    },
    methods: {
        async deletedBills() {
            await axios.get("/trash/bills").then((data) => {
                console.log(data);
                this.bills = data.data;
            });
        },
        async deleteEvent(id) {
            await axios.get("/delete/bills/" + id);
            await this.deletedBills();
        },
        async restore(id) {
            await axios.get("/restore/bills/" + id);
            await this.deletedBills();
        },
    },
};
</script>
