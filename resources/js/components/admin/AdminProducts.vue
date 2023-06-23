<template>
  <div>
    <LeftMenu />
    <!--Main layout-->
    <main style="margin-top: 58px">
      <div class="col-1">
        <router-link
          :to="{ name: 'admin.products.create' }"
          class="page-link mb-3 text-center p-2 rounded"
          >Добавить
        </router-link>
      </div>
      <div class="container pt-4">
        <div
          v-for="product in allProducts"
          :key="product.id"
          class="col-md-auto"
        >
          <ProductItem :id="product.id" :product="product" />
        </div>
      </div>

      <nav aria-label="Page navigation example" v-if="getPagesArray.length > 0">
        <ul class="pagination justify-content-center mt-5">
          <li>
            <router-link
              :to="{
                name: 'admin.products',
                params: { page: 1 },
              }"
              class="page-link me-3"
              >First
            </router-link>
          </li>

          <li>
            <router-link
              :to="{
                name: 'admin.products',
                params: { page: getPreviosPageNumber },
              }"
              class="page-link me-3"
            >
              <ChevronLeft />
            </router-link>
          </li>

          <li class="page-item" v-for="page in pages_array" :key="page.id">
            <router-link
              v-if="page == current_page"
              :to="{
                name: 'admin.products',
                params: { page: page },
              }"
              class="page-link"
              id="active"
              >{{ page }}
            </router-link>

            <router-link
              v-else
              :to="{
                name: 'admin.products',
                params: { page: page },
              }"
              class="page-link"
              >{{ page }}
            </router-link>
          </li>

          <li>
            <router-link
              :to="{
                name: 'admin.products',
                params: { page: getNextPageNumber },
              }"
              class="page-link ms-3"
            >
              <ChevronRight />
            </router-link>
          </li>
          <li>
            <router-link
              :to="{
                name: 'admin.products',
                params: { page: pages_count },
              }"
              class="page-link ms-3"
              >Last
            </router-link>
          </li>
        </ul>
      </nav>
    </main>
    <!--Main layout-->
  </div>
</template>
<script>
import LeftMenu from "./LeftMenu.vue";
import ProductItem from "./ProductItem.vue";
import useAdmin from "../../composables/admin";
import { useRoute } from "vue-router";
import { watch } from "vue";
import { onMounted } from "vue";
import ChevronRight from "../Icons/ChevronRight";
import ChevronLeft from "../Icons/ChevronLeft";

export default {
  components: {
    ProductItem,
    LeftMenu,
    ChevronRight,
    ChevronLeft,
  },

  data() {
    return {
      products: [],
      pages_array: [],
      pages_count: 1,
      current_page: 1,
    };
  },
  setup() {
    const {
      allProducts,
      all_products_pages_count,
      all_products_current_page,
      getAllProducts,
    } = useAdmin();

    const route = useRoute();
    watch(route, () => {
      getAllProducts(route.params.page);
    });
    onMounted(() => {
      getAllProducts(1);
    });

    return {
      allProducts,
      all_products_pages_count,
      all_products_current_page,
    };
  },
  computed: {
    getPagesArray() {
      this.pages_array = [];
      if (this.all_products_current_page == 1) {
        for (let i = 1; i <= this.all_products_current_page + 4; i++) {
          if (i > 0 && i <= this.all_products_pages_count) {
            this.pages_array.push(i);
          }
        }
      } else if (this.all_products_current_page == 2) {
        for (let i = 1; i <= this.all_products_current_page + 3; i++) {
          if (i > 0 && i <= this.all_products_pages_count) {
            this.pages_array.push(i);
          }
        }
      } else if (
        this.all_products_current_page == this.all_products_pages_count
      ) {
        for (
          let i = this.all_products_current_page - 4;
          i <= this.all_products_current_page;
          i++
        ) {
          if (i > 0 && i <= this.all_products_pages_count) {
            this.pages_array.push(i);
          }
        }
      } else if (
        this.all_products_current_page ==
        this.all_products_pages_count - 1
      ) {
        for (
          let i = this.all_products_current_page - 3;
          i <= this.all_products_current_page + 1;
          i++
        ) {
          if (i > 0 && i <= this.all_products_pages_count) {
            this.pages_array.push(i);
          }
        }
      } else {
        for (
          let i = this.all_products_current_page - 2;
          i <= this.all_products_current_page + 2;
          i++
        ) {
          if (i > 0 && i <= this.all_products_pages_count) {
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
      if (this.all_products_current_page <= this.all_products_pages_count) {
        return this.all_products_current_page + 1;
      } else {
        return this.all_products_pages_count;
      }
    },
    getPreviosPageNumber() {
      if (this.all_products_current_page >= 1) {
        return this.all_products_current_page - 1;
      } else {
        return this.all_products_pages_count;
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