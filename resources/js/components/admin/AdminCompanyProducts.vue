<template>
  <div>
    <LeftMenu />
    <main style="margin-top: 58px">
      <div class="col-2">
        <router-link
          :to="{ name: 'admin.index' }"
          class="page-link mb-3 text-center"
        >
          Назад
        </router-link>
      </div>
      <div class="container pt-4">
        <div
          v-for="product in companiesProducts"
          :key="product.id"
          class="col-md-auto"
        >
          <CompanyProductsItem
            :id="product.id"
            :product="product"
            :company_id="company_id"
          />
        </div>
      </div>
      <nav aria-label="Page navigation example" v-if="getPagesArray.length > 1">
        <ul class="pagination justify-content-center mt-5">
          <li>
            <router-link
              :to="{
                name: 'admin.company.products',
                params: { company_id: company_id, page: 1 },
              }"
              class="page-link me-3"
              >First
            </router-link>
          </li>

          <li>
            <router-link
              :to="{
                name: 'admin.company.products',
                params: { company_id: company_id, page: getPreviosPageNumber },
              }"
              class="page-link me-3"
            >
              <IconsChevronLeft />
            </router-link>
          </li>

          <li class="page-item" v-for="page in pages_array" :key="page.id">
            <router-link
              v-if="page == current_page"
              :to="{
                name: 'admin.company.products',
                params: { company_id: company_id, page: page },
              }"
              class="page-link active"
              >{{ page }}
            </router-link>

            <router-link
              v-else
              :to="{
                name: 'admin.company.products',
                params: { company_id: company_id, page: page },
              }"
              class="page-link"
              >{{ page }}
            </router-link>
          </li>

          <li>
            <router-link
              :to="{
                name: 'admin.company.products',
                params: { company_id: company_id, page: getNextPageNumber },
              }"
              class="page-link ms-3"
            >
              <IconsChevronRight />
            </router-link>
          </li>
          <li>
            <router-link
              :to="{
                name: 'admin.company.products',
                params: { company_id: company_id, page: products_pages_count },
              }"
              class="page-link ms-3"
              >Last
            </router-link>
          </li>
        </ul>
      </nav>
    </main>
  </div>
</template>




<script>
import CompanyProductsItem from "./CompanyProductsItem.vue";
import LeftMenu from "./LeftMenu.vue";
import useAdmin from "../../composables/admin";
import { useRoute } from "vue-router";
import { watch } from "vue";
import { onMounted } from "vue";

export default {
  components: {
    CompanyProductsItem,
    LeftMenu,
  },

  data() {
    return {
      pages_array: [],
    };
  },
  setup() {
    const {
      companiesProducts,
      products_current_page,
      products_pages_count,
      getCompaniesProducts,
    } = useAdmin();

    const route = useRoute();

    const company_id = route.params.company_id;
    watch(route, () => {
      getCompaniesProducts(route.params.company_id, route.params.page);
    });
    onMounted(() => {
      getCompaniesProducts(route.params.company_id, 1);
    });

    return {
      companiesProducts,
      company_id,
      products_pages_count,
      products_current_page,
    };
  },

  computed: {
    getPagesArray() {
      this.pages_array = [];
      if (this.products_current_page == 1) {
        for (let i = 1; i <= this.products_current_page + 4; i++) {
          if (i > 0 && i <= this.products_pages_count) {
            this.pages_array.push(i);
          }
        }
      } else if (this.products_current_page == 2) {
        for (let i = 1; i <= this.products_current_page + 3; i++) {
          if (i > 0 && i <= this.products_pages_count) {
            this.pages_array.push(i);
          }
        }
      } else if (this.products_current_page == this.products_pages_count) {
        for (
          let i = this.products_current_page - 4;
          i <= this.products_current_page;
          i++
        ) {
          if (i > 0 && i <= this.products_pages_count) {
            this.pages_array.push(i);
          }
        }
      } else if (this.products_current_page == this.products_pages_count - 1) {
        for (
          let i = this.products_current_page - 3;
          i <= this.products_current_page + 1;
          i++
        ) {
          if (i > 0 && i <= this.products_pages_count) {
            this.pages_array.push(i);
          }
        }
      } else {
        for (
          let i = this.products_current_page - 2;
          i <= this.products_current_page + 2;
          i++
        ) {
          if (i > 0 && i <= this.products_pages_count) {
            this.pages_array.push(i);
          }
        }
      }
      return this.pages_array;
    },
    getProductsLength() {
      return this.products.length;
    },
    getNextPageNumber() {
      if (this.products_current_page <= this.products_pages_count) {
        return this.products_current_page + 1;
      } else {
        return this.products_pages_count;
      }
    },
    getPreviosPageNumber() {
      if (this.products_current_page >= 1) {
        return this.products_current_page - 1;
      } else {
        return this.products_pages_count;
      }
    },
  },
};
</script>

<style>
.page-link {
  color: black;
}

#active {
  color: rgb(64, 177, 252);
}
</style>