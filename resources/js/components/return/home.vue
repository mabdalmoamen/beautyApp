<template>
    <div>
        <returnR v-if="mixins.country == 1"></returnR>

        <processR v-else></processR>
    </div>
</template>

<script>
import returnR from "./index.vue";
import processR from "./process.vue";

export default {
    components: { returnR, processR },

    async created() {
        if (!User.loggedIn()) {
            await this.$router.push("/");
        }
                this.user = await Auth.getAuth();
        this.mixins = this.user.branch;

    },

    data() {
        return {
            mixins: {},
        };
    },

};
</script>
