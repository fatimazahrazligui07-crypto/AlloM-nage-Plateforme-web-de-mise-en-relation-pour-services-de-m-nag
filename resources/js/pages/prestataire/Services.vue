<script setup>
import { ref, computed } from 'vue';
import Topbar from '@/components/Topbar.vue'
import PrestataireDashboardHeader from '@/components/PrestataireDashboardHeader.vue'
import MainFooter from '@/components/MainFooter.vue';
import { Link } from '@inertiajs/inertia-vue3'

// Recevoir les services depuis Inertia
const props = defineProps({
  services: Array
})

// Sélection initiale
const selected = ref('particuliers')

// Filtrage dynamique
const filteredServices = computed(() => {
  return props.services.filter(service => {
    return service.type_id === (selected.value === 'particuliers' ? 1 : 2)
  })
})
</script>

<template>
  <div class="bg-white font-[Poppins]">
    <Topbar />
    <PrestataireDashboardHeader />

    <!-- Hero Section -->
    <section class="relative bg-cover bg-center bg-no-repeat h-120 flex items-center justify-center text-white"
      style="background-image: url('/hero-gallery.png');">
      <div class="bg-blue-600/60 absolute inset-0"></div>
      <div class="relative z-10 text-center">
        <h1 class="text-5xl font-bold">Services</h1>
        <p class="mt-3 text-lg">
          <a href="/" class="hover:underline text-yellow-400">Accueil</a> &nbsp; › &nbsp; Services
        </p>
      </div>
    </section>

    <!-- Switch Particuliers / Professionnels -->
    <div class="flex justify-center mt-16 mb-12">
      <div class="bg-gray-100 rounded-full p-1 flex shadow-lg border border-gray-200">
        <button @click="selected = 'particuliers'"
          :class="[ 'px-8 py-3 text-lg font-semibold rounded-full transition duration-300',
            selected === 'particuliers' 
            ? 'bg-gradient-to-r from-blue-600 to-blue-400 text-white shadow-md'
            : 'text-gray-600 hover:text-white hover:bg-yellow-400' ]">
          Services Particuliers
        </button>
        <button @click="selected = 'professionnels'"
          :class="[ 'px-8 py-3 text-lg font-semibold rounded-full transition duration-300',
            selected === 'professionnels' 
            ? 'bg-gradient-to-r from-blue-600 to-blue-400 text-white shadow-md'
            : 'text-gray-600 hover:text-white hover:bg-yellow-400' ]">
          Services Professionnels
        </button>
      </div>
    </div>

    <!-- Liste des services -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10 max-w-7xl mx-auto px-6 mb-24">
      <div v-for="service in filteredServices" :key="service.id" class="bg-white rounded-2xl shadow-lg overflow-hidden transition hover:-translate-y-1 hover:shadow-2xl duration-300">
        <div class="h-60 bg-center bg-cover" :style="`background-image: url('${service.logo}')`"></div>
        <div class="p-6 text-center">
          <h3 class="text-xl font-bold text-[#0b2c7a] mb-2">{{ service.title }}</h3>
          <p class="text-gray-600 mb-4">{{ service.description }}</p>

          <!-- Le bouton de demande -->
          <Link 
            :href="`/dashboard/client/demandesform/create?service_id=${service.id}`"
            class="bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-4 py-2 rounded-full transition duration-300"
          >
            Demander ce service
          </Link>
        </div>
      </div>
    </div>

    <MainFooter />
  </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
</style>