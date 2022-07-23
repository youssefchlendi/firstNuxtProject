<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <v-app id="inspire">
    <div>
      <v-container fluid>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md8>
            <v-card class="elevation-12 rounded-lg" shaped>
              <v-toolbar dark>
                <v-toolbar-title>تسجيل الدخول</v-toolbar-title>
              </v-toolbar>
              <v-card-text>
                <v-alert v-if="alert.show" class="text-right" dismissible :type="alert.variant">
                  <p>{{ alert.msg }}</p>
                  <span
                    v-if="
                      alert.msg ==
                        'حسابك غير مفعل, يرجى التحقق من بريدك الإلكتروني'
                    "
                    class="caption"
                  >
                    <router-link to="/auth/request-verify-email">طلب تأكيد البريد الإلكتروني</router-link>
                  </span>
                </v-alert>
                <v-form id="login-form" @submit.prevent="Login">
                  <v-text-field
                    v-model="email"
                    prepend-icon="person"
                    name="البريد الإلكتروني"
                    label="البريد الإلكتروني"
                    :error-messages="emailErrors"
                    type="text"
                    @change="$v.$touch()"
                  />
                  <v-text-field
                    id="password"
                    v-model="password"
                    :error-messages="passwordErrors"
                    prepend-icon="lock"
                    name="كلمة المرور"
                    label="كلمة المرور"
                    type="password"
                    @change="$v.$touch()"
                  />
                </v-form>
                <v-card-actions>
                  <v-spacer />
                  <span class="caption">
                    هل لديك حساب ?
                    <router-link color="primary" to="/auth/register">صنع حساب</router-link>
                  </span>
                  <v-btn color="success" form="login-form" type="submit">
                    التسجيل
                  </v-btn>
                </v-card-actions>
                <div v-if="attempt > 2">
                  <span class="caption">
                    <router-link class="text-danger" to="/auth/forgot-password">
                      هل نسيت كلمة المرور؟
                    </router-link>
                  </span>
                </div>
              </v-card-text>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </div>
  </v-app>
</template>

<script>
import { required, minLength, email } from 'vuelidate/lib/validators'

export default {
  auth: 'guest',
  validations: {
    email: {
      required,
      email,
      async exists (value) {
        if (value === '') {
          return true
        }
        const response = await this.$axios(`/unique/${value}`)
        return response.status === 201 || value === ''
      }
    },
    password: { required, minLength: minLength(8) }
  },
  data () {
    return {
      oldEmail: '',
      attempt: 0,
      email: '',
      password: '',
      alert: {
        show: null,
        variant: 'n',
        msg: null
      }
    }
  },
  computed: {
    passwordErrors () {
      const errors = []
      if (!this.$v.password.$dirty) { return errors }
      !this.$v.password.required && errors.push('الرجاء ادخال بكلمة المرور')
      !this.$v.password.minLength &&
        errors.push('الرجاء ادخال بكلمة المرور بحد اقل من 8 حروف')
      return errors
    },
    emailErrors () {
      const errors = []
      if (!this.$v.email.$dirty) { return errors }
      !this.$v.email.email && errors.push('الرجاء ادخال بريد صحيح')
      !this.$v.email.required && errors.push('الرجاء ادخال بريد الكتروني')
      !this.$v.email.exists && errors.push('البريد الالكتروني غير مسجل')
      return errors
    }
  },
  methods: {
    async Login () {
      this.$v.$touch()
      if (!this.$v.$invalid) {
        if (this.email === this.oldEmail) {
          this.attempt++
        } else {
          this.attempt = 0
        }
        try {
          this.oldEmail = this.email
          await this.$auth.loginWith('laravelSanctum', {
            data: {
              email: this.email,
              password: this.password
            }
          })
        } catch (error) {
          this.alert.variant = 'error'
          this.alert.msg = error.response.data.message
          this.alert.show = true
          setTimeout(() => {
            this.alert.show = false
          }, 5000)
        }
      }
    },
    post () {
      this.$v.$touch()
    }
  }
}
</script>

<style>
</style>
