<template>
    <div>
        <div v-if="!loading" class="row my-3">
            <div class="card-header text-center mb-2 col-12">
                <h5>الصفحة الرئيسية</h5>
            </div>

            <div class="col-md-2 col-sm-2" v-if="user.new_bill">
                <router-link class="card text-center " style="text-decoration: none; text-align: center" to="/bill">
                    <img alt="Card image cap" class="card-img-top
                         " src="backend/img/menu/new_bill.PNG" />
                    <h5 class="text-center my-0">
                        {{ __("New Bill") }}
                    </h5>
                </router-link>
            </div>
            <div class="col-md-2 col-sm-2 d-none">
                <router-link class="card text-center " style="text-decoration: none; text-align: center" to="/sales">
                    <img alt="Card image cap" class="card-img-top " src="backend/img/menu/sales.PNG" />
                    <h5 class="text-center my-0">
                        {{ __("Sales Types") }}
                    </h5>
                </router-link>
            </div>
            <div class="col-md-2 col-sm-2" v-if="user.bills">
                <router-link class="card text-center " style="text-decoration: none; text-align: center" to="/bills">
                    <img alt="Card image cap" class="card-img-top " src="backend/img/menu/bills.PNG" />
                    <h5 class="text-center my-0">
                        {{ __("Bills") }}
                    </h5>
                </router-link>
            </div>

            <div class="col-md-2 col-sm-2" v-if="user.process_bill">
                <router-link class="card text-center " style="text-decoration: none; text-align: center" to="/process">
                    <img alt="Card image cap" class="card-img-top " src="backend/img/menu/process_bills.PNG" />
                    <h5 class="text-center my-0">
                        {{ __("Manage Exit bill") }}
                    </h5>
                </router-link>
            </div>

            <div class="col-md-2 col-sm-2" v-if="user.main_types">
                <router-link class="card text-center " style="text-decoration: none; text-align: center" to="/mainTypes">
                    <img alt="Card image cap" class="card-img-top " src="backend/img/menu/category.PNG" />
                    <h5 class="text-center my-0">
                        {{ __("Categories") }}
                    </h5>
                </router-link>
            </div>
            <div class="col-md-2 col-sm-2" v-if="user.units">
                <router-link class="card text-center " style="text-decoration: none; text-align: center" to="/units">
                    <img alt="Card image cap" class="card-img-top " src="backend/img/menu/operations.PNG" />
                    <h5 class="text-center my-0">
                        {{ __("Units") }}
                    </h5>
                </router-link>
            </div>

            <div class="col-md-2 col-sm-2" v-if="user.types">
                <router-link class="card text-center " style="text-decoration: none; text-align: center" to="/types">
                    <img alt="Card image cap" class="card-img-top " src="backend/img/menu/items.PNG" />
                    <h5 class="text-center my-0">
                        {{ __("Types") }}
                    </h5>
                </router-link>
            </div>
            <div class="col-md-2 col-sm-2" v-if="user.tables">
                <router-link class="card text-center " style="text-decoration: none; text-align: center" to="/tables">
                    <img alt="Card image cap" class="card-img-top " src="backend/img/menu/chairs.PNG" />
                    <h5 class="text-center my-0">
                        {{ __("Tables") }}
                    </h5>
                </router-link>
            </div>
            <div class="col-md-2 col-sm-2" v-if="user.offers">
                <router-link class="card text-center " style="text-decoration: none; text-align: center" to="/offers">
                    <img alt="Card image cap" class="card-img-top " src="backend/img/menu/offers.PNG" />
                    <h5 class="text-center my-0">
                        {{ __("Offers") }}
                    </h5>
                </router-link>
            </div>
            <div class="col-md-2 col-sm-2" v-if="user.puraches_bill">
                <router-link class="card text-center " to="/create/stock/bill"
                    style="text-decoration: none; text-align: center">
                    <img class="card-img-top " src="backend/img/menu/purchase_bill.PNG" alt="Card image cap" />
                    <h5 class="text-center my-0">
                        {{ __("Purchase Bill") }}
                    </h5>
                </router-link>
            </div>
            <div class="col-md-2 col-sm-2" v-if="user.puraches_bills">
                <router-link class="card text-center " to="/allPurchaseBills"
                    style="text-decoration: none; text-align: center">
                    <img class="card-img-top " src="backend/img/menu/purchases.PNG" alt="Card image cap" />
                    <h5 class="text-center my-0">
                        {{ __("Purchase Bills") }}
                    </h5>
                </router-link>
            </div>
            <div class="col-md-2 col-sm-2" v-if="user.stocks">
                <router-link class="card text-center " style="text-decoration: none; text-align: center" to="/stocks">
                    <img alt="Card image cap" class="card-img-top " src="backend/img/menu/stock.PNG" />
                    <h5 class="text-center my-0">
                        {{ __("Manage Stock") }}
                    </h5>
                </router-link>
            </div>
            <div class="col-md-2 col-sm-2" v-if="user.stock">
                <router-link class="card text-center " style="text-decoration: none; text-align: center" to="/gusto/stocks">
                    <img alt="Card image cap" class="card-img-top " src="backend/img/menu/order.PNG" />
                    <h5 class="text-center my-0">
                        {{ __("Create Order") }}
                    </h5>
                </router-link>
            </div>

            <div class="col-md-2 col-sm-2" v-if="user.customer_pay">
                <router-link class="card text-center " style="text-decoration: none; text-align: center" to="/cash">
                    <img alt="Card image cap" class="card-img-top " src="backend/img/menu/cash.PNG" />
                    <h5 class="text-center my-0">
                        {{ __("Cash") }}
                    </h5>
                </router-link>
            </div>
            <div class="col-md-2 col-sm-2" v-if="user.suppliers">
                <router-link class="card text-center " style="text-decoration: none; text-align: center" to="/suppliers">
                    <img alt="Card image cap" class="card-img-top " src="backend/img/menu/suppliers.PNG" />
                    <h5 class="text-center my-0">
                        {{ __("Suppliers") }}
                    </h5>
                </router-link>
            </div>
            <div class="col-md-2 col-sm-2" v-if="user.expenses">
                <router-link class="card text-center " style="text-decoration: none; text-align: center" to="/expenses">
                    <img alt="Card image cap" class="card-img-top " src="backend/img/menu/expenses.PNG" />
                    <h5 class="text-center my-0">
                        {{ __("Expenses") }}
                    </h5>
                </router-link>
            </div>
            <div class="col-md-2 col-sm-2" v-if="user.customers">
                <router-link class="card text-center " style="text-decoration: none; text-align: center" to="/customers">
                    <img alt="Card image cap" class="card-img-top " src="backend/img/menu/customers.PNG" />
                    <h5 class="text-center my-0">
                        {{ __("Customers") }}
                    </h5>
                </router-link>
            </div>

            <div class="col-md-2 col-sm-2" v-if="user.workers">
                <router-link class="card text-center " style="text-decoration: none; text-align: center" to="/workers">
                    <img alt="Card image cap" class="card-img-top " src="backend/img/menu/workers.PNG" />
                    <h5 class="text-center my-0">
                        {{ __("Workers") }}
                    </h5>
                </router-link>
            </div>

            <div class="col-md-2 col-sm-2" v-if="user.users">
                <router-link class="card text-center " style="text-decoration: none; text-align: center" to="/users">
                    <img alt="Card image cap" class="card-img-top " src="backend/img/menu/users.PNG" />
                    <h5 class="text-center my-0">
                        {{ __("Users") }}
                    </h5>
                </router-link>
            </div>
            <div class="col-md-2 col-sm-2" v-if="user.reports">
                <router-link class="card text-center " style="text-decoration: none; text-align: center" to="/report-menu">
                    <img alt="Card image cap" class="card-img-top " src="backend/img/menu/reports.PNG" />
                    <h5 class="text-center my-0">
                        {{ __("Reports") }}
                    </h5>
                </router-link>
            </div>
            <div class="col-md-2 col-sm-2 d-none" v-show="user.barcode_settings">
                <router-link class="card text-center " to="/barcode">
                    <img class="card-img-top " src="backend/img/menu/barcode.PNG" alt="Card image cap" />
                    <h5 class="text-center my-0">
                        {{ __("Barcode Settings") }}
                    </h5>
                </router-link>
            </div>
            <div class="col-md-2 col-sm-2 d-none">
                <router-link class="card text-center " to="/attendance">
                    <img alt="Card image cap" class="card-img-top " src="backend/img/menu/attendance.PNG" />
                    <h5 class="text-center my-0">
                        {{ __("Attendance And Leave") }}
                    </h5>
                </router-link>
            </div>
            <div class="col-md-2 col-sm-2" v-if="user.settings">
                <router-link class="card text-center " to="/mixins">
                    <img alt="Card image cap" class="card-img-top " src="backend/img/menu/settings.PNG" />
                    <h5 class="text-center my-0">
                        {{ __("Settings") }}
                    </h5>
                </router-link>
            </div>
        </div>
        <Spinner v-else :title="title" />
    </div>
</template>
<script>
import Spinner from "./spinner/loading.vue";
export default {
    components: { Spinner },
    async created() {
        if (!User.loggedIn()) {
            this.$router.push("/");
        }
        this.user = await Auth.getAuth();
        this.mixins = this.user.branch;
        this.loading = false;
    },
    data() {
        return {
            user: {},
            mixins: {},
            loading: true,
            title: "Loading",
        };
    },
};
</script>
<style scoped>
a:hover {
    color: #222;
}

.card {
    background-color: transparent !important;
    transition: transform 0.3s, background 0.3s;
    box-shadow: inset;
    margin-right: 5px;
}

.card:hover {
    transform: scale(1.09);
}

/* .card img {
    width: 100px !important;
    min-height: 100px !important;
    border-radius: 14px;
    object-fit: cover;
    margin: auto;
} */

.card img {
    width: 100%;
    height: 100%;
    max-width: 170px;
    max-height: 170px;
    min-width: 170px;
    min-height: 170px;
    margin: auto;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    filter: hue-rotate(50%);

}

h5 {
    font-size: 20px;
    font-weight: bolder;
}
</style>
