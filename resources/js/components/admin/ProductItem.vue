<template>
  <div class="card m-2 p-2 rounded mb-5" style="width: 80%">
    <img
      class="card-img-top"
      :src="getImagePath"
      style="width: 50%"
      height="170"
      alt="Card
      image cap"
    />
    <p><b>id : </b>{{ product.id }}</p>
    <p>
      <b>Название : </b>
      {{ product.name }}
    </p>
    <p><b>Описание : </b>{{ product.description }}</p>
    <p><b>Брэнд : </b>{{ product.brand.name }}</p>
    <p><b>Категория : </b>{{ product.category.title }}</p>
    <p><b>Создано : </b>{{ product.created_at }}</p>
    <p><b>Обновлено : </b>{{ product.updated_at }}</p>
    <p>
      <b>approved : </b
      ><button @click="changeApprovedStatus(product.id)">
        {{ getApprovedText }}
      </button>
    </p>

    <div
      v-for="product in product.companies_product"
      :key="product.id"
      class="col-md-auto"
    >
      <div class="card p-2 rounded mb-2">
        <p><b>Компания: </b>{{ product.company.name }}</p>
        <p><b>Цена: </b>{{ product.price }}</p>
        <p>
          <b>Минимальное количество для заказа: </b
          >{{ product.min_order_count }}
        </p>
      </div>
    </div>
  </div>
</template>
            

<script>
import { useCookies } from "vue3-cookies";

export default {
  props: ["product"],

  created() {
    this.approved = this.product.approved;
  },

  methods: {
    async changeApprovedStatus(productId) {
      try {
        const { cookies } = useCookies();

        const token = "Bearer " + cookies.get("Bearer");

        const config = {
          headers: { Authorization: token },
        };
        const bodyParameters = {
          approved_status: this.approved ? 0 : 1,
        };
        let response = await axios
          .post(
            `/api/v1/admin/products/${productId}/approve`,
            bodyParameters,
            config
          )
          .then((response) => {});

        this.approved = this.approved ? 0 : 1;
      } catch (err) {}
    },
  },
  computed: {
    getApprovedText() {
      return this.approved ? "Да" : "Нет";
    },

    getImagePath() {
      return "https://yemarket.kz/uploads/products/" + this.product.image;
    },
  },
  data() {
    return {
      archived: 0,
      approved: 0,
    };
  },
};
</script>