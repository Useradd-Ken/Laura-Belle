<template>
  <div>
    <Nav />
    <RouterView />
  </div>
</template>

<script>
import { RouterView } from 'vue-router';
import Nav from './components/nav.vue';

export default {
  name: 'App',
  components: {
    RouterView,
    Nav
  }
};
</script>

<style scoped>
</style>
