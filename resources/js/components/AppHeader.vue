<template>
  <div>
    <div class="container-fluid bg-light pb-3"></div>
    <nav class="navbar navbar-light border-bottom">
      <div class="d-flex justify-content-between container">
        <div class="ms-5">
          <div class="container-fluid d-flex justify-content-center container">
            <div class="container">
              <router-link
                :to="{ name: 'main.index' }"
                class="navbar-brand fs-2 pb-1 fw-bolder"
              >
                YEMARKET
              </router-link>
            </div>
          </div>
        </div>
        <div>
          <div class="container">
            <div class="row">
              <div class="col mt-2">
                <router-link
                  :to="{ name: 'company.login' }"
                  class="fw-light text-secondary rounded p-2 pe-3 ps-3 btn-gray"
                >
                  <span class="black">Войти</span>
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </div>
</template>

<script>
import { useCookies } from "vue3-cookies";

export default {
  name: "AppHeader",
  data() {
    return {
      categoryInFocus: {},
      isCategoriesInFocus: false,
    };
  },
  setup() {
    const { cookies } = useCookies();
    return {};
  },

  methods: {},
};
</script>


<style>
* {
  padding: 0;
  margin: 0;
}

.row-cart {
  display: flex;
}

.col-cart {
  flex: 50%;
}

.black {
  color: black;
}

.dropdown:hover .dropdown-menu {
  display: block;
  margin-top: 0;
}

.main--content {
  position: relative;
}

.darkenBg {
  position: absolute;
  display: block;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
}

.darkenBg-toggle {
  background: rgba(27, 27, 27, 0.55);
  mix-blend-mode: multiply;
  z-index: 999;
}

.catalog__wrap {
  width: 830px;
  height: 490px;
  padding: 14px 25px 16px 22px;
  border: 0;
  display: flex;
}
</style>
