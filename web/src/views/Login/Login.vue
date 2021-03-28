<template>
  <div class="main-content home">
    <div class="page-title">
      Login
    </div>
    <div>
      <form id="login" @submit="login">
        <section>
          <fieldset>
            <div>
              <label>Usuário ou E-mail:</label>
              <input type="text" name="username" v-model="username" />
            </div>
            <div>
              <label>Senha:</label>
              <input type="password" name="passowrd" v-model="password" />
            </div>
            <div>
              <button type="submit">Entrar</button>
            </div>
          </fieldset>
        </section>
      </form>
    </div>
  </div>
</template>

<script>

import api from '../../services/api';

export default {
  name: 'Login',

  data() {
    return {
      username: '',
      password: '',
    }
  },

  methods: {
    login(event) {
      event.preventDefault();

      if (this.username !== '' && this.password !== '') {
        api.post('/auth/login', {
          email: this.username,
          password: this.password,
        }).then((response) => {
          if (response.data.access_token) {
            localStorage.setItem('user-token', response.data.access_token);
            alert('Autenticação realizada.');
            window.location.href = '/';
          }
        })
      }
    },
  }
}
</script>

<style lang="scss">
  @import "./styles.scss";
</style>
