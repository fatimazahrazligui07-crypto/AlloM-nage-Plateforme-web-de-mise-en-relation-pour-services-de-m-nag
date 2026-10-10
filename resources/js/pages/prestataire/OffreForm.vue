<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
  demande: Object
});

const form = useForm({
  demande_id: props.demande.id,
  prixpropose: '',
  message: ''
});

// Sidebar logic
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
</script>

<template>
  <Head title="Soumettre une offre" />
  <div class="min-h-screen bg-gray-50">
    <!-- Sidebar et bouton hamburger -->
    <button @click="toggleSidebar" class="fixed top-4 left-4 z-50 lg:hidden p-2 rounded-md text-gray-600 hover:bg-gray-100">
      <div class="w-6 h-5 flex flex-col justify-between">
        <span class="w-full h-0.5 bg-current transform transition-all duration-300" :class="{ 'rotate-45 translate-y-2': isSidebarOpen }"></span>
        <span class="w-full h-0.5 bg-current transition-all duration-300" :class="{ 'opacity-0': isSidebarOpen }"></span>
        <span class="w-full h-0.5 bg-current transform transition-all duration-300" :class="{ '-rotate-45 -translate-y-2': isSidebarOpen }"></span>
      </div>
    </button>
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
            <Link href="/dashboard/prestataire/demandes" class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-50" :class="{ 'bg-gray-100 font-semibold': $page.url.startsWith('/dashboard/prestataire/demandes') }">
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

    <!-- Contenu principal -->
    <div class="transition-all duration-300 ease-in-out lg:ml-64 p-6">
      <header class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Soumettre une offre</h1>
        <p class="text-sm text-gray-600">Remplissez le formulaire pour répondre à la demande <span class="font-semibold">#{{ demande.id }}</span>.</p>
      </header>
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 max-w-xl mx-auto p-6">
        <div class="mb-6 p-4 bg-gray-100 rounded text-gray-700">
          <div class="mb-1"><span class="font-semibold">Ville :</span> {{ demande.ville }}</div>
          <div class="mb-1"><span class="font-semibold">Quartier :</span> {{ demande.quartier }}</div>
          <div><span class="font-semibold">Date :</span> {{ demande.date }}</div>
        </div>
        <form @submit.prevent="form.post('/dashboard/prestataire/offres')">
          <div class="mb-5">
            <label class="block mb-2 text-gray-800 font-semibold">Prix proposé (MAD)</label>
            <input v-model="form.prixpropose" type="number" class="border border-gray-300 rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required />
            <div v-if="form.errors.prixpropose" class="text-red-600 text-xs mt-1">{{ form.errors.prixpropose }}</div>
          </div>
          <div class="mb-5">
            <label class="block mb-2 text-gray-800 font-semibold">Message</label>
            <textarea v-model="form.message" class="border border-gray-300 rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" rows="4" required></textarea>
            <div v-if="form.errors.message" class="text-red-600 text-xs mt-1">{{ form.errors.message }}</div>
          </div>
          <input type="hidden" :value="form.demande_id" name="demande_id" />
          <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded font-semibold hover:bg-green-700 transition" :disabled="form.processing">
            Envoyer l'offre
          </button>
        </form>
      </div>
    </div>
  </div>
</template>