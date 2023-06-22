
<template>
  <div>
    <LeftMenu />
    <div class="d-flex flex-column min-vh-100">
      <main style="margin-top: 58px">
        <div class="container">
          <div class="row">
            <div class="col-2">
              <router-link
                :to="{ name: 'company.products.all', params: { page: 1 } }"
                class="page-link mb-3 text-center p-2 rounded"
                >Присоедениться к продукту
              </router-link>
            </div>
            <div class="col-2">
              <router-link
                :to="{ name: 'company.products.create' }"
                class="page-link mb-3 text-center p-2 rounded"
                >Создать новый продукт
              </router-link>
            </div>
            <div class="col-4">
              <form action="#" v-on:submit.prevent="searchProduct">
                <div class="input-group w-100">
                  <input
                    v-model="search_text"
                    type="text"
                    class="form-control rounded"
                    placeholder="Начните вводить название продукта"
                  />
                  <button type="submit" class="btn border btn-gray">
                    <IconsSearch />
                  </button>
                </div>
              </form>
            </div>
          </div>

          <div class="row justify-content-md-center">
            <div v-if="!companyProducts.length">
              У Вас пока нет добавленных продуктов.
            </div>

            <div
              v-else
              v-for="product in companyProducts"
              :key="product.id"
              class="col-md-auto"
            >
              <ProductInListCompany :id="product.id" :product="product" />
            </div>
          </div>

          <nav
            aria-label="Page navigation example"
            v-if="getPagesArray.length > 1"
          >
            <ul class="pagination justify-content-center mt-5">
              <li>
                <router-link
                  :to="{ name: 'company.products', params: { page: 1 } }"
                  class="page-link me-3"
                  >First
                </router-link>
              </li>

              <li>
                <router-link
                  :to="{
                    name: 'company.products',
                    params: { page: getPreviosPageNumber },
                  }"
                  class="page-link me-3"
                >
                  <IconsChevronLeft />
                </router-link>
              </li>

              <li class="page-item" v-for="page in pages_array" :key="page.id">
                <router-link
                  v-if="page == current_page"
                  :to="{ name: 'company.products', params: { page: page } }"
                  class="page-link active"
                  >{{ page }}
                </router-link>

                <router-link
                  v-else
                  :to="{ name: 'company.products', params: { page: page } }"
                  class="page-link"
                  >{{ page }}
                </router-link>
              </li>

              <li>
                <router-link
                  :to="{
                    name: 'company.products',
                    params: { page: getNextPageNumber },
                  }"
                  class="page-link ms-3"
                >
                  <IconsChevronRight />
                </router-link>
              </li>
              <li>
                <router-link
                  :to="{
                    name: 'company.products',
                    params: { page: pages_count },
                  }"
                  class="page-link ms-3"
                  >Last
                </router-link>
              </li>
            </ul>
          </nav>
        </div>
      </main>
    </div>
  </div>
</template>

<script>
import LeftMenu from "./LeftMenu.vue";
import ProductInListCompany from "./ProductInListCompany.vue";
import { onMounted } from "vue";
import useAuth from "../../composables/company";
import { useCookies } from "vue3-cookies";
import { useRoute } from "vue-router";
import { watch } from "vue";
export default {
  components: {
    LeftMenu,
    ProductInListCompany,
  },
  name: "CompanyIndex",

  data() {
    return {
      pages_array: [],
      search_text: "",
    };
  },
  setup() {
    const { companyProducts, pages_count, current_page, getCompanyProducts } =
      useAuth();

    const route = useRoute();

    watch(route, () => {
      getCompanyProducts(route.params.page);
    });
    onMounted(() => {
      getCompanyProducts(1);
    });

    return {
      companyProducts,
      pages_count,
      current_page,
    };
  },

  computed: {
    getPagesArray() {
      this.pages_array = [];
      if (this.current_page == 1) {
        for (let i = 1; i <= this.current_page + 4; i++) {
          if (i > 0 && i <= this.pages_count) {
            this.pages_array.push(i);
          }
        }
      } else if (this.current_page == 2) {
        for (let i = 1; i <= this.current_page + 3; i++) {
          if (i > 0 && i <= this.pages_count) {
            this.pages_array.push(i);
          }
        }
      } else if (this.current_page == this.pages_count) {
        for (let i = this.current_page - 4; i <= this.current_page; i++) {
          if (i > 0 && i <= this.pages_count) {
            this.pages_array.push(i);
          }
        }
      } else if (this.current_page == this.pages_count - 1) {
        for (let i = this.current_page - 3; i <= this.current_page + 1; i++) {
          if (i > 0 && i <= this.pages_count) {
            this.pages_array.push(i);
          }
        }
      } else {
        for (let i = this.current_page - 2; i <= this.current_page + 2; i++) {
          if (i > 0 && i <= this.pages_count) {
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
      if (this.current_page <= this.pages_count) {
        return this.current_page + 1;
      } else {
        return this.pages_count;
      }
    },
    getPreviosPageNumber() {
      if (this.current_page >= 1) {
        return this.current_page - 1;
      } else {
        return this.pages_count;
      }
    },
  },

  methods: {
    async searchProduct() {
      const { cookies } = useCookies();
      const token = "Bearer " + cookies.get("Bearer");

      const config = {
        headers: { Authorization: token },
      };

      const search_text = this.search_text;
      let formData = new FormData();
      formData.append("search_text", search_text);

      let response = await axios.post(
        "/api/v1/company/products/search",
        formData,
        config
      );

      this.companyProducts = [];
      this.companyProducts = response.data.data;
      this.pages_count = response.data.last_page;
      this.current_page = response.data.current_page;
    },
  },
};
</script>