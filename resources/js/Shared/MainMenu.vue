<template>
  <div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('warga')">
        <icon name="office" class="w-4 h-4 mr-2" :class="isUrl('warga') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('warga') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Data Warga</div>
      </inertia-link>
    </div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('iuran')">
        <icon name="office" class="w-4 h-4 mr-2" :class="isUrl('iuran') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('iuran') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Iuran</div>
      </inertia-link>
    </div>
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'

export default {
  components: {
    Icon,
  },
  props: {
    url: String,
  },
  methods: {
    isUrl(...urls) {
      if (urls[0] === '') {
        return this.url === ''
      }

      return urls.filter(url => this.url.startsWith(url)).length
    },
  },
}
</script>
