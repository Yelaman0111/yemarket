<template>
  <footer class="footer p-4 mt-auto fixed-bottom">
    <div class="container ps-5">
      <div class="row">
        <div class="col-xl-5">
          <div class="container text-light fw-light">
            <div class="row">
              <div class="col-xl-auto">
                <p><small>Доставка</small></p>
              </div>
              <div class="col-xl-auto">
                <p><small>FAQ</small></p>
              </div>
              <div class="col-xl-auto">
                <p><small>Акции</small></p>
              </div>
              <div class="col-xl-auto">
                <p><small>Вакансии</small></p>
              </div>
              <div class="col-xl-auto">
                <p><small>О нас</small></p>
              </div>
              <div class="col-xl-auto">
                <router-link :to="{ name: 'privacy.index' }">
                  <p><small>Политика конфидециальности</small></p>
                </router-link>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="row mt-2">
              <div class="col-xl-auto">
                <!-- <img
                  src="~/static/images/appstore.svg"
                  alt=""
                  width="150"
                  height="50"
                  class="rounded"
                /> -->
              </div>
              <div class="col-xl-auto">
                <!-- <img
                  src="~/static//images/google-play.png"
                  alt=""
                  width="150"
                  height="50"
                  class="rounded"
                /> -->
              </div>
            </div>
          </div>
          <div class="container text-light fw-light mt-3">
            <p><small>© 2023. Все права защищены.</small></p>
          </div>
        </div>
        <div class="col-xl-3"></div>

        <div class="col-xl-2 text-light fw-light">
          <p><small>Телефон:</small></p>
          <p><small>Email:</small></p>
        </div>
        <div class="col-xl-2 text-light fw-light">
          <p><small>+7 (747) 802 69 28</small></p>
          <p><small>yelaman0111@gmail.com</small></p>
          <div class="container-fluid">
            <div class="row pt-3">
              <div class="col-xl-auto">
                <!-- <img
                  src="~/static/images/whatsapp-white.svg"
                  alt=""
                  width="30"
                  height="30"
                  class="rounded"
                /> -->
              </div>
              <div class="col-xl-auto">
                <!-- <img
                  src="~/static/images/instagram.svg"
                  alt=""
                  width="30"
                  height="30"
                  class="rounded"
                /> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>


<style>
* {
  padding: 0;
  margin: 0;
}
.footer {
  background-color: rgb(0, 0, 0, 0.87);
}
</style>
