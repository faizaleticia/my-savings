<template>
  <div class="main-content home">
    <div class="m-t-25">
      <div class="items-content" v-if="items">
        <item
          v-for="item in items"
          :key="item.title"
          :title="item.title"
          :description="item.description"
          :route="item.route"
        />
      </div>
    </div>
  </div>
</template>

<script>

import Item from '../../components/Item/Item';
import api from '../../services/api';

export default {
  name: 'Home',

  components: {
    Item,
  },

  data() {
    return {
      items: null,
    }
  },

  created() {
    this.getMenuItems();
  },

  methods: {
    getMenuItems() {
      api.get('/menu-items')
        .then((response) => {
          if (response.data.success) {
            this.items = response.data.menu_items;
          } else {
            console.log(response.data.message);
          }
        })
    }
  }
}
</script>

<style lang="scss">
  @import "./styles.scss";
</style>
