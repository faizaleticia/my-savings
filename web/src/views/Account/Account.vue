<template>
  <div class="main-content contact">
    <div class="page-title d-flex jc-space-between">
      <div>Contas</div>
      <div>
        <button type="button" class="btn btn-primary">
          <i class="icon fas fa-plus" />
          Adicionar conta
        </button>
      </div>
    </div>
    <div>
      <account-list />
    </div>
  </div>
</template>

<script>

import AccountList from './AccountList';

export default {
  name: 'Account',

  components: {
    AccountList,
  },
}
</script>

<style lang="scss">
  @import "./styles.scss";
</style>
