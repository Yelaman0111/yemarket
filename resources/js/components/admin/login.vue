<template>
  <AppHeader />

  <div class="container center text-center">
    <form class="mx-1 mx-md-4 mt-4 container">
      <div class="row">
        <div class="col-3"></div>

        <div class="col-3">
          <div class="mb-4">
            <div class="form-outline flex-fill mb-0 text-center">
              <label class="form-label" for="form3Example3c">Email</label>
              <input
                type="email"
                id="form3Example3c"
                class="form-control text-center"
                v-model="form.email"
              />
            </div>
          </div>

          <div class="mb-4">
            <div class="form-outline flex-fill mb-0 text-center">
              <label class="form-label" for="form3Example4c">Пароль</label>
              <input
                type="password"
                id="form3Example4c"
                class="form-control text-center"
                v-model="form.password"
              />
            </div>
          </div>

          <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
            <button type="button" @click="submit()" class="btn btn-gray btn-lg">
              Войти
            </button>
          </div>
        </div>
      </div>

      <div class="col-3"></div>
    </form>
  </div>
  <AppFooter />
</template>

<script>
import AppHeader from "../AppHeader.vue";
import AppFooter from "../AppFooter.vue";
import { useCookies } from "vue3-cookies";

export default {
  components: {
    AppHeader,
    AppFooter,
  },
  head() {
    return {
      title: "Yemarket",
    };
  },
  methods: {
    async submit() {
      try {
        const { cookies } = useCookies();

        const credentials = {
          email: this.form.email,
          password: this.form.password,
        };
        let response = await axios
          .post("/api/v1/admin/login", credentials)
          .then((response) => {
            console.log(response.data);
            cookies.set("Bearer", response.data);
            cookies.set("Role", "Admin");
            this.$router.push("/admin");
          });
      } catch (e) {}
    },
  },
  created() {},
  data() {
    return {
      form: {
        email: "",
        password: "",
      },
    };
  },
};
</script>
