<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Warga</h1>
    <div class="mb-6 flex justify-between items-center">
      <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
        <label class="block text-gray-700">Blok Rumah:</label>
        <select v-model="form.block" class="mt-1 w-full form-select">
          <option :value="null" />
          <option v-for="block in blocks" :value="block.blok_rumah">{{block.blok_rumah}}</option>
        </select>
      </search-filter>
      <inertia-link class="btn-indigo" :href="route('warga.create')">
        <span>Tambah</span>
        <span class="hidden md:inline">Warga</span>
      </inertia-link>
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
      <table class="w-full whitespace-no-wrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">Nama</th>
          <th class="px-6 pt-6 pb-4">No Telepon</th>
          <th class="px-6 pt-6 pb-4">Blok Rumah</th>
          <th class="px-6 pt-6 pb-4">Status Rumah</th>
          <th class="px-6 pt-6 pb-4">Status Tinggal</th>
        </tr>
        <tr v-for="warga in warga.data" :key="warga.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('warga.edit', warga.id)">
              {{ warga.jenis_kelamin }}. {{ warga.nama }}
              <icon v-if="warga.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('warga.edit', warga.id)" tabindex="-1">
              {{ warga.no_telepon }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('warga.edit', warga.id)" tabindex="-1">
              {{ warga.blok_rumah }} - {{ warga.nomor}}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('warga.edit', warga.id)" tabindex="-1">
              {{ warga.status_rumah }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('warga.edit', warga.id)" tabindex="-1">
              {{ warga.status_tinggal }}
            </inertia-link>
          </td>
          <td class="border-t w-px">
            <inertia-link class="px-4 flex items-center" :href="route('warga.edit', warga.id)" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </inertia-link>
          </td>
        </tr>
        <tr v-if="warga.data.length === 0">
          <td class="border-t px-6 py-4" colspan="4">tidak ada data.</td>
        </tr>
      </table>
    </div>
    <pagination :links="warga.links" />
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

export default {
  metaInfo: { title: 'Warga' },
  layout: Layout,
  components: {
    Icon,
    Pagination,
    SearchFilter,
  },
  props: {
    warga: Object,
    blocks: {},
    filters: Object
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        block: this.filters.block
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
  },
}
</script>
