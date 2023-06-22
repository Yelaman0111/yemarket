
<template>
  <div>
    <LeftMenu />
    <div class="d-flex flex-column min-vh-100">
      <main style="margin-top: 58px">
        <div class="container p-5">
          <div class="row">
            <div class="col-md-3"></div>
            <form class="col-md-6">
              <div class="form-group mt-3">
                <label for="name">Название компании</label>
                <input
                  v-model="company.name"
                  type="name"
                  class="form-control"
                  id="name"
                  placeholder="Название компании"
                  readonly
                />
              </div>
              <div class="form-group mt-3">
                <label for="email">Логин</label>
                <input
                  v-model="company.email"
                  type="email"
                  class="form-control"
                  id="email"
                  placeholder="Логин"
                  readonly
                />
              </div>
              <div class="form-group mt-3">
                <label for="phone">Контактный телефон, для покупателей</label>
                <input
                  v-model="company.phone"
                  type="phone"
                  class="form-control"
                  id="phone"
                  placeholder="Контактный телефон, для покупателей"
                  readonly
                />
              </div>
              <div class="form-group mt-3">
                <label for="phone">Минимальная сумма одного заказа</label>
                <input
                  v-model="company.min_order_sum"
                  type="phone"
                  class="form-control"
                  id="phone"
                  placeholder="Минимальная сумма одного заказа"
                  readonly
                />
              </div>
            </form>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script>
import LeftMenu from "./LeftMenu.vue";
import { onMounted } from "vue";
import useAuth from "../../composables/company";

export default {
  components: {
    LeftMenu,
  },
  name: "CompanyIndex",

  data() {
    return {};
  },
  setup() {
    const { company, getCompany } = useAuth();

    onMounted(getCompany);

    return {
      company,
    };
  },
};
</script>