<template>
  <div class="main-content home">
    <div class="m-t-25">
      <div class="items-content">
        <item v-for="item in items" :key="item.title" :title="item.title" :description="item.description"/>
      </div>
    </div>
  </div>
</template>

<script>
import Item from '../../components/Item/Item';

export default {
  name: 'Home',

  components: {
    Item,
  },

  data() {
    return {
      items: [
        {
          title: 'Contas',
          description: 'Gerencia suas contas financeiras: Ao manter suas contas financeiras no MySavings, é possível obter diversas métricas, tais como: saldo inicial, saldo atual, receitas e despesas por período e comparativos de saídas e entradas.'
        },
      ],
    }
  },
}
</script>

<style lang="scss">
  @import "./styles.scss";
</style>
