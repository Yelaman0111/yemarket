<template>
  <div>
    <LeftMenu />
    <!--Main layout-->
    <main style="margin-top: 58px">
      <div class="col-1">
        <router-link
         :to="{ name: 'admin.categories.create' }"
          class="page-link mb-3 text-center p-2 rounded"
          >Добавить
        </router-link>
      </div>
      <div class="container pt-4">
        <div
          v-for="category in categories"
          :key="category.id"
          class="col-md-auto"
        >
          <AllCategoriesItem :id="category.id" :category="category" />
        </div>
      </div>
    </main>
  </div>
</template>
            

<script>
import AllCategoriesItem from "./AllCategoriesItem.vue";
import LeftMenu from "./LeftMenu.vue";
import useAdmin from "../../composables/admin";
import { useRoute } from "vue-router";
import { onMounted } from "vue";

export default {
  components: {
    AllCategoriesItem,
    LeftMenu,
  },
  setup() {
    const { categories, getAllCategories } = useAdmin();

    const route = useRoute();

    onMounted(() => {
      getAllCategories();
    });

    return {
      categories,
    };
  },
};
</script>