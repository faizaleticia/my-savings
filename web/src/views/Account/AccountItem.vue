<template>
  <div class="account" @mouseover="mouseOver" @mouseleave="mouseLeave">
    <div class="color" :style="`background-color: ${account.color}`">
      {{ account.letter.toUpperCase() }}
    </div>
    <div class="text">
      <div class="name">{{ account.name }}</div>
      <div :class="`${totalClass} positive`" v-show="!loading.total">{{ formattedTotal }}</div>
    </div>
    <div class="button-content">
      <transition name="fade">
        <div v-show="isHover">
          <button
            type="button"
            class="button-account btn btn-ternary"
            title="Editar"
            @click="showManageAcccount">
            <i class="far fa-edit" />
          </button>
          <button
            type="button"
            class="button-account btn btn-ternary"
            title="Excluir"
            @click="deleteAccount" >
            <i class="far fa-trash-alt" />
          </button>
        </div>
      </transition>
    </div>
  </div>
</template>

<script>

import api from '../../services/api';

export default {
  name: 'AccountItem',

  props: ['account'],

  data () {
    return {
      isHover: false,
      total: 0,

      loading: {
        total: true,
      }
    }
  },

  mounted () {
    this.getTotal();
  },

  computed: {
    formattedTotal () {
      return this.total.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
    },

    totalClass () {
      if (this.total > 0) {
        return 'green';
      } else if (this.total < 0) {
        return 'red';
      } else {
        return 'gray';
      }
    },
  },

  methods: {
    mouseOver () {
      this.isHover = true;
    },

    mouseLeave () {
      this.isHover = false;
    },

    showManageAcccount () {
      const modal = document.getElementById(`modal_${this.account.id}`);
      modal.classList.remove('hidden');
      modal.classList.add('show');
      const body = document.body;
      body.classList.add('show-modal');

      this.$emit('increment-btn', 1);
    },

    deleteAccount() {
      api.delete(`/accounts/${this.account.id}`, {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('user-token')}`
        }
      })
        .then((response) => {
          alert(response.data.message);

          if (response.data.success) {
            this.$router.go();
          }
        });
    },

    getTotal () {
      api.get(`/accounts/${this.account.id}/total`, {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('user-token')}`
        }
      }).then((response) => {
        this.total = response.data.total;
        this.loading.total = false;
      });
    }
  },
}
</script>

<style lang="scss">
  @import "./styles.scss";
</style>
