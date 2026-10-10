<template>
  <div class="bg-white font-[Poppins]">
    <Topbar />
    <PrestataireDashboardHeader />
     <!-- Hero Section -->
    <section class="relative bg-cover bg-center bg-no-repeat h-120 flex items-center justify-center text-white"
             style="background-image: url('/hero-gallery.png');">
      <div class="bg-blue-600/50 absolute inset-0"></div>
      <div class="relative z-10 text-center">
        <h1 class="text-4xl font-bold">Témoignages</h1>
        <p class="mt-2 text-sm">
          <a href="/" class="hover:underline text-yellow-400">Accueil</a> &nbsp; &gt; &nbsp; Témoignages
        </p>
      </div>
    </section>
    <!-- Section Témoignages avec fond et voile inspiré -->
    <section>
      <div class="">
        <div class="max-w-7xl mx-auto px-6 py-20 flex flex-col items-center justify-center">

          <!-- Titre -->
          <div class="mb-12 text-center">
            <div class="text-sm uppercase font-semibold text-gray-500 mb-2 flex items-center justify-center gap-2">
              <span class="text-blue-500 text-xl">✨</span> Témoignages
            </div>
            <h2 class="text-4xl font-bold text-gray-900">
              Ce que nos <span class="text-blue-600">clients</span> disent de nous !
            </h2>
          </div>

          <!-- Grille globale des témoignages -->
          <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">

            <!-- Témoignage 1 -->
            <div class="bg-white p-6 rounded-xl shadow-lg relative group">
              <div class="text-4xl text-gray-400 mb-4">❝</div>
              <p class="text-gray-700">"Un service rapide et impeccable. Je suis ravie du professionnalisme de l'équipe"</p>
              <div class="mt-6 flex flex-col items-center">
                
                <h4 class="mt-2 font-bold text-gray-800">Amina B.</h4>
                <p class="text-sm text-gray-500">Casa Clean Pro</p>
              </div>
            </div>

            <!-- Témoignage 2 -->
            <div class="bg-white p-6 rounded-xl shadow-lg relative group">
              <div class="text-4xl text-gray-400 mb-4">❝</div>
              <p class="text-gray-700">"Une équipe professionnelle et ponctuelle."</p>
              <div class="mt-6 flex flex-col items-center">
                
                <h4 class="mt-2 font-bold text-gray-800">Omar K.</h4>
                <p class="text-sm text-gray-500">Azur Nettoyage</p>
              </div>
            </div>

            <!-- Témoignage 3 -->
            <div class="bg-white p-6 rounded-xl shadow-lg relative group">
              <div class="text-4xl text-gray-400 mb-4">❝</div>
              <p class="text-gray-700">"Très satisfaite de la qualité du ménage."</p>
              <div class="mt-6 flex flex-col items-center">
               
                <h4 class="mt-2 font-bold text-gray-800">Salma B.</h4>
                <p class="text-sm text-gray-500">Hygia Services</p>
              </div>
            </div>
             <!-- Témoignage 1 -->
            <div class="bg-white p-6 rounded-xl shadow-lg relative group">
              <div class="text-4xl text-gray-400 mb-4">❝</div>
              <p class="text-gray-700">"Service impeccable ! Mon appartement n’a jamais été aussi propre."</p>
              <div class="mt-6 flex flex-col items-center">
                
                <h4 class="mt-2 font-bold text-gray-800">Fatima Z.</h4>
                <p class="text-sm text-gray-500">Hygia Services</p>
              </div>
            </div>

            <!-- Témoignage 2 -->
            <div class="bg-white p-6 rounded-xl shadow-lg relative group">
              <div class="text-4xl text-gray-400 mb-4">❝</div>
              <p class="text-gray-700">"Une équipe professionnelle et ponctuelle."</p>
              <div class="mt-6 flex flex-col items-center">
                
                <h4 class="mt-2 font-bold text-gray-800">Omar K.</h4>
                <p class="text-sm text-gray-500">Azur Nettoyage</p>
              </div>
            </div>

            <!-- Témoignage 3 -->
            <div class="bg-white p-6 rounded-xl shadow-lg relative group">
              <div class="text-4xl text-gray-400 mb-4">❝</div>
              <p class="text-gray-700">"Très satisfaite de la qualité du ménage."</p>
              <div class="mt-6 flex flex-col items-center">
                
                <h4 class="mt-2 font-bold text-gray-800">Salma B.</h4>
                <p class="text-sm text-gray-500">EcoMénage Maroc</p>
              </div>
            </div>

            <!-- Tu peux continuer d'ajouter autant de témoignages ici -->

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
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
</style>
