<template>
  <v-dialog v-model="dialog" persistent max-width="290">
    <template #activator="{ on, attrs }">
      <v-btn
        class="mx-1"
        x-small
        :fab="$vuetify.breakpoint.name != 'sm'"
        color="red"
        v-bind="attrs"
        v-on="on"
      >
        <v-icon color="white">
          delete
        </v-icon>
      </v-btn>
    </template>
    <v-card>
      <v-card-title class="text-h5 text-right">
        حذف الفرقة
      </v-card-title>
      <v-card-text class="text-right">
        <p>هل تريد حذف الفرقة ؟{{ id }}</p>
        باختيار "نعم" سيتم حذف الفرقة
      </v-card-text>
      <v-card-actions>
        <v-spacer />
        <v-btn color="red darken-1" text @click="dialog = false">
          لا
        </v-btn>
        <v-btn color="green" class="text-white" @click="ok">
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
    ok () {
      this.dialog = false
      this.$emit('ok', this.id)
    }
  }
}
</script>
