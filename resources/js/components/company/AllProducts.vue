
<template>
  <div>
    <LeftMenu />
    <main style="margin-top: 58px">
      <div class="container">
        <div class="row">
          <div class="col-2">
            <router-link
              :to="{ name: 'company.products' }"
              class="page-link mb-3 text-center"
            >
              Назад
            </router-link>
          </div>
          <div class="col-6">
            <form action="#" v-on:submit.prevent="searchProduct">
              <div class="input-group w-75">
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
          <div v-if="products.length < 1">
            Найдите товар к которому вы хотите добавиться как продавец.
          </div>
          <div
            v-else
            v-for="product in products"
            :key="product.id"
            class="col-md-auto"
          >
            <ProductCardInCreate :id="product.id" :product="product" />
          </div>
        </div>

        <nav
          aria-label="Page navigation example"
          v-if="getPagesArray.length > 2"
        >
          <ul class="pagination justify-content-center mt-5">
            <li>
              <router-link
                :to="{ name: 'company.products.all', params: { page: 1 } }"
                class="page-link me-3"
                >First
              </router-link>
            </li>

            <li>
              <router-link
                :to="{
                  name: 'company.products.all',
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
                :to="{ name: 'company.products.all', params: { page: page } }"
                class="page-link active"
                >{{ page }}
              </router-link>

              <router-link
                v-else
                :to="{ name: 'company.products.all', params: { page: page } }"
                class="page-link"
                >{{ page }}
              </router-link>
            </li>

            <li>
              <router-link
                :to="{
                  name: 'company.products.all',
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
                  name: 'company.products.all',
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
    <!--Main layout-->
  </div>
</template>


<script>
import LeftMenu from "./LeftMenu.vue";
import ProductCardInCreate from "./ProductCardInCreate.vue";
import useProduct from "../../composables/product";
import { onMounted } from "vue";
import { useRoute } from "vue-router";
import { watch } from "vue";

import { useCookies } from "vue3-cookies";

export default {
  components: {
    LeftMenu,
    ProductCardInCreate,
  },

  setup() {
    const { products, pages_count, current_page, getProducts } = useProduct();
    const route = useRoute();

    watch(route, () => {
      getProducts(route.params.page);
    });
    onMounted(() => {
      getProducts(1);
    });

    return {
      products,
      pages_count,
      current_page,
    };
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
        "/api/v1/company/products/all/search",
        formData,
        config
      );

      this.products = [];
      this.products = response.data.data;
      this.pages_count = response.data.last_page;
      this.current_page = response.data.current_page;
    },
  },

  data() {
    return {
      pages_array: [],
      search_text: "",
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
};
</script> 
<style scoped>
.page-link {
  color: black;
}

.active {
  color: rgb(64, 177, 252);
}
</style>