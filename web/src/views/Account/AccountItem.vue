<template>
  <tr>
    <td>
      {{ account.letter }}
    </td>
    <td class="text-left">
      {{ account.name }}
    </td>
    <td class="text-left">
      {{ account.description }}
    </td>
    <td>
      <button type="button" class="btn btn-ternary" @click="showManageAcccount">
        <i class="icon far fa-edit" />
        Editar
      </button>
      <button type="button" class="btn btn-ternary">
        <i class="icon far fa-trash-alt" />
        Excluir
      </button>
    </td>
  </tr>
</template>

<script>
export default {
  name: 'AccountItem',

  props: ['account'],

  methods: {
    showManageAcccount() {
      const modal = document.getElementById(`modal_${this.account.id}`);
      modal.classList.remove('hidden');
      modal.classList.add('show');
      const body = document.body;
      body.classList.add('show-modal');

      this.$emit('increment-btn', 1);
    },
  }
}
</script>
