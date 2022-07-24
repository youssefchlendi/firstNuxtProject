<template>
  <v-dialog
    v-model="dialog"
    persistent
    max-width="290"
  >
    <template #activator="{ on, attrs }">
      <v-btn
        color="red"
        icon
        v-bind="attrs"
        v-on="on"
      >
        <v-icon>delete</v-icon>
      </v-btn>
    </template>
    <v-card>
      <v-card-title class="text-h5 text-right">
        حذف الاثاث
      </v-card-title>
      <v-card-text class="text-right">
        <p>
          هل تريد حذف الاثاث ؟{{ id }}
        </p>
        باختيار "نعم" سيتم حذف الاثاث
      </v-card-text>
      <v-card-actions>
        <v-spacer />
        <v-btn
          color="red darken-1"
          text
          @click="dialog = false"
        >
          لا
        </v-btn>
        <v-btn
          color="green"
          class="text-white"
          @click="$emit('ok',id)"
        >
          نعم
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script>
export default {
  props: {
    id: {
      type: Number,
      default: 0
    }
  },
  data () {
    return {
      dialog: false
    }
  }
}
</script>
