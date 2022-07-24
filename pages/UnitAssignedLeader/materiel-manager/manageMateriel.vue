<template>
  <div>
    <Form
      :dialog="dialog"
      :materiel="mat"
      :editm="edit"
      @close="close"
      @success="getMateriel"
    />
    <v-btn color="success" class="m-4 mr-0" large @click="dialog = true">
      <v-icon>mdi-plus</v-icon>
      اضافة
    </v-btn>
    <v-alert :value="alert.show" dismissible :type="alert.type">
      {{
        alert.msg
      }}
    </v-alert>
    <v-card>
      <v-card-title>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="بحث عن طريق الاسم او الوصف"
          single-line
          hide-details
        />
      </v-card-title>
      <v-data-table
        :headers="headers"
        :items="materiel"
        :items-per-page="5"
        :search="search"
        class="elevation-1"
      >
        <template #item.categories="{ item }">
          <v-chip
            v-for="categorie in item.categories"
            :key="categorie.id"
            :color="categorie.color"
          >
            {{ categorie.text }}
          </v-chip>
        </template>

        <template #item.operations="{ item }">
          <v-btn icon color="primary" dark @click="editMateriel(item)">
            <v-icon>edit</v-icon>
          </v-btn>
          <deleteForm :id="item.id" @ok="deleteMateriel" />
        </template>
      </v-data-table>
    </v-card>
  </div>
</template>

<script>
import Form from '~/components/manageMateriel/formManageMateriel.vue'
import deleteForm from '@/components/manageMateriel/deleteDialog.vue'
export default {
  components: {
    Form,
    deleteForm
  },
  middleware: 'materielManager',
  data () {
    return {
      search: '',
      materiel: [],
      headers: [
        {
          text: 'الاسم',
          align: 'start',
          sortable: false,
          value: 'name'
        },
        {
          text: 'الوصف',
          align: 'start',
          sortable: false,
          value: 'description'
        },
        {
          text: 'الكمية',
          align: 'start',
          sortable: false,
          value: 'quantity'
        },
        {
          value: 'categories',
          text: 'الفئة'
        },
        {
          text: 'العمليات',
          sortable: false,
          align: 'center',
          value: 'operations'
        }
      ],
      alert: {
        show: false,
        type: null,
        msg: null
      },
      dialog: false,
      edit: false,
      mat: null
    }
  },
  created () {
    this.getMateriel()
  },
  methods: {
    getMateriel (alert = { show: false, type: null, msg: null }) {
      this.$axios
        .get('/materiel/')
        .then((response) => {
          this.materiel = response.data
        })
        .finally(() => {
          this.alert = alert
          setTimeout(() => {
            this.alert.show = false
          }, 5000)
        })
    },
    close () {
      this.mat = null
      this.edit = false
      this.dialog = false
    },
    deleteMateriel (materiel) {
      this.$axios
        .delete('/materiel/' + materiel)
        .then(() => {
          this.getMateriel({
            show: true,
            type: 'success',
            msg: 'تم حذف الاثاث بنجاح'
          })
        })
        .catch(() => {
          this.getMateriel({
            show: true,
            type: 'error',
            msg: 'حدث خطأ أثناء حذف الاثاث'
          })
        })
    },
    editMateriel (materiel) {
      this.mat = materiel
      this.dialog = true
      this.edit = true
    }
  }
}
</script>

<style>
</style>
