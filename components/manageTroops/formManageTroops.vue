<!-- eslint-disable vue/no-mutating-props -->
<template>
  <v-row class="">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="text-h5">اضافة فرقة</span>
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
                <v-select
                  v-model="form.gender"
                  prepend-icon="mdi-sexe"
                  :error-messages="genderError"
                  label="الجنس"
                  required
                  outlined
                  :items="[
                    { text: 'ذكر', value: 'H' },
                    { text: 'أنثى', value: 'F' },
                  ]"
                  class="mt-3"
                />
              </v-col>
              <v-col cols="12" sm="12" md="12" lg="12" xl="12">
                <v-text-field
                  v-model="form.min_age"
                  type="number"
                  min="0"
                  prepend-icon="mdi-numeric"
                  :error-messages="min_ageError"
                  label="اصغر عمر"
                  required
                  outlined
                  class="mt-3"
                />
              </v-col>
              <v-col cols="12" sm="12" md="12" lg="12" xl="12">
                <v-text-field
                  v-model="form.max_age"
                  type="number"
                  min="0"
                  prepend-icon="mdi-numeric"
                  :error-messages="max_ageError"
                  label="اكبر عمر"
                  required
                  outlined
                  class="mt-3"
                />
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
            {{ edit?"تحديث":"اضافة" }}
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
  props: {
    dialog: {
      type: Boolean,
      default: false
    },
    troupe: {
      type: Object,
      default: () => ({})
    },
    edit: {
      type: Boolean,
      default: false
    }
  },
  data: () => ({
    form: {
      name: '',
      description: '',
      min_age: '',
      max_age: ''
    }
  }),
  computed: {
    nameError () {
      const errors = []
      if (!this.$v.form.name.$dirty) { return errors }
      !this.$v.form.name.required && errors.push('الرجاء ادخال اسم فرقة')
      !this.$v.form.name.minLength &&
        errors.push('الرجاء ادخال اسم فرقة بحد اقل 3 حروف')
      !this.$v.form.name.maxLength &&
        errors.push('الرجاء ادخال اسم فرقة بحد اكثر 25 حروف')
      return errors
    },
    descriptionError () {
      const errors = []
      if (!this.$v.form.description.$dirty) { return errors }
      !this.$v.form.description.required &&
        errors.push('الرجاء ادخال وصف فرقة')
      !this.$v.form.description.minLength &&
        errors.push('الرجاء ادخال وصف فرقة بحد اقل 3 حروف')
      !this.$v.form.description.maxLength &&
        errors.push('الرجاء ادخال وصف فرقة بحد اكثر 255 حروف')
      return errors
    },
    genderError () {
      const errors = []
      if (!this.$v.form.gender.$dirty) { return errors }
      !this.$v.form.gender.required && errors.push('الرجاء اختيار الجنس')
      return errors
    },
    min_ageError () {
      const errors = []
      if (!this.$v.form.min_age.$dirty) { return errors }
      !this.$v.form.min_age.required &&
        errors.push('الرجاء ادخال اصغر عمر فرقة')
      !this.$v.form.min_age.numeric &&
        errors.push('الرجاء ادخال اصغر عمر فرقة أرقام')
      !this.$v.form.min_age.min &&
        errors.push('الرجاء ادخال اصغر عمر فرقة بحد اقل 0')
      return errors
    },
    max_ageError () {
      const errors = []
      if (!this.$v.form.max_age.$dirty) { return errors }
      !this.$v.form.max_age.required &&
        errors.push('الرجاء ادخال اكبر عمر فرقة')
      !this.$v.form.max_age.numeric &&
        errors.push('الرجاء ادخال اكبر عمر فرقة أرقام')
      !this.$v.form.max_age.mini &&
        errors.push('الرجاء ادخال اكبر عمر فرقة اكبر من اصغر عمر')
      return errors
    }
  },
  watch: {
    dialog () {
      this.form = this.dialog
        ? Object.assign({}, this.troupe)
        : {
            name: '',
            description: '',
            min_age: '',
            max_age: ''
          }
    }
  },
  created () {},
  validations () {
    return {
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
        gender: {
          required
        },
        min_age: {
          required,
          numeric,
          min: minValue(0)
        },
        max_age: {
          required,
          numeric,
          mini: minValue(this.form.min_age)
        }
      }
    }
  },
  methods: {
    reset () {
      this.form = {
        name: '',
        description: '',
        gender: 'H',
        min_age: '',
        max_age: ''
      }
      this.$emit('close')
    },
    add () {
      this.$v.$touch()
      if (!this.$v.$invalid) {
        this.$emit('add', this.form)
        this.reset()
      }
    }
  }
}
</script>

<style>
</style>
