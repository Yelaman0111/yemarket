
<template>
  <div>
    <LeftMenu />
    <main style="margin-top: 58px">
      <div class="container pt-4">
        <div v-if="shops.length < 1">Пока что нет поставщиков</div>
        <div v-else v-for="shop in shops" :key="shop.id" class="col-md-auto">
          <ShopItem :id="shop.id" :shop="shop" />
        </div>
      </div>
    </main>
    <!--Main layout-->
  </div>
</template>

<script>
import ShopItem from "./ShopItem.vue";
import LeftMenu from "./LeftMenu.vue";
import { onMounted } from "vue";
import useAdmin from "../../composables/admin";

export default {
  components: {
    ShopItem,
    LeftMenu,
  },

  setup() {
    const { shops, getAllShops } = useAdmin();

    onMounted(getAllShops);

    return {
      shops,
    };
  },
};
</script>