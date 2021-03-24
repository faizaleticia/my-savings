<template>
  <div class="main-content home">
    <div class="page-title">
      Register
    </div>
    <div>
      <form id="register-form" @submit="register">
        <section>
          <fieldset>
            <div>
              <label>Nome:</label>
              <input type="text" name="name" v-model="name" />
            </div>
            <div>
              <label>Usuário:</label>
              <input type="text" name="username" v-model="username" />
            </div>
            <div>
              <label>E-mail:</label>
              <input type="mail" name="email" v-model="email" />
            </div>
            <div>
              <label>Senha:</label>
              <input type="password" name="password" v-model="password" />
            </div>
            <div>
              <button type="submit">Registrar</button>
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
  name: 'Register',

  data() {
    return {
      name: '',
      username: '',
      email: '',
      password: '',
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
          .then((response) => {
            alert(response.data.message);
            window.location.href = '/';
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
