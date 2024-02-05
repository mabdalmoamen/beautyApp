<template>
    <div class="card">
        <div class="card-header">
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
        <div class="row text-center">
            <div v-if="mixins.country == 1" class="col-3">
                <router-link to="/trash/bill">
                    <div class="card">
                        <div class="card-header">
                            {{ __("Deleted Bills") }}
                        </div>
                        <div class="card-bod">
                            <img src="backend/img/menu/bills.png" alt="" />
                        </div>
                    </div>
                </router-link>
            </div>
            <div class="col-3">
                <router-link to="/trash/type">
                    <div class="card">
                        <div class="card-header">
                            {{ __("Deleted Types") }}
                        </div>
                        <div class="card-bod">
                            <img w- src="backend/img/menu/types.png" alt="" />
                        </div>
                    </div>
                </router-link>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    async created() {
        this.user = await Auth.getAuth();
        this.mixins = this.user.branch;
    },
    data() {
        return {
            mixins: {},
            user: {},
        };
    },
};
</script>
<style scoped>
.card img {
    width: 100px !important;
    min-height: 100px !important;
    border-radius: 14px;
    object-fit: cover;
    margin: auto;
}
</style>
