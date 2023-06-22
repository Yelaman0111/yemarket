<template>
  <!--Main Navigation-->
  <header>
    <!-- Sidebar -->
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
      <div class="position-sticky">
        <div class="list-group list-group-flush mx-3">
          <router-link
            :to="{ name: 'main.index' }"
            class="dropdown-item fw-bold mb-3"
          >
            Назад на сайт
          </router-link>
          <router-link
            :to="{ name: 'company.index' }"
            class="dropdown-item fw-bold"
          >
            Профиль
          </router-link>
          <hr />
          <router-link
            :to="{ name: 'company.products' }"
            class="dropdown-item fw-bold"
          >
            Продукты
          </router-link>
          <router-link
            :to="{ name: 'company.orders' }"
            class="dropdown-item fw-bold"
          >
            Заказы
          </router-link>
          <button @click="logoutCompany" class="mt-5">Выход</button>
        </div>
      </div>
    </nav>
    <!-- Sidebar -->
  </header>
  <!--Main Navigation-->
</template>


<script>
import { useCookies } from "vue3-cookies";
export default {
  created() {},
  layout: "companyAdmin",
  methods: {
    logoutCompany() {
      const { cookies } = useCookies();
      cookies.remove("Bearer");
      cookies.remove("Role");
      this.$router.push("/");
    },
  },
};
</script>

<style>
.cursor-pointer {
  cursor: pointer;
}

body {
  background-color: #fbfbfb;
}
@media (min-width: 991.98px) {
  main {
    padding-left: 240px;
  }
}

/* Sidebar */
.sidebar {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  padding: 58px 0 0; /* Height of navbar */
  box-shadow: 0 2px 5px 0 rgb(0 0 0 / 5%), 0 2px 10px 0 rgb(0 0 0 / 5%);
  width: 240px;
  z-index: 600;
}

@media (max-width: 991.98px) {
  .sidebar {
    width: 100%;
  }
}
.sidebar .active {
  border-radius: 5px;
  box-shadow: 0 2px 5px 0 rgb(0 0 0 / 16%), 0 2px 10px 0 rgb(0 0 0 / 12%);
}

.sidebar-sticky {
  position: relative;
  top: 0;
  height: calc(100vh - 48px);
  padding-top: 0.5rem;
  overflow-x: hidden;
  overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
}
</style>