<template>
  <v-row class="">
    <v-dialog :value="dialog" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="text-h5">اضافة اثاث</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="12" md="12" lg="12" xl="12">
                <v-textarea
                  v-model="form.message"
                  prepend-icon="mdi-card-text-outline"
                  :error-messages="messageError"
                  label="الرسالة"
                  required
                  outlined
                  counter="255"
                  class="mt-3"
                />
              </v-col>
              <v-col cols="12" sm="12" md="12" lg="12" xl="12">
                <v-text-field
                  v-model="form.date_demande"
                  type="date"
                  prepend-icon="mdi-calendar"
                  :error-messages="date_demandeError"
                  label="تاريخ الطلب"
                  required
                  outlined
                  class="mt-3"
                />
              </v-col>
              <v-col cols="12" sm="12" md="12" lg="12" xl="12">
                <v-text-field
                  v-model="form.date_fin_demande"
                  type="date"
                  prepend-icon="mdi-calendar"
                  :error-messages="date_fin_demandeError"
                  label="تاريخ الارجاع"
                  required
                  outlined
                  class="mt-3"
                />
              </v-col>
              <v-col>
                <v-combobox
                  v-model="model"
                  prepend-icon="mdi-tag"
                  :filter="filter"
                  :hide-no-data="!search"
                  :items="items"
                  :search-input.sync="search"
                  hide-selected
                  label="البحث عن فئة"
                  multiple
                  small-chips
                  solo
                >
                  <template #no-data>
                    <v-list-item>
                      <v-icon color="grey">
                        mdi-magnify
                      </v-icon>
                      <span class="subtitle-2 text-right">
                        لا يوجد نتائج للبحث
                      </span>
                    </v-list-item>
                  </template>
                  <template
                    #selection="{ attrs, item, parent, selected }"
                  >
                    <v-chip
                      v-if="item === Object(item)"
                      v-bind="attrs"
                      :color="`${item.color} lighten-3`"
                      :input-value="selected"
                      label
                      small
                    >
                      <span class="pr-2">
                        {{ item.text }}
                      </span>
                      <v-icon small @click="parent.selectItem(item)">
                        $delete
                      </v-icon>
                    </v-chip>
                  </template>
                  <template #item="{ item }">
                    <v-chip
                      :color="`${item.color} lighten-3`"
                      dark
                      label
                      small
                    >
                      {{ item.text }}
                    </v-chip>
                    <span class="caption">
                      {{ `(${item.responsable})` }}
                    </span>
                    <v-spacer />
                  </template>
                </v-combobox>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn color="red darken-1" text @click="reset">
            اغلاق
          </v-btn>
          <v-btn color="success darken-1" @click="add">
            اضافة
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
import { required, minLength, maxLength } from 'vuelidate/lib/validators'
const dateValidator = (date) => {
  return new Date(date).setHours(0, 0, 0, 0) >= new Date().setHours(0, 0, 0, 0)
}
export default {
  validations: {
    form: {
      message: {
        required,
        minLength: minLength(3),
        maxLength: maxLength(255)
      },
      date_demande: {
        required,
        dateValidator
      },
      date_fin_demande: {
        required,
        dateValidator,
        minValue (val, { date_demande }) {
          return new Date(val).setHours(0, 0, 0, 0) >= new Date(date_demande).setHours(0, 0, 0, 0)
        }
      }
    }
  },
  props: {
    dialog: {
      type: Boolean,
      default: false
    },
    demandeMateriel: {
      type: Object,
      default: () => ({})
    },
    editm: {
      type: Boolean,
      default: false
    }
  },
  data: () => ({
    form: {
      message: '',
      date_demande: null
    },
    activator: null,
    attach: null,
    colors: ['green', 'purple', 'indigo', 'cyan', 'teal', 'orange'],
    editing: null,
    editingIndex: -1,
    items: [],
    visible_items: [],
    nonce: 1,
    menu: false,
    model: [],
    x: 0,
    search: null,
    y: 0
  }),
  computed: {
    messageError () {
      const errors = []
      if (!this.$v.form.message.$dirty) { return errors }
      !this.$v.form.message.required && errors.push('الرجاء ادخال الرسالة')
      !this.$v.form.message.minLength &&
        errors.push('الرجاء ادخال الرسالة بحد اقل 3 حروف')
      !this.$v.form.message.maxLength &&
        errors.push('الرجاء ادخال الرسالة بحد اكثر 255 حروف')
      return errors
    },
    date_demandeError () {
      const errors = []
      if (!this.$v.form.date_demande.$dirty) { return errors }
      !this.$v.form.date_demande.required &&
        errors.push('الرجاء ادخال تاريخ الطلب')
      !this.$v.form.date_demande.dateValidator &&
        errors.push('تاريخ الطلب لا يمكن ان يكون في الماضي')
      return errors
    },
    date_fin_demandeError () {
      const errors = []
      if (!this.$v.form.date_fin_demande.$dirty) { return errors }
      !this.$v.form.date_fin_demande.required &&
        errors.push('الرجاء ادخال تاريخ الارجاع')
      !this.$v.form.date_fin_demande.dateValidator &&
        errors.push('تاريخ الارجاع لا يمكن ان يكون في الماضي')
      !this.$v.form.date_fin_demande.minValue &&
        errors.push('تاريخ الارجاع لا يمكن ان يكون قبل تاريخ الطلب')
      return errors
    }

  },
  watch: {
    dialog () {
      this.form = this.dialog
        ? Object.assign({}, this.demandeMateriel)
        : {
            name: '',
            message: '',
            date_demande: ''
          }
      this.model = this.demandeMateriel
        ? Object.assign([], this.demandeMateriel.materielEdit)
        : []
    },
    model (val, prev) {
      if (val.length === prev.length) { return }
      this.visible_items = this.model.length !== 0
        ? this.items.filter((item) => {
          return this.model[0].responsable_id === item.responsable_id
        })
        : this.items
    }
  },
  created () {
    this.getMaterials()
  },
  methods: {
    reset () {
      this.form = {
        message: '',
        date_demande: null,
        date_fin_demande: null
      }

      this.$emit('close')
    },
    add () {
      this.$v.$touch()
      if (this.$v.$invalid) {
        return
      }
      this.form.materielEdit = this.model
      if (this.editm === false) {
        this.$axios
          .post('/demande-materiel/', this.form)
          .then(() => {
            this.$emit('success', {
              show: true,
              type: 'success',
              msg: 'تم اضافة الطلب بنجاح'
            })
            this.reset()
          })
          .catch(() => {
            this.$emit('success', {
              show: true,
              type: 'red',
              msg: 'حدث خطأ ما'
            })
            this.reset()
          })
      } else {
        this.$axios
          .put('/demande-materiel/' + this.demandeMateriel.id, this.form)
          .then(() => {
            this.$emit('success', {
              show: true,
              type: 'success',
              msg: 'تمت تعديل الطلب بنجاح'
            })
            this.reset()
          })
          .catch(() => {
            this.$emit('success', {
              show: true,
              type: 'red',
              msg: 'حدث خطأ ما'
            })
            this.reset()
          })
      }
    },
    filter (item, queryText, itemText) {
      if (item.header) { return false }

      const hasValue = val => (val != null ? val : '')

      const text = hasValue(itemText)
      const query = hasValue(queryText)

      return (
        text.toString().toLowerCase().includes(query.toString().toLowerCase())
      )
    },
    getMaterials () {
      this.$axios.get('/all-materiel').then((response) => {
        this.items = response.data
        this.visible_items = response.data
      })
    }
  }
}
</script>

<style>
</style>
