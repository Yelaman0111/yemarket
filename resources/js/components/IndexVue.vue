
<template>
  <AppHeader />

  <h1>Hello Vue!</h1>
  <AppFooter />
</template>

<script>
import AppHeader from "../components/AppHeader.vue";
import AppFooter from "../components/AppFooter.vue";

export default {
  components: {
    AppHeader,
    AppFooter,
  },
  name: "IndexVue",
};
</script>