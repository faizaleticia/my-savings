<template>
  <div>
    <div class="text-information" v-if="loading">
      Carregando...
    </div>
    <div class="text-information" v-else-if="noInformation">
      Nenhuma conta cadastrada.
    </div>
    <div class="account-content" v-else>
      <account-item
        v-for="account in accounts"
        v-bind:key="account.id"
        :account="account" />

      <modal-manage-account
        v-for="account in accounts"
        :key="account.id"
        :account="account"
      />
    </div>
  </div>
</template>

<script>

import ModalManageAccount from './ModalManageAccount';
import AccountItem from './AccountItem';
import api from '../../services/api';

export default {
  name: 'AccountList',

  components: {
    ModalManageAccount,
    AccountItem,
  },

  data() {
    return {
      accounts: null,
      loading: false,
    }
  },

  created() {
    this.getAccounts();
  },

  computed: {
    noInformation() {
      return !this.loading && this.accounts === null || this.accounts.length === 0;
    },
  },

  methods: {
    getAccounts() {
      this.loading = true;
      api.get('/accounts', {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('user-token')}`
        }
      })
        .then((response) => {
          if (response.data.success) {
            this.accounts = response.data.accounts;
          } else {
            console.log(response.data.message);
          }

          this.loading = false;
        })
    },
  }
}
</script>
