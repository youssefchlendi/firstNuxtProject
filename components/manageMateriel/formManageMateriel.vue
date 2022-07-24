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
                <v-text-field
                  v-model="form.name"
                  prepend-icon="mdi-form-textbox"
                  label="الاسم"
                  required
                  :error-messages="nameError"
                  outlined
                  counter="25"
                  class="mt-3"
                />
              </v-col>
              <v-col cols="12" sm="12" md="12" lg="12" xl="12">
                <v-textarea
                  v-model="form.description"
                  prepend-icon="mdi-card-text-outline"
                  :error-messages="descriptionError"
                  label="الوصف"
                  required
                  outlined
                  counter="255"
                  class="mt-3"
                />
              </v-col>
              <v-col cols="12" sm="12" md="12" lg="12" xl="12">
                <v-text-field
                  v-model="form.quantity"
                  type="number"
                  min="0"
                  prepend-icon="mdi-numeric"
                  :error-messages="quantityError"
                  label="الكمية"
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
                      <span>صنع</span>
                      <v-chip
                        :color="`${colors[nonce - 1]} lighten-3`"
                        label
                        small
                      >
                        {{ search }}
                      </v-chip>
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
                  <template #item="{ index, item }">
                    <v-text-field
                      v-if="editing === item"
                      v-model="editing.text"
                      autofocus
                      flat
                      background-color="transparent"
                      hide-details
                      solo
                      @keyup.enter="edit(index, item)"
                    />
                    <v-chip
                      v-else
                      :color="`${item.color} lighten-3`"
                      dark
                      label
                      small
                    >
                      {{ item.text }}
                    </v-chip>
                    <v-spacer />
                    <v-list-item-action @click.stop>
                      <v-list-item-content>
                        <v-list-item-title>
                          <v-btn icon @click.stop.prevent="edit(index, item)">
                            <v-icon>
                              {{
                                editing !== item ? "mdi-pencil" : "mdi-check"
                              }}
                            </v-icon>
                          </v-btn>
                          <v-btn icon @click.stop.prevent="delet(item)">
                            <v-icon>mdi-delete</v-icon>
                          </v-btn>
                        </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item-action>
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
import {
  required,
  minLength,
  maxLength,
  numeric,
  minValue
} from 'vuelidate/lib/validators'

export default {
  validations: {
    form: {
      name: {
        required,
        minLength: minLength(3),
        maxLength: maxLength(25)
      },
      description: {
        required,
        minLength: minLength(3),
        maxLength: maxLength(255)
      },
      quantity: {
        required,
        numeric,
        min: minValue(0)
      }
    }
  },
  props: {
    dialog: {
      type: Boolean,
      default: false
    },
    materiel: {
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
      name: '',
      description: '',
      quantity: '',
      categories: []
    },
    activator: null,
    attach: null,
    colors: ['green', 'purple', 'indigo', 'cyan', 'teal', 'orange'],
    editing: null,
    editingIndex: -1,
    items: [],
    nonce: 1,
    menu: false,
    model: [],
    x: 0,
    search: null,
    y: 0
  }),
  computed: {
    nameError () {
      const errors = []
      if (!this.$v.form.name.$dirty) { return errors }
      !this.$v.form.name.required && errors.push('الرجاء ادخال اسم الاثاث')
      !this.$v.form.name.minLength &&
        errors.push('الرجاء ادخال اسم الاثاث بحد اقل 3 حروف')
      !this.$v.form.name.maxLength &&
        errors.push('الرجاء ادخال اسم الاثاث بحد اكثر 25 حروف')
      return errors
    },
    descriptionError () {
      const errors = []
      if (!this.$v.form.description.$dirty) { return errors }
      !this.$v.form.description.required &&
        errors.push('الرجاء ادخال وصف الاثاث')
      !this.$v.form.description.minLength &&
        errors.push('الرجاء ادخال وصف الاثاث بحد اقل 3 حروف')
      !this.$v.form.description.maxLength &&
        errors.push('الرجاء ادخال وصف الاثاث بحد اكثر 255 حروف')
      return errors
    },
    quantityError () {
      const errors = []
      if (!this.$v.form.quantity.$dirty) { return errors }
      !this.$v.form.quantity.required &&
        errors.push('الرجاء ادخال كمية الاثاث')
      !this.$v.form.quantity.numeric &&
        errors.push('الرجاء ادخال كمية الاثاث أرقام')
      !this.$v.form.quantity.min &&
        errors.push('الرجاء ادخال كمية الاثاث بحد اقل 0')
      return errors
    }
  },
  watch: {
    dialog () {
      this.form = this.dialog
        ? Object.assign({}, this.materiel)
        : {
            name: '',
            description: '',
            quantity: '',
            categories: []
          }
      this.model = this.materiel
        ? Object.assign([], this.materiel.categories)
        : []
    },
    model (val, prev) {
      if (val.length === prev.length) { return }

      this.model = val.map((v) => {
        if (typeof v === 'string') {
          v = {
            text: v,
            color: this.colors[this.nonce - 1]
          }
          this.$axios
            .post('/categorie-materiel/', { name: v.text })
            .then(() => {
              this.getCategories()
            })

          this.nonce++
        }
        if (this.editing) {
          this.$axios
            .put('/categorie-materiel/' + this.editing.id, { name: v.text })
            .then(() => this.getCategories())
        }
        return v
      })
    }
  },
  created () {
    this.getCategories()
  },
  methods: {
    reset () {
      this.form = {
        name: '',
        description: '',
        quantity: '',
        categories: []
      }
      this.$emit('close')
    },
    add () {
      this.$v.$touch()
      if (this.$v.$invalid) {
        return
      }
      this.form.categories = this.model
      if (this.editm === false) {
        this.$axios
          .post('/materiel/', this.form)
          .then(() => {
            this.$emit('success', {
              show: true,
              type: 'success',
              msg: 'تمت اضافة الاثاث بنجاح'
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
          .put('/materiel/' + this.materiel.id, this.form)
          .then(() => {
            this.$emit('success', {
              show: true,
              type: 'success',
              msg: 'تمت تعديل الاثاث بنجاح'
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
    edit (index, item) {
      if (!this.editing) {
        this.editing = item
        this.editingIndex = index
      } else {
        this.$axios
          .put('/categorie-materiel/' + this.editing.id, {
            name: this.editing.text
          })
          .then(() => this.getCategories())
        this.editing = null
        this.editingIndex = -1
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
    getCategories () {
      this.$axios.get('/categorie-materiel').then((response) => {
        this.items = response.data
      })
    },
    delet (item) {
      if (confirm('هل تريد حذف فئة الاثاث ' + item.text + '؟')) {
        this.axios.delete('/categorie-materiel/' + item.id).then(() => {
          this.getCategories()
        })
      }
    }
  }
}
</script>

<style>
</style>
