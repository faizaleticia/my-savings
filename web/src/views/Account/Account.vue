<template>
  <div class="main-content contact">
    <div class="page-title d-flex jc-space-between">
      <div>Contas</div>
      <div>
        <button type="button" class="btn btn-primary" @click="showAddAcccount">
          <i class="icon fas fa-plus" />
          Adicionar conta
        </button>
      </div>
    </div>
    <div>
      <account-list />
    </div>

    <modal-manage-account />
  </div>
</template>

<script>

import AccountList from './AccountList';
import ModalManageAccount from './ModalManageAccount';

export default {
  name: 'Account',

  components: {
    AccountList,
    ModalManageAccount,
  },

  methods: {
    showManageAcccount() {
      const modal = document.getElementById(`modal`);
      modal.classList.remove('hidden');
      modal.classList.add('show');
      const body = document.body;
      body.classList.add('show-modal');
    },
  },
}
</script>

<style lang="scss">
  @import "./styles.scss";
</style>
