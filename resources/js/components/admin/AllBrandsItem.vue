<template>
  <div class="card m-2 p-2 rounded mb-5" style="width: 80%">
    <img
      class="card-img-top rounded-circle"
      :src="getImagePath(brand.image)"
      height="170"
      alt="Card
      image cap"
    />
    <p><b>id : </b>{{ brand.id }}</p>
    <router-link
      :to="{
        name: 'admin.brands.edit',
        params: {
          brand_name: brand.name,
          brand_id: brand.id,
          brand_image: brand.image,
        },
      }"
    >
      <p><b>Название : </b>{{ brand.name }}</p>
    </router-link>
    <p><b>Создано : </b>{{ brand.created_at }}</p>
    <p><b>Обновлено : </b>{{ brand.updated_at }}</p>
  </div>
</template>
            

<script>
export default {
  name: "Brand",

  props: ["brand"],

  methods: {
    getImagePath(image_name) {
      return "http://localhost/uploads/brands/" + image_name;
    },
  },
};
</script>