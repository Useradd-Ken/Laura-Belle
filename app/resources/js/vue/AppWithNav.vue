<template>
  <div>
    <Nav />
    <RouterView />
  </div>
</template>

<script>
import { RouterView } from 'vue-router';
import Nav from '../components/nav.vue';

export default {
  name: 'AppWithNav',
  components: {
    RouterView,
    Nav
  }
};
</script>
