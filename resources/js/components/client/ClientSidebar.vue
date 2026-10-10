<script setup>
import { Home, FileText, Clock, User, Plus, LogOut } from 'lucide-vue-next';

const emit = defineEmits(['changeTab', 'logout']);
const props = defineProps({
  activeTab: String
});
</script>

<template>
  <div class="w-64 bg-white shadow-lg h-full">
    <div class="flex items-center justify-center h-16 bg-[#0b2c7a] text-white text-xl font-bold">Dashboard Client</div>

    <nav class="mt-8 space-y-2 px-4">
      <button @click="$emit('changeTab','dashboard')" :class="btnClass('dashboard')">
        <Home class="w-5 h-5 mr-3" /> Tableau de bord
      </button>
      <button @click="$emit('changeTab','nouvelle-demande')" :class="btnClass('nouvelle-demande')">
        <Plus class="w-5 h-5 mr-3" /> Nouvelle demande
      </button>
      <button @click="$emit('changeTab','demandes')" :class="btnClass('demandes')">
        <FileText class="w-5 h-5 mr-3" /> Mes demandes
      </button>
      <button @click="$emit('changeTab','prestations')" :class="btnClass('prestations')">
        <Clock class="w-5 h-5 mr-3" /> Historique
      </button>
      <button @click="$emit('changeTab','profil')" :class="btnClass('profil')">
        <User class="w-5 h-5 mr-3" /> Mon profil
      </button>
    </nav>

    <div class="absolute bottom-4 w-full px-4">
      <button @click="$emit('logout')" class="w-full flex items-center px-4 py-2 text-red-600 bg-red-50 rounded-lg hover:bg-red-100">
        <LogOut class="w-5 h-5 mr-3" /> Déconnexion
      </button>
    </div>
  </div>
</template>

<script>
function btnClass(tab) {
  return ['flex items-center px-4 py-2 rounded-lg transition-colors w-full',
          props.activeTab === tab ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100'];
}
</script>
