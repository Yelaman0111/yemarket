<template>
  <div class="card m-2 p-2 rounded mb-5" style="width: 90%">
    <p>ID: {{ company.id }}</p>
    <p>Название: {{ company.name }}</p>
    <p>Email: {{ company.email }}</p>
    <p>Телефон: {{ company.phone }}</p>
    <p>Минимальная сумма заказа: {{ company.min_order_sum }}</p>

    <p>
      Количество товаров: {{ company.products_count }}
      <router-link
        :to="{
          name: 'admin.company.products',
          params: { company_id: company.id, page: 1 },
        }"
      >
        Смотреть
      </router-link>
    </p>
    <p>
      Количество заказов: {{ company.orders_count }}
      <router-link
        :to="{
          name: 'admin.company.orders',
          params: { company_id: company.id, page: 1 },
        }"
      >
        Смотреть
      </router-link>
    </p>
    <p>Дата регистрации: {{ company.created_at }}</p>
    <p>
      Блокирован:
      <button @click="changeBlockedStatus(company.id)">
        {{ getBlockedText }}
      </button>
    </p>
  </div>
</template>
            

<script>
import { useCookies } from "vue3-cookies";

export default {
  name: "Company",

  props: ["company"],

  created() {
    this.blocked = this.company.blocked;
  },

  methods: {
    async changeBlockedStatus(companyId) {
      const { cookies } = useCookies();
      const token = "Bearer " + cookies.get("Bearer");

      try {
        const config = {
          headers: { Authorization: token },
        };
        const bodyParameters = {
          block_status: this.blocked === 0 ? 1 : 0,
        };

        let response = await axios
          .post(
            `/api/v1/admin/companies/${companyId}/block`,
            bodyParameters,
            config
          )
          .then(function (response) {});

        this.blocked = this.blocked === 0 ? 1 : 0;
      } catch (err) {}
    },
  },
  computed: {
    getBlockedText() {
      return this.blocked === 0 ? "Нет" : "Да";
    },
  },
  data() {
    return {
      blocked: 0,
    };
  },
};
</script>