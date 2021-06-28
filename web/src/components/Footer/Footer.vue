<template>
  <footer>
    <div class="container">
      <div class="content">
        <div class="logo">
          <img src="../../assets/images/reduced-logo.png" alt="Logo" />
        </div>
        <div class="text">
          <p><span>O MySavings é uma platafoma de gerenciamento de finanças
            online, que permite aos seus usuários possuir acesso a todas as
            suas contas ativas, sejam bancárias ou não, de qualquer lugar
            do Brasil e do mundo, de forma gratuita.
          </span></p>
          <nav class="menu">
            <ul v-if="!isAuthenticated">
              <li><a href="/register">REGISTRAR</a></li>
              <li><a href="/login">ENTRAR</a></li>
            </ul>
            <ul v-else>
              <li><a @click="logout">SAIR</a></li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </footer>
</template>

<script>

import api from '../../services/api';

export default {
  computed: {
    isAuthenticated () {
      const token = localStorage.getItem('user-token');
      return token && token != '';
    },
  },

  methods: {
    logout () {
     api.post('/auth/logout', {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('user-token')}`
        }
      }).then((response) => {
        if (response.data.message == 'Successfully logged out') {
          localStorage.removeItem('user-token');
          window.location.href = '/';
        }
      }).catch((error) => {
        if (error.response.data.message == 'Unauthenticated.') {
          localStorage.removeItem('user-token');
          window.location.href = '/';
        }
      });
    },
  },
}
</script>

<style lang="scss">
  @import "./styles.scss";
</style>
