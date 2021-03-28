<template>
  <table class="table">
    <thead>
      <tr>
        <th>
          #
        </th>
        <th class="text-left">
          Nome
        </th>
        <th class="text-left">
          Descrição
        </th>
        <th style="width: 210px">
          Ações
        </th>
      </tr>
    </thead>
    <tbody>
      <account-item
        v-for="account in accounts"
        :key="account.id"
        :account="account"
      />
    </tbody>
  </table>
</template>

<script>

import AccountItem from './AccountItem';

export default {
  name: 'TableAccount',

  props: ['accounts'],

  components: {
    AccountItem,
  },
}
</script>
