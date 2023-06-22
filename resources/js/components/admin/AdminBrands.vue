<template>
  <div>
    <LeftMenu />
    <main style="margin-top: 58px">
      <div class="col-1">
        <router-link
          :to="{ name: 'admin.brands.create' }"
          class="page-link mb-3 text-center p-2 rounded"
          >Добавить
        </router-link>
      </div>
      <div class="container pt-4">
        <div v-for="brand in brands" :key="brand.id" class="col-md-auto">
          <AllBrandsItem :id="brand.id" :brand="brand" />
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import LeftMenu from "./LeftMenu.vue";
import useAdmin from "../../composables/admin";
import { onMounted } from "vue";
import AllBrandsItem from "./AllBrandsItem.vue";

export default {
  components: {
    AllBrandsItem,
    LeftMenu,
  },
  setup() {
    const { brands, getAllBrands } = useAdmin();

    onMounted(() => {
      getAllBrands();
    });

    return {
      brands,
    };
  },
};
</script>