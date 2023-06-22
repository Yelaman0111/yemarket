<template>
  <div class="card m-2 p-2 rounded mb-5" style="width: 80%">
    <div class="row">
      <div class="col-xl-2">
        <img
          class="card-img-top rounded-circle"
          :src="getImagePath(category.image)"
          height="200"
          alt="Card
          image cap"
        />
      </div>
      <div class="col-xl-5">
        <p><b>id : </b>{{ category.id }}</p>
        <b>Название : </b>
        <router-link
          :to="{
            name: 'admin.categories.edit',
            params: {
              category_title: category.title,
              category_id: category.id,
              parent_category_id: category.parent_id,
              image: category.image,
            },
          }"
        >
          <p>{{ category.title }}</p>
        </router-link>
        <p><b>Создано : </b>{{ category.created_at }}</p>
        <p><b>Обновлено : </b>{{ category.updated_at }}</p>
      </div>
    </div>

    <div
      v-for="category in category.child_categories"
      :key="category.id"
      class="col-md-auto"
    >
      <div class="card rounded mb-3 p-3 mt-3">
        <div class="row">
          <div class="col-xl-2">
            <img
              class="card-img-top rounded-circle"
              :src="getImagePath(category.image)"
              height="80"
              alt="Card
              image cap"
            />
          </div>
          <div class="col-xl-5">
            <p><b>id : </b>{{ category.id }}</p>
            <p>
              <b>Название : </b>
              <router-link
                :to="{
                  name: 'admin.categories.edit',
                  params: {
                    category_title: category.title,
                    category_id: category.id,
                    parent_category_id: category.parent_id,
                    image: category.image,
                  },
                }"
              >
                <p>{{ category.title }}</p>
              </router-link>
            </p>
            <p><b>Создано : </b>{{ category.created_at }}</p>
            <p><b>Обновлено : </b>{{ category.updated_at }}</p>
            <p><b>Количество продуктов: </b>{{ category.products_count }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
            

<script>
export default {
  name: "category",
  props: ["category"],

  created() {},
  methods: {
    getImagePath(image_name) {
      return "http://localhost/uploads/category/" + image_name;
    },
  },
  computed: {},
  data() {
    return {};
  },
};
</script>