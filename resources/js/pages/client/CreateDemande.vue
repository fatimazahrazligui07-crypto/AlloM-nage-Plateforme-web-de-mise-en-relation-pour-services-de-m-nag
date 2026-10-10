<script setup>
import { ref, onMounted, watch } from 'vue'
import { useForm } from '@inertiajs/inertia-vue3'
import ClientDashboardHeader from '@/components/ClientDashboardHeader.vue'
import Topbar from '@/components/Topbar.vue'
import MainFooter from '@/components/MainFooter.vue'

const form = useForm({
  nbr_perstataires: '',
  sexe: '',
  age: '',
  ville_id: '',  // Utilisation de ville_id pour stocker l'id de la ville
  quartier_id: '',  // Utilisation de quartier_id pour stocker l'id du quartier
  produit: false,
  duree: '',
  date: '',
  change_deco: false,
    id_service: '' // <-- important !
})

const services = ref([]) // charge la liste des services pour le select
const villes = ref([])
const quartiers = ref([])
const isLoadingQuartiers = ref(false)
 // Récupérer le service_id de l'URL si présent
onMounted(() => {
  const params = new URLSearchParams(window.location.search)
  const serviceId = params.get('service_id')
  if (serviceId) {
    form.id_service = serviceId
  }
  // ... charger la liste des services ici si besoin ...
})

// Charger les villes depuis l'API au montage du composant
onMounted(async () => {
  try {
    const response = await fetch('/api/villes')
    const data = await response.json()
    if (data && data.data) {
      villes.value = data.data
    }
  } catch (error) {
    console.error('Erreur lors du chargement des villes:', error)
  }
})

// Surveiller le changement de ville pour charger les quartiers
watch(() => form.ville_id, async (newVilleId) => {
  if (newVilleId) {
    isLoadingQuartiers.value = true
    form.quartier_id = '' // Réinitialiser la sélection du quartier
    
    try {
      const response = await fetch(`/api/villes/${newVilleId}/quartiers`)
      const data = await response.json()
      if (data && data.data) {
        quartiers.value = data.data
      }
    } catch (error) {
      console.error('Erreur lors du chargement des quartiers:', error)
    } finally {
      isLoadingQuartiers.value = false
    }
  } else {
    quartiers.value = []
    form.quartier_id = ''
  }
})
</script>

<template>
  <Head title="Demande du service" />
  <div class="bg-white font-[Poppins]">
    <Topbar />
    <ClientDashboardHeader />

    <div class="max-w-7xl mx-auto px-6 py-10">
<form @submit.prevent="form.post('/client/demandes')">        
  <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
          <!-- Champ nombre de prestataires -->
          <div>
            <label class="block text-sm font-medium text-black">Nombre de Prestataires</label>
            <input v-model="form.nbr_perstataires" type="number" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-[#0b2c7a]" />
          </div>

          <!-- Champ sexe -->
          <div>
            <label class="block text-sm font-medium text-black">Sexe</label>
            <select v-model="form.sexe" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-black p-2">              <option value="Homme">Homme</option>
              <option value="Femme">Femme</option>
            </select>
          </div>
          <!-- Champ âge -->
<div>
  <label class="block text-sm font-medium text-black">Âge</label>
  <input
    v-model="form.age"
    type="number"
    min="0"
    placeholder="Âge"
    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-black p-2"
  />
</div>

          <!-- Champ ville -->
          <div>
            <label class="block text-sm font-medium text-black">Ville</label>
            <select v-model="form.ville_id" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-[#0b2c7a]">
              <option value="">Sélectionnez une ville</option>
              <option v-for="ville in villes" :key="ville.id" :value="ville.id">{{ ville.nom_ville }}</option>
            </select>
          </div>

          <!-- Champ quartier -->
          <div>
            <label class="block text-sm font-medium text-black">Quartier</label>
            <select v-model="form.quartier_id" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-black p-2" :disabled="isLoadingQuartiers">              <option value="">Sélectionnez un quartier</option>
              <option v-for="quartier in quartiers" :key="quartier.id" :value="quartier.id">{{ quartier.nom_quartier }}</option>
            </select>
          </div>

          <!-- Champ produit -->
          <div>
            <label class="block text-sm font-medium text-black">Produit</label>
            <input v-model="form.produit" type="checkbox" class="mt-1"/>
          </div>

          <!-- Champ durée -->
          <div>
            <label class="block text-sm font-medium text-black">Durée</label>
            <input v-model="form.duree" type="number" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-black p-2"/>
          </div>

          <!-- Champ date -->
          <div>
            <label class="block text-sm font-medium text-black">Date</label>
            <input v-model="form.date" type="date" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-black p-2"/>
          </div>


          <!-- Champ changement de décoration -->
          <div>
            <label class="block text-sm font-medium text-black">Changer la décoration</label>
            <input v-model="form.change_deco" type="checkbox" class="mt-1"/>
          </div>
        </div>

        <div class="mt-6 flex justify-end">
          <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-4 py-2 rounded-full transition duration-300">
            Soumettre la Demande
          </button>
        </div>
      </form>
    </div>

    <MainFooter />
  </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

.bg-gradient {
  background: linear-gradient(45deg, #007bff, #facc15);
}

input, select {
  background-color: #f3f9f7;  /* Fond légèrement gris clair pour les champs */
  border-radius: 8px;  /* Bordure arrondie */
  color: #000000; /* Couleur du texte en noir */
  font-size: 14px; /* Taille de police confortable */
  padding: 12px;  /* Un peu plus d'espace à l'intérieur des champs */
  transition: all 0.3s ease;
}

input:focus, select:focus {
  border-color: #facc15;  /* Changer la bordure en jaune lors du focus */
  box-shadow: 0 0 8px rgba(250, 204, 21, 0.5);  /* Légère ombre jaune pour l'effet de focus */
}
</style>