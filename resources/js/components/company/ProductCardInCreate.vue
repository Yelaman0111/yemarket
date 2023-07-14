<template>
  <div class="p-2 rounded mb-3 max" id="product_cart" style="height: 250px">
    <router-link
      :to="{
        name: 'company.products.connect',
        params: { product: JSON.stringify(product) },
      }"
    >
      <img
        class="card-img-top"
        :src="getImagePath"
        height="170"
        alt="Card image cap"
      />
      <div class="card-body">
        <p class="text-center text-black">
          {{ product.name.substring(0, 10) }}
        </p>
      </div>
    </router-link>
  </div>
</template>

<script>
export default {
  name: "product",
  props: ["product", "id"],
  computed: {
    getImagePath() {
      return "https://yemarket.kz/uploads/products/" + this.product.image;
    },
  },
};
</script>
<style>
#product_cart {
  width: 13rem;
  border: 1px solid;
  border-color: rgb(236, 236, 236);
}

#product_cart:hover {
  border-color: rgb(202, 201, 201);
}

.cursor-pointer {
  cursor: pointer;
}

.text-black {
  color: black;
}

.product {
  padding: 1rem;
  border: 1px dotted #ccc;
  margin: 1rem 0;
}

a:link {
  text-decoration: none;
}

.btn-gray {
  background-color: rgb(212, 211, 211);
}

.row-cart {
  display: flex;
}

.col-cart {
  flex: 50%;
}
</style>