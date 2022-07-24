<template>
  <div>
    <Form
      :dialog="dialog"
      :troupe="troupe"
      :edit="edit"
      @close="reset"
      @add="add"
    />
    <v-btn color="success" class="m-2 mr-0" large @click="dialog = true">
      <v-icon>mdi-plus</v-icon>
      اضافة
    </v-btn>
    <show
      :headers="headers"
      :troops="troops"
      @delete="delet"
      @update="update"
    />
    <v-snackbar v-model="snack" :timeout="10000" :color="snackColor">
      {{ snackText }}
      <template #action="{ attrs }">
        <v-btn v-bind="attrs" text @click="snack = false">
          اغلاق
        </v-btn>
      </template>
    </v-snackbar>
  </div>
</template>

<script>
import show from '~/components/manageTroops/showManageTroops.vue'
import Form from '~/components/manageTroops/formManageTroops.vue'

export default {
  components: {
    show,
    Form
  },
  middleware: 'superAdmin',
  data () {
    return {
      troops: [],
      troupe: {},
      snack: false,
      snackColor: '',
      dialog: false,
      snackText: '',
      edit: false
    }
  },
  computed: {
    headers () {
      return [
        {
          text: 'الاسم',
          value: 'name'
        },
        {
          text: 'الوصف',
          value: 'description'
        },
        {
          text: 'الجنس',
          value: 'gender'
        },
        {
          text: 'اقل عمر',
          value: 'min_age'
        },
        {
          text: 'اكبر عمر',
          value: 'max_age'
        },
        {
          text: 'اجرائات',
          value: 'actions',
          sortable: false
        }
      ]
    }
  },
  created () {
    this.getTroops()
  },
  methods: {
    getTroops () {
      this.$axios
        .get('/troupes')
        .then((response) => {
          this.troops = response.data
        })
        .catch((error) => {
          console.log(error)
          this.snack = true
          this.snackColor = 'red'
          this.snackText = error.response.data.error
            ? error.response.data.error
            : 'لقد حصل عطب في الخادم, الرجاء المحاولة لاحقا'
        })
    },
    delet (id) {
      this.$axios
        .delete('/troupes/' + id)
        .then(() => {
          this.getTroops()
          this.snack = true
          this.snackColor = 'green'
          this.snackText = 'تم حذف الطرق المرضية بنجاح'
        })
        .catch((error) => {
          console.log(error)
          this.snack = true
          this.snackColor = 'red'
          this.snackText = error.response.data.error
            ? error.response.data.error
            : 'لقد حصل عطب في الخادم, الرجاء المحاولة لاحقا'
        })
    },
    update (troupe) {
      this.edit = true
      this.troupe = troupe
      this.dialog = true
    },
    add (form) {
      if (!this.edit) {
        this.$axios
          .post('/troupes', form)
          .then(() => {
            this.getTroops()
            this.snack = true
            this.snackColor = 'success'
            this.snackText = 'تمت الاضافة بنجاح'
          })
          .catch((error) => {
            console.log(error)
            this.snack = true
            this.snackColor = 'red'
            this.snackText = error.response.data.error
              ? error.response.data.error
              : 'لقد حصل عطب في الخادم, الرجاء المحاولة لاحقا'
          })
      } else {
        this.$axios
          .put('/troupes/' + this.troupe.id, form)
          .then(() => {
            this.getTroops()
            this.snack = true
            this.snackColor = 'success'
            this.snackText = 'تم التعديل بنجاح'
          })
          .catch((error) => {
            console.log(error)
            this.snack = true
            this.snackColor = 'red'
            this.snackText = error.response.data.error
              ? error.response.data.error
              : 'لقد حصل عطب في الخادم, الرجاء المحاولة لاحقا'
          })
      }
    },
    reset () {
      this.edit = false
      this.troupe = {}
      this.dialog = false
    }
  }
}
</script>

<style>
</style>
