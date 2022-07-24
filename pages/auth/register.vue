<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <div>
    <v-alert
      v-if="alert.show"
      class="mt-4"
      dismissible
      :type="alert.variant"
    >
      <p>{{ alert.msg }}</p>
    </v-alert>
    <form-wizard @onComplete="onComplete">
      <tab-content title="معلومات شخصية" :selected="true">
        <div class="form-group">
          <label for="first_name">الأسم</label>
          <input
            id="first_name"
            v-model="formData.first_name"
            type="text"
            name="first_name"
            class="form-control"
            :class="hasError('first_name') ? 'is-invalid' : ''"
            placeholder="ادخل اسمك"
          >
          <div v-if="hasError('first_name')" class="invalid-feedback">
            <div v-if="!$v.formData.first_name.required" class="error">
              الرجاء ادخال اسمك.
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="last_name">اللقب</label>
          <input
            id="last_name"
            v-model="formData.last_name"
            type="text"
            name="last_name"
            class="form-control"
            :class="hasError('last_name') ? 'is-invalid' : ''"
            placeholder="ادخل لقبك"
          >
          <div v-if="hasError('last_name')" class="invalid-feedback">
            <div v-if="!$v.formData.last_name.required" class="error">
              الرجاء ادخال لقبك.
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="birth_date">تاريح الولادة</label>
          <input
            id="birth_date"
            v-model="formData.birth_date"
            type="date"
            class="form-control"
            :class="hasError('birth_date') ? 'is-invalid' : ''"
            placeholder="الرجاء ادخال تاريخ ولادتك"
            @change="formData.troupe = null"
          >
          <div v-if="hasError('birth_date')" class="invalid-feedback">
            <div v-if="!$v.formData.birth_date.required" class="error">
              الرجاء ادخال تاريخ ولادتك.
            </div>
            <div v-if="!$v.formData.birth_date.dateValidator" class="error">
              الرجاء ادخال تاريخ ولادتك بشكل صحيح.
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="sexe">الجنس</label>
          <select
            id="sexe"
            v-model="formData.sexe"
            class="form-control"
            :class="hasError('sexe') ? 'is-invalid' : ''"
            @change="formData.troupe = null"
          >
            <option disabled="disabled" selected="selected">
              اختر جنسك
            </option>

            <option value="F">
              انثى
            </option>
            <option value="H">
              ذكر
            </option>
          </select>
          <div v-if="hasError('sexe')" class="invalid-feedback">
            <div v-if="!$v.formData.sexe.required" class="error">
              الرجاء اختيار جنسك.
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="image">صورة</label>
          <input
            id="image"
            ref="file"
            type="file"
            name="image"
            accept="image/*"
            :class="hasError('image') ? 'is-invalid' : ''"
            class="form-control"
            @change="convert64"
          >
          <div v-if="hasError('image')" class="invalid-feedback">
            <div
              v-if="
                !$v.formData.image.required || !$v.formData.image.isFileImage
              "
              class="error"
            >
              الرجاء ادخال صورة.
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="cin">رقم ب.ت.و</label>
          <input
            id="cin"
            v-model="formData.cin"
            type="number"
            name="cin"
            class="form-control"
            :class="hasError('cin') ? 'is-invalid' : ''"
            placeholder="ادخل رقم ب.ت.و"
          >
          <div v-if="hasError('cin')" class="invalid-feedback">
            <div v-if="!$v.formData.cin.required" class="error">
              الرجاء ادخال رقم ب.ت.و(او رقم ب.ت.و الولي )
            </div>
            <div v-if="!$v.formData.cin.numeric || !$v.formData.cin.between" class="error">
              الرجاء ادخال رقم ب.ت.و بشكل صحيح.
            </div>
            <!-- <div
              class="error"
              v-if="!$v.formData.cin.isUnique"
            >
              Cette cin est deja utilisée.
            </div> -->
          </div>
        </div>
        <span class="caption">
          هل لديك حساب ?
          <router-link color="primary" :to="{ name:'auth-login'}">تسجيل الدخول</router-link>
        </span>
      </tab-content>
      <tab-content title="المعطيات الكشفية">
        <div class="form-group">
          <label for="role">مهمة</label>
          <select id="role" v-model="formData.role" :class="hasError('role') ? 'is-invalid' : ''" class="form-control">
            <option disabled="disabled" selected="selected">
              اختر مهمتك
            </option>
            <option v-for="role in roles" :key="role.id" :value="role.id">
              {{ role.name }}
            </option>
          </select>
          <div v-if="hasError('role')" class="invalid-feedback">
            <div v-if="!$v.formData.role.required" class="error">
              <span>مهمة مطلوبة</span>
            </div>
          </div>
        </div>
        <div
          v-if="
            roles.length != 0 &&
              roles[formData.role ? formData.role - 2 : 0].ename ==
              'Unit Assigned Leader'
          "
          class="form-group"
        >
          <label for="responsability">المسؤولية</label>
          <select
            id="responsability"
            v-model="formData.responsability"
            :class="hasError('responsability') ? 'is-invalid' : ''"
            class="form-control"
          >
            <option disabled="disabled" selected="selected">
              اختر فرقتك
            </option>

            <option v-for="responsability in responsablities" :key="responsability.id" :value="responsability.id">
              {{ responsability.name }}
            </option>
          </select>
          <div v-if="hasError('responsability')" class="invalid-feedback">
            <div v-if="!$v.formData.responsability.required" class="error">
              <span>المسؤولية مطلوبة</span>
            </div>
          </div>
        </div>
        <div
          v-if="
            roles.length != 0 &&
              roles[formData.role ? formData.role - 2 : 0].name !=
              'قيادة الفوج' &&
              roles[formData.role ? formData.role - 2 : 0].name != 'ولي'
          "
          class="form-group"
        >
          <label for="troupe">الفرقة</label>
          <select
            id="troupe"
            v-model="formData.troupe"
            :class="hasError('troupe') ? 'is-invalid' : ''"
            class="form-control"
          >
            <option disabled="disabled" selected="selected">
              اختر فرقتك
            </option>

            <option
              v-for="troupe in troupes"
              v-show="
                (age >= troupe.min_age &&
                  age <= troupe.max_age &&
                  formData.sexe == troupe.gender) ||
                  (roles[formData.role ? formData.role - 2 : 0].name !=
                    'قيادة الفوج' &&
                    roles[formData.role ? formData.role - 2 : 0].name != 'ولي' &&
                    formData.sexe == troupe.gender &&
                    roles[formData.role ? formData.role - 2 : 0].name != 'فرد')
              "
              :key="troupe.id"
              :value="troupe.id"
            >
              {{ troupe.name }}
            </option>
          </select>
          <div v-if="hasError('troupe')" class="invalid-feedback">
            <div v-if="!$v.formData.troupe.required" class="error">
              <span>الفرقة مطلوبة</span>
            </div>
          </div>
        </div>
      </tab-content>
      <tab-content title="الاتصال">
        <div class="form-group">
          <div class="form-group">
            <label for="email">البريد الإلكتروني</label>
            <input
              id="email"
              v-model="formData.email"
              type="email"
              name="email"
              class="form-control"
              :class="hasError('email') ? 'is-invalid' : ''"
              placeholder="ادخل البريد الإلكترونيك"
            >
            <div v-if="hasError('email')" class="invalid-feedback">
              <div v-if="!$v.formData.email.required" class="error">
                الرجاء ادخال البريد الإلكتروني.
              </div>
              <div v-if="!$v.formData.email.email" class="error">
                الرجاء ادخال البريد الإلكتروني بشكل صحيح.
              </div>
              <div v-if="!$v.formData.email.isUnique" class="error">
                البريد الإلكتروني هذا مستخدم من قبل.
              </div>
            </div>
          </div>
          <label for="phone_number">رقم الهاتف</label>
          <input
            id="phone_number"
            v-model="formData.phone_number"
            type="number"
            name="phone_numberf"
            class="form-control"
            :class="hasError('phone_number') ? 'is-invalid' : ''"
            placeholder="ادخل رقم الهاتف"
          >
          <div v-if="hasError('phone_number')" class="invalid-feedback">
            <div v-if="!$v.formData.phone_number.required" class="error">
              الرجاء ادخال رقم الهاتف.
            </div>
            <div
              v-if="
                !$v.formData.phone_number.numeric ||
                  !$v.formData.phone_number.between
              "
              class="error"
            >
              الرجاء ادخال رقم الهاتف بشكل صحيح.
            </div>
          </div>
        </div>
      </tab-content>
      <tab-content title="معرفات">
        <div class="form-group">
          <label for="password">الرمز السري</label>
          <input
            id="password"
            v-model="formData.password"
            type="password"
            :class="hasError('password') ? 'is-invalid' : ''"
            class="form-control"
          >
          <div v-if="hasError('password')" class="invalid-feedback">
            <div v-if="!$v.formData.password.required" class="error">
              الرجاء ادخال رمز السر.
            </div>
            <div
              v-if="
                !$v.formData.password.minLength ||
                  !$v.formData.password.maxLength
              "
              class="error"
            >
              الرمز السري يجب ان يكون بين 8 و 30 حرف.
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="confirm_password">اعادة الرمز السري</label>
          <input
            id="confirm_password"
            v-model="formData.confirm_password"
            :class="hasError('confirm_password') ? 'is-invalid' : ''"
            class="form-control"
            type="password"
          >
          <div v-if="hasError('confirm_password')" class="invalid-feedback">
            <div v-if="!$v.formData.confirm_password.required" class="error">
              الرجاء ادخال رمز السر مرة اخرى.
            </div>
            <div
              v-if="
                !$v.formData.confirm_password.minLength ||
                  !$v.formData.confirm_password.maxLength
              "
              class="error"
            >
              الرمز السري يجب ان يكون بين 8 و 30 حرف.
            </div>
            <div v-if="!$v.formData.confirm_password.confirmed" class="error">
              الرجاء ادخال رمز السر مرة اخرى.
            </div>
          </div>
        </div>
      </tab-content>
    </form-wizard>
    <v-dialog v-model="dialog" hide-overlay persistent width="300">
      <v-card color="primary" dark>
        <v-card-text>
          الرجاء الانتظار
          <v-progress-linear indeterminate color="white" class="mb-0" />
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import { FormWizard, TabContent, ValidationHelper } from 'vue-step-wizard'
import 'vue-step-wizard/dist/vue-step-wizard.css'
import {
  required,
  requiredIf,
  email,
  numeric,
  between,
  minLength,
  maxLength,
  sameAs
} from 'vuelidate/lib/validators'
const dateValidator = (date) => {
  return new Date(date).setHours(0, 0, 0, 0) <= new Date().setHours(0, 0, 0, 0)
}
const isFileImage = (file) => {
  if (file == null) {
    return true
  }
  return file ? file.includes('image') : false
}
export default {
  auth: 'guest',
  name: 'StepFormValidation',
  components: {
    FormWizard,
    TabContent
  },
  mixins: [ValidationHelper],
  data () {
    return {
      dialog: false,
      roles: [],
      troupes: {},
      uniqueCin: false,
      uniqueEmail: false,
      responsablities: [],
      formData: {
        first_name: '',
        last_name: '',
        email: null,
        cin: null,
        password: null,
        confirm_password: null,
        birth_date: null,
        role: null,
        troupe: null,
        sexe: null,
        image: null,
        responsability: null
      },
      validationRules: [
        {
          first_name: { required },
          last_name: { required },
          birth_date: { required, dateValidator },
          sexe: { required },
          cin: {
            required,
            numeric,
            between: between(1000000, 99999999)
          },
          image: { isFileImage }
        },
        {
          role: {
            required
          },
          responsability: {
            required: requiredIf(function () {
              const index =
                this.formData.role !== null ? this.formData.role - 2 : 0
              return this.roles.length !== 0
                ? this.roles[index].ename === 'Unit Assigned Leader'
                : false
            })
          },
          troupe: {
            required: requiredIf(function () {
              const index =
                this.formData.role !== null ? this.formData.role - 2 : 0
              return this.roles.length !== 0
                ? this.roles[index].name !== 'قيادة الفوج' &&
                this.roles[index].name !== 'ولي'
                : false
            })
          }
        },
        {
          phone_number: { required, between: between(10000000, 99999999) },
          email: {
            required,
            email,
            async isUnique (value) {
              const response = await this.$axios(`/unique/${value}`)
              return response.status === 200 || value === ''
            }
          }
        },
        {
          password: {
            required,
            minLength: minLength(8),
            maxLength: maxLength(30)
          },
          confirm_password: {
            required,
            minLength: minLength(8),
            maxLength: maxLength(30),
            confirmed: sameAs('password')
          }
        }
      ],
      alert: {
        show: null,
        variant: null,
        msg: null
      }
    }
  },
  computed: {
    age () {
      const date = new Date(this.formData.birth_date)
      const ageDiff = new Date().getFullYear() - date.getFullYear()
      return ageDiff
    }
  },
  created () {
    this.$axios.get('/roles').then((response) => {
      this.roles = response.data
    })
    this.$axios.get('/troupes').then((response) => {
      this.troupes = response.data
    })
    this.$axios.get('/responsablities').then((response) => {
      this.responsablities = response.data
    })
  },
  methods: {
    Register () {
      this.alert.msg = ''
      this.dialog = true
      this.$axios
        .get('http://localhost:8000/sanctum/csrf-cookie', {
          withCredentials: true
        }).then(() => {
          this.$axios.post('/register', this.formData, {
            headers: {
              'Content-Type': 'application/json'
            },
            withCredentials: true
          })
            .then(() => {
              this.$router.push({ name: 'auth-login' })
            })
            .catch(() => {
              this.alert.show = true
              this.alert.variant = 'error'
              this.alert.msg = 'حدث خطأ اثناء التسجيل'
              setTimeout(() => {
                this.alert.show = false
              }, 5000)
            })
            .finally(() => {
              this.dialog = false
            })
        })
    },
    onComplete () {
      this.Register()
    },
    convert64 (e) {
      const file = e.target.files[0]
      this.srcImage = file
      const reader = new FileReader()
      reader.onloadend = () => {
        this.formData.image = reader.result
      }
      this.image = file
      reader.readAsDataURL(file)
    }
  }

}
</script>
<style>
::-webkit-input-placeholder {
  text-align: right;
}

:-moz-placeholder {
  /* Firefox 18- */
  text-align: right;
}

::-moz-placeholder {
  /* Firefox 19+ */
  text-align: right;
}

:-ms-input-placeholder {
  text-align: right;
}

input {
  text-align: right;
}

option,
select {
  text-align: right;
}

.error {
  border-color: red;
  border-width: 1px;
  border-style: solid;
  border-radius: 5px;
  padding: 5px;
  color: white !important;
}

.progressbar {
  -webkit-transition: width 1s ease;
  transition: width 1s ease
}

.vue-step-wizard {
  background-color: #202020;
  color: #fff;
  width: 900px;
  margin: auto;
  padding: 40px
}

.step-progress {
  height: 1rem;
  background: rgb(65, 64, 64);
  border-radius: 1rem;
  margin: 1rem 0
}

.step-progress .bar {
  content: "";
  height: 1rem;
  border-radius: 1rem;
  background-color: #4b8aeb
}

.step-pills {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  background-color: rgb(65, 64, 64);
  color: #fff;
  -webkit-box-pack: justify;
  -ms-flex-pack: justify;
  justify-content: space-between;
  padding: 1rem;
  border-radius: 1rem;
  -webkit-box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
  box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important
}

.step-pills .step-item {
  background-color: rgb(95, 95, 95) ;
   color: #fff;
  border-radius: 10px;
  padding: 5px 20px;
  list-style-type: none;
  padding: .5rem 1.5rem
}

.step-pills .step-item a {
  text-decoration: none;
  color: #fff
}

.step-pills .step-item.active {
  border: 1px solid #4b8aeb
}

.step-pills .step-item.validated {
  border: 1px solid #008011
}

.step-body {
  background-color: rgb(65, 64, 64);
  text-align: right;
  margin-left: auto;
  -webkit-box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
  box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important
}

.step-body,
.step-footer {
  padding: 1rem;
  border-radius: 1rem
}

.step-footer {
  margin-left: auto;
  margin: 1rem 0;
  text-align: center
}

.step-button {
  font-weight: 700;
  line-height: 1;
  text-transform: uppercase;
  position: relative;
  max-width: 30rem;
  text-align: center;
  border: 1px solid;
  border-radius: 12px;
  color: #22292f;
  color: rgba(34, 41, 47, var(--text-opacity));
  padding: .5rem 1.25rem;
  font-size: .875rem;
  margin: .5rem;
  color: #fff;
  outline: none !important;
  -webkit-box-shadow: none !important;
  box-shadow: none !important
}

.step-button-next {
  background-color: #126fde
}

.step-button-previous {
  background-color: #3deaba
}

.step-button-submit {
  background-color: #4fa203
}

.step-button-reset {
  background-color: #037da2
}

.tabStatus {
  display: inline-block;
  width: 1.5rem;
  height: 1.5rem;
  margin-right: .5rem;
  line-height: 1.5rem;
  color: #fff;
  text-align: center;
  background: rgba(0, 0, 0, .38);
  border-radius: 50%
}
</style>
