<template>
  <v-dialog v-model="dialog" persistent max-width="290">
    <template #activator="{ on, attrs }">
      <v-btn color="red" text v-bind="attrs" class="m-4 mr-0 ml-1" v-on="on">
        <v-icon>mdi-close</v-icon>
        حذف
      </v-btn>
    </template>
    <v-card>
      <v-card-title class="text-h5 text-right">
        حذف الأثاث من الطلب
      </v-card-title>
      <v-card-text class="text-right">
        <p>هل تريد حذف الأثاث من الطلب {{ id }}؟</p>
        باختيار "نعم" سيتم حذف الأثاث من الطلب
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
      type: String,
      default: ''
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
