<template>
  <transition name="fade">
    <div class="item-content">
      <div class="logo">
        <img src="../../assets/images/account.png" alt="Logo" />
      </div>
      <div class="m-t-25 title">{{title}}</div>
      <div class="m-t-25 description">
        {{description}}
      </div>
      <div class="m-t-25 more-information">
        <a :href="route" alt="Gerencie aqui" v-if="isAuthenticated">
          Gerencie aqui
        </a>
        <span v-else>
          Autentique-se ou cadastre-se para gerenciar
        </span>
      </div>
    </div>
  </transition>
</template>

<script>

export default {
  props: ['title', 'description', 'route'],

  name: 'Item',

  computed: {
    isAuthenticated () {
      const token = localStorage.getItem('user-token');
      return token && token != '';
    },
  },
}
</script>

<style lang="scss">
  @import "./styles.scss";
</style>
