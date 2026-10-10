
<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const isSidebarOpen = ref(false);

const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value;
};

const page = usePage();

const isLinkActive = (routeName) => {
    return page.component.startsWith(`Admin/${routeName}`);
};

// Responsive handling
const handleResize = () => {
  if (window.innerWidth >= 1024) {
    isSidebarOpen.value = true;
  } else {
    isSidebarOpen.value = false;
  }
};

// Lifecycle hooks
import { onMounted, onUnmounted } from 'vue';

onMounted(() => {
  window.addEventListener('resize', handleResize);
  handleResize();
});

onUnmounted(() => {
  window.removeEventListener('resize', handleResize);
});
</script>

<template>
  <div>
    <!-- Hamburger Button -->
    <button 
      @click="toggleSidebar" 
      class="fixed top-4 left-4 z-[60] lg:hidden p-2 rounded-md bg-white/50 hover:bg-white"
    >
      <div class="w-6 h-5 flex flex-col justify-between">
        <span class="w-full h-0.5 bg-gray-800 transform transition-all duration-300" 
              :class="{ 'rotate-45 translate-y-[9px]': isSidebarOpen }"></span>
        <span class="w-full h-0.5 bg-gray-800 transition-all duration-300"
              :class="{ 'opacity-0': isSidebarOpen }"></span>
        <span class="w-full h-0.5 bg-gray-800 transform transition-all duration-300"
              :class="{ '-rotate-45 -translate-y-[9px]': isSidebarOpen }"></span>
      </div>
    </button>
    
    <!-- Sidebar -->
    <aside 
      :class="['fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform transition-transform duration-300', { 'translate-x-0': isSidebarOpen, '-translate-x-full': !isSidebarOpen }]"
      class="lg:translate-x-0"
    >
      <div class="flex items-center justify-center h-16 bg-blue-600">
        <h1 class="text-xl font-bold text-white">ADMIN PANEL</h1>
      </div>
      
      <nav class="mt-8">
        <div class="px-4 py-2">
          <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">ADMIN</p>
        </div>
        
        <div class="mt-2">
          <Link :href="route('admin.dashboard')" 
                :class="['flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100', { 'bg-blue-50 border-r-4 border-blue-500 font-semibold': isLinkActive('Dashboard') }]">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
            </svg>
            Statistiques
          </Link>
        </div>

        <div class="mt-2">
          <p class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">PAGES</p>
          <div class="space-y-1">
            <Link :href="route('admin.users')" 
                  :class="['flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100', { 'bg-blue-50 border-r-4 border-blue-500 font-semibold': isLinkActive('Users') }]">
              <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
              </svg>
              Utilisateurs
            </Link>
            
           
          <Link  href="/dashboard/admin/commission-rules" 
               :class="['flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100', { 'bg-blue-50 border-r-4 border-blue-500 font-semibold': isLinkActive('Services') }]">

    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <circle cx="7" cy="17" r="1.5" stroke="currentColor" stroke-width="2"/>
    <circle cx="17" cy="7" r="1.5" stroke="currentColor" stroke-width="2"/>
    <line x1="6" y1="18" x2="18" y2="6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
  </svg>
                  <span>Gestion Commissions</span>
          </Link>
            <Link :href="route('admin.services.index')" 
                  :class="['flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100', { 'bg-blue-50 border-r-4 border-blue-500 font-semibold': isLinkActive('Services') }]">
              <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v18h18V3H3zm4.5 4.5h3v3h-3v-3zm0 6h3v3h-3v-3zm6-6h3v3h-3v-3zm0 6h3v3h-3v-3z"></path></svg>
               Gestion Services
            </Link>
          </div>
        </div>

         <div class="mt-6">
          <p class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">UTILS</p>
          <div class="space-y-1">
            <Link :href="route('logout')" method="post" as="button" class="w-full flex items-center px-4 py-2 text-red-600 hover:bg-red-50" type="button">
              <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
              </svg>
              Déconnexion
            </Link>
          </div>
        </div>
      </nav>
    </aside>
  </div>
</template> 
