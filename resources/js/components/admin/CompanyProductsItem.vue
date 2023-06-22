<template>
  <div class="card m-2 p-2 rounded mb-5" style="width: 90%">
    <img
      class="card-img-top"
      :src="getImagePath"
      height="170"
      width="50"
      alt="Card
      image cap"
    />
    <p><b>ID продукта:</b> {{ product.product.id }}</p>
    <p><b>ID продукта компании:</b> {{ product.id }}</p>
    <p><b>Название:</b> {{ product.product.name }}</p>
    <p><b>Цена:</b> {{ product.price }}</p>
    <p><b>Мин кол-во для заказа:</b> {{ product.min_order_count }}</p>
    <p>
      <b>approved:</b>
      <button @click="changeApprovedStatus(product.id)">
        {{ getApprovedText }}
      </button>
    </p>
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
    async changeApprovedStatus(companyProductId) {
      const { cookies } = useCookies();
      const token = "Bearer " + cookies.get("Bearer");
      const config = {
        headers: { Authorization: token },
      };
      this.approved = this.approved ? 0 : 1;

      try {
        const bodyParameters = {
          approved_status: this.approved ? 0 : 1,
        };

        let response = await axios
          .post(
            "api/v1/admin/companies/products/" + companyProductId,
            bodyParameters,
            config
          )
          .then(function (response) {});
      } catch (err) {}
    },
  },
  computed: {
    getApprovedText() {
      return this.approved ? "Да" : "Нет";
    },
    getImagePath() {
      return "http://localhost/uploads/products/" + this.product.product.image;
    },
  },

  data() {
    return {
      company_product: {},
      approved: 0,
    };
  },
};
</script>