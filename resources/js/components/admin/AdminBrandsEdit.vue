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
            <h5 class="modal-title" id="exampleModalLabel">Сохранить?</h5>
            <button
              type="button"
              class="btn-close"
              data-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">Сохранить данные по brand?</div>
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
              @click="updatebrand()"
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
          :src=getImagePath
          height="400"
          alt="Card image cap"
        />
        </div>
        </div>

      <form class="col-md-auto"> 
          <p v-if="errors.length">
            <b>Ошибка изменения brand:</b>
            <ul>
              <li v-for="error in errors" :key="error.id">{{ error }}</li>
            </ul>
          </p>
        <div class="form-group  mt-3">
          <label for="name">Название brand</label>
          <input
            v-model="brand_name"
            type="name"
            class="form-control"
            id="name"
            placeholder="Название brand"
          />
        </div>
         <div class="mb-3 mt-3">
          <label for="formFile" class="form-label">Картинка Brnad</label>
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
import { useCookies } from "vue3-cookies";

export default {
  components: {
    LeftMenu,
  },

  setup() {
    const route = useRoute();

    const brand_name = route.params.brand_name;
    const brand_id = route.params.brand_id;
    const brand_image = route.params.brand_image;
    return {
      brand_name,
      brand_id,
      brand_image,
    };
  },

  data() {
    return {
      file: null,
      errors: [],
      images_path: "",
    };
  },
  computed: {
    getImagePath() {
      return "https://yemarket.kz/uploads/brands/" + this.brnad_image;
    },
  },
  methods: {
    handleFileUpload(event) {
      this.file = event.target.files[0];
    },

    redirectBack() {
      this.$router.back();
    },

    async updatebrand() {
      if (this.brand_name) {
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
          formData.append("name", this.brand_name);

          let response = await axios.post(
            "/api/v1/admin/brands/" + this.brand_id,
            formData,
            config
          );
          this.$router.back();
        } catch (err) {}
      } else {
        this.errors = [];

        if (!this.addBrnadForm.name) {
          this.errors.push("Введите название Brnad.");
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