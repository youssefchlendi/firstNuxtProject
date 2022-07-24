<template>
  <v-dialog v-model="dialog" persistent max-width="290">
    <template #activator="{ on, attrs }">
      <v-btn color="red" text v-bind="attrs" v-on="on">
        حذف
        <v-icon>delete</v-icon>
      </v-btn>
    </template>
    <v-card>
      <v-card-title class="text-h5 text-right">
        حذف الطلب
      </v-card-title>
      <v-card-text class="text-right">
        <p>هل تريد حذف الطلب ؟{{ id }}</p>
        باختيار "نعم" سيتم حذف الطلب
      </v-card-text>
      <v-card-actions>
        <v-spacer />
        <v-btn color="red darken-1" text @click="dialog = false">
          لا
        </v-btn>
        <v-btn color="green" class="text-white" @click="deleteItem(id)">
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
  },
  methods: {
    deleteItem (id) {
      this.dialog = false
      this.$emit('ok', id)
    }
  }
}
</script>
