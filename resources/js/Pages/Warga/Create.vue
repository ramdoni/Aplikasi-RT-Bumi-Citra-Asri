<template>
  <div>
    <h1 class="mb-8 font-bold text-2xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('warga')">Warga</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Tambah
    </h1>
    <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
        <form @submit.prevent="submit">
            <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
              <select-input v-model="form.jenis_kelamin" class="pr-6 pb-8 w-full lg:w-1/6" label="Panggilan">
                  <option>Bp</option>
                  <option>Ibu</option>
                </select-input>
              <text-input v-model="form.nama" :errors="$page.errors.nama" class="pr-6 pb-8 w-full lg:w-1/2" label="Nama" />
              <text-input v-model="form.nik" :errors="$page.errors.nik" class="pr-6 pb-8 w-full lg:w-1/3" label="NIK" />
              <text-input v-model="form.no_telepon" :errors="$page.errors.no_telepon" class="pr-6 pb-8 w-full lg:w-1/2" label="Telepon" />
              <text-input v-model="form.blok_rumah" :errors="$page.errors.blok_rumah" class="pr-6 pb-8 w-full lg:w-1/4 text-uppercase" placeholder="Contoh : A2/B1/C1..." label="Blok Rumah" />
              <text-input v-model="form.nomor" :errors="$page.errors.nomor" class="pr-6 pb-8 w-full lg:w-1/4" label="Nomor Rumah" />
              <select-input v-model="form.status_tinggal" class="pr-6 pb-8 w-full lg:w-1/3" label="Status Tinggal">
                  <option>Menetap</option>
                  <option>Belum Menetap</option>
              </select-input>
              <select-input v-model="form.status_rumah" class="pr-6 pb-8 w-full lg:w-1/3" label="Status Rumah">
                <option>Milik Sendiri</option>
                <option>Keluarga</option>
                <option>Ngontrak</option>
              </select-input>
            </div> 
            <hr />
            <div class="p-8">
              <h2 class="mt-0 font-bold text-2xl mb-8">Anggota Keluarga</h2>
              <div v-for="(i,k) in form.form_anggota_keluarga_item" class="flex flex-wrap" :key="k">
                <select-input v-model="form.keluarga_hubungan[k]" class="pr-6 pb-8 w-full lg:w-1/3" label="Hubungan">
                  <option>Istri</option>
                  <option>Anak</option>
                  <option>Orang Tua</option>
                  <option>Sodara</option>
                </select-input>
                <text-input v-model="form.keluarga_nama[k]" class="pr-6 pb-8 w-full lg:w-1/3" label="Nama" />
                <select-input v-model="form.keluarga_jenis_kelamin[k]" class="pr-6 pb-8 w-full lg:w-1/3" label="Jenis Kelamin">
                  <option>Laki-laki</option>
                  <option>Perempuan</option>
                </select-input>
              </div>
              <a href="javascript:void(0)" @click="form.form_anggota_keluarga_item.push(1)" class="-mt-10">+ Tambah</a>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
                <loading-button :loading="sending" class="btn-indigo" type="submit">Simpan</loading-button>
            </div>
        </form>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import LoadingButton from '@/Shared/LoadingButton'
import SelectInput from '@/Shared/SelectInput'
import TextInput from '@/Shared/TextInput'

export default {
  metaInfo: { title: 'Tambah Warga' },
  layout: Layout,
  components: {
    LoadingButton,
    SelectInput,
    TextInput
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        nama: null,
        jenis_kelamin: 'Bp',
        no_telepon: null,
        nik: null,
        blok_rumah: null,
        form_anggota_keluarga_item :[],
        keluarga_hubungan :[],
        keluarga_nama :[],
        keluarga_jenis_kelamin :[],
        status_rumah :null,
        status_tinggal:null
      }
    }
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.post(this.route('warga.store'), this.form)
        .then(() => this.sending = false)
    },
  },
}
</script>
