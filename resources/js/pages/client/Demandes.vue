<script setup>
import Topbar from '@/components/Topbar.vue'
import ClientDashboardHeader from '@/components/ClientDashboardHeader.vue'
import MainFooter from '@/components/MainFooter.vue'
import { router } from '@inertiajs/vue3'  // Mise à jour de l'import
import { ref } from 'vue'

const props = defineProps({
  demandes: {
    type: Array,
    required: true
  }
})

function annulerDemande(id) {
  if (confirm("Voulez-vous vraiment annuler cette demande ?")) {
    router.post(`/dashboard/client/demandes/${id}/annuler`)
  }
}

// Formatage de la date
function formatDate(dateString) {
  return new Date(dateString).toLocaleDateString('fr-FR', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}
</script>

<template>
  <div class="bg-white min-h-screen font-[Poppins]">
    <Topbar />
    <ClientDashboardHeader />

    <div class="max-w-7xl mx-auto px-6 py-10">
      <div class="flex justify-between items-center mb-8 text-black" >
        <h1 class="text-3xl font-bold">Mes Demandes</h1>
      
      </div>

      <!-- Message si aucune demande -->
      <div v-if="!demandes || demandes.length === 0" 
           class="text-center py-10 bg-gray-50 rounded-lg">
        <p class="text-gray-500">Vous n'avez pas encore de demandes</p>
      </div>

      <!-- Table des demandes -->
      <div v-else class="overflow-x-auto">
        <table class="min-w-full bg-white shadow rounded">
          <thead>
            <tr class="bg-blue-500 text-white">
              <th class="py-3 px-6 text-left">Service</th>
              <th class="py-3 px-6 text-left">Ville</th>
              <th class="py-3 px-6 text-left">Date de demande</th>
              <th class="py-3 px-6 text-left">Status</th>
              <th class="py-3 px-6 text-left">Actions</th>
            </tr>
          </thead>
     <tbody>
  <tr v-for="demande in demandes" 
      :key="demande.id" 
      class="border-b hover:bg-gray-50">
    <td class="py-3 px-6 text-black">{{ demande.service?.nom || 'N/A' }}</td>
    <td class="py-3 px-6 text-black">{{ demande.ville }}</td>
    <td class="py-3 px-6 text-black">{{ formatDate(demande.date) }}</td>
    <td class="py-3 px-6">
   <span
  :class="{
    'bg-green-100 text-green-700 border border-green-400': demande.statut && demande.statut.toLowerCase() === 'acceptée',
    'bg-yellow-100 text-yellow-700 border border-yellow-400': demande.statut && demande.statut.toLowerCase() === 'en attente',
    'bg-red-100 text-red-700 border border-red-400': demande.statut && demande.statut.toLowerCase() === 'annulée',
    'bg-gray-200 text-gray-700 border border-gray-400': !demande.statut || !['acceptée', 'en attente', 'annulée'].includes(demande.statut.toLowerCase())
  }"
  class="px-3 py-1 rounded-full text-sm font-bold inline-block"
>
  {{ demande.statut || 'N/A' }}
</span>
    </td>
    <td class="py-3 px-6">
      <div class="flex gap-2">
        <button v-if="demande.statut === 'en attente'"
                @click="annulerDemande(demande.id)"
                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
          Annuler
        </button>
      </div>
    </td>
  </tr>
</tbody>
        </table>
      </div>
    </div>

    <MainFooter />
  </div>
</template>
<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
</style>

