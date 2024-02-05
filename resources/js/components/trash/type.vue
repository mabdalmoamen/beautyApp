<template>
    <div class="card">
        <div class="card-header text-center">
            {{ __("Deleted Types") }}
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
                        <th>{{ __("Type Name") }}</th>
                        <th>{{ __("Sill Price") }}</th>
                        <th>{{ __("Reset") }}</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="type in types">
                        <td>{{ type.type_id }}</td>
                        <td>{{ type.type_name_ar }}</td>
                        <td>{{ type.type_sill_price }}</td>
                        <td>
                            <button
                                class="btn btn-sm btn-danger text-light"
                                @click="restore(type.type_id)"
                            >
                                {{ __("Reset") }}
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
        await this.deletedTypes();
    },
    data() {
        return {
            types: [],
        };
    },
    methods: {
        async deletedTypes() {
            await axios.get("/trash/types").then((data) => {
                console.log(data);
                this.types = data.data;
            });
        },

        async restore(id) {
            await axios.get("/restore/" + id);
            await this.deletedTypes();
        },
    },
};
</script>
