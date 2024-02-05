<template>
    <div>
        <Sidebar />

        <div :style="{ direction: dir }" class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid ml-auto">
                    <router-view></router-view>
                </div>
            </section>
        </div>
    </div>
</template>

<script>
import Sidebar from "./components/layout/sidebar.vue";

export default {
    components: { Sidebar },
    async created() {
        this.user = await Auth.getAuth();
        this.mixins = this.user.branch;
        if (this.mixins.default_lang == "ar") {
            this.dir = "rtl";
        }
    },

    data() {
        return {
            mixins: {},
            loading: false,
            title: "Loading",
            user: {},
            dir: "ltr",
        };
    },
};
</script>
