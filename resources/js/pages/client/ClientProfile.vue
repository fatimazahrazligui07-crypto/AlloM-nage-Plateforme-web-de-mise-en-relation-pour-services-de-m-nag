<template>
  <div class="min-h-screen flex flex-col bg-gray-100 text-black">
    <Topbar />
    <ClientDashboardHeader />

    <!-- Contenu principal centré -->
    <main class="flex-grow flex items-center justify-center px-4 py-10">
      <div class="w-full max-w-4xl bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Mon Profil</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Nom :</label>
            <div class="border p-2 rounded">{{ client.nom }}</div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Prénom :</label>
            <div class="border p-2 rounded">{{ client.prenom }}</div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Email :</label>
            <div class="border p-2 rounded">{{ client.email }}</div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Téléphone :</label>
            <div class="border p-2 rounded">{{ client.num_telephone }}</div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Adresse :</label>
            <div class="border p-2 rounded">{{ client.adresse }}</div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Ville :</label>
            <div class="border p-2 rounded">{{ client.ville }}</div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Code postal :</label>
            <div class="border p-2 rounded">{{ client.code_postal }}</div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Date de naissance :</label>
            <div class="border p-2 rounded">{{ client.date_naissance }}</div>
          </div>
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

const props = defineProps({
  client: Object
})
</script>
<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
</style>
