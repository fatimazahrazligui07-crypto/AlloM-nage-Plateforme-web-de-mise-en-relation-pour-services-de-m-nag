<template>
  <div class="bg-white font-[Poppins]">
    <Topbar />
    <PrestataireDashboardHeader />

    <!-- Hero Section -->
    <section class="relative bg-cover bg-center bg-no-repeat h-120 flex items-center justify-center text-white"
             style="background-image: url('/hero-gallery.png');">
      <div class="bg-blue-600/50 absolute inset-0"></div>
      <div class="relative z-10 text-center">
        <h1 class="text-4xl font-bold">Galerie</h1>
        <p class="mt-2 text-sm">
          <a href="/" class="hover:underline text-yellow-400">Accueil</a> &nbsp; &gt; &nbsp; Galerie
        </p>
      </div>
    </section>
    <br>
    <br>
    <br>
    <!-- Gallery Section -->
    <section class="relative bg-cover bg-center bg-no-repeat overflow-hidden py-0">
      
      <div class="relative z-10 max-w-7xl mx-auto px-6">

        <!-- Titre -->
        <div class="mb-12 text-center">
          <div class="text-sm uppercase font-semibold text-gray-500 mb-2 flex items-center justify-center gap-2">
            <span class="text-blue-500 text-xl">✨</span> Galerie
          </div>
          <h2 class="text-4xl font-bold text-gray-900">
            Découvrez Les <span class="text-blue-600">réalisations</span> 
          </h2>
        </div>

        <!-- Filtres -->
        <div class="flex justify-center gap-4 mb-12">
          <button @click="filter = 'all'" :class="buttonClass('all')">Voir tout</button>
          <button @click="filter = 'house'" :class="buttonClass('house')">Particuliers</button>
          <button @click="filter = 'office'" :class="buttonClass('office')">Professionnels</button>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-20">
          <div v-for="item in filteredGallery" :key="item.id" class="group relative overflow-hidden rounded-lg shadow-lg">
            <img :src="item.image" alt="Project" class="w-full h-72 object-cover transition-transform duration-300 group-hover:scale-110" />

            <!-- Overlay -->
            <div class="absolute inset-0 bg-yellow-400/50 opacity-0 group-hover:opacity-100 flex flex-col justify-center items-center transition-all duration-300">
              <div class="flex gap-4 mb-4">
                <div class="bg-white rounded-full p-3 text-blue-600 shadow cursor-pointer">
                  <i class="fa fa-picture-o"></i>
                </div>
                <div class="bg-white rounded-full p-3 text-blue-600 shadow cursor-pointer">
                  <i class="fa fa-link"></i>
                </div>
              </div>
              <h3 class="font-bold text-xl text-white">{{ item.title }}</h3>
              <p class="text-white text-sm">{{ item.subtitle }}</p>
            </div>
          </div>
        </div>

      </div>
    </section>

    <MainFooter />
  </div>
</template>

<script setup>
import Topbar from '@/components/Topbar.vue'
import PrestataireDashboardHeader from '@/components/PrestataireDashboardHeader.vue'
import MainFooter from '@/components/MainFooter.vue'
import { ref, computed } from 'vue'

const gallery = [
  { id: 1, image: '/gallery-1.png', category: 'house', title: 'Ménage régulier', subtitle: 'Toilettes' },
  { id: 2, image: '/gallery-2.png', category: 'office', title: 'Ménage industriel', subtitle: 'Nettoyage d’usines' },
  { id: 3, image: '/gallery-3.png', category: 'house', title: 'Nettoyage après fête', subtitle: 'terrasses' },
  { id: 4, image: '/gallery-4.png', category: 'office', title: 'Ménage hôtelier', subtitle: 'Balcons' },
  { id: 5, image: '/gallery-5.png', category: 'office', title: 'Ménage en milieu scolaire', subtitle: 'Crèches' },
  { id: 6, image: '/gallery-6.png', category: 'house', title: 'Ménage résidentiel', subtitle: 'Appartement' }
]

const filter = ref('all')

const filteredGallery = computed(() => {
  if (filter.value === 'all') return gallery
  return gallery.filter(item => item.category === filter.value)
})

const buttonClass = (btn) => {
  return [
    "px-5 py-2 rounded text-sm font-semibold transition",
    filter.value === btn 
      ? "bg-blue-600 text-white" 
      : "bg-gray-100 text-gray-700 hover:bg-yellow-400 hover:text-white"
  ]
}
</script>

<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
</style>