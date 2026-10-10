<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import ClientDashboardHeader from '@/components/ClientDashboardHeader.vue'
import Topbar from '@/components/Topbar.vue'
import MainFooter from '@/components/MainFooter.vue'

// Props reçues depuis le contrôleur (optionnel)
const props = defineProps({
  services: {
    type: Array,
    default: () => []
  }
});

// Variable pour stocker les services
const services = ref(props.services || []);

// Récupérer les services depuis l'API si pas déjà fournis
onMounted(async () => {
  if (services.value.length === 0) {
    try {
      // URL corrigée avec le bon chemin API
      const response = await axios.get('/api/services');
      console.log('Services récupérés:', response.data);
      services.value = response.data;
    } catch (error) {
      console.error("Erreur lors de la récupération des services:", error);
      
      // Afficher plus de détails sur l'erreur
      if (error.response) {
        console.error('Statut:', error.response.status);
        console.error('Données:', error.response.data);
      }
    }
  }
});

const currentPage = ref(1);
const itemsPerPage = 3;

const pagedServices = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  return services.value.slice(start, start + itemsPerPage);
});

const totalPages = computed(() => Math.ceil(services.value.length / itemsPerPage));

function goToPage(page) {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page;
  }
}
</script>

<!-- Le reste de votre template reste identique -->


<template>
  <div class="bg-white font-[Poppins]">
    <Topbar />
    <ClientDashboardHeader />
     <!-- Hero Section -->
    <section class="relative bg-cover bg-center bg-no-repeat h-120 flex items-center justify-center text-white"
      style="background-image: url('/hero-gallery.png');">
      <div class="bg-blue-600/60 absolute inset-0"></div>
      <div class="relative z-10 text-center">
        <h1 class="text-5xl font-bold">A propos</h1>
        <p class="mt-3 text-lg">
          <a href="/" class="hover:underline text-yellow-400">Accueil</a> &nbsp; › &nbsp; Services
        </p>
      </div>
    </section>
      
<!-- A propos -->
    <section id="a-propos" class="bg-white py-20">
      <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <!-- Floating Image -->
        <div class="group relative overflow-hidden rounded-xl shadow-lg">
          <img
            src="/about-cleaning-office.png"
            alt="About Cleaning Team"
            class="rounded-xl transform transition-transform duration-500 ease-in-out group-hover:scale-105"
          />
        </div>
      <!-- Text Content de la partie de a propos -->
        <div>
          <div class="text-sm uppercase font-semibold text-gray-500 mb-2">✨ QUI SOMMES-NOUS</div>
          <h3 class="text-4xl font-bold text-gray-900 mb-4">
            Notre mission : Offrir un environnement <span class="text-blue-600">Propre et Sain</span> pour les familles.
          </h3>
          <p class="text-gray-600 mb-6">
            Nos services de nettoyage approfondi vont au-delà de l'entretien classique en s'attaquant aux zones souvent négligées, comme les plinthes, l'arrière des appareils électroménagers, l'intérieur des placards et autres espaces difficiles d’accès.
          </p>

          <div class="space-y-6 mb-6">
            <div class="flex items-start">
              <div class="w-12 h-12 flex-shrink-0 bg-blue-600 text-white rounded-full flex items-center justify-center text-xl">
                ✨
              </div>
              <div class="ml-4">
                <h4 class="font-semibold text-gray-900">Personnel expérimenté</h4>
                <p class="text-gray-600 text-sm">Nos prestations sont adaptées aux besoins spécifiques de chaque client.</p>
              </div>
            </div>

            <div class="flex items-start">
              <div class="w-12 h-12 flex-shrink-0 bg-blue-600 text-white rounded-full flex items-center justify-center text-xl">
                🧰
              </div>
              <div class="ml-4">
                <h4 class="font-semibold text-gray-900">Équipements professionnels</h4>
                <p class="text-gray-600 text-sm">Nous proposons des solutions complètes pour les particuliers comme pour les entreprises.</p>
              </div>
            </div>

            <div class="flex items-start">
              <div class="w-12 h-12 flex-shrink-0 bg-yellow-400 text-white rounded-full flex items-center justify-center text-xl">
                🍃
              </div>
              <div class="ml-4">
                <h4 class="font-semibold text-gray-900"> Produits naturels</h4>
                <p class="text-gray-600 text-sm">Nous privilégions des produits respectueux de l’environnement tout en garantissant un nettoyage de haute qualité.</p>
              </div>
            </div>
          </div>

          <a href="apropos" class="inline-flex items-center bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-6 py-3 rounded-full shadow">
            En savoir plus sur nous <i class="fas fa-arrow-right ml-2"></i>
          </a>
        </div>
      </div>
    </section>

    <!-- Vidéo présentative -->
    <section id="video-presentation" class="py-20 bg-gray-50 flex justify-center">
      <video controls width="700" class="rounded-lg shadow-lg" src="/videos/presentation.mp4"></video>
    </section>

    <!-- What We Do -->
    <section id="services" class="bg-gray-50 py-16 max-w-7xl mx-auto px-6">
  <div class="text-center mb-12">
    <div class="flex items-center justify-center mb-3">
      <img src="/icone-title.png" alt="Balai" class="w-8 h-8" />
      <h4 class="text-sm uppercase font-semibold text-gray-500 mb-2">Nos Services</h4>
    </div>
    <h4 class="text-3xl md:text-4xl font-bold text-gray-900">
      Nous intervenons dans <span class="text-blue-600">plusieurs domaines</span> pour nettoyer votre environnement.
    </h4>
  </div>

  <div class="grid gap-10 md:grid-cols-3">
    
    <!-- Boucle à travers les services récupérés depuis l'API -->
    <div
      v-for="service in pagedServices"
      :key="service.id"
      class="bg-white rounded-xl shadow-md overflow-hidden group hover:shadow-lg transition-shadow duration-300 cursor-pointer"
    >
      <div class="relative overflow-hidden">
        <img
          :src="service.logo"  
          :alt="service.title"
          class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500"
        />
        <div
          class="absolute bottom-3 right-3 bg-white p-3 rounded-full opacity-80 group-hover:opacity-100 transition-opacity duration-300"
        >
          <img :src="service.icon" alt="Icone service" class="w-6 h-6" />
        </div>
      </div>

      <div class="p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ service.title }}</h3>
        <p class="text-gray-600 text-sm mb-4">{{ service.description }}</p>
        <button
          class="inline-flex items-center text-yellow-500 font-semibold hover:underline"
          @click="alert(`En savoir plus sur ${service.title}`)"
        >
          En savoir plus
          <svg
            class="ml-1 w-4 h-4"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            viewBox="0 0 24 24"
          >
            <path d="M5 12h14M12 5l7 7-7 7"></path>
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Pagination -->
  <div class="flex justify-center mt-10 space-x-4">
    <button
      v-for="page in totalPages"
      :key="page"
      @click="goToPage(page)"
      :class="[
        'w-4 h-4 rounded-full',
        currentPage === page ? 'bg-blue-600' : 'bg-blue-300 hover:bg-blue-500',
        'transition-colors duration-300',
      ]"
    ></button>
  </div>
</section>


     <!-- Whay chose us -->
    <section id="why-choose-us" class="bg-white py-20">
  <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center md:items-start gap-12">
    <!-- Texte à gauche avec plus de largeur -->
    <div class="md:w-2/3 text-left px-6">
      <div class="flex items-center mb-6 gap-3">
        <img src="/icone-title.png" alt="Balai" class="w-8 h-8" />
        <h4 class="text-sm uppercase font-semibold text-gray-500 mb-2">Pourquoi nous choisir ?</h4>
      </div>
      <h4 class="text-4xl font-bold text-gray-900 mb-4">
        Nous intervenons dans <span class="text-blue-600">de nombreux domaines</span> pour nettoyer
        votre environnement.
      </h4>

      <p class="text-gray-700 mb-6">
        Nous sommes aussi forts que nos équipes. C’est pourquoi notre équipe a conçu des services fiables et adaptés à vos besoins.
        <br><br> Nous sélectionnons rigoureusement tous nos agents de nettoyage pour que vous puissiez avoir l’esprit tranquille chez vous.
      </p>
    </div>

    <!-- Image centrée -->
    <div class="md:w-1/3 flex justify-center space-y-6 mb-6 mt-15">
      <img src="/why-chose-us.png" alt="Nettoyage professionnel" class="rounded-lg shadow-lg max-w-full h-auto" />
    </div>

    <!-- Liste des éléments avec icônes -->
    <div class="space-y-6 mb-6 mt-15">
      <div class="flex items-start">
        <img src="/icons-done.png" alt="Support 24/7" class="w-8 h-8 flex-shrink-0 mr-4" />
        <div>
          <h4 class="font-semibold text-gray-900">Support 24/7 disponible</h4>
          <p class="text-gray-600 text-sm">
            Nous sommes là pour vous aider à tout moment. Notre service client répond rapidement à toutes vos questions.
          </p>
        </div>
      </div>

      <div class="flex items-start">
        <img src="/icons-handshake.png" alt="Une équipe de confiance" class="w-8 h-8 flex-shrink-0 mr-4" />
        <div>
          <h4 class="font-semibold text-gray-900">Une équipe de confiance</h4>
          <p class="text-gray-600 text-sm">
            Nous sélectionnons rigoureusement nos prestataires de ménage pour garantir la qualité et la sécurité de vos prestations.
          </p>
        </div>
      </div>

      <div class="flex items-start">
        <img src="/icons-qualified.png" alt="Avis clients" class="w-8 h-8 flex-shrink-0 mr-4" />
        <div>
          <h4 class="font-semibold text-gray-900">Avis clients authentiques</h4>
          <p class="text-gray-600 text-sm">
            Consultez les retours réels de nos utilisateurs pour choisir le service qui vous convient en toute sérénité.
          </p>
        </div>
      </div>
    </div>
  </div>
  </section>



    <MainFooter/>
</div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

/* Optionnel : pointer sur les boutons pagination */
button:focus {
  outline: none;
  box-shadow: 0 0 0 2px #059669; /* vert clair */
}
</style>
