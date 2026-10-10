<script setup>
import Topbar from '@/components/Topbar.vue'
import PrestataireDashboardHeader from '@/components/PrestataireDashboardHeader.vue'
import MainFooter from '@/components/MainFooter.vue'
</script>

<template>
  <div class="bg-white font-[Poppins]">
    <!-- Topbar -->
    <Topbar />

    <!-- Header -->
    <PrestataireDashboardHeader />

     <!-- Hero Section with Background Image -->
    <section class="relative bg-cover bg-center bg-no-repeat overflow-hidden" style="background-image: url('/background.jpg');">
      <div class="bg-[#f3f9f7]/80">
        <div class="max-w-7xl mx-auto px-6 py-20 flex flex-col-reverse md:flex-row items-center justify-between">
          <div class="md:w-1/2 text-center md:text-left">
            <p class="text-[#0b2c7a] font-semibold uppercase mb-3">Bienvenue chez Allo Ménage</p>
            <h1 class="text-5xl md:text-6xl font-bold text-[#0b2c7a] leading-tight mb-6">
              Votre Réseau de Ménage  <br /> Fiable et Qualifié
            </h1>
            <p class="text-gray-600 mb-8 text-lg">
              Une solution simple et sécurisée pour tous vos besoins de ménage et d’entretien.
            </p>
            <div class="flex flex-col sm:flex-row items-center sm:space-x-6 space-y-4 sm:space-y-0 justify-center md:justify-start">
              

                
              
              <div class="relative group">
                <button class="bg-white text-yellow-600 border-4 border-yellow-300 hover:border-yellow-500 rounded-full w-16 h-16 flex items-center justify-center shadow-lg relative z-10 group-hover:scale-110 transition">
                  <i class="fas fa-play text-xl"></i>
                </button>
                <div class="absolute inset-0 rounded-full bg-blue-100 opacity-50 scale-125 blur-md z-0 group-hover:scale-[1.4] transition"></div>
              </div>
            </div>
          </div>
          <div class="md:w-1/2 flex justify-center mb-10 md:mb-0">
            <img src="/cleaning-lady.png" alt="Femme de ménage" class="max-w-lg rounded-xl " />
          </div>
        </div>
      </div>
      <div class="absolute bottom-0 left-0 w-full h-0 bg-white rotate-2 origin-bottom-left"></div>
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
          <h2 class="text-4xl font-bold text-gray-900 mb-4">
            Notre mission : Offrir un environnement <span class="text-blue-600">Propre et Sain</span> pour les familles.
          </h2>
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
   <!-- Services Section page statique de l'acceuil-->

    <section id="services" class="bg py-20">
      
      <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-6">
          <div class="text-sm uppercase font-semibold text-gray-500 mb-2">✨ SERVICES</div>
          <h2 class="text-4xl font-bold text-gray-800">
           Nos <span class="text-blue-600">Services</span> Pour Votre Confort.
          </h2>
        </div>
        <div class="flex justify-center mb-14">
          <a href="/services" class="bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-6 py-3 rounded shadow flex items-center gap-2">
            Tous les services<i class="fas fa-paper-plane"></i>
          </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8"></div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
          <div class="group relative overflow-hidden rounded-xl shadow-lg">
            <img src="/service1.png" alt="Service 1" class="w-full h-110 object-cover transition-transform duration-500 group-hover:scale-105">
            <div class="absolute bottom-0 left-0 w-full bg-white p-4">
              <div class="flex items-center mb-2">
                <span class="text-blue-600 text-xl mr-2">✨</span>
                <h3 class="font-semibold text-gray-800">Ménage résidentiel</h3>
              </div>
              <p class="text-sm text-gray-600">Entretien régulier ou ponctuel des logements</p>
              <a href="/services" class="block mt-4 bg-yellow-400 hover:bg-yellow-500 text-black font-semibold text-center py-2 rounded transition-opacity opacity-0 group-hover:opacity-100">Voir plus <i class="fas fa-paper-plane ml-2"></i></a>
            </div>
          </div>
          <div class="group relative overflow-hidden rounded-xl shadow-lg">
            <img src="/service2.png" alt="Service 2" class="w-full h-72 object-cover transition-transform duration-500 group-hover:scale-105">
            <div class="absolute bottom-0 left-0 w-full bg-white p-4">
              <div class="flex items-center mb-2">
                <span class="text-blue-600 text-xl mr-2">✨</span>
                <h3 class="font-semibold text-gray-800">Nettoyage après fête</h3>
              </div>
              <p class="text-sm text-gray-600">Nettoyage après événements privés</p>
              <a href="/services" class="block mt-4 bg-yellow-400 hover:bg-yellow-500 text-black font-semibold text-center py-2 rounded transition-opacity opacity-0 group-hover:opacity-100">Voir plus <i class="fas fa-paper-plane ml-2"></i></a>
            </div>
          </div>
          <div class="group relative overflow-hidden rounded-xl shadow-lg">
            <img src="/service3.png" alt="Service 3" class="w-full h-72 object-cover transition-transform duration-500 group-hover:scale-105">
            <div class="absolute bottom-0 left-0 w-full bg-white p-4">
              <div class="flex items-center mb-2">
                <span class="text-blue-600 text-xl mr-2">✨</span>
                <h3 class="font-semibold text-gray-800">Ménage régulier </h3>
              </div>
              <p class="text-sm text-gray-600">Nettoyage hebdomadaire ou bihebdomadaire</p>
              <a href="/services" class="block mt-4 bg-yellow-400 hover:bg-yellow-500 text-black font-semibold text-center py-2 rounded transition-opacity opacity-0 group-hover:opacity-100">Voir plus <i class="fas fa-paper-plane ml-2"></i></a>
            </div>
          </div>
          <div class="group relative overflow-hidden rounded-xl shadow-lg">
            <img src="/service4.png" alt="Service 4" class="w-full h-72 object-cover transition-transform duration-500 group-hover:scale-105">
            <div class="absolute bottom-0 left-0 w-full bg-white p-4">
              <div class="flex items-center mb-2">
                <span class="text-blue-600 text-xl mr-2">✨</span>
                <h3 class="font-semibold text-gray-800">Ménage industriel</h3>
              </div>
              <p class="text-sm text-gray-600">Nettoyage d’usines, entrepôts, zones de production</p>
              <a href="/services" class="block mt-4 bg-yellow-400 hover:bg-yellow-500 text-black font-semibold text-center py-2 rounded transition-opacity opacity-0 group-hover:opacity-100">Voir plus <i class="fas fa-paper-plane ml-2"></i></a>
            </div>
          </div>
        </div>
      </div>

    </section>
    
   <!-- Testimonials Section (a changer la mettre plus flottante )-->
    <section id="testimonials" class="bg-gradient-to-b from- via-white to- py-20">
      <div class="max-w-7xl mx-auto px-6 text-center">
        <div class="mb-12">
          <div class="text-sm uppercase font-semibold text-gray-500 mb-2 flex items-center justify-center gap-2">
            <span class="text-blue-500 text-xl">✨</span> Témoignages
          </div>
          <h2 class="text-4xl font-bold text-gray-900">
            Ce que nos  <span class="text-blue-600">Clients</span> disent de notre travail!
          </h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
          <div class="bg-white p-6 rounded-xl shadow-lg relative group">
            <div class="text-4xl text-gray-400 mb-4">❝</div>
            <p class="text-gray-700">"Le service de ménage a dépassé mes attentes ! L'équipe est arrivée à l'heure, a travaillé efficacement et a laissé mon logement parfaitement propre. Ils ont été courtois et ont montré un vrai souci du détail dans leur travail. Le tarif était très raisonnable au vu de la qualité de la prestation. Je referai appel à eux sans hésiter et je les recommande vivement à mes proches !"</p>
            <div class="mt-6 flex flex-col items-center">
             
              <h4 class="mt-2 font-bold text-gray-800">Mariam </h4>
              <p class="text-sm text-gray-500">Mariam Bellehi</p>
            </div>
          </div>
          <div class="bg-white p-6 rounded-xl shadow-lg relative group">
            <div class="text-4xl text-gray-400 mb-4">❝</div>
            <p class="text-gray-700">"Nous faisons appel à leurs services pour l'entretien régulier de nos bureaux. Ponctualité, professionnalisme et qualité de nettoyage sont toujours au rendez-vous. Une équipe fiable et réactive, que nous recommandons à d'autres entreprises."</p>
            <div class="mt-6 flex flex-col items-center">
              
              <h4 class="mt-2 font-bold text-gray-800">Mohammed</h4>
              <p class="text-sm text-gray-500">Achref</p>
            </div>
          </div>
          <div class="bg-white p-6 rounded-xl shadow-lg relative group">
            <div class="text-4xl text-gray-400 mb-4">❝</div>
            <p class="text-gray-700">"Après notre déménagement, ils ont pris en charge le grand nettoyage de l'appartement. Le résultat était impeccable et conforme à nos attentes. Merci pour votre sérieux et votre efficacité. "</p>
            <div class="mt-6 flex flex-col items-center">
              
              <h4 class="mt-2 font-bold text-gray-800">Nabil</h4>
              <p class="text-sm text-gray-500">Bensrhier</p>
            </div>
          </div>
        </div>
        <div class="flex justify-center">
          <a href="/services" class="bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-6 py-3 rounded shadow flex items-center gap-2">
            Voir plus <i class="fas fa-paper-plane"></i>
          </a>
        </div>
      </div>
    </section>

     <!-- Stats Bar (A lier avec la base de donnee) -->
      <div class="bg-[#0b2c7a] py-12">
        <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 text-center text-white">
          <div>
            <i class="fas fa-briefcase text-yellow-500 text-3xl mb-2"></i>
            <h3 class="text-2xl font-bold">10 K</h3>
            <p class="text-sm">Prestations réalisées</p>
          </div>
          <div>
            <i class="fas fa-user-check text-yellow-500 text-3xl mb-2"></i>
            <h3 class="text-2xl font-bold">1050+</h3>
            <p class="text-sm">Clients satisfaits</p>
          </div>
          <div>
            <i class="fas fa-trophy text-yellow-500 text-3xl mb-2"></i>
            <h3 class="text-2xl font-bold">50K</h3>
            <p class="text-sm">Prestataires partenaires</p>
          </div>
          <div>
            <i class="fas fa-stopwatch text-yellow-500 text-3xl mb-2"></i>
            <h3 class="text-2xl font-bold">100K</h3>
            <p class="text-sm">Demandes traitées</p>
          </div>
        </div>
      </div>
    <!-- Work Process section 
     (1.choisir service a votre propre information et lance votre demande 
      2.choisir une offre que le prestatire a suggerer 
      3. paiyer votre demande et bienvenue haha) -->
    <section id="work-process" class="bg-white py-20">
      <div class="max-w-5xl mx-auto px-6 text-center">
        <div class="mb-12">
          <div class="text-sm font-bold text-yellow-600 uppercase tracking-wider mb-2">✨ PROCESSUS DE RÉSERVATION</div>
          <h2 class="text-4xl font-extrabold text-[#0b2c7a] leading-tight">
            Quelques étapes simples <br class="hidden sm:block" /> pour réserver votre prestation de ménage
          </h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-10">
          <div class="flex flex-col items-center">
            <div class="w-20 h-20 flex items-center justify-center rounded-full bg-gradient-to-b from-gray-100 to-white shadow-md text-2xl font-bold text-[#0b2c7a] border-b-4 border-yellow-500">1</div>
            <h4 class="mt-4 font-semibold text-[#0b2c7a]">Sélectionnez un service</h4>
            <p class="text-sm text-gray-500 mt-2">Choisissez le type de prestation selon vos besoins (ménage régulier, ponctuel, professionnel...).</p>
          </div>
          <div class="flex flex-col items-center">
            <div class="w-20 h-20 flex items-center justify-center rounded-full bg-gradient-to-b from-gray-100 to-white shadow-md text-2xl font-bold text-[#0b2c7a] border-b-4 border-yellow-500">2</div>
            <h4 class="mt-4 font-semibold text-[#0b2c7a]">Recevez et comparez les offres</h4>
            <p class="text-sm text-gray-500 mt-2">Nos prestataires vous envoient leurs propositions. Comparez les tarifs et disponibilités.</p>
          </div>
          <div class="flex flex-col items-center">
            <div class="w-20 h-20 flex items-center justify-center rounded-full bg-gradient-to-b from-gray-100 to-white shadow-md text-2xl font-bold text-[#0b2c7a] border-b-4 border-yellow-500">3</div>
            <h4 class="mt-4 font-semibold text-[#0b2c7a]">Réservez et profitez de la prestatio</h4>
            <p class="text-sm text-gray-500 mt-2">Sélectionnez l’offre qui vous convient, effectuez le paiement sécurisé, et le prestataire intervient à la date choisie.</p>
          </div>
        </div>
      </div>
    </section>
    <!-- Nouvelle Section Pages -->
    <!-- <section id="pages" class="bg-[#f8fafc] py-20">
      <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12">
          <h2 class="text-4xl font-bold text-gray-800">
            Explore Our <span class="text-blue-600">Pages</span>
          </h2>
          <p class="text-gray-600 mt-4">Learn more about our company, mission, and team members.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
          <div class="bg-white p-6 rounded-xl shadow-lg text-center group hover:scale-105 transition">
            <img src="/pages-aboutus.png" alt="About Us" class="w-20 h-20 mx-auto mb-4">
            <h3 class="text-xl font-semibold text-gray-900 mb-2">About Us</h3>
            <p class="text-gray-600 text-sm mb-4">Discover who we are and what drives us every day.</p>
            <a href="/about" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-4 py-2 rounded-full">Read More</a>
          </div>
          <div class="bg-white p-6 rounded-xl shadow-lg text-center group hover:scale-105 transition">
            <img src="/pages-company.png" alt="Company" class="w-20 h-20 mx-auto mb-4">
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Company</h3>
            <p class="text-gray-600 text-sm mb-4">Our company’s journey, values and vision for the future.</p>
            <a href="/company" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-4 py-2 rounded-full">Read More</a>
          </div>
          <div class="bg-white p-6 rounded-xl shadow-lg text-center group hover:scale-105 transition">
            <img src="/pages-team.png" alt="Team Member" class="w-20 h-20 mx-auto mb-4">
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Team Member</h3>
            <p class="text-gray-600 text-sm mb-4">Meet the dedicated professionals behind our services.</p>
            <a href="/team" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-4 py-2 rounded-full">Read More</a>
          </div>
          <div class="bg-white p-6 rounded-xl shadow-lg text-center group hover:scale-105 transition">
            <img src="/pages-testimonials.png" alt="Testimonials" class="w-20 h-20 mx-auto mb-4">
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Testimonials</h3>
            <p class="text-gray-600 text-sm mb-4">See what our happy clients have to say about us.</p>
            <a href="/testimonials" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-4 py-2 rounded-full">Read More</a>
          </div>
        </div>
      </div>
    </section> -->
    <!-- Footer -->
    <MainFooter />
  </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
</style>
