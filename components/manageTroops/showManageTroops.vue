<template>
  <v-data-table
    :headers="headers"
    :items="troops"
    item-key="id"
    class="elevation-1"
  >
    <template #[`item.actions`]="{ item }">
      <div class="align-center">
        <deleteDialog :id="item.id" @ok="$emit('delete',item.id)" />
        <v-btn
          class="mx-1"
          :disabled="item.status == 1"
          x-small
          :fab="$vuetify.breakpoint.name != 'sm'"
          color="warning"
          @click="$emit('update',item)"
        >
          <v-icon>mdi-pen</v-icon>
        </v-btn>
      </div>
    </template>
  </v-data-table>
</template>

<script>
import deleteDialog from './deleteDialog.vue'
export default {
  components: {
    deleteDialog
  },
  props: ['troops', 'headers']
}
</script>

<style>

</style>
