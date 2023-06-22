<template>
  <div>
    <LeftMenu />
  <!--Main layout-->
  <main style="margin-top: 58px">
    <div class="container p-5">
       <div class="row">
        <div class="col-2">
           <button @click="redirectBack()" class="page-link mb-3 text-center"
            >Назад
          </button>
        </div>
      </div>
      <form class="col-md-auto"> 
          <p v-if="errors.length">
            <b>Ошибка добавления Category:</b>
            <ul>
              <li v-for="error in errors" :key="error.id">{{ error }}</li>
            </ul>
          </p>
        <div class="form-group">
          <label for="title">Название Category</label>
          <input
            v-model="addCategoryForm.title"
            type="title"
            class="form-control"
            id="title"
            placeholder="Название Category"
            required
          />
        </div>

        <div class="form-group mt-3">
          <label for="category">Родительская категория</label>
          <select
            class="form-control"
            id="category"
            v-model="addCategoryForm.category_id"

          >
            <option
              v-for="(item) in parentCategories"
              :key="item.id"
              :value="item.id"
            >
              {{ item.title }}
            </option>
          </select>
        </div>

        <div class="mb-3 mt-3">
          <label for="formFile" class="form-label">Картинка Category</label>
          <input class="form-control" ref="file" type="file" id="formFile"  v-on:change="handleFileUpload"/>
        </div>

          <button
            type="submit"
            class="btn btn-primary mt-3"
            @click.prevent="addCategory()"
          >
            Создать
          </button>
      </form>
    </div>
  </main>
  <!--Main layout-->
  </div>
</template>
<script>
import LeftMenu from "./LeftMenu.vue";
import { useRoute } from "vue-router";
import useAdmin from "../../composables/admin";
import { useCookies } from "vue3-cookies";
import { onMounted } from "vue";
export default {
  components: {
    LeftMenu,
  },
  created() {},

  data() {
    return {
      addCategoryForm: {
        title: "",
        category_id: "",
      },
      file: null,
      errors: [],
      categories: [],
    };
  },
  setup() {
    const route = useRoute();

    const { parentCategories, getParentCategories } = useAdmin();

    onMounted(() => {
      getParentCategories();
    });

    return {
      parentCategories,
    };
  },

  methods: {
    redirectBack() {
      this.$router.back();
    },

    handleFileUpload(event) {
      this.file = event.target.files[0];
    },

    async addCategory() {
      if (this.addCategoryForm.title && this.addCategoryForm.category_id) {
        try {
          const { cookies } = useCookies();
          const token = "Bearer " + cookies.get("Bearer");

          const config = {
            headers: {
              Authorization: token,
              "content-type": "multipart/form-data",
            },
          };
          let formData = new FormData();
          formData.append("image", this.file);
          formData.append("title", this.addCategoryForm.title);
          formData.append("parent_id", this.addCategoryForm.category_id);

          let response = await axios.post(
            "/api/v1/admin/categories/create",
            formData,
            config
          );

          this.$router.back();
        } catch (err) {}
      } else {
        this.errors = [];

        if (!this.addCategoryForm.title) {
          this.errors.push("Введите название Category.");
        }

        if (!this.addCategoryForm.category_id) {
          this.errors.push("Введите parent category_id.");
        }
      }
    },
  },
};
</script>

<style scoped>
.page-link {
  color: black;
}
</style>