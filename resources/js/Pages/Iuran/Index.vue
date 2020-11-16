<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Iuran</h1>
    <div class="mb-6 justify-between items-center">
      <input type="text" class="px-4 py-3" v-model="form.search" placeholder="Search" />
      <a :href="route('iuran.download-excel')+'?search='+(form.search?form.search:'')" class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-5 rounded">Download Excel</a>
      <button v-on:click="modal=true" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded">Tambah Iuran</button>
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


    <div class="fixed z-10 inset-0 overflow-y-auto" v-if="modal==true">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" v-on:click="modal=false">
          <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
        <form  @submit.prevent="submitFormBayar">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-2 sm:pb-4">
              <div class="sm:items-start">
                <div class="mt-6 text-center sm:mt-4 sm:ml-4 sm:mr-4 sm:text-left">
                  <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline"> Tambah Iuran</h3>
                  <div class="mt-4 flex">
                    <select class="px-4 py-3 bg-white shadow-sm border w-1/2" v-model="formTambah.warga_id" required>
                      <option value=""> --- Pilih Warga --- </option>
                      <option v-for="warga in wargas" :value="warga.id">{{warga.nama}}</option>
                    </select>
                    <select class="px-4 py-3 bg-white shadow-sm border w-1/2" v-model="formTambah.bulan" required>
                      <option value=""> --- Bulan --- </option>
                      <option value="1">Januari</option>
                      <option value="2">Februari</option>
                      <option value="3">Maret</option>
                      <option value="4">April</option>
                      <option value="5">Mei</option>
                      <option value="6">Juni</option>
                      <option value="7">Juli</option>
                      <option value="8">Agustus</option>
                      <option value="9">September</option>
                      <option value="10">Oktober</option>
                      <option value="11">November</option>
                      <option value="12">Desember</option>
                    </select>  
                  </div>
                  <input type="date" class="px-4 py-3 bg-white shadow-sm border w-1/2" v-model="formTambah.tanggal" required>
                </div>
              </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
              <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                <loading-button :loading="sending" class="btn-indigo" type="submit">Simpan</loading-button>
              </span>
              <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                <button type="button" v-on:click="modal=false" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                  Cancel
                </button>
              </span>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import LoadingButton from '@/Shared/LoadingButton'
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
    LoadingButton
  },
  props: {
    iurans: Object,
    filters: Object,
    wargas:Object
  },
  data() {
    return {
      sending: false,
      form: {
        search: this.filters.search,
        trashed: this.filters.trashed,
      }, 
      modal:false,
      formTambah:{
        warga_id:"",
        bulan:"",
        tanggal:""
      }
    }
  },
  watch: {
    form: {
      handler: throttle(function() {
        let query = pickBy(this.form)
        this.$inertia.replace(this.route('iuran', Object.keys(query).length ? query : { remember: 'forget' }))
      }, 150),
      deep: true,
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => "")
    },
    submitFormBayar(){
      this.$inertia.post(this.route('iuran.store-form-iuran'), this.formTambah)
        .then(response => { 
          this.sending = false
          this.modal=false
        })
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
