<template></template>
<script>
import AppStorage from "../../Helpers/AppStorage";

export default {
    async created() {
        if (!User.loggedIn()) {
            this.$router.push({ name: "/" });
        }

        if (User.hasToken()) {
            await axios.post("api/auth/logout").then(async () => {
                AppStorage.clear();
                $(".layout-fixed").removeClass("sidebar-mini");

                await this.$router.push("/");
            });

            // location.reload(true);
        }
    },
};
</script>
