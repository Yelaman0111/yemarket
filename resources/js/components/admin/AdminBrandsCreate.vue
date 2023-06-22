<template>
  <div>
    <LeftMenu />
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
            <b>Ошибка добавления Brnad:</b>
            <ul>
              <li v-for="error in errors" :key="error.id">{{ error }}</li>
            </ul>
          </p>
        <div class="form-group">
          <label for="name">Название Brnad</label>
          <input
            v-model="addBrnadForm.name"
            type="name"
            class="form-control"
            id="name"
            placeholder="Название Brnad"
            required
          />
        </div>

        <div class="mb-3 mt-3">
          <label for="formFile" class="form-label">Картинка Brnad</label>
          <input class="form-control" ref="file" type="file" id="formFile"  v-on:change="handleFileUpload"/>
        </div>

          <button
            type="submit"
            class="btn btn-primary mt-3"
            @click.prevent="addBrnad()"
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
import { useCookies } from "vue3-cookies";

export default {
  components: {
    LeftMenu,
  },
  data() {
    return {
      addBrnadForm: {
        name: "",
      },
      file: null,
      errors: [],
    };
  },
  methods: {
    redirectBack() {
      this.$router.back();
    },

    handleFileUpload(event) {
      this.file = event.target.files[0];
    },
    async addBrnad() {
      if (this.addBrnadForm.name) {
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
          formData.append("name", this.addBrnadForm.name);

          const response = await axios.post(
            "/api/v1/admin/brands/create",
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

<style scoped>
.page-link {
  color: black;
}
</style>