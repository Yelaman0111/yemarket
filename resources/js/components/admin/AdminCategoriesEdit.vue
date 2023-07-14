<template>
  <div>
    <LeftMenu />
  <!--Main layout-->
  <main >
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
            <h5 class="modal-title" id="exampleModalLabel">Сохранить?</h5>
            <button
              type="button"
              class="btn-close"
              data-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">Сохранить данные по category?</div>
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
              @click="updatecategory()"
            >
              Да
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
          :src=getImagePath(image)
          height="250"
          alt="Card image cap"
        />
        </div>
        </div>

      <form class="col-md-auto"> 
          <p v-if="errors.length">
            <b>Ошибка изменения category:</b>
            <ul>
              <li v-for="error in errors" :key="error.id">{{ error }}</li>
            </ul>
          </p>
        <div class="form-group  mt-3">
          <label for="title">Название category</label>
          <input
            v-model="category_title"
            type="title"
            class="form-control"
            id="title"
            placeholder="Название category"
          />
        </div>
         <div class="form-group mt-3">
          <label for="category">Родительская категория</label>
          <select
            class="form-control"
            id="category"
            v-model="parent_category_id"
          ><option
              :value="0"
            >
             0
            </option>
            <option
              v-for="(item) in parentCategories"
              :key="item.id"
              :value="item.id"
              :selected="item.id == parent_category_id"
            >
              {{ item.title}}
            </option>
          </select>
        </div>
         <div class="mb-3 mt-3">
          <label for="formFile" class="form-label">Картинка категории</label>
          <input class="form-control" ref="file" type="file" id="formFile"  v-on:change="handleFileUpload"/>
        </div>
         <button
           
            type="button"
            class="btn btn-primary mt-3 "
            data-toggle="modal"
            data-target= '#modalShow'
          >
            Сохранить
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
import { onMounted } from "vue";
import { useCookies } from "vue3-cookies";

export default {
  components: {
    LeftMenu,
  },
  props: ["category"],

  setup() {
    const route = useRoute();

    const category_title = route.params.category_title;
    const category_id = route.params.category_id;
    const parent_category_id = route.params.parent_category_id;
    const image = route.params.image;
    const { parentCategories, getParentCategories } = useAdmin();

    onMounted(() => {
      getParentCategories();
    });

    return {
      parentCategories,
      category_title,
      category_id,
      image,
      parent_category_id,
    };
  },

  data() {
    return {
      file: null,
      errors: [],
      images_path: "",
      category_id: 0,
    };
  },
  methods: {
    getImagePath(name) {
      return "https://yemarket.kz/uploads/category/" + name;
    },
    handleFileUpload(event) {
      this.file = event.target.files[0];
    },

    redirectBack() {
      this.$router.back();
    },

    async updatecategory() {
      if (this.category_title) {
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
          formData.append("title", this.category_title);
          formData.append("parent_id", this.parent_category_id);

          let response = await axios.post(
            "/api/v1/admin/categories/" + this.category_id,
            formData,
            config
          );

          this.$router.back();
        } catch (err) {}
      } else {
        this.errors = [];

        if (!this.addBrnadForm.title) {
          this.errors.push("Введите название категории.");
        }
      }
    },
  },
};
</script>

<style >
.page-link {
  color: black;
}
a {
  color: black;
}
</style>