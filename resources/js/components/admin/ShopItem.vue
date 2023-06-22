<template>
  <div class="card m-2 p-2 rounded mb-5" style="width: 90%">
    <p>ID: {{ shop.id }}</p>
    <p>Название: {{ shop.name }}</p>
    <p>Email: {{ shop.email }}</p>
    <p>Телефон: {{ shop.phone }}</p>

    <p>
      Количество заказов: {{ shop.orders_count }}
      <router-link
        :to="{
          name: 'admin.shop.orders',
          params: { shop_id: shop.id, page: 1 },
        }"
      >
        Смотреть
      </router-link>
    </p>
    <p>Дата регистрации: {{ shop.created_at }}</p>
    <p>
      Блокирован:
      <button @click="changeBlockedStatus(shop.id)">
        {{ getBlockedText }}
      </button>
    </p>
  </div>
</template>
            

<script>
import { useCookies } from "vue3-cookies";

export default {
  name: "Company",

  props: ["shop"],

  created() {
    this.blocked = this.shop.blocked;
  },

  methods: {
    async changeBlockedStatus(shopId) {
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
          .post(`/api/v1/admin/shops/${shopId}/block`, bodyParameters, config)
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