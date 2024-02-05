<template>
    <div>
        <div class="row my-3">
            <div class="card-header col-12 py-3 d-flex flex-row align-items-center justify-content-between">
                <a class="btn btn-warning text-light" @click="$router.go(-1)">
                    <i :class="
                        $root.$data.codies.default_lang == 'ar'
                            ? 'fa fa-arrow-right'
                            : 'fa fa-arrow-left'
                    "></i>
                </a>
                <h5>{{ __("Reports") }}</h5>
            </div>
            <div class="col-2">
                <router-link class="card text-center p-1 w-100" :to="{ name: 'report', params: { period: 'daily' } }"
                    style="text-decoration: none; text-align: center">
                    <img class="card-img-top w-100" src="backend/img/reports/daily.PNG" alt="Card image cap" />
                    <h5 class="text-center my-0 ">
                        {{ __("Today Report") }}
                    </h5>
                </router-link>
            </div>
            <div class="col-2">
                <router-link class="card text-center p-1 w-100" :to="{ name: 'report', params: { period: 'monthly' } }"
                    style="text-decoration: none; text-align: center">
                    <img class="card-img-top w-100" src="backend/img/reports/monthly.PNG" alt="Card image cap" />
                    <h5 class="text-center my-0 ">
                        {{ __("Monthly Report") }}
                    </h5>
                </router-link>
            </div>

            <div class="col-2">
                <router-link class="card text-center p-1 w-100" to="/bills/report"
                    style="text-decoration: none; text-align: center">
                    <img class="card-img-top w-100" src="backend/img/reports/period.PNG" alt="Card image cap" />
                    <h5 class="text-center my-0 ">
                        {{ __("Period Report") }}
                    </h5>
                </router-link>
            </div>
            <div class="col-2">
                <a class="card text-center p-1 w-100" href="/appreport" style="text-decoration: none; text-align: center">
                    <img class="card-img-top w-100" src="backend/img/reports/bills.PNG" alt="Card image cap" />
                    <h5 class="text-center my-0 ">
                        {{ __("Bills Report") }}
                    </h5>
                </a>
            </div>
            <div class="col-2">
                <a class="card text-center p-1 w-100" href="/TypeReport" style="text-decoration: none; text-align: center">
                    <img class="card-img-top w-100" src="backend/img/menu/items.PNG" alt="Card image cap" />
                    <h5 class="text-center my-0 ">
                        {{ __("Types Report") }}
                    </h5>
                </a>
            </div>
            <div class="col-2">
                <router-link class="card text-center p-1 w-100" to="/PurachasesReport"
                    style="text-decoration: none; text-align: center">
                    <img class="card-img-top w-100" src="backend/img/reports/puraches.PNG" alt="Card image cap" />
                    <h5 class="text-center my-0 ">
                        {{ __("Purchase Bills Report") }}
                    </h5>
                </router-link>
            </div>
            <div class="col-2 d-none">
                <router-link class="card text-center p-1 w-100" to="/ProcessReport"
                    style="text-decoration: none; text-align: center">
                    <img class="card-img-top w-100" src="backend/img/reports/bills.PNG" alt="Card image cap" />
                    <h5 class="text-center my-0 ">
                        {{ __("Process Bills Report") }}
                    </h5>
                </router-link>
            </div>
            <div class="col-2">
                <router-link class="card text-center p-1 w-100" to="/customers/report"
                    style="text-decoration: none; text-align: center">
                    <img class="card-img-top w-100" src="backend/img/reports/customers.PNG" alt="Card image cap" />
                    <h5 class="text-center my-0 ">
                        {{ __("Customers Report") }}
                    </h5>
                </router-link>
            </div>
            <div class="col-2">
                <router-link class="card text-center p-1 w-100" to="/search"
                    style="text-decoration: none; text-align: center">
                    <img class="card-img-top w-100" src="backend/img/reports/search.PNG" alt="Card image cap" />
                    <h5 class="text-center my-0 ">
                        {{ __("Search Report") }}
                    </h5>
                </router-link>
            </div>

            <div class="col-2">
                <router-link to="/shiftReport" class="card text-center p-1 w-100">
                    <img alt="Card image cap" class="card-img-top w-100" src="backend/img/reports/shift.PNG" />
                    <h5 class="text-center my-0 ">
                        {{ __("Shift Report") }}
                    </h5>
                </router-link>
            </div>
            <div class="col-md-2 col-sm-4 d-none">
                <router-link to="/attendance/report" class="card text-center p-1 w-100">
                    <img alt="Card image cap" class="card-img-top w-100" src="backend/img/menu/attendance.PNG" />
                    <h5 class="text-center my-0 ">
                        {{ __("Attendance And Leave report") }}
                    </h5>
                </router-link>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    async created() {
        if (!User.loggedIn()) {
            await this.$router.push("/");
        }
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
    margin: auto;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    filter: hue-rotate(50%);
    max-width: 170px;
    max-height: 170px;
    min-width: 170px;
    min-height: 170px;
}

h5 {
    font-size: 20px;
    font-weight: bolder;
}
</style>
