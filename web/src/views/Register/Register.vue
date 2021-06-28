<template>
  <div class="main-content home">
    <alert :show="showAlert" :message="alertMessage" :type="typeAlert" />
    <div class="page-title">
      Registrar
    </div>
    <div class="principal-register">
      <form id="register" @submit="register">
        <div class="register form">
          <div class="input-content">
            <label>Nome:</label>
            <input class="input" type="text" name="name" v-model="name" autofocus />
          </div>
          <div class="input-content">
            <label>Usuário:</label>
            <input class="input" type="text" name="username" v-model="username" />
          </div>
          <div class="input-content">
            <label>E-mail:</label>
            <input class="input" type="mail" name="email" v-model="email" />
          </div>
          <div class="input-content">
            <label>Senha:</label>
            <input class="input" type="password" name="password" v-model="password" />
          </div>
          <div class="submit p-t-15">
            <button class="btn btn-primary" type="submit">Registrar</button>
          </div>
        </div>

        <div class="register">
          <img src="../../assets/images/human_2.png" alt="Logo" />
        </div>
      </form>
    </div>
  </div>
</template>

<script>

import Alert from '../../components/Alert/Alert';
import api from '../../services/api';

export default {
  name: 'Register',

  components: {
    Alert,
  },

  data() {
    return {
      name: '',
      username: '',
      email: '',
      password: '',

      showAlert: false,
      alertMessage: '',
      typeAlert: 'success',
    }
  },

  methods: {
    register(event) {
      event.preventDefault();

      if (this.name !== '' && this.username !== '' && this.email !== '' && this.password !== '') {
        api.post('/auth/register', {
          name: this.name,
          username: this.username,
          email: this.email,
          password: this.password
        })
          .then(() => {
            this.alertMessage = 'Cadastro efetuado com sucesso.';
            this.showAlert = true;

            setTimeout(() => {
              window.location.href = '/';
            }, 500);
          })
          .catch((error) => console.log(error));
      }
      console.log('Register');
    },
  },
}
</script>

<style lang="scss">
  @import "./styles.scss";
</style>
