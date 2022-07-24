<template>
  <div>
    <v-alert :value="alert.show" dismissible :type="alert.type">
      {{
        alert.msg
      }}
    </v-alert>
    <show
      :demandes="demandes"
      :pagination_meta="pagination_meta"
      @rem="rem"
      @setStatus="setStatus"
      @getDemandeMateriel="getDemandeMateriel"
    />
  </div>
</template>

<script>
import show from '~/components/demandeMateriel/manage/showManageDemandeMateriel.vue'

export default {
  components: {
    show
  },
  middleware: 'materielManager',
  data () {
    return {
      alert: {
        show: false,
        type: null,
        msg: null
      },
      pagination_meta: {
        current: 1,
        total: 0
      },
      demandes: []
    }
  },
  created () {
    this.getDemandeMateriel()
  },
  methods: {
    getDemandeMateriel (alert = {}, pagination = 5) {
      this.$axios
        .get('/demande-materiel', { params: { pagination } })
        .then((response) => {
          this.demandes = response.data.data
          this.pagination_meta.current = response.data.pagination.current_page
          this.pagination_meta.total = response.data.pagination.last_page
        })
        .catch()
        .finally(() => {
          if ('type' in alert) {
            this.alert = alert
            setTimeout(() => {
              this.alert.show = false
            }, 5000)
          }
        })
    },
    rem () {},
    setStatus (id, status) {
      this.$axios
        .put(`/demande-materiel-status/${id}/${status}`)
        .then(() => {
          if (status === 1) {
            this.getDemandeMateriel({
              show: true,
              type: 'success',
              msg: 'تم القبول  بنجاح'
            })
          } else {
            this.getDemandeMateriel({
              show: true,
              type: 'success',
              msg: 'تم الرفض  بنجاح'
            })
          }
        })
        .catch()
        .finally(() => {
          this.alert = alert
          setTimeout(() => {
            this.alert.show = false
          }, 5000)
        })
    }
  }
}
</script>

<style>
</style>
