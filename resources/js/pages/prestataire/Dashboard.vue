<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Bouton Hamburger -->
    <button 
      @click="toggleSidebar" 
      class="fixed top-4 left-4 z-50 lg:hidden p-2 rounded-md hover:bg-gray-100"
    >
      <div class="w-6 h-5 flex flex-col justify-between">
        <span class="w-full h-0.5 bg-gray-600 transform transition-all duration-300" 
              :class="{ 'rotate-45 translate-y-2': isSidebarOpen }"></span>
        <span class="w-full h-0.5 bg-gray-600 transition-all duration-300"
              :class="{ 'opacity-0': isSidebarOpen }"></span>
        <span class="w-full h-0.5 bg-gray-600 transform transition-all duration-300"
              :class="{ '-rotate-45 -translate-y-2': isSidebarOpen }"></span>
      </div>
    </button>
    
    <!-- Sidebar -->
    <div 
      :class="['fixed', 'inset-y-0', 'left-0', 'z-40', 'w-64', 'bg-white', 'shadow-lg', 'transform', 'transition-transform', 'duration-300', 'ease-in-out', { 'translate-x-0': isSidebarOpen, '-translate-x-full': !isSidebarOpen }, 'lg:translate-x-0']"
    >
      <div class="flex items-center justify-center h-16 bg-blue-600">
        <h1 class="text-xl font-bold text-white">PRESTATAIRE PANNEAU</h1>
      </div>
      
      <nav class="mt-8">
        
        
        <div class="mt-2">
          <a href="/dashboard/prestataire" class="flex items-center px-4 py-3 text-gray-700 bg-blue-50 border-r-4 border-blue-500">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
            </svg>
             Statistiques
          </a>
        </div>

        <div class="mt-2">
          <p class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">PAGES</p>
          <div class="space-y-1">
            <a href="/dashboard/prestataire/offres" class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-50">
              <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
              Offres
            </a>
            <a href="/dashboard/prestataire/demandes" class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-50">
               <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
              </svg>
              Demandes
            </a>
            <a href="#" class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-50">
              <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
              </svg>
              Commissions
            </a>
            <!-- <a href="#" class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-50">
              <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
              </svg>
              Statistiques
            </a> -->
          </div>
        </div>

        <div class="mt-6">
          <p class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">UTILS</p>
          <div class="space-y-1">
            <a href="/dashboard/prestataire/profil" class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-50">
              <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
              </svg>
              Profil
            </a>
            <a href="\" class="flex items-center px-4 py-2 text-red-600 hover:bg-red-50">
              <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
              </svg>
              Déconnexion
            </a>
          </div>
        </div>
      </nav>
    </div>

    <!-- Main Content -->
    <div class="transition-all duration-300 ease-in-out lg:ml-64 p-6">
      <!-- Header -->
      <header class="mb-8">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-bold text-gray-900">Tableau de bord</h1>
            <p class="text-sm text-gray-600">Bienvenue sur votre panel prestataire</p>
          </div>
          <div class="flex items-center space-x-4">
           
            
          </div>
        </div>
      </header>

      <!-- Stats Cards -->
      <div v-if="stats" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">Total Offres</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.totalOffres }}</p>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
              <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">Total Demandes</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.totalDemandes }}</p>
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
              <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
              </svg>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">Commissions</p>
              <p class="text-2xl font-bold text-gray-900">{{ formatCurrency(stats.totalCommissions) }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
              <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
              </svg>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</template>

<script>
// Il est probable que vous utilisiez Inertia.js, donc j'importe le composant Link.
// Si ce n'est pas le cas, vous pouvez retirer cet import et le composant dans 'components'.
import { Link } from '@inertiajs/vue3';

export default {
  components: {
    Link,
  },
  props: {
    // Les données statistiques sont passées en tant que props,
    // comme dans votre exemple du dashboard Admin.
    stats: {
      type: Object,
      default: () => ({
        totalOffres: 0,
        totalDemandes: 0,
        totalCommissions: 0,
      })
    }
  },
  data() {
    return {
      // Gère l'état d'ouverture/fermeture de la sidebar sur mobile
      isSidebarOpen: false 
    }
  },
  methods: {
    // Méthode pour formater les montants en devise (MAD)
    formatCurrency(amount) {
      if(typeof amount !== 'number') {
        return '';
      }
      return new Intl.NumberFormat('fr-MA', {
        style: 'currency',
        currency: 'MAD',
        minimumFractionDigits: 2
      }).format(amount)
    },
    // Méthode pour basculer la visibilité de la sidebar
    toggleSidebar() {
      this.isSidebarOpen = !this.isSidebarOpen
    }
  },
  mounted() {
    // Gère l'affichage de la sidebar en fonction de la taille de l'écran
    const handleResize = () => {
      if (window.innerWidth >= 1024) { // lg breakpoint
        this.isSidebarOpen = true;
      } else {
        this.isSidebarOpen = false;
      }
    };

    window.addEventListener('resize', handleResize);
    // Appelle la fonction une première fois au chargement
    handleResize();

    // Nettoie l'écouteur d'événement quand le composant est détruit
    this.$once('hook:beforeDestroy', () => {
      window.removeEventListener('resize', handleResize);
    });
  }
}
</script>

<style scoped>
/* Vous pouvez ajouter ici des styles spécifiques si nécessaire */
</style>