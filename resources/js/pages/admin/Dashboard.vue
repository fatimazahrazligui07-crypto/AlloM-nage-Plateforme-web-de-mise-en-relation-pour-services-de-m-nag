<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Sidebar -->
      <Sidebar />

    <!-- Main Content -->
    <div class="ml-64 p-6">
      <!-- Header -->
      <div class="mb-8">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-sm text-gray-600">Bienvenue dans votre panel d'administration</p>
          </div>
          <div class="flex items-center space-x-4">
           <div class="relative">
              <input type="text" placeholder="Rechercher..." class="w-64 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
              <svg class="absolute right-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
              </svg>
            </div>
            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
              <span class="text-white text-sm font-medium">A</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex justify-center items-center h-64">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
      </div>

      <!-- Stats Cards -->
      <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">Total Utilisateurs</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.totalUsers }}</p>
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
              <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
              </svg>
            </div>
          </div>
          <div class="flex items-center mt-4">
            <span class="text-sm text-orange-600 bg-orange-100 px-2 py-1 rounded">
              {{ stats.activeUsers }} actifs
            </span>
          </div>
        </div>


        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">Total Offres</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.totalOffers }}</p>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
              <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
            </div>
          </div>
          <div class="flex items-center mt-4">
            <span class="text-sm text-red-600 bg-red-100 px-2 py-1 rounded">
              En cours
            </span>
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
          <div class="flex items-center mt-4">
            <span class="text-sm text-green-600 bg-green-100 px-2 py-1 rounded">
              +15.3% ce mois
            </span>
          </div>
        </div>

         <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">Activité</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.activeUsers }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
              <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
              </svg>
            </div>
          </div>
          <!-- Growth Rate -->
      <div v-if="stats.growthRate !== undefined" class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <div class="flex items-center justify-between">
          <p class="text-sm font-medium text-gray-600">Croissance des Commissions</p>
          <p class="text-2xl font-bold text-gray-900">
            <span :class="{'text-green-600': stats.growthRate > 0, 'text-red-600': stats.growthRate < 0}">
              {{ stats.growthRate }}%
            </span>
          </p>
        </div>
      </div>
          <div class="flex items-center mt-4">
            <span class="text-sm text-blue-600 bg-blue-100 px-2 py-1 rounded">
              Utilisateurs en ligne
            </span>
          </div>
        </div>
      </div>
      <!-- Charts Section -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Utilisateurs par mois</h3>
          </div>
          <div class="h-64 flex items-end justify-between space-x-2">
            <div v-for="(month, index) in monthlyUsersChart" :key="index" class="flex flex-col items-center">
              <div class="bg-blue-500 rounded-t" :style="{ height: `${(month.count / maxMonthlyUsers) * 200}px`, width: '24px' }"></div>
              <span class="text-xs text-gray-500 mt-2">{{ getMonthName(month.month) }}</span>
            </div>
          </div>
        </div>
         <!-- Revenue Chart -->
       
        
      </div>    
      <!-- Recent Activity -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Activité récente</h3>
    </div>
    <div class="p-6">
        <div class="space-y-4">
            <!-- Nouveaux utilisateurs -->
            <div v-for="activity in recentActivities.newUsers" :key="activity.id" class="flex items-center space-x-4">
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">{{ activity.message }}</p>
                    <p class="text-sm text-gray-500">{{ activity.time }}</p>
                </div>
            </div>

            <!-- Nouvelles commissions -->
            <div v-for="activity in recentActivities.newCommissions" :key="activity.id" class="flex items-center space-x-4">
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">{{ activity.message }} ({{ formatCurrency(activity.amount) }})</p>
                    <p class="text-sm text-gray-500">{{ activity.time }}</p>
                </div>
            </div>

            <!-- Nouvelles offres -->
            <div v-for="activity in recentActivities.newOffers" :key="activity.id" class="flex items-center space-x-4">
                <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">{{ activity.message }} - {{ activity.title }}</p>
                    <p class="text-sm text-gray-500">{{ activity.time }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
      
      </div>
      
    </div>
    
  
</template>

<script>
import { Link } from '@inertiajs/vue3';
import Sidebar from '@/components/Admin/Sidebar.vue';
import '../../../css/global.css'
export default {
  // 2. DÉCLARER LE COMPOSANT LINK POUR POUVOIR L'UTILISER
  components: {
    Link,
    Sidebar,

  },
  props: {
    stats: Object,
    charts: Object,
    recentActivities: Object
  },
  data() {
    return {
      isSidebarOpen: false  // Ajout uniquement de cette propriété
    }
  },
  computed: {
    monthlyUsersChart() {
      return this.charts.monthlyUsers || []
    },
    maxMonthlyUsers() {
      return Math.max(...this.monthlyUsersChart.map(m => m.count), 1)
    }
  },
  methods: {
    formatCurrency(amount) {
      return new Intl.NumberFormat('fr-MA', {
        style: 'currency',
        currency: 'MAD',
        minimumFractionDigits: 2
      }).format(amount)
    },
    getMonthName(monthNumber) {
      const months = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc']
      return months[monthNumber - 1] || ''
    },
    // Ajout de la méthode pour le toggle du sidebar
    toggleSidebar() {
      this.isSidebarOpen = !this.isSidebarOpen
    }
  },
 mounted() {
    // Gestion du responsive
    const handleResize = () => {
      if (window.innerWidth >= 1024) {
        this.isSidebarOpen = true
      } else {
        this.isSidebarOpen = false
      }
    }
    window.addEventListener('resize', handleResize)
    handleResize()
    this.$once('hook:beforeDestroy', () => {
      window.removeEventListener('resize', handleResize)
    })
  }
}
</script>

<style scoped>
/* Styles for the dashboard */
</style>
