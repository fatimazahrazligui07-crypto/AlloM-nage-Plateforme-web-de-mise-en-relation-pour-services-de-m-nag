<script setup>
import { ref, watch } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import Sidebar from '@/components/Admin/Sidebar.vue';
import '../../../css/global.css'
const props = defineProps({
  users: Object,
  filters: Object
});

const search = ref(props.filters.search);
const roleFilter = ref(props.filters.role || 'tous');

watch(search, debounce((value) => {
  applyFilters();
}, 300));

function applyFilters() {
  router.get('/dashboard/admin/users', {
    search: search.value,
    role: roleFilter.value === 'tous' ? null : roleFilter.value,
  }, {
    preserveState: true,
    replace: true,
  });
}

function setRoleFilter(role) {
  roleFilter.value = role;
  applyFilters();
}

const toggleStatus = (userId) => {
  if (confirm('Voulez-vous vraiment changer le statut de cet utilisateur ?')) {
    router.put(`/dashboard/admin/users/${userId}/toggle-status`, {}, { preserveScroll: true });
  }
};

const toggleVerification = (userId) => {
    if(confirm('Voulez-vous changer le statut de vérification de ce prestataire ?')) {
        router.put(`/dashboard/admin/users/${userId}/toggle-verification`, {}, { preserveScroll: true });
    }
};

const deleteUser = (userId) => {
  if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
    router.delete(`/dashboard/admin/users/${userId}`, { preserveScroll: true });
  }
};
</script>

<template>
  <div class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
   <Sidebar />

    <!-- Main Content -->
    <main class="ml-64 flex-1 p-6">
      <!-- En-tête -->
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-black">Utilisateurs</h1>
        
      </div>

      <!-- Barre de filtres -->
      <div class="bg-white p-4 rounded-t-lg border-b flex justify-between items-center">
        <div class="flex items-center gap-4">
            <input 
              v-model="search" 
              type="text" 
              placeholder="Filtrer par nom, email..."
              class="border rounded px-3 py-1.5 text-black"
            />
            <div class="flex gap-2">
                <button @click="setRoleFilter('tous')" :class="{'bg-blue-500 text-white': roleFilter === 'tous'}" class="px-3 py-1 rounded text-sm text-gray-700">Tous</button>
                <button @click="setRoleFilter('client')" :class="{'bg-blue-500 text-white': roleFilter === 'client'}" class="px-3 py-1 rounded text-sm text-gray-700">Clients</button>
                <button @click="setRoleFilter('prestataire')" :class="{'bg-blue-500 text-white': roleFilter === 'prestataire'}" class="px-3 py-1 rounded text-sm text-gray-700">Prestataires</button>
            </div>
        </div>
      </div>

      <!-- Tableau des utilisateurs -->
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-b-lg">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Nom complet</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Courriel</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Rôle</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Actif</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Vérifié</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <tr v-for="user in users.data" :key="user.id">
              <td class="px-6 py-4 whitespace-nowrap text-black">{{ user.prenom }} {{ user.nom }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-black">{{ user.email }}</td>
              <td class="px-6 py-4 whitespace-nowrap capitalize text-black">{{ user.role }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span v-if="user.status" class="text-green-600">✔️</span>
                <span v-else class="text-red-600">❌</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span v-if="user.role === 'prestataire'">
                    <span v-if="user.is_verify" class="text-green-600 font-bold">Oui</span>
                    <span v-else class="text-orange-500 font-bold">Non</span>
                </span>
                <span v-else class="text-gray-400">N/A</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                <button class="text-blue-600 hover:text-blue-800" title="Modifier">✏️</button>
                <button @click="toggleStatus(user.id)" class="text-yellow-600 hover:text-yellow-800" title="Activer/Désactiver">
                  <span v-if="user.status">🔒</span>
                  <span v-else>🔓</span>
                </button>
                <button v-if="user.role === 'prestataire'" @click="toggleVerification(user.id)" class="text-teal-600 hover:text-teal-800" title="Vérifier/Dévérifier">
                    <span v-if="!user.is_verify">👍</span>
                    <span v-else>👎</span>
                </button>
                <button @click="deleteUser(user.id)" class="text-red-600 hover:text-red-800" title="Supprimer">🗑️</button>
              </td>
            </tr>
            <tr v-if="users.data.length === 0">
                <td colspan="6" class="px-6 py-4 text-center text-gray-500">Aucun utilisateur trouvé.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</template>