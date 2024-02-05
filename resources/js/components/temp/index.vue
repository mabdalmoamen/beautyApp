<template>
  <div>
    <div class="row">
      <!-- Datatables -->
      <div v-show="!loading" class="col-lg-12">
        <div class="card mb-4">
          <div
            class="
              card-header
              d-flex
              flex-row
              align-items-center
              justify-content-between
            "
          >
            <h6 class="m-0 font-weight-bold text-primary">كل المنتجات</h6>
            <router-link
              class="m-0 font-weight-bold text-primary"
              to="/create/supplier"
              >إضافة</router-link
            >
            <button
              class="btn btn-primary"
              onclick="download('xlsx');"
              type="submit"
            >
              <i class="fa fa-file-excel"></i>
            </button>
            <a class="btn btn-info" href="javascript:timedRefresh(2000)">
              <i class="fa fa-sort"></i>
            </a>
            <h6 class="m-0 font-weight-bold text-primary float-left">
              <div id="search">
                <input
                  id="filter"
                  class="form-control-sm"
                  name="filter"
                  type="text"
                  value=""
                />
              </div>
            </h6>
          </div>
          <div class="w-100 dragscroll table-wrapper">
            <div id="pagewrap" class="row">
              <div id="body" class="col-sm-12">
                <table id="resultTable" class="text-center table-bordered">
                  <thead>
                    <tr>
                      <th class="col-header" style="width: 15%">إعدادات</th>

                      <th class="col-header" style="width: 15%">كود</th>
                      <th class="col-header" style="width: 15%">الاسم</th>
                      <th class="col-header" style="width: 15%">الهاتف</th>
                      <th class="col-header" style="width: 15%">
                        اجمالي المسحوبات
                      </th>
                      <th class="col-header" style="width: 15%">
                        اجمالي المدفوع
                      </th>
                      <th class="col-header" style="width: 15%">
                        اجمالي المتبقي
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="supplier in suppliers" class="ErrorRow">
                      <td>
                        <router-link
                          :to="{
                            name: 'edit-supplier',
                            params: { id: supplier.supplier_id },
                          }"
                          class="btn btn-sm btn-primary"
                          ><i class="fa fa-edit"></i>
                        </router-link>
                        <a
                          class="btn btn-sm btn-danger"
                          @click="deleteAction(supplier.supplier_id)"
                          ><i class="fa fa-trash"></i
                        ></a>
                      </td>
                      <td>{{ supplier.supplier_id }}</td>
                      <td>{{ supplier.supplier_name }}</td>
                      <td>{{ supplier.supplier_mobile }}</td>
                      <td>{{ supplier.supplier_total_withdrawals }}</td>
                      <td>{{ supplier.supplier_total_paid }}</td>
                      <td>{{ supplier.supplier_total_remain }}</td>
                    </tr>
                  </tbody>
                  <tfoot></tfoot>
                </table>
                <div v-show="suppliers.length > 0" class="row text-center">
                  <ul class="pagination justify-content-center">
                    <li :class="page == 1 ? 'page-item disabled' : 'page-item'">
                      <a class="page-link" href="#" @click="nextPage(1)"
                        >البداية</a
                      >
                    </li>
                    <li class="page-item">
                      <a
                        class="page-link"
                        href="#"
                        @click="nextPage(current_page - 1)"
                        >السابق</a
                      >
                    </li>
                    <li
                      class="page-item d-none"
                      v-for="(i, index) in total"
                      @click="nextPage(i)"
                    >
                      <a class="page-link" href="#">{{ i }}</a>
                    </li>
                    <li class="page-item">
                      <a
                        class="page-link"
                        href="#"
                        @click="nextPage(current_page + 1)"
                        >التالي</a
                      >
                    </li>
                    <li
                      :class="
                        page == total + 1 ? 'page-item disabled' : 'page-item'
                      "
                    >
                      <a class="page-link" href="#" @click="nextPage(total + 1)"
                        >الاخير</a
                      >
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- DataTable with Hover -->

      <div v-show="loading" class="text-center bg-info text-light" dir="rtl">
        <div class="spinner-border m-5" role="status">
          <span class="sr-only"></span>
        </div>
        <p class="align-middle" style="margin: -50vh auto !important">
          في انتظار التحميل ........
        </p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  created() {
    if (!User.loggedIn()) {
            this.$router.push("/");
        }
    this.allSuppliers();
  },
  data() {
    return {
      suppliers: [],
      searchTerm: "",
      loading: true,

      total: 1,
      page: 1,
      current_page: "",
    };
  },
  computed: {
    filterSearch() {
      return this.suppliers.filter((supplier) => {
        return supplier.supplier_name_ar.match(this.searchTerm);
      });
    },
  },
  methods: {
    allSuppliers() {
      axios
        .get("/api/suppliers?page=" + this.page)
        .then(({ data }) => {
          if (data.data.length > 0) {
            this.loading = false;
            this.total = parseInt(data.total / data.per_page);
            this.suppliers = data.data;
            this.current_page = data.current_page;
          }
        })
        .catch((error) => console.log(error));
    },

    nextPage(i) {
      this.page = i;
      this.allsuppliers();
    },
    deleteAction(id) {
      Swal.fire({
        title: "هل تريد حذف الصنف؟",
        text: "لايمكن الاسترجاع عن هذا!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "تأكيد حذف لصنف!",
        cancelButtonText: "إلغاء",
      }).then((result) => {
        if (result.value) {
          axios
            .delete("/api/suppliers/" + id)
            .then(() => {
              this.suppliers = this.suppliers.filter((supplier) => {
                return supplier.supplier_id != id;
              });
            })
            .catch(() => {
              this.$router.push({ name: "suppliers" });
            });
          Swal.fire("حذف!", "تم الحذف.", "success");
        }
      });
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
