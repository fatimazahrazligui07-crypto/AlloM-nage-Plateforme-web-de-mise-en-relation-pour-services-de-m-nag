<script setup> 
import Topbar from '@/components/Topbar.vue'
import ClientDashboardHeader from '@/components/ClientDashboardHeader.vue'
import MainFooter from '@/components/MainFooter.vue'
import { Inertia } from '@inertiajs/inertia'
import { ref, computed } from 'vue'

const props = defineProps({
  prestations: Array
})

const selectedStatus = ref('Tous')

const filteredPrestations = computed(() => {
  if (selectedStatus.value === 'Tous') {
    return props.prestations
  }
  return props.prestations.filter(p => p.statut === selectedStatus.value)
})

const peutAnnuler = (datePrestation) => {
  const now = new Date()
  const prestationDate = new Date(datePrestation)
  const diffHours = (prestationDate - now) / 1000 / 3600
  return diffHours > 48
}

const annulerPrestation = (id) => {
  if (confirm("Confirmez-vous l'annulation de cette prestation ?")) {
    Inertia.post(`/dashboard/client/prestations/${id}/annuler`)
  }
}
</script>

<template>
  <div class="bg-white min-h-screen font-[Poppins]">
    <Topbar />
    <ClientDashboardHeader />

    <div class="max-w-7xl mx-auto px-6 py-10">
      

      <!-- Filtre Statut -->
      <div class="mb-8 flex items-center">
        <label class="font-semibold text-lg text-[#0b2c7a] mr-3">Statut :</label>
        <select v-model="selectedStatus" class="border p-2 rounded text-[#0b2c7a] bg-white">
          <option value="Tous">Tous</option>
          <option>En cours</option>
          <option>Terminée</option>
          <option>Annulée</option>
        </select>
      </div>

      <table class="min-w-full bg-white shadow rounded">
        <thead>
          <tr class="bg-green-800 text-white">
            <th class="py-3 px-6 text-left">Date</th>
            <th class="py-3 px-6 text-left">Heure</th>
            <th class="py-3 px-6 text-left">Prestataire</th>
            <th class="py-3 px-6 text-left">Montant Payé</th>
            <th class="py-3 px-6 text-left">Statut</th>
            <th class="py-3 px-6 text-left">Actions</th>
          </tr>
        </thead>

        <tbody>
          <tr v-if="filteredPrestations.length === 0">
            <td colspan="5" class="py-6 px-6 text-center text-gray-500">
              Aucune prestation disponible.
            </td>
          </tr>

          <tr v-for="p in filteredPrestations" :key="p.id" class="border-b">
            <td class="py-3 px-6">{{ p.date_prestation }}</td>
            <td class="py-3 px-6">{{ p.heure_prestation }}</td>
            <td class="py-3 px-6">{{ p.prestataire?.nom_Entreprise ?? '---' }}</td>
            <td class="py-3 px-6">{{ p.montant_paye ? p.montant_paye + ' MAD' : '---' }}</td>
            <td class="py-3 px-6">{{ p.statut }}</td>
            <td class="py-3 px-6">
              <button
                v-if="peutAnnuler(p.date_prestation) && p.statut === 'À venir'"
                @click="annulerPrestation(p.id)"
                class="bg-green-800 hover:bg-red-600 text-white px-3 py-1 rounded">
                Annuler
              </button>
            </td>
          </tr>
        </tbody>
      </table>

    </div>

    <MainFooter />
  </div>
</template>
<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
</style>
