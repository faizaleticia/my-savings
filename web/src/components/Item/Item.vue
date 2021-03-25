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
        <a href="/" alt="Gerencie aqui">
          Gerencie aqui
        </a>
      </div>
    </div>
  </transition>
</template>

<script>

export default {
  props: ['title', 'description'],

  name: 'Item',
}
</script>

<style lang="scss">
  @import "./styles.scss";
</style>
