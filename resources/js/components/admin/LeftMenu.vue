<template>
  <!--Main Navigation-->
  <header>
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
      <div class="position-sticky">
        <div class="list-group list-group-flush mx-3">
          <router-link :to="{ name: 'main.index' }">
            Назад на сайт
          </router-link>
          <router-link
            :to="{ name: 'admin.index' }"
            class="dropdown-item fw-bold"
          >
            Все компании
          </router-link>
          <router-link
            :to="{ name: 'admin.shops' }"
            class="dropdown-item fw-bold"
          >
            Все магазины
          </router-link>
          <router-link
            :to="{ name: 'admin.products' }"
            class="dropdown-item fw-bold"
          >
            Все продукты
          </router-link>

          <router-link
            :to="{ name: 'admin.brands' }"
            class="dropdown-item fw-bold"
          >
            Все брэнды
          </router-link>
          <router-link
            :to="{ name: 'admin.categories' }"
            class="dropdown-item fw-bold"
          >
            Все категории
          </router-link>
          <button @click="logoutCompany" class="mt-5">Выход</button>
        </div>
      </div>
    </nav>
  </header>
  <!--Main Navigation-->
</template>


<script>
import { useCookies } from "vue3-cookies";

export default {
  created() {},
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