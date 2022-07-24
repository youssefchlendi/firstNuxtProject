<template>
  <div>
    <div
      v-for="demande in demandes"
      v-show="demandes.length != 0"
      :key="demande.id + 'i'"
    >
      <v-card>
        <v-tabs align-with-title>
          <v-tabs-slider />
          <v-tab v-for="item in items" :key="item">
            {{ item }}
          </v-tab>
          <v-tab-item>
            <v-container p-4>
              <v-row>
                <span class="h6">المرسل :</span>
                {{ demande.user.first_name + " " + demande.user.last_name }}
              </v-row>
              <v-row>
                <span class="h6">الرسالة :</span>
                {{ demande.message }}
              </v-row>
              <v-row>
                <span class="h6">تاريخ الارسال :</span>
                {{ demande.created_at }}
              </v-row>
              <v-row>
                <span class="h6">تاريخ الطلب :</span>
                {{ demande.date_demande }}
              </v-row>
              <v-row>
                <span class="h6">تاريخ الارجاع :</span>
                {{ demande.date_fin_demande }}
              </v-row>
            </v-container>
          </v-tab-item>
          <v-tab-item>
            <v-container p-4>
              <v-row v-for="materiel in demande.materiels" :key="materiel.id">
                <v-text-field
                  v-model="materiel.pivot.quantity"
                  label="الكمية"
                  type="number"
                  step="1"
                  min="1"
                  disabled
                  max="100"
                  style="width: 100px"
                >
                  <span slot="prepend">
                    {{ materiel.name }}
                  </span>
                </v-text-field>

                <div
                  v-if="$store.state.auth.user.user.id == materiel.responsable_id"
                  class="m-4 mr-0 ml-1 mr-1"
                >
                  <v-btn
                    v-if="materiel.pivot.status != 1"
                    color="success"
                    text
                    @click="setStatus(materiel.pivot.id, 1)"
                  >
                    <v-icon>mdi-check</v-icon>
                    قبول
                  </v-btn>
                  <v-btn
                    v-if="materiel.pivot.status != 2"
                    color="error"
                    text
                    @click="setStatus(materiel.pivot.id, 2)"
                  >
                    <v-icon>mdi-close</v-icon>
                    رفض
                  </v-btn>
                </div>
                <div v-else class="m-4 mr-0 ml-1 pl-4 mr-1">
                  <v-tooltip bottom color="red">
                    <template #activator="{ on, attrs }">
                      <v-icon v-bind="attrs" v-on="on">
                        mdi-close
                      </v-icon>
                    </template>
                    <span>
                      لست مسؤول عن هذا الأثاث</span>
                  </v-tooltip>
                </div>
              </v-row>
              <v-row v-if="demande.materiels.length == 0">
                <span class="h5"> لا يوجد اثاث </span>
              </v-row>
            </v-container>
          </v-tab-item>
        </v-tabs>
        <v-card-actions>
          <v-spacer />
          <deleteDialog
            :id="demande.id"
            @ok="$emit('deleteItem', demande.id)"
          />
        </v-card-actions>
      </v-card>
      <br>
    </div>

    <v-card v-if="demandes.length == 0">
      <v-card-title>
        <h1>لا يوجد طلبات</h1>
      </v-card-title>
      <v-card-text>
        <p>لم تصلك اي طلبات بعد</p>
      </v-card-text>
    </v-card>
    <v-pagination
      v-model="pagination_meta.current"
      :length="pagination_meta.total"
      @input="$emit('getDemandeMateriel',{},pagination)"
    />
    <v-select
      v-model="pagination"
      :items="[5,10,15,30,50,100]"
      label="عدد الصفوف"
      @input="$emit('getDemandeMateriel',{},pagination)"
    />
  </div>
</template>

<script>
import deleteDialog from '@/components/demandeMateriel/deleteDialog.vue'
export default {
  components: {
    deleteDialog
  },
  props: {
    demandes: {
      type: Array,
      default: () => []
    },
    pagination_meta: {
      type: Object,
      default: () => {
        return {
          current: 1,
          total: 0
        }
      }
    }
  },
  data () {
    return {
      tab: null,
      items: ['المعلومات الاساسية', 'الاثاث المطلوب'],
      pagination: 5
    }
  },
  watch: {
    demandes () {}
  },
  methods: {
    setStatus (id, status) {
      this.$emit('setStatus', id, status)
    },
    rem (id, materiel_id) {
      this.$emit('rem', id, materiel_id)
    }
  }
}
</script>

<style>
</style>
