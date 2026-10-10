<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import MainHeader from '@/components/MainHeader.vue'
import MainFooter from '@/components/MainFooter.vue'
import Topbar from '@/components/Topbar.vue'

const prestataires = ref([])
const loading = ref(true)
const error = ref(null)

const currentPage = ref(1)
const itemsPerPage = 6

const pagedPrestataires = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage
  return prestataires.value.slice(start, start + itemsPerPage)
})

const totalPages = computed(() => Math.ceil(prestataires.value.length / itemsPerPage))

function goToPage(page) {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page
  }
}

onMounted(async () => {
  try {
    const response = await axios.get('/api/prestataires')
    prestataires.value = response.data
  } catch (err) {
    error.value = "Erreur lors de la récupération des prestataires."
    console.error(err)
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <div class="bg-gray-100 min-h-screen">
    <Topbar />
    <MainHeader />
    <!-- Hero Section -->
    <section class="relative bg-cover bg-center bg-no-repeat h-120 flex items-center justify-center text-white"
      style="background-image: url('/hero-gallery.png');">
      <div class="bg-blue-600/60 absolute inset-0"></div>
      <div class="relative z-10 text-center">
        <h1 class="text-5xl font-bold">Prestataires</h1>
        <p class="mt-3 text-lg">
          <a href="/" class="hover:underline text-yellow-400">Accueil</a> &nbsp; › &nbsp; Prestataires
        </p>
      </div>
    </section>

    <div class="max-w-7xl mx-auto py-12 px-4 min-h-[60vh]">
      
      <div v-if="loading" class="flex justify-center items-center py-20">
        <span class="loader"></span>
      </div>
      <div v-else-if="error" class="flex justify-center items-center py-20">
        <div class="bg-red-100 text-red-700 px-6 py-4 rounded shadow">{{ error }}</div>
      </div>
      <div v-else>
        <div v-if="pagedPrestataires.length === 0" class="text-center text-gray-500 py-10">Aucun prestataire trouvé.</div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
          <div
            v-for="prestataire in pagedPrestataires"
            :key="prestataire.id"
            class="prestataire-card group bg-white rounded-2xl shadow-md p-6 flex flex-col items-center transition-transform hover:-translate-y-2 hover:shadow-xl"
          >
            <div class="relative mb-4">
              <img
                :src="prestataire.logo || '/logo.png'"
                alt="Logo"
                class="w-24 h-24 object-cover rounded-full border-4 border-blue-200 shadow group-hover:scale-105 transition-transform bg-gray-50"
              />
              <span
                v-if="prestataire.is_verify"
                class="absolute bottom-0 right-0 bg-green-500 text-white text-xs px-2 py-0.5 rounded-full shadow"
                title="Prestataire vérifié"
              >✔ Vérifié</span>
            </div>
            <h2 class="text-xl font-bold mb-1 text-blue-800 text-center">{{ prestataire.nom_Entreprise }}</h2>
            <p class="text-gray-600 mb-1 text-center">
  <span class="font-semibold">Quartier :</span>
  {{ prestataire.quartier?.nom_quartier || 'Non renseigné' }}
</p>
<p class="text-gray-600 mb-1 text-center">
  <span class="font-semibold">Ville :</span>
  {{ prestataire.quartier?.ville?.nom_ville || 'Non renseigné' }}
</p>
          </div>
        </div>
        <!-- Pagination -->
        <div v-if="totalPages > 1" class="flex justify-center mt-10 space-x-2">
          <button
            v-for="page in totalPages"
            :key="page"
            @click="goToPage(page)"
            :class="[
              'px-4 py-2 rounded-lg font-semibold border transition',
              currentPage === page
                ? 'bg-blue-700 text-white border-blue-700 shadow'
                : 'bg-white text-blue-700 border-blue-200 hover:bg-blue-50'
            ]"
          >
            {{ page }}
          </button>
        </div>
      </div>
    </div>
    <MainFooter />
  </div>
</template>

<style scoped>
.loader {
  border: 4px solid #e5e7eb;
  border-top: 4px solid #2563eb;
  border-radius: 50%;
  width: 48px;
  height: 48px;
  animation: spin 1s linear infinite;
  display: inline-block;
}
@keyframes spin {
  to { transform: rotate(360deg); }
}
.prestataire-card {
  min-height: 340px;
}
</style>