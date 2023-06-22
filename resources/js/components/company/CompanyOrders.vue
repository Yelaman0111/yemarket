

<template>
  <div>
    <LeftMenu />
    <main style="margin-top: 58px">
      <div class="container pt-4">
        <div v-if="orders.length < 1">
          Извините, у Вас пока ничего не заказали.
        </div>
        <div v-else v-for="order in orders" :key="order.id" class="col-md-auto">
          <Order :id="order.id" :order="order" />
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import LeftMenu from "./LeftMenu.vue";
import Order from "./Order.vue";
import useOrders from "../../composables/orders";
import { onMounted } from "vue";

export default {
  components: {
    LeftMenu,
    Order,
  },
  name: "CompanyOrders",
  setup() {
    const { orders, getOrders } = useOrders();

    onMounted(getOrders);

    return {
      orders,
    };
  },
};
</script>