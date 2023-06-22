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
          <div
            v-if="getOrderStatus === 1"
            class="float-end btn btn-gray"
            @click="acceptOrder(order.id)"
          >
            Создан
          </div>
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

    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Компания</th>
          <th>Контактный номер</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{ order.company.name }}</td>
          <td>{{ order.company.phone }}</td>
        </tr>
      </tbody>
    </table>

    <table class="table table-bordered table-striped table-hover">
      <thead class="thead-grey">
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
        <tr v-for="(order, index) in order.orders" :key="order.id">
          <td scope="row">
            <p class="text-center text-black">{{ index + 1 }}</p>
          </td>
          <td scope="row" class="w-50">
            <p class="text-center text-black">
              {{ order.product_company.product.name }}
            </p>
          </td>
          <td scope="row">
            <p class="text-center text-black">{{ order.price }}</p>
          </td>
          <td scope="row">
            <p class="text-center text-black">
              {{ order.count }}
            </p>
          </td>
          <td scope="row">
            <p class="text-center text-black">
              {{ order.count * order.price }}
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
  </div>
</template>
            

<script>
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

  computed: {
    getProduct() {
      return this.order.products;
    },
    getOrderStatus() {
      return this.order.status;
    },
  },
  data() {
    return {
      products_count: [],
      order_total_price: 0,
      orderStatus: 0,
    };
  },
};
</script>