<template>
  <div class="main-content home">
    <alert :show="showAlert" :message="alertMessage" :type="typeAlert" />
    <div class="principal-login">
      <form id="login" @submit="login">
        <div class="login">
          <img src="../../assets/images/human_1.png" alt="Logo" />
        </div>
        <div class="login form">
          <div class="page-title">
            Login
          </div>
          <div class="input-content">
            <label>E-mail:</label>
            <input
              :class="`${usernameError ? 'input-error' : ''} input`"
              type="text"
              name="username"
              v-model="username"
              autofocus
              @input="usernameError = false"
            />
            <div v-show="usernameError" class="message-error">{{usernameMessageError}}</div>
          </div>
          <div class="input-content">
            <label>Senha:</label>
            <input class="input" type="password" name="passowrd" v-model="password" />
          </div>
          <div class="submit p-t-15">
            <button class="btn btn-primary" type="submit">Entrar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>

import Alert from '../../components/Alert/Alert';
import api from '../../services/api';

export default {
  name: 'Login',

  components: {
    Alert,
  },

  data() {
    return {
      username: '',
      password: '',

      usernameError: false,
      usernameMessageError: '',

      showAlert: false,
      alertMessage: '',
      typeAlert: 'success',
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
            this.alertMessage = 'Autenticação realizada.';
            this.typeAlert = 'success';
            this.showAlert = true;

            setTimeout(() => {
              window.location.href = '/';
            }, 500);
          }
        }).catch((error) => {
          const keys = Object.keys(error.response.data);
          this.usernameError = keys.includes('email');
          if (this.usernameError) {
            this.usernameMessageError = error.response.data['email'];
          } else if (error.response.data.error == 'Unauthorized') {
            this.alertMessage = 'Usuário e senha inválidos.';
            this.typeAlert = 'danger';
            this.showAlert = true;
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
