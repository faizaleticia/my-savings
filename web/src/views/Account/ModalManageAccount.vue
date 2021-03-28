<template>
  <transition name="fade">
    <div :id="`modal_${account ? account.id : ''}`" class="modal hidden">
      <div class="content">
        <div class="header">
          <div class="title"><span>Adicionar conta</span></div>
          <div title="Fechar" @click="close"><fa icon="times" class="close-icon"></fa></div>
        </div>
        <div class="body">
          <form>
            <fieldset>
              <div>
                <label>Letra:</label>
                <input type="text" name="letter" v-model="letter" />
              </div>
              <div>
                <label>Nome: </label>
                <input type="text" name="name" v-model="name" />
              </div>
              <div>
                <label>Descrição:</label>
                <textarea name="description" v-model="description" />
              </div>
              <div>
                <label>Cor:</label>
                <textarea name="color" v-model="color" />
              </div>
            </fieldset>
          </form>
        </div>
        <div class="footer">
          <button type="button" class="btn btn-ternary" @click="close">Cancelar</button>
          <button type="button" class="btn btn-primary" @click="save">Salvar</button>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
import api from '../../services/api';
export default {
  name: 'ModalManageAccount',

  props: ['account'],

  data() {
    return {
      id: null,
      name: null,
      description: null,
      letter: null,
      color: null,
    }
  },

  mounted() {
    if (this.account) {
      this.id = this.account.id;
      this.letter = this.account.letter;
      this.name = this.account.name;
      this.description = this.account.description;
      this.color = this.account.color;
    }
  },

  methods: {
    close() {
      const modal = document.getElementById(`modal_${this.account ? this.account.id : ''}`);
      modal.classList.remove('show');
      modal.classList.add('hidden');
      const body = document.body;
      body.classList.remove('show-modal');
    },

    save() {
      if (this.letter !== null && this.letter !== ''
        && this.name !== null && this.name !== ''
        && this.description !== null && this.description !== ''
        && this.color !== null && this.color !== '') {
          if (this.account) {
            this.edit();
          } else {
            this.add();
          }
      }
    },

    add() {
      api.post('/accounts', {
        letter: this.letter,
        name: this.name,
        description: this.description,
        color: this.color,
      }, {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('user-token')}`
        }
      })
        .then((response) => {
          if (response.data.success) {
            this.letter = null;
            this.name = null;
            this.description = null;
            this.color = null;
            this.close();
          }

          alert(response.data.message);

          this.$router.go();
        });
    },

    edit() {
      api.put(`/accounts/${this.account.id}`, {
        letter: this.letter,
        name: this.name,
        description: this.description,
        color: this.color,
      }, {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('user-token')}`
        }
      })
        .then((response) => {
          if (response.data.success) {
            this.letter = null;
            this.name = null;
            this.description = null;
            this.color = null;
            this.close();
          }

          alert(response.data.message);

          this.$router.go();
        });
    },
  }
}
</script>
