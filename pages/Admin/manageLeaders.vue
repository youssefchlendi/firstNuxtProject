<template>
  <div>
    <v-data-table
      :headers="headers"
      :items="leaders"
      show-expand
      :single-expand="true"
      :expanded.sync="expanded"
      item-key="id"
      class="elevation-1"
      show-group-by
    >
      <template #[`item.user.image`]="{ item }">
        <v-avatar size="64">
          <img :src="item.user.image" alt="لا يوجد صورة">
        </v-avatar>
      </template>
      <template #[`item.troupe.name`]="{ item }">
        <td>{{ item.troupe ? item.troupe.name : "فوج" }}</td>
      </template>
      <template #[`item.role.name`]="{ item }">
        <td>
          {{
            item.role.name !== "معين قائد وحدة"
              ? item.role.name
              : item.role.name + "(" + item.responsability[0].name + ")"
          }}
        </td>
      </template>
      <template #expanded-item="{ item }">
        <td>
          <v-card>
            العمر:
            {{
              Math.floor(
                (new Date() - new Date(item.user.birth_date)) / 31557600000
              )
            }}
          </v-card>
        </td>
        <td>
          <v-card> ر.ب.و: {{ item.user.cin }} </v-card>
        </td>
        <td>
          <v-card> البريد الالكتروني: {{ item.user.email }} </v-card>
        </td>
        <td>
          <v-card> رقم الهاتف: {{ item.user.phone_number }} </v-card>
        </td>
        <td>
          <v-card>
            تاريخ انشاء الحساب:
            {{
              new Date(item.user.created_at).getDate() +
                "/" +
                (new Date(item.user.created_at).getMonth() + 1) +
                "/" +
                new Date(item.user.created_at).getFullYear()
            }}
          </v-card>
        </td>
      </template>
      <template #[`item.actions`]="{ item }">
        <div class="align-center">
          <v-btn
            class="mx-1"
            :disabled="item.status == 0"
            x-small
            :fab="$vuetify.breakpoint.name != 'sm'"
            color="red"
            @click="reject(item.id)"
          >
            <v-icon color="white">
              mdi-close-outline
            </v-icon>
          </v-btn>
          <v-btn
            class="mx-1"
            :disabled="item.status == 1"
            x-small
            :fab="$vuetify.breakpoint.name != 'sm'"
            color="success"
            @click="accept(item.id)"
          >
            <v-icon>mdi-check-outline</v-icon>
          </v-btn>
        </div>
      </template>
    </v-data-table>
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
export default {
  middleware: ['superAdmin'],
  data () {
    return {
      snack: false,
      snackColor: '',
      snackText: '',
      expanded: [],
      singleExpand: false,
      leaders: []
    }
  },
  computed: {
    headers () {
      return [
        {
          text: 'الاسم',
          value: 'user.first_name',
          groupable: false
        },
        {
          text: 'اللقب',
          value: 'user.last_name',
          groupable: false
        },
        {
          text: 'المهمة',
          value: 'role.name'
        },
        {
          text: 'الفرقة',
          value: 'troupe.name',
          default: 'الفرقة'
        },
        {
          text: 'الصورة',
          value: 'user.image',
          groupable: false,
          sortable: false,
          align: 'center',
          class: 'img-responsive'
        },
        {
          text: 'اجرائات',
          value: 'actions',
          groupable: false,
          sortable: false
        },
        {
          text: '',
          value: 'data-table-expand',
          groupable: false

        }
      ]
    }
  },
  created () {
    this.getLeaders()
  },
  methods: {
    getLeaders () {
      this.$axios
        .get('/leaders')
        .then((response) => {
          this.leaders = response.data
          this.leaders.forEach((leader) => {
            if (leader.troupe == null) {
              leader.troupe = {
                name: 'فوج'
              }
            }
          })
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
    accept (id) {
      this.$axios
        .put('/leaders/' + id + '/accept')
        .then(() => {
          this.snack = true
          this.snackColor = 'success'
          this.snackText = 'لقد تم القبول'
          this.getLeaders()
        })
        .catch((error) => {
          this.snack = true
          this.snackColor = 'red'
          this.snackText = error.response.data.error
            ? error.response.data.error
            : 'لقد حصل عطب في الخادم, الرجاء المحاولة لاحقا'
        })
    },
    reject (id) {
      this.$axios
        .put('/leaders/' + id + '/reject')
        .then(() => {
          this.snack = true
          this.snackColor = 'pink'
          this.snackText = 'لقد تم الرفض'
          this.getLeaders()
        })
        .catch((error) => {
          this.snack = true
          this.snackColor = 'red'
          this.snackText = error.response.data.error
            ? error.response.data.error
            : 'لقد حصل عطب في الخادم, الرجاء المحاولة لاحقا'
        })
    }
  }
}
</script>

<style></style>
