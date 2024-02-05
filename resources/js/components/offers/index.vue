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
                        {{ __("Offers") }}
                    </h6>
                    <router-link
                        class="m-0 font-weight-bold text-primary"
                        to="/create/offer"
                        >{{ __("Create") }}</router-link
                    >
                </div>
                <div class="table-responsive">
                    <table
                        v-if="offers.length > 0"
                        id="offers"
                        class="text-center table-bordered"
                    >
                        <thead>
                            <tr>
                                <th
                                    v-show="
                                        user.delete_offer || user.edit_offer
                                    "
                                    class="col-header"
                                    style="width: 15%"
                                >
                                    {{ __("Settings") }}
                                </th>

                                <th class="col-header" style="width: 15%">
                                    {{ __("Main Offer type") }}
                                </th>
                                <th class="col-header" style="width: 15%">
                                    {{ __("Offer Type") }}
                                </th>
                                <th class="col-header" style="width: 15%">
                                    {{ __("Discount Percent") }}
                                </th>
                                <th class="col-header" style="width: 15%">
                                    {{ __("Main Offer Type Count") }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="offer in offers" class="ErrorRow">
                                <td>
                                    <router-link
                                        v-show="user.edit_offer"
                                        :to="{
                                            name: 'edit-offer',
                                            params: {
                                                id: offer.id,
                                            },
                                        }"
                                        class="btn btn-sm btn-primary"
                                        ><i class="fa fa-edit"></i>
                                    </router-link>
                                    <a
                                        v-show="user.delete_offer"
                                        class="btn btn-sm btn-danger"
                                        @click="deleteAction(offer.id)"
                                        ><i class="fa fa-trash"></i
                                    ></a>
                                </td>
                                <td>
                                    {{ offer.main_offer_type.type_name_ar }}
                                </td>
                                <td>
                                    {{ offer.offer_type.type_name_ar }}
                                </td>
                                <td>
                                    {{ offer.offer_discount_percent }}
                                </td>
                                <td>{{ offer.main_type_count }}</td>
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

        this.alloffers();
    },
    data() {
        return {
            user: {},
            title: "Offers",
            offers: [],
            searchTerm: "",
            loading: true,
        };
    },

    methods: {
        alloffers() {
            axios
                .get("/api/offers")
                .then(({ data }) => {
                    if (!data.isEmpty) {
                        this.loading = false;

                        this.offers = data;
                    }
                })
                .catch((error) => console.log(error));
        },

        deleteAction(id) {
            if (confirm("هل تريد الحذف؟لايمكن الاستعاده مره اخرى.")) {
                axios
                    .delete("/api/offers/" + id)
                    .then(() => {
                        this.offers = this.offers.filter((offer) => {
                            return offer.id != id;
                        });
                        Notification.successMsg("تم الحذف بنجاح");
                    })
                    .catch(() => {
                        Notification.errorMsg("حدث خطأ ما");
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
