<template>
  <div class="account">
    <div class="color">{{ account.letter.toUpperCase() }}</div>
    <div class="text">
      <div class="name">{{ account.name }}</div>
      <div class="positive">R$ 50,00</div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['account'],
}
</script>
