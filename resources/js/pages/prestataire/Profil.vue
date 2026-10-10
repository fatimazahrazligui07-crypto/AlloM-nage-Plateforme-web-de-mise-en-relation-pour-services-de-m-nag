<script setup>
import { ref, onMounted, onBeforeUnmount, defineProps } from 'vue';
import { Head, Link } from '@inertiajs/vue3';

// --- PROPS REÇUES DU CONTRÔLEUR ---
const props = defineProps({
  prestataire: Object,
});


// --- LOGIQUE POUR LA SIDEBAR ---
const isSidebarOpen = ref(false);

const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value;
};

const handleResize = () => {
  isSidebarOpen.value = window.innerWidth >= 1024;
};

onMounted(() => {
  window.addEventListener('resize', handleResize);
  handleResize();
});

onBeforeUnmount(() => {
  window.removeEventListener('resize', handleResize);
});

// --- FONCTIONS UTILITAIRES ---
// Fonction pour mettre la première lettre en majuscule
const capitalize = (s) => {
  if (typeof s !== 'string') return ''
  return s.charAt(0).toUpperCase() + s.slice(1)
}
</script>

<template>
  <Head title="Mon Profil" />

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
            <Link href="/dashboard/prestataire/offres" class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-50" :class="{ 'bg-gray-100 font-semibold': $page.url.startsWith('/dashboard/prestataire/offres') }">
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
            <Link href="/dashboard/prestataire/profil" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50" :class="{ 'bg-blue-50 border-r-4 border-blue-500': $page.url.startsWith('/dashboard/prestataire/profil') }">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
              Profil
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
      
      <header class="mb-8">
          <h1 class="text-2xl font-bold text-gray-900">Mon Profil</h1>
          <p class="text-sm text-gray-600">Consultez les informations de votre entreprise et de votre compte.</p>
      </header>

      <!-- Cartes d'information -->
      <div v-if="prestataire" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Carte Informations Entreprise -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow-sm p-6 border border-gray-200">
          <h3 class="text-lg font-semibold text-gray-900 border-b pb-3 mb-4">Informations sur l'entreprise</h3>
          <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
            <div class="md:col-span-2">
              <dt class="text-sm font-medium text-gray-500">Nom de l'entreprise</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ prestataire.nom_Entreprise || 'Non renseigné' }}</dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500">ICE</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ prestataire.ICE || 'Non renseigné' }}</dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500">Banque</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ prestataire.Bank || 'Non renseigné' }}</dd>
            </div>
            <div class="md:col-span-2">
              <dt class="text-sm font-medium text-gray-500">RIB</dt>
              <dd class="mt-1 text-sm text-gray-900 font-mono">{{ prestataire.RIB || 'Non renseigné' }}</dd>
            </div>
          </dl>
        </div>

        <!-- Carte Contact & Statut -->
        <div class="lg:col-span-1 bg-white rounded-lg shadow-sm p-6 border border-gray-200">
          <h3 class="text-lg font-semibold text-gray-900 border-b pb-3 mb-4">Contact & Statut</h3>
          <dl class="space-y-4">
            <div>
              <dt class="text-sm font-medium text-gray-500">Nom du contact</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ capitalize(prestataire.user.prenom) }} {{ capitalize(prestataire.user.nom) }}</dd>
            </div>
             <div>
              <dt class="text-sm font-medium text-gray-500">Adresse Email</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ prestataire.user.email }}</dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500">Localisation</dt>
              <dd class="mt-1 text-sm text-gray-900">
                {{ capitalize(prestataire.quartier.nom) }}, {{ capitalize(prestataire.quartier.ville.nom) }}
              </dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500">Compte Actif</dt>
              <dd class="mt-1 text-sm">
                <span :class="prestataire.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" class="text-xs font-semibold px-2.5 py-0.5 rounded-full">
                  {{ prestataire.is_active ? 'Oui' : 'Non' }}
                </span>
              </dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500">Compte Vérifié</dt>
              <dd class="mt-1 text-sm">
                 <span :class="prestataire.is_verify ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" class="text-xs font-semibold px-2.5 py-0.5 rounded-full">
                  {{ prestataire.is_verify ? 'Oui' : 'Non' }}
                </span>
              </dd>
            </div>
          </dl>
        </div>

      </div>

    </div>
  </div>
</template>