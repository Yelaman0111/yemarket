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
        <div class="col">
          <button
            v-if="getOrderStatus === 1"
            class="float-end btn btn-gray"
            @click="acceptOrder(order.id)"
          >
            Принять
          </button>
          <div v-else-if="getOrderStatus === 0" class="float-end">
            Заказ отменен
          </div>
          <div v-else-if="getOrderStatus === 2" class="float-end">
            Заказ принят
          </div>
          <div v-else-if="getOrderStatus === 3" class="float-end">
            Заказ завершен
          </div>
        </div>
      </div>
    </div>

    <table class="table table-bordered" v-if="getOrderStatus === 2">
      <thead>
        <tr>
          <th>Магазин</th>
          <th>Адрес</th>
          <th>Контактный номер</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{ order.shop["name"] }}</td>
          <td>{{ order.shop["address"] }}</td>
          <td>{{ order.shop["phone"] }}</td>
        </tr>
      </tbody>
    </table>

    <table class="table table-bordered table-striped table-hover">
      <thead>
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
            <p class="text-center text-black">{{ product.product.name }}</p>
          </td>
          <td scope="row">
            <p class="text-center text-black">{{ product.price }}</p>
          </td>

          <td scope="row">
            <p class="text-center text-black">
              {{ products_count[index] }}
            </p>
          </td>
          <td scope="row">
            <p class="text-center text-black">
              {{ products_count[index] * product.price }}
            </p>
          </td>
        </tr>
        <tr>
          <th colspan="3"></th>
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
import { useCookies } from "vue3-cookies";

export default {
  name: "order",
  props: ["order"],

  created() {
    this.orderStatus = this.order.status;
    this.order.orders.forEach((element, index) => {
      this.products_count.push(element.count);
      this.products.push(element.product_company);
      this.order_total_price +=
        parseInt(element.price) * this.products_count[index];
    });
  },

  methods: {
    async acceptOrder(orderId) {
      const { cookies } = useCookies();

      const token = "Bearer " + cookies.get("Bearer");

      const config = {
        headers: { Authorization: token },
      };
      try {
        const bodyParameters = {
          id: orderId,
        };

        let response = await axios
          .post("/api/v1/company/orders/accept", bodyParameters, config)
          .then((response) => {});

        this.orderStatus = 2;
      } catch (err) {}
    },

    async downloadOrder(orderId) {
      try {
        const { cookies } = useCookies();

        const token = "Bearer " + cookies.get("Bearer");

        const config = {
          headers: { Authorization: token },
          responseType: "blob",
        };
        let response = await axios
          .get(`/api/v1/company/orders/download/${orderId}`, config)
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
      products_count: [],
      products: [],
      order_total_price: 0,
      orderStatus: 0,
    };
  },
};
</script>