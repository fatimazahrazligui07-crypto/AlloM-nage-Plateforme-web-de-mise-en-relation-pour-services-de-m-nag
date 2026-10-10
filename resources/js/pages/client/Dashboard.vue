<template>
  <div class="min-h-screen flex flex-col bg-gray-50">
    <Topbar />
    <ClientDashboardHeader />
    <!-- CONTENU DU DASHBOARD -->
    <main class="mt-10 p-8 bg-gray-50 ">

      <!-- Bienvenue -->
      <div class="mb-10 bg-white p-12 rounded-lg shadow flex justify-between items-center">
        <div>
          <h1 class="text-3xl font-bold text-gray-800">Bienvenue sur votre espace client</h1>
          <p class="text-gray-500 mt-2">Gérez l'ensemble de vos demandes, prestations, offres et paiements depuis un espace centralisé, simple et sécurisé.</p>
        </div>
        
      </div>


      <!-- Offres récentes -->
      <div v-if="offres && offres.length > 0" class="mb-8 bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
          <h2 class="text-xl font-semibold text-gray-900">Offres récentes</h2>
          <p class="text-sm text-gray-600 mt-1">Les dernières offres reçues pour vos demandes</p>
        </div>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prestataire</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Localisation</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix proposé</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="offre in offres" :key="offre.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                      <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                        <span class="text-sm font-medium text-gray-700">
                          {{ (offre.prestataire_prenom?.charAt(0) || '') + (offre.prestataire_nom?.charAt(0) || '') }}
                        </span>
                      </div>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">
                        {{ offre.prestataire_prenom }} {{ offre.prestataire_nom }}
                      </div>
                      <div class="text-sm text-gray-500">{{ offre.nom_Entreprise }}</div>
                      <div v-if="offre.is_verify" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        ✓ Vérifié
                      </div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ offre.ville }}</div>
                  <div class="text-sm text-gray-500">{{ offre.quartier }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">{{ offre.prixpropose }} MAD</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ formatDate(offre.created_at) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <Link :href="`/dashboard/client/offres`" class="text-blue-600 hover:text-blue-900 mr-3">
                    Voir détails
                  </Link>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
          <Link href="/dashboard/client/offres" class="text-sm font-medium text-blue-600 hover:text-blue-500">
            Voir toutes les offres →
          </Link>
        </div>
      </div>

      <!-- Les 3 blocs du dashboard -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        <!-- Bloc Demandes -->
        <!-- <div class="bg-blue-100 p-6 rounded-lg shadow hover:shadow-lg transition">
          <h2 class="text-xl font-semibold text-blue-800 mb-4">Gérez vos demandes </h2>
          <p class="text-gray-600 mb-6">Créez, suivez et consultez vos demandes de prestations de ménage en toute simplicité.</p>
          <Link href="/demandes" class="bg-blue-800 text-white px-4 py-2 rounded hover:bg-blue-900 transition">
            Accéder
          </Link>
        </div> -->
        <div class="bg-yellow-100 p-6 rounded-lg shadow hover:shadow-lg transition">
          <h2 class="text-xl font-semibold text-yellow-800 mb-4">Gérez vos demandes </h2>
          <p class="text-gray-600 mb-6">Créez, suivez et consultez vos demandes de prestations de ménage en toute simplicité.</p>
          <Link href="/dashboard/client/demandes" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">
            Accéder
          </Link>
        </div>

        <!-- Bloc Prestations -->
        <div class="bg-green-100 p-6 rounded-lg shadow hover:shadow-lg transition">
          <h2 class="text-xl font-semibold text-green-800 mb-4">Visualisez l'avancement de vos prestations</h2>
          <p class="text-gray-600 mb-6">Suivez en temps réel l'état d'avancement de vos prestations réservées, et accédez à l'historique complet de vos paiements</p>
          <Link href="/dashboard/client/prestations" class="bg-green-800 text-white px-4 py-2 rounded hover:bg-green-900 transition">
            Suivre
          </Link>
        </div>

        <!-- Bloc Paiements
        <div class="bg-yellow-100 p-6 rounded-lg shadow hover:shadow-lg transition">
          <h2 class="text-xl font-semibold text-yellow-800 mb-4">Consultez vos paiements et vos factures</h2>
          <p class="text-gray-600 mb-6">Accédez à l'historique complet de vos paiements, téléchargez vos factures et gérez votre facturation en toute autonomie.</p>
          <Link href="/paiements" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">
            Voir mes paiements
          </Link>
        </div> -->

        <!-- Bloc offres -->
        <div class="bg-red-100 p-6 rounded-lg shadow hover:shadow-lg transition">
          <h2 class="text-xl font-semibold text-red-800 mb-4">Consultez vos offres disponibles</h2>
          <p class="text-gray-600 mb-6">Retrouvez l'historique de vos offres et profitez des services adaptés à vos besoins de ménage.</p>
          <Link href="/dashboard/client/offres" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
            Voir mes offres
          </Link>
        </div>

      </div>

    </main>

    <MainFooter />
  </div>
</template>

<script setup>
import Topbar from '@/components/Topbar.vue'
import ClientDashboardHeader from '@/components/ClientDashboardHeader.vue'
import MainFooter from '@/components/MainFooter.vue'
import { ref, onMounted, onUnmounted } from 'vue'
import { Link } from '@inertiajs/inertia-vue3'
import { User } from 'lucide-vue-next'

const props = defineProps({
  user: Object,
  demandes: Array,
  offres: Array,
  stats: Object,
  typesServices: Array
})

const showDropdown = ref(false)
const isScrolled = ref(false)

const toggleDropdown = () => { showDropdown.value = !showDropdown.value }
const handleScroll = () => { isScrolled.value = window.scrollY > 50 }

onMounted(() => { window.addEventListener('scroll', handleScroll) })
onUnmounted(() => { window.removeEventListener('scroll', handleScroll) })

// Fonction pour formater la date
const formatDate = (dateString) => {
  if (!dateString) return '';
  return new Date(dateString).toLocaleDateString('fr-FR', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  });
};
</script>
