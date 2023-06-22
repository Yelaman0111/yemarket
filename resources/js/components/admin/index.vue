
<template>
  <div>
    <LeftMenu />
    <main style="margin-top: 58px">
      <div class="container pt-4">
        <div v-if="companies.length < 1">Пока что нет поставщиков</div>
        <div
          v-else
          v-for="company in companies"
          :key="company.id"
          class="col-md-auto"
        >
          <CompanyItem :id="company.id" :company="company" />
        </div>
      </div>
    </main>
    <!--Main layout-->
  </div>
</template>

<script>
import CompanyItem from "./CompaniesItem.vue";
import LeftMenu from "./LeftMenu.vue";
import { onMounted } from "vue";
import useAdmin from "../../composables/admin";

export default {
  components: {
    CompanyItem,
    LeftMenu,
  },

  data() {
    return {
      companies: [],
    };
  },
  setup() {
    const { companies, getAllCompanies } = useAdmin();

    onMounted(getAllCompanies);

    return {
      companies,
    };
  },
};
</script>