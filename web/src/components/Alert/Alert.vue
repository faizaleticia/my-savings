<template>
  <transition name="fade">
    <div :class="`${type} alert-message`" v-if="show">
      {{message}}
      <i class="icon fas fa-info-circle" />
    </div>
  </transition>
</template>

<script>
export default {
  name: 'Alert',

  props: ['show', 'message', 'type']
}
</script>

<style lang="scss">
  @import "./styles.scss";
</style>
