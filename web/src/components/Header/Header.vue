<template>
  <header>
      <div class="logo">
        <a href="/">
          <img src="../../assets/images/logo.png" alt="Logo" />
        </a>
      </div>
      <nav class="menu">
				<ul v-if="!isAuthenticated">
					<li><a href="/register">REGISTRAR</a></li>
          <li><a href="/login">ENTRAR</a></li>
				</ul>
        <ul v-else>
          <li><a @click="logout">SAIR</a></li>
        </ul>
			</nav>
    </header>
</template>

<script>

import api from '../../services/api';

export default {
  name: 'Header',

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
