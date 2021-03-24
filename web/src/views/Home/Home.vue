<template>
  <div class="main-content home">
    <div class="page-title">
      Sobre
    </div>
    <div class="text-information">
      Aplicação desenvolvida para o gerenciamento de finanças.
    </div>
  </div>
</template>

<script>

export default {
  name: 'Home',

  create() {
    document.title = 'Teste'
  },
}
</script>

<style lang="scss">
  @import "./styles.scss";
</style>