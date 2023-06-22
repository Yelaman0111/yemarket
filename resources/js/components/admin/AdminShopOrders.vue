<template>
  <div>
    <LeftMenu />
    <!--Main layout-->
    <main style="margin-top: 58px">
      <div class="col-2">
        <router-link
          :to="{ name: 'admin.shops' }"
          class="page-link mb-3 text-center"
        >
          Назад
        </router-link>
      </div>
      <div class="container pt-4">
        <div v-for="order in shopOrders" :key="order.id" class="col-md-auto">
          <ShopOrderItem :id="order.id" :order="order" />
        </div>
      </div>

      <nav aria-label="Page navigation example" v-if="getPagesArray.length > 2">
        <ul class="pagination justify-content-center mt-5">
          <li>
            <nuxt-link
              :to="'/admin/companyOrders?page=' + 1 + '&id=' + shop_id"
              class="page-link me-3"
              >First
            </nuxt-link>
          </li>

          <li>
            <nuxt-link
              :to="'/admin/companyOrders?page=' + getPreviosPageNumber"
              class="page-link me-3"
            >
              <IconsChevronLeft />
            </nuxt-link>
          </li>

          <li class="page-item" v-for="page in pages_array" :key="page.id">
            <nuxt-link
              v-if="page == current_page"
              :to="'/admin/companyOrders?page=' + page"
              class="page-link"
              id="active"
              >{{ page }}
            </nuxt-link>

            <nuxt-link
              v-else
              :to="'/admin/companyOrders?page=' + page + '&id=' + shop_id"
              class="page-link"
              >{{ page }}
            </nuxt-link>
          </li>

          <li>
            <nuxt-link
              :to="
                '/admin/companyOrders?page=' +
                getNextPageNumber +
                '&id=' +
                shop_id
              "
              class="page-link ms-3"
            >
              <IconsChevronRight />
            </nuxt-link>
          </li>
          <li>
            <nuxt-link
              :to="
                '/admin/companyOrders?page=' + pages_count + '&id=' + shop_id
              "
              class="page-link ms-3"
              >Last
            </nuxt-link>
          </li>
        </ul>
      </nav>
    </main>
    <!--Main layout-->
  </div>
</template>



<script>
import ShopOrderItem from "./ShopOrderItem.vue";
import LeftMenu from "./LeftMenu.vue";
import useAdmin from "../../composables/admin";
import { useRoute } from "vue-router";
import { watch } from "vue";
import { onMounted } from "vue";

export default {
  components: {
    ShopOrderItem,
    LeftMenu,
  },

  data() {
    return {
      orders: [],
      pages_array: [],
    };
  },
  setup() {
    const {
      shopOrders,
      shop_orders_current_page,
      shop_orders_pages_count,
      getShopOrders,
    } = useAdmin();

    const route = useRoute();
    const shop_id = route.params.shop_id;
    watch(route, () => {
      getShopOrders(route.params.shop_id, route.params.page);
    });
    onMounted(() => {
      getShopOrders(route.params.shop_id, 1);
    });

    return {
      shopOrders,
      shop_id,
      shop_orders_current_page,
      shop_orders_pages_count,
    };
  },
  computed: {
    getPagesArray() {
      this.pages_array = [];
      if (this.orders_current_page == 1) {
        for (let i = 1; i <= this.orders_current_page + 4; i++) {
          if (i > 0 && i <= this.orders_pages_count) {
            this.pages_array.push(i);
          }
        }
      } else if (this.orders_current_page == 2) {
        for (let i = 1; i <= this.orders_current_page + 3; i++) {
          if (i > 0 && i <= this.orders_pages_count) {
            this.pages_array.push(i);
          }
        }
      } else if (this.orders_current_page == this.orders_pages_count) {
        for (
          let i = this.orders_current_page - 4;
          i <= this.orders_current_page;
          i++
        ) {
          if (i > 0 && i <= this.orders_pages_count) {
            this.pages_array.push(i);
          }
        }
      } else if (this.orders_current_page == this.orders_pages_count - 1) {
        for (
          let i = this.orders_current_page - 3;
          i <= this.orders_current_page + 1;
          i++
        ) {
          if (i > 0 && i <= this.orders_pages_count) {
            this.pages_array.push(i);
          }
        }
      } else {
        for (
          let i = this.orders_current_page - 2;
          i <= this.orders_current_page + 2;
          i++
        ) {
          if (i > 0 && i <= this.orders_pages_count) {
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
      if (this.orders_current_page <= this.orders_pages_count) {
        return this.orders_current_page + 1;
      } else {
        return this.orders_pages_count;
      }
    },
    getPreviosPageNumber() {
      if (this.orders_current_page >= 1) {
        return this.orders_current_page - 1;
      } else {
        return this.orders_pages_count;
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