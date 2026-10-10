<script setup>
import Topbar from '@/components/Topbar.vue'
import ClientDashboardHeader from '@/components/ClientDashboardHeader.vue'
import MainFooter from '@/components/MainFooter.vue'
import { router } from '@inertiajs/inertia'
import { ref } from 'vue'
import { Link } from '@inertiajs/inertia-vue3'
import { useForm } from '@inertiajs/vue3'

const isPaiementModalOpen = ref(false)
const paiementForm = useForm({
  offre_id: null,
  montant: 0,
})
const props = defineProps({
  offres: Array
})

function annulerOffre(id) {
  if (confirm("Voulez-vous vraiment annuler cette offre ?")) {
    router.delete(`/dashboard/client/offres/${id}/annuler`)
  }
}

function ouvrirPaiementModal(offre) {
  paiementForm.offre_id = offre.id
  paiementForm.montant = offre.prixpropose
  isPaiementModalOpen.value = true
}

function fermerPaiementModal() {
  isPaiementModalOpen.value = false
  paiementForm.reset()
  paiementForm.clearErrors()
}

function submitPaiement() {
  paiementForm.post('/dashboard/client/paiement', {
    onSuccess: () => fermerPaiementModal(),
  })
}
</script>

<template>
  <div class="bg-white min-h-screen font-[Poppins]">
    <Topbar />
    <ClientDashboardHeader />

    <div class="max-w-7xl mx-auto px-6 py-10 text-black">
      <h1 class="text-3xl font-bold mb-8">Mes Offres Reçues</h1>

      <div v-if="!offres || offres.length === 0" class="text-center py-12">
        <div class="bg-gray-50 rounded-lg p-8">
          <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
          <h3 class="text-lg font-medium text-black mb-2">Aucune offre reçue</h3>
          <p class="text-gray-700">Vous n'avez pas encore reçu d'offres pour vos demandes.</p>
          <Link href="/dashboard/client/demandesform/create" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
            Créer une nouvelle demande
          </Link>
        </div>
      </div>

      <table v-else class="min-w-full bg-white shadow rounded text-black">
        <thead>
         <tr class="bg-red-500 text-white">
            <th class="py-3 px-6 text-left text-white">Demande</th>
            <th class="py-3 px-6 text-left text-white">Prestataire</th>
            <th class="py-3 px-6 text-left text-white">Montant</th>
            <th class="py-3 px-6 text-left text-white">Date d'offre</th>
            <th class="py-3 px-6 text-left text-white">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="offre in offres" :key="offre.id" class="border-b text-black">
            <td class="py-3 px-6 text-black">{{ offre.id_demande }}</td>
            <td class="py-3 px-6 text-black">
              <div>
                <div class="font-medium text-black">{{ offre.prestataire_prenom }} {{ offre.prestataire_nom }}</div>
                <div class="text-sm text-gray-700">{{ offre.nom_Entreprise }}</div>
                <div v-if="offre.is_verify" class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                  ✓ Vérifié
                </div>
              </div>
            </td>
            <td class="py-3 px-6 text-black">{{ offre.prixpropose }} MAD</td>
            <td class="py-3 px-6 text-black">{{ new Date(offre.created_at).toLocaleDateString() }}</td>
            <td class="py-3 px-6 flex gap-3 text-black">
              <button class="bg-green-500 text-white px-3 py-1 rounded" @click="ouvrirPaiementModal(offre)">
                Accepter
              </button>
              <button class="bg-red-500 text-white px-3 py-1 rounded" @click="annulerOffre(offre.id)">Annuler</button>
            </td>
          </tr>
        </tbody>
      </table>

      <teleport to="body">
        <div v-if="isPaiementModalOpen" class="fixed inset-0 z-50 flex items-center justify-center">
          <div class="absolute inset-0 bg-gray-500 opacity-50"></div>
          <div class="relative z-50 bg-white rounded-lg shadow-xl p-6 w-full max-w-lg text-black">
            <form @submit.prevent="submitPaiement">
              <h3 class="text-lg font-medium mb-4 text-black">Paiement de l'offre</h3>
              <div class="mb-4">
                <label class="block text-sm font-medium text-black">Montant à payer</label>
                <input v-model="paiementForm.montant" type="number" class="mt-1 block w-full border rounded text-black" readonly>
              </div>
              <div class="flex justify-end space-x-2 mt-6">
                <button @click="fermerPaiementModal" type="button" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Annuler</button>
                <button type="submit" :disabled="paiementForm.processing" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                  Payer
                </button>
              </div>
            </form>
          </div>
        </div>
      </teleport>
    </div>

    <MainFooter />
  </div>
</template>
<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
</style>