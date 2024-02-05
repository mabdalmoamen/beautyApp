<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card mb-4">
                    <form @keydown.enter.prevent @submit.prevent="create">
                        <div class="card-header text-center">
                            <a
                                class="btn btn-warning text-light float-right"
                                @click="$router.go(-1)"
                            >
                                <i
                                    :class="
                                        lang == 'ar'
                                            ? 'fa fa-arrow-right'
                                            : 'fa fa-arrow-left'
                                    "
                                ></i>
                            </a>
                            <span class="font-weight-bold text-primary">
                                {{ __("Insert Category Information") }}
                            </span>
                            <button
                                class="btn btn-primary float-left"
                                type="submit"
                            >
                                {{ __("Save") }}
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="input-group">
                                <img
                                    :src="form.type_icon"
                                    class="card-img-top w-25 h-25 m-auto"
                                />
                                <div class="file-input img_file">
                                    <input
                                        onClick="this.select();"
                                        type="file"
                                        name="file-input"
                                        id="file-input"
                                        class="file-input__input"
                                        @change="onFileSelected"
                                    />
                                    <label
                                        class="file-input__label"
                                        for="file-input"
                                    >
                                        <i class="fa fa-upload"></i>

                                        <span> {{ __("Icon") }}</span></label
                                    >
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span
                                        id="basic-addon1"
                                        class="input-group-text"
                                        >{{ __("Category Name ar") }}</span
                                    >
                                </div>
                                <input
                                    aria-describedby="basic-addon1"
                                    class="form-control"
                                    v-model="form.main_type_title_ar"
                                    type="text"
                                    required
                                />
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span
                                        id="basic-addon2"
                                        class="input-group-text"
                                    >
                                        {{ __("Category Name En") }}</span
                                    >
                                </div>
                                <input
                                    aria-describedby="basic-addon2"
                                    class="form-control"
                                    v-model="form.main_type_title_en"
                                    type="text"
                                />
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span
                                        id="basic-addon2"
                                        class="input-group-text"
                                    >
                                        {{ __("Select Printer") }}</span
                                    >
                                    <select
                                        name="printer"
                                        id="printer"
                                        class="form-control"
                                        v-model="form.printer_name"
                                    >
                                        <option disabled n-bind:key="undefined">
                                            Select printer
                                        </option>
                                        <option
                                            v-for="printer in printers"
                                            v-bind:key="printer"
                                        >
                                            {{ printer }}
                                        </option>
                                    </select>
                                    <input
                                        aria-describedby="basic-addon1"
                                        class="form-control"
                                        v-model="form.printer_name"
                                        type="text"
                                        :placeholder=" __('Select Printer')"
                                    />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    async created() {
        if (!User.loggedIn()) {
            this.$router.push("/");
        }
        this.user = await Auth.getAuth();
        this.form.branch_id = this.user.branch_id;
        if(jsPrintSetup){
        let p = jsPrintSetup.getPrintersList();
        var lines = p.split(",");
        for (var i = 1; i < lines.length; i++) {
            this.printers.push(lines[i]);
        }
        }
        this.lang = localStorage.getItem("lang");
    },
    data() {
        return {
            form: {
                main_type_title_ar: null,
                main_type_title_en: null,
                printer_name: "",
            },
            printers: [],
            errors: {},
            print2default: false,
            lang: "ar",
        };
    },

    methods: {
        onFileSelected(event) {
            let file = event.target.files[0];
            if (file.size > 1048770) {
                Notification.image_validation();
            } else {
                let reader = new FileReader();
                reader.onload = (event) => {
                    this.form.type_icon = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
        create() {
            axios
                .post("/api/mainTypes", this.form)
                .then(() => {
                    this.$router.push({ name: "mainTypes" });
                    Notification.success();
                })
                .catch((error) => (this.errors = error.response.data.errors));
        },
    },
};
</script>
