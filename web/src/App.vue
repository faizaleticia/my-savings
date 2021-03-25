<template>
  <div class="main">
    <Header />
    <router-view/>
    <Footer />
  </div>
</template>

<script>

import Header from '@/components/Header/Header';
import Footer from '@/components/Footer/Footer';

export default {
  name: 'App',

  components: {
    Header,
    Footer,
  },
}
</script>

<style lang="scss">
  @import url('https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
  @import "./assets/styles/styles.scss";
  @import './assets/styles/helpers.scss';
</style>
