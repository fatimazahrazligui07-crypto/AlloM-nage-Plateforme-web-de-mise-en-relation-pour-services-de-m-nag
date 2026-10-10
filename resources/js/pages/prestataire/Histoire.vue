<script setup>
import { ref } from 'vue'
import Topbar from '@/components/Topbar.vue'
import PrestataireDashboardHeader from '@/components/PrestataireDashboardHeader.vue'
import MainFooter from '@/components/MainFooter.vue'

const timelineData = ref([
  {
    date: 'Avril 2025',
    title: 'Lancement de la plateforme',
    description: 'Nous avons lancé notre plateforme avec la volonté de créer un pont fiable et efficace entre les clients et les entreprises de ménage.',
    icon: 'fas fa-rocket',
    color: '#1E3A8A',
    side: 'left',
    image: '/path/to/image1.jpg', // Ajouter le chemin de l'image ici
  },
  {
    date: 'Mai 2025',
    title: 'Croissance et expansion',
    description: 'Face à une demande croissante, nous avons élargi notre réseau de partenaires pour proposer une gamme plus large de services.',
    icon: 'fas fa-chart-line',
    color: '#1E3A8A',
    side: 'right',
    image: '/croissance et expansion.png', // Ajouter le chemin de l'image ici
  },
  {
    date: 'Juin 2025',
    title: 'Innovation technologique',
    description: 'Nous avons intégré des outils technologiques avancés pour simplifier la mise en relation, la réservation et le paiement.',
    icon: 'fas fa-cogs',
    color: '#1E3A8A',
    side: 'left',
    image: '/innovation technologique.png', // Ajouter le chemin de l'image ici
  },
  {
    date: 'Juillet 2025',
    title: 'Consolidation et confiance',
    description: 'La plateforme est devenue une référence reconnue dans le secteur du nettoyage.',
    icon: 'fas fa-trophy',
    color: '#1E3A8A',
    side: 'right',
    image: '/path/to/image4.jpg', // Ajouter le chemin de l'image ici
  }
])
</script>

<template>
  <div class="bg-white font-[Poppins]">
    <Topbar />
    <PrestataireDashboardHeader />

    <!-- Hero Section -->
    <section class="relative bg-cover bg-center bg-no-repeat h-120 flex items-center justify-center text-white"
      style="background-image: url('/hero-gallery.png');">
      <div class="bg-blue-600/60 absolute inset-0"></div>
      <div class="relative z-10 text-center">
        <h1 class="text-5xl font-bold">Histoire</h1>
        <p class="mt-3 text-lg">
          <a href="/" class="hover:underline text-yellow-400">Accueil</a> &nbsp; › &nbsp; Histoire
        </p>
      </div>
    </section>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-6 py-16">
      <!-- Page Title -->
      <div class="text-center mb-16">
        <h1 class="text-4xl md:text-5xl font-bold text-[#0b2c7a] mb-4">
          Notre Histoire
        </h1>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
          Découvrez l'évolution de notre entreprise et les étapes clés qui ont marqué notre parcours vers l'excellence.
        </p>
      </div>

      <!-- Timeline Container -->
      <div class="relative timeline-container">
        <!-- Year Circle at Top -->
        <div class="flex justify-center mb-8">
          <div class="w-20 h-20 bg-[#1E3A8A] rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg">
            2025
          </div>
        </div>

        <!-- Vertical Line -->
        <div class="absolute left-1/2 transform -translate-x-1/2 w-1 bg-[#1E3A8A] timeline-line"></div>

        <!-- Timeline Items -->
        <div class="space-y-16">
          <div 
            v-for="(item, index) in timelineData" 
            :key="index"
            class="relative flex items-center"
            :class="item.side === 'right' ? 'justify-end' : 'justify-start'"
          > 
            <!-- Timeline Dot -->
            <div class="absolute left-1/2 transform -translate-x-1/2 w-6 h-6 bg-[#1E3A8A] rounded-full border-4 border-white shadow-lg z-10">
              <i :class="item.icon"></i> <!-- Icône dynamique -->
            </div>

            <!-- Content Container -->
            <div 
              class="w-5/12 timeline-content"
              :class="item.side === 'right' ? 'text-left pl-8' : 'text-right pr-8'"
            >
              <!-- Image -->
              <img 
                :src="item.image" 
                :alt="item.title"
                class="w-80 h-40 object-cover rounded-lg mr-6" 
              />
              <!-- Date -->
              <p class="text-[#1E3A8A] font-semibold text-sm mb-2">
                {{ item.date }}
              </p>

              <!-- Title -->
              <h3 class="text-2xl font-bold text-gray-800 mb-4">
                {{ item.title }}
              </h3>

              <!-- Description -->
              <p class="text-gray-600 leading-relaxed text-sm mb-4">
                {{ item.description }}
              </p>
            </div>
          </div>
        </div>
      </div>

    
    </main>

    <MainFooter />
  </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

.timeline-container {
  position: relative;
  padding: 2rem 0;
}

.timeline-line {
  top: 10rem;
  bottom: 0;
  z-index: 1;
  background-color: #e1e2e3;
}

.timeline-content {
  opacity: 0;
  transform: translateY(30px);
  animation: fadeInUp 0.6s ease-out forwards;
}

.timeline-content:nth-child(1) { animation-delay: 0.2s; }
.timeline-content:nth-child(2) { animation-delay: 0.4s; }
.timeline-content:nth-child(3) { animation-delay: 0.6s; }

@keyframes fadeInUp {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Responsive Design */
@media (max-width: 768px) {
  .timeline-container .flex {
    flex-direction: column;
    align-items: center;
    text-align: center;
  }
  
  .timeline-content {
    width: 90% !important;
    text-align: center !important;
    padding: 0 !important;
  }
  
  .timeline-line {
    left: 50%;
  }
}
</style>