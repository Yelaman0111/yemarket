
<template>
  <div>
    <LeftMenu />
    <main style="">
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
              <b>Ошибка добавления продукта:</b>
              <ul>
                <li v-for="error in errors" :key="error.id">{{ error }}</li>
              </ul>
            </p>
          <div class="form-group">
            <label for="name">Название продукта</label>
            <input
              v-model="addProductForm.name"
              type="name"
              class="form-control"
              id="name"
              placeholder="Название продукта"
              required
            />
          </div>
          
          <div class="form-group mt-3">
            <label for="description">Описание</label>
            <textarea
              v-model="addProductForm.description"
              type="text"
              rows="3"
              class="form-control"
              id="description"
              placeholder="Описание"
            />
          </div>

          <div class="form-group mt-3">
            <label for="brand">Брэнд</label>
            <select
              class="form-control"
              id="brand"
              v-model="addProductForm.brand_id"
            >
              <option
                v-for="(item) in brandsAll"
                :key="item.id"
                :value="item.id"
              >
                {{ item.name }}
              </option>
            </select>
          </div>


          <div class="form-group mt-3">
            <label for="measure">Категории</label>
            <select
              @change="changeCategoryChild()"
              class="form-control"
              id="measure"
              v-model="selectedCategory"
            >
              <option
                v-for="(item, index) in categoriesAll"
                :key="item.id"
                :value="index"
              >
                {{ item.title }}
              </option>
            </select>
          </div>


          <div class="form-group mt-3">
            <label for="measure">Подкатегории</label>
            <select
              class="form-control"
              id="measure"
              v-model="addProductForm.category_id"
            >
              <option
                v-for="(item) in childCategory.child_categories"
                :key="item.id"
                :value="item.id"
              >
                {{ item.title }}
              </option>
            </select>
          </div>
          <div class="mb-3 mt-3">
            <label for="formFile" class="form-label">Картинка продукта</label>
            <input class="form-control" ref="file" type="file" id="formFile"  v-on:change="handleFileUpload"/>
          </div>

            <button
              type="submit"
              class="btn btn-primary mt-3"
              @click.prevent="addProduct()"
            >
              Создать
            </button>
        </form>
      </div>
    </main>
  </div>
</template>

<script>
import LeftMenu from "./LeftMenu.vue";
import { onMounted } from "vue";
import useCategories from "../../composables/categories";
import useBrands from "../../composables/brands";
import useProduct from "../../composables/product";

export default {
  components: {
    LeftMenu,
  },
  setup() {
    const { categoriesAll, getAllCategories } = useCategories();
    const { brandsAll, getAllBrands } = useBrands();

    onMounted(getAllCategories);
    onMounted(getAllBrands);

    return {
      categoriesAll,
      brandsAll,
    };
  },
  data() {
    return {
      addProductForm: {
        category_id: 0,
        brand_id: "",
        name: "",
        description: "",
      },
      file: null,
      errors: [],
      categories: [],
      childCategory: {},
      brands: [],
      selectedCategory: "",
    };
  },
  methods: {
    redirectBack() {
      this.$router.back();
    },
    changeCategoryChild() {
      this.childCategory = this.categoriesAll[this.selectedCategory];
    },

    handleFileUpload(event) {
      this.file = event.target.files[0];
    },

    async addProduct() {
      if (
        this.addProductForm.name &&
        this.addProductForm.description &&
        this.addProductForm.brand_id !== null &&
        this.addProductForm.category_id &&
        this.file
      ) {
        try {
          let formData = new FormData();
          formData.append("image", this.file);
          formData.append("category_id", this.addProductForm.category_id);
          formData.append("name", this.addProductForm.name);
          formData.append("description", this.addProductForm.description);
          formData.append("brand_id", this.addProductForm.brand_id);

          const { storeProduct, products } = useProduct();

          await storeProduct(formData);
          this.$router.back();
        } catch (err) {}
      } else {
        this.errors = [];

        if (!this.addProductForm.name) {
          this.errors.push("Введите название продукта.");
        }

        if (!this.addProductForm.description) {
          this.errors.push("Введите описание продукта.");
        }
        if (this.addProductForm.brand_id == null) {
          this.errors.push("Выберите брэнд.");
        }
        if (!this.addProductForm.category_id) {
          this.errors.push("Выберите категорию продукта.");
        }
        if (!this.file) {
          this.errors.push("Выберите картинку продукта.");
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