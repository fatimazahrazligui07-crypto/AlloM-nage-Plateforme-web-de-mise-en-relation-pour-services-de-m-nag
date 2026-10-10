<script setup>
import { ref, onMounted, onBeforeUnmount, defineProps } from 'vue';
import { Head, Link } from '@inertiajs/vue3';

// --- PROPS REÇUES DU CONTRÔLEUR ---
const props = defineProps({
  offres: Array,
});


// --- LOGIQUE POUR LA SIDEBAR (pris de votre dashboard) ---
const isSidebarOpen = ref(false);

const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value;
};

const handleResize = () => {
  // Ouvre la sidebar sur les grands écrans, la ferme sur les petits
  isSidebarOpen.value = window.innerWidth >= 1024; // 'lg' de Tailwind
};

onMounted(() => {
  window.addEventListener('resize', handleResize);
  handleResize(); // Appel initial
});

onBeforeUnmount(() => {
  // Nettoyage pour éviter les fuites de mémoire
  window.removeEventListener('resize', handleResize);
});


// --- FONCTIONS UTILITAIRES ---
const formatDate = (dateString) => {
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  return new Date(dateString).toLocaleDateString('fr-FR', options);
};

const formatCurrency = (value) => {
  return new Intl.NumberFormat('fr-MA', { style: 'currency', currency: 'MAD' }).format(value);
};
</script>

<template>
  <Head title="Mes Offres" />

  <div class="min-h-screen bg-gray-50">
    <!-- Bouton Hamburger -->
    <button @click="toggleSidebar" class="fixed top-4 left-4 z-50 lg:hidden p-2 rounded-md text-gray-600 hover:bg-gray-100">
      <div class="w-6 h-5 flex flex-col justify-between">
        <span class="w-full h-0.5 bg-current transform transition-all duration-300" :class="{ 'rotate-45 translate-y-2': isSidebarOpen }"></span>
        <span class="w-full h-0.5 bg-current transition-all duration-300" :class="{ 'opacity-0': isSidebarOpen }"></span>
        <span class="w-full h-0.5 bg-current transform transition-all duration-300" :class="{ '-rotate-45 -translate-y-2': isSidebarOpen }"></span>
      </div>
    </button>
    
    <!-- Sidebar -->
    <div :class="['fixed', 'inset-y-0', 'left-0', 'z-40', 'w-64', 'bg-white', 'shadow-lg', 'transform', 'transition-transform', 'duration-300', 'ease-in-out', { 'translate-x-0': isSidebarOpen, '-translate-x-full': !isSidebarOpen }, 'lg:translate-x-0']">
      <div class="flex items-center justify-center h-16 bg-blue-600">
        <h1 class="text-xl font-bold text-white">PRESTATAIRE PANEL</h1>
      </div>
      
      <nav class="mt-8">
        <div class="mt-2">
           <Link href="/dashboard/prestataire" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50" :class="{ 'bg-blue-50 border-r-4 border-blue-500': $page.url === '/dashboard/prestataire' }">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path></svg>
             Statistiques
          </Link>
        </div>

        <div class="mt-2">
          <p class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">PAGES</p>
          <div class="space-y-1">
            <Link href="/dashboard/prestataire/offres" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50" :class="{ 'bg-blue-50 border-r-4 border-blue-500': $page.url.startsWith('/dashboard/prestataire/offres') }">
              <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
              Offres
            </Link>
            <Link href="#" class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-50">
               <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path></svg>
              Demandes
            </Link>
            <Link href="#" class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-50">
              <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path></svg>
              Commissions
            </Link>
          </div>
        </div>

        <div class="mt-6">
          <p class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">UTILS</p>
          <div class="space-y-1">
            <Link href="#" class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-50">
              <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
              Paramètres
            </Link>
            <Link href="#" class="flex items-center px-4 py-2 text-red-600 hover:bg-red-50">
              <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
              Déconnexion
            </Link>
          </div>
        </div>
      </nav>
    </div>

    <!-- Contenu Principal -->
    <div class="transition-all duration-300 ease-in-out lg:ml-64 p-6">
      
      <!-- En-tête de la page -->
      <header class="mb-8">
          <h1 class="text-2xl font-bold text-gray-900">Mes Offres</h1>
          <p class="text-sm text-gray-600">Voici la liste de toutes les offres que vous avez envoyées.</p>
      </header>

      <!-- Tableau des offres -->
      <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="overflow-x-auto">
          <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
              <tr>
               <!-- <th scope="col" class="px-6 py-3">Titre de la Demande</th>-->
                <th scope="col" class="px-6 py-3">Prix Proposé</th>
                <th scope="col" class="px-6 py-3">Message</th>
                <th scope="col" class="px-6 py-3">Date d'envoi</th>
                <th scope="col" class="px-6 py-3">Statut</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="!offres || !offres.length">
                  <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                    Vous n'avez envoyé aucune offre pour le moment.
                  </td>
              </tr>
              <tr v-for="offre in offres" :key="offre.id" class="bg-white border-b hover:bg-gray-50">
                <!--<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                  {{ offre.demande ? offre.demande.titre : 'Demande non disponible' }}
                </th>-->
                <td class="px-6 py-4">
                  {{ formatCurrency(offre.prixpropose) }}
                </td>
                <td class="px-6 py-4 max-w-sm truncate">
                  {{ offre.message }}
                </td>
                <td class="px-6 py-4">
                  {{ formatDate(offre.created_at) }}
                </td>
                <td class="px-6 py-4">
                  <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Envoyée</span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</template>