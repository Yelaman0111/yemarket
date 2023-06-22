<template>
  <div class="card m-2 p-2 rounded mb-5" style="width: 90%">
    <div class="container">
      <div class="row mb-3">
        <div class="col">
          {{
            new Date(order.created_at).toLocaleString("ru", {
              year: "numeric",
              month: "long",
              day: "numeric",
              hour: "numeric",
              minute: "numeric",
            })
          }}
        </div>
        <div class="col">
          <p class="text-center text-black">Номер заказа: {{ order.id }}</p>
        </div>
        <div class="col"></div>
      </div>
    </div>

    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Магазин</th>
          <th>Адрес</th>
          <th>Контактный номер</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{ order.retail_shop["full_name"] }}</td>
          <td>{{ order.retail_shop["address"] }}</td>
          <td>{{ order.retail_shop["phone"] }}</td>
        </tr>
      </tbody>
    </table>

    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Поставщик</th>
          <th>Почта</th>
          <th>Контактный номер</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{ order.opto_shop["full_name"] }}</td>
          <td>{{ order.opto_shop["email"] }}</td>
          <td>{{ order.opto_shop["phone"] }}</td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered table-striped table-hover">
      <thead class="thead-dark">
        <tr>
          <th scope="col-1">
            <p class="text-center text-black">№</p>
          </th>
          <th scope="col">
            <p class="text-center text-black">Наименование</p>
          </th>
          <th scope="col">
            <p class="text-center text-black">Цена (тг)</p>
          </th>
          <th scope="col">
            <p class="text-center text-black">Единица измерения</p>
          </th>
          <th scope="col">
            <p class="text-center text-black">Количество</p>
          </th>
          <th scope="col">
            <p class="text-center text-black">Сумма (тг)</p>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(product, index) in products" :key="product.id">
          <td scope="row">
            <p class="text-center text-black">{{ index + 1 }}</p>
          </td>
          <td scope="row" class="w-50">
            <p class="text-center text-black">{{ product.name }}</p>
          </td>
          <td scope="row">
            <p class="text-center text-black">
              {{ products_company[index].price }}
            </p>
          </td>
          <td scope="row">
            <p class="text-center text-black">{{ product.measure }}</p>
          </td>
          <td scope="row">
            <p class="text-center text-black">
              {{ products_count[index] }}
            </p>
          </td>
          <td scope="row">
            <p class="text-center text-black">
              {{ products_count[index] * products_company[index].price }}
            </p>
          </td>
        </tr>
        <tr>
          <th colspan="4"></th>
          <th>
            <p class="text-center text-black">Итого</p>
          </th>

          <th>
            <p class="text-center text-black">{{ order_total_price }} ₸</p>
          </th>
        </tr>
      </tbody>
    </table>

    <div class="row">
      <div class="col"></div>
      <div class="col"></div>
      <div class="col">
        <button
          v-if="getOrderStatus === 2"
          class="float-end btn btn-gray"
          @click="downloadOrder(order.id)"
        >
          Скачать
        </button>
      </div>
    </div>
  </div>
</template>
            

<script>
export default {
  name: "order",
  props: ["order"],

  created() {
    this.orderStatus = this.order.status;
    this.products_string = this.order.products.split("|||");
    this.products_company_string = this.order.company_products.split("|||");
    this.products_count = this.order.products_count.split(",");

    this.products_string.forEach((element, index) => {
      let product = JSON.parse(element);
      this.products.push(product);
    });

    this.products_company_string.forEach((element, index) => {
      let product_company = JSON.parse(element);
      this.products_company.push(product_company);
      this.order_total_price +=
        parseInt(product_company.price) * this.products_count[index];
    });
  },

  methods: {
    async acceptOrder(orderId) {
      const token = this.$auth.$storage._state["_token.laravelJWT"];

      try {
        const config = {
          headers: { Authorization: token },
        };
        const bodyParameters = {
          id: orderId,
        };

        const res = await this.$axios
          .post(`/api/optoshop/orders/accept`, bodyParameters, config)
          .then(function (response) {});
        this.orderStatus = 2;
        this.$toast.success("Заказ принят в обработку.");
      } catch (err) {}
    },
    async downloadOrder(orderId) {
      try {
        const token = this.$auth.$storage._state["_token.laravelJWT"];

        const config = {
          headers: { Authorization: token },
          responseType: "blob",
        };

        const res = await this.$axios
          .get(`/api/optoshop/orders/download/${orderId}`, config)
          .then(function (response) {
            let blob = new Blob([response.data], {
              type: "application/docx",
            });
            let link = document.createElement("a");
            link.href = window.URL.createObjectURL(blob);
            link.download = "Заказ №" + orderId + ".docx";
            link.click();
          });
      } catch (err) {}
    },
  },
  computed: {
    getProduct() {
      return this.order.products;
    },
    getOrderStatus() {
      return this.orderStatus;
    },
  },
  data() {
    return {
      products_string: [],
      products_company: [],
      products_count: [],
      products: [],
      order_total_price: 0,
      orderStatus: 0,
    };
  },
};
</script>