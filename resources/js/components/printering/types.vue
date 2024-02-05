<template>

</template>
<script>
export default {
    components: { Spinner },
    name: "sidebar",
    async created() {
        this.user = await Auth.getAuth();
        this.mixins = this.user.branch;
        this.lang = this.mixins.default_lang;
    },
    data() {
        return {
            mixins: {},
            lang: "",
            loading: false,
            title: "Loading",
            user: {},
        };
    },
    methods: {
        async changeLang(lang) {
            this.mixins.default_lang = lang;
            await axios.patch(
                "/api/mixins/" + this.user.branch_id,
                this.mixins
            );
            localStorage.setItem("lang", lang);
            await location.reload(true);

        },
    },
};
</script>
