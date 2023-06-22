
<template>
  <div>
    <LeftMenu />
  <!--Main layout-->
  <main>
    <div
      class="modal fade"
      id='modalShow'
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Присоединиться?</h5>
          
          </div>
          <div class="modal-body">Вы будете добавлены к данному товару, после того как наш модератор проверит правильность заполнения.</div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Отменить
            </button>
            <button
              type="button"
              class="btn btn-primary"
              data-dismiss="modal"
              @click="updateProduct()"
            >
              ОК
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="container p-5">
       <div class="row">
        <div class="col-2">
          <button @click="redirectBack()" class="page-link mb-3 text-center"
            >Назад
          </button>
        </div>
      </div>
      <div class="row">
        <div class="col-3">
        </div>
        <div class="col-6">
        <img
          class="card-img-top p-1 border mt-3"
          :src=getImagePath
          height="400"
          alt="Card image cap"
        />
        </div>
        </div>
      <form class="col-md-auto"> 
          <p v-if="errors.length">
            <b>Ошибка добавления продукта:</b>
            <ul>
              <li v-for="error in errors" :key="error.id">{{ error }}</li>
            </ul>
          </p>
        <div class="form-group  mt-3">
          <label for="name">Название продукта</label>
          <input
            v-model="addProductForm.name"
            type="name"
            class="form-control"
            id="name"
            placeholder="Название продукта"
            readonly
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
            readonly
          />
        </div>
  <div class="form-group">
          <label for="short_description">Категория</label>
          <input
            v-model="addProductForm.cat"
            type="name"
            class="form-control"
            id="short_description"
            placeholder="Название продукта"
            readonly
          />
        </div>
         <div class="form-group">
          <label for="short_description">Подкатегории</label>
          <input
            v-model="addProductForm.cat2"
            type="name"
            class="form-control"
            id="short_description"
            placeholder="Название продукта"
            readonly
          />
        </div>

        <div class="form-group mt-3" hidden>
          <label for="measure">Категория</label>
          <select
            class="form-control"
            id="measure"
            v-model="selectedParentCategory"
            disabled="true"
          >
            <option
              v-for="(item, index) in categoriesAll"
              :key="item.id"
              :value="index"
              :selected="setSelectedParentCategory == item.id"
            >
              {{ item.title }}
            </option>
          </select>
        </div>

        <div class="form-group mt-3">
          <label for="price">Введите вашу цену на этот продукт</label>
          <input
            v-model="addProductSellerForm.price"
            type="number"
            class="form-control"
            id="price"
            placeholder="Цена"
          />
        </div>
        <div class="form-group mt-3">
          <label for="price">Введите минимальное количество товара для заказа</label>
          <input
            v-model="addProductSellerForm.minOrderCount"
            type="number"
            class="form-control"
            id="price"
          />
        </div>
        <div class="form-group mt-3">
          <label for="description">SKU</label>
          <textarea
            v-model="addProductSellerForm.sku"
            type="text"
            rows="3"
            class="form-control"
            id="description"
            placeholder="SKU"
            
          />
        </div>

          <button
           
            type="button"
            class="btn btn-primary mt-3 "
            data-toggle="modal"
            data-target= '#modalShow'
          >
            Присоединиться
          </button>
      </form>
    </div>
  </main>
  <!--Main layout-->
  </div>
</template>

<script>
import LeftMenu from "./LeftMenu.vue";
import useCategories from "../../composables/categories";
import { onMounted } from "vue";
import useAuth from "../../composables/company";

export default {
  components: {
    LeftMenu,
  },

  setup() {
    const { categoriesAll, getAllCategories } = useCategories();

    onMounted(getAllCategories);

    return {
      categoriesAll,
    };
  },

  created() {
    this.addProductForm.name = JSON.parse(this.$route.params.product).name;
    this.addProductForm.description = JSON.parse(
      this.$route.params.product
    ).description;
    this.addProductForm.category_id = JSON.parse(
      this.$route.params.product
    ).category_id;
    this.selectedChildCategory = JSON.parse(
      this.$route.params.product
    ).category_id;
    this.image = JSON.parse(this.$route.params.product).image;
    this.product_id = JSON.parse(this.$route.params.product).id;
  },

  data() {
    return {
      addProductSellerForm: {
        sku: "",
        price: "",
        minOrderCount: 1,
      },
      addProductForm: {
        name: "",
        description: "",
        price: "",
        category_id: 0,
        cat: "",
        cat2: "",
      },
      product_id: 0,
      errors: [],
      parentCategories: [],
      childCategory: {},
      selectedParentCategory: "",
      selectedChildCategory: "",
      image: "",
    };
  },
  computed: {
    getImagePath() {
      return "http://localhost/uploads/products/" + this.image;
    },
    setSelectedParentCategory() {
      this.categoriesAll.forEach((parentCategory, index) => {
        parentCategory.child_categories.forEach((ChildCategory, key) => {
          if (ChildCategory.id == this.addProductForm.category_id) {
            this.selectedParentCategory = parentCategory.id - 1;
            this.childCategory =
              this.parentCategories[this.selectedParentCategory];

            this.addProductForm.cat = parentCategory.title;
            this.addProductForm.cat2 = ChildCategory.title;
          }
        });
      });
    },
  },
  methods: {
    redirectBack() {
      this.$router.back();
    },

    async updateProduct() {
      if (
        this.addProductSellerForm.sku &&
        this.addProductSellerForm.price &&
        this.addProductSellerForm.minOrderCount
      ) {
        try {
          const { storeProduct } = useAuth();

          let formData = new FormData();
          formData.append("product_id", this.product_id);
          formData.append("price", this.addProductSellerForm.price);
          formData.append("sku", this.addProductSellerForm.sku);
          formData.append(
            "min_order_count",
            this.addProductSellerForm.minOrderCount
          );

          storeProduct(formData);

          this.$router.back();
        } catch (err) {}
      } else {
        this.errors = [];

        if (!this.addProductSellerForm.sku) {
          this.errors.push("Введите sku продукта.");
        }
        if (!this.addProductSellerForm.price) {
          this.errors.push("Введите вашу цену продукта.");
        }
        if (!this.addProductSellerForm.minOrderCount) {
          this.errors.push("Введите минимальное количество товара для заказа.");
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