<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Iuran</h1>
    <div class="mb-6 flex justify-between items-center">
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
      <table class="w-full whitespace-no-wrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">Nama</th>
          <th class="px-6 pt-6 pb-4 text-center">Jan</th>
          <th class="px-6 pt-6 pb-4 text-center">Feb</th>
          <th class="px-6 pt-6 pb-4 text-center">Mar</th>
          <th class="px-6 pt-6 pb-4 text-center">Apr</th>
          <th class="px-6 pt-6 pb-4 text-center">Mei</th>
          <th class="px-6 pt-6 pb-4 text-center">Juni</th>
          <th class="px-6 pt-6 pb-4 text-center">Juli</th>
          <th class="px-6 pt-6 pb-4 text-center">Ags</th>
          <th class="px-6 pt-6 pb-4 text-center">Sep</th>
          <th class="px-6 pt-6 pb-4 text-center">Okt</th>
          <th class="px-6 pt-6 pb-4 text-center">Nov</th>
          <th class="px-6 pt-6 pb-4 text-center">Des</th>
        </tr>
        <tr v-for="iuran in iurans" :key="iuran.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('warga.edit', iuran.id)">
              {{ iuran.nama }}
            </inertia-link>
          </td>
          <td class="border-t text-center">
            <a href="#" v-if="iuran.januari>0"><i class="fa fa-check text-green-300"></i></a>
            <a href="javascript:void(0)" v-else @click="bayar(iuran,1,'januari')"><i class="fa fa-times text-red-300"></i></a>
          </td>
          <td class="border-t text-center">
            <a href="#" v-if="iuran.februari>0"><i class="fa fa-check text-green-300"></i></a>
            <a href="javascript:void(0)" v-else @click="bayar(iuran,2,'februari')"><i class="fa fa-times text-red-300"></i></a>
          </td>
          <td class="border-t text-center">
            <a href="#" v-if="iuran.maret>0"><i class="fa fa-check text-green-300"></i></a>
            <a href="javascript:void(0)" v-else @click="bayar(iuran,3,'maret')"><i class="fa fa-times text-red-300"></i></a>
          </td>
          <td class="border-t text-center">
            <a href="#" v-if="iuran.april>0"><i class="fa fa-check text-green-300"></i></a>
            <a href="javascript:void(0)" v-else @click="bayar(iuran,4,'april')"><i class="fa fa-times text-red-300"></i></a>
          <td class="border-t text-center">
            <a href="#" v-if="iuran.mei>0"><i class="fa fa-check text-green-300"></i></a>
            <a href="javascript:void(0)" v-else @click="bayar(iuran,5,'mei')"><i class="fa fa-times text-red-300"></i></a>
          </td>
          <td class="border-t text-center">
            <a href="#" v-if="iuran.juni>0"><i class="fa fa-check text-green-300"></i></a>
            <a href="javascript:void(0)" v-else @click="bayar(iuran,6,'juni')"><i class="fa fa-times text-red-300"></i></a>
          </td>
          <td class="border-t text-center">
            <a href="#" v-if="iuran.juli>0"><i class="fa fa-check text-green-300"></i></a>
            <a href="javascript:void(0)" v-else @click="bayar(iuran,7,'juli')"><i class="fa fa-times text-red-300"></i></a>
          </td>
          <td class="border-t text-center">
            <a href="#" v-if="iuran.agustus>0"><i class="fa fa-check text-green-300"></i></a>
            <a href="javascript:void(0)" v-else @click="bayar(iuran,8,'agustus')"><i class="fa fa-times text-red-300"></i></a>
          </td>
          <td class="border-t text-center">
            <a href="#" v-if="iuran.september>0"><i class="fa fa-check text-green-300"></i></a>
            <a href="javascript:void(0)" v-else @click="bayar(iuran,9,'september')"><i class="fa fa-times text-red-300"></i></a>
          </td>
          <td class="border-t text-center">
            <a href="#" v-if="iuran.oktober>0"><i class="fa fa-check text-green-300"></i></a>
            <a href="javascript:void(0)" v-else @click="bayar(iuran,10,'oktober')"><i class="fa fa-times text-red-300"></i></a>
          </td>
          <td class="border-t text-center">
            <a href="#" v-if="iuran.november>0"><i class="fa fa-check text-green-300"></i></a>
            <a href="javascript:void(0)" v-else @click="bayar(iuran,11,'november')"><i class="fa fa-times text-red-300"></i></a>
          </td>
          <td class="border-t text-center">
            <a href="#" v-if="iuran.desember>0"><i class="fa fa-check text-green-300"></i></a>
            <a href="javascript:void(0)" v-else @click="bayar(iuran,12,'desember')"><i class="fa fa-times text-red-300"></i></a>
          </td>
        </tr>
        <tr v-if="iurans.length === 0">
          <td class="border-t px-6 py-4" colspan="4">tidak ada data.</td>
        </tr>
      </table>
    </div>
    <pagination :links="iurans.links" />
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination'
import pickBy from 'lodash/pickBy'
import SearchFilter from '@/Shared/SearchFilter'
import throttle from 'lodash/throttle'

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} 
export default {
  metaInfo: { title: 'Warga' },
  layout: Layout,
  components: {
    Icon,
    Pagination,
    SearchFilter,
  },
  props: {
    iurans: Object,
    filters: Object,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        trashed: this.filters.trashed,
      },
    }
  },
  watch: {
    form: {
      handler: throttle(function() {
        let query = pickBy(this.form)
        this.$inertia.replace(this.route('warga', Object.keys(query).length ? query : { remember: 'forget' }))
      }, 150),
      deep: true,
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
    bayar(item, bulan,str){
      if(confirm('Bayar iuran bulan '+str +' ?')){
        axios.post(this.route('iuran.bayar'), {
          warga_id: item.id,
          bulan: bulan,
          tahun: new Date().getFullYear()
        })
        .then(response =>{
          item[str] = 1;
        })         
      }
    }
  },
}
</script>
