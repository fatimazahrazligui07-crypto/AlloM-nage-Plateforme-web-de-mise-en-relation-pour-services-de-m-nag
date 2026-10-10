<template>
  <div class="bg-white font-[Poppins]">
    <MainHeader />

    <!-- Hero Section -->
    <section class="relative bg-cover bg-center bg-no-repeat h-120 flex items-center justify-center text-white"
             style="background-image: url('/hero-gallery.png');">
      <div class="bg-blue-600/50 absolute inset-0"></div>
      <div class="relative z-10 text-center">
        <h1 class="text-4xl font-bold">Conditions Générales d'Utilisation</h1>
        <p class="mt-2 text-sm">
          <a href="/" class="hover:underline text-yellow-400">Accueil</a> &nbsp; &gt; &nbsp; CGU
        </p>
      </div>
    </section>

    <!-- Terms Section -->
    <section class="bg-gray-20 py-16">
      <div class="max-w-4xl mx-auto px-6 text-gray-800 space-y-10">

        <h2 class="text-3xl font-bold text-center text-blue-900">Conditions Générales d'Utilisation</h2>

        <div class="space-y-6">
          <div>
            <h3 class="text-xl font-semibold text-blue-800">1. Objet</h3>
            <p>
              Les présentes CGU ont pour objet de définir les modalités d’accès et d’utilisation du site Allo Ménage. En accédant à ce site, vous acceptez pleinement et sans réserve toutes les dispositions ci-après.
            </p>
          </div>

          <div>
            <h3 class="text-xl font-semibold text-blue-800">2. Propriété intellectuelle</h3>
            <p>
              Tous les contenus de ce site (textes, images, logos, vidéos...) sont protégés par la législation sur la propriété intellectuelle. Toute reproduction ou diffusion sans autorisation écrite est interdite.
            </p>
          </div>

          <div>
            <h3 class="text-xl font-semibold text-blue-800">3. Accès au service</h3>
            <p>
              Le site est accessible à tout moment, sauf cas de force majeure ou maintenance. Allo Ménage ne garantit pas une disponibilité continue et ne peut être tenu responsable en cas d’interruption.
            </p>
          </div>

          <div>
            <h3 class="text-xl font-semibold text-blue-800">4. Conditions d’inscription</h3>
            <p>
              Certaines fonctionnalités nécessitent une inscription. Vous vous engagez à fournir des informations exactes et à maintenir la confidentialité de votre mot de passe.
            </p>
          </div>

          <div>
            <h3 class="text-xl font-semibold text-blue-800">5. Données personnelles</h3>
            <p>
              Les données collectées sont traitées conformément à notre politique de confidentialité. Vous disposez d’un droit d’accès, de modification ou de suppression de vos données en nous contactant à <a href="mailto:contact@allomenage.com" class="text-blue-600 underline">contact@allomenage.com</a>.
            </p>
          </div>

          <div>
            <h3 class="text-xl font-semibold text-blue-800">6. Cookies</h3>
            <p>
              Ce site utilise des cookies pour améliorer votre expérience. En continuant à naviguer, vous acceptez leur utilisation selon notre politique.
            </p>
          </div>

          <div>
            <h3 class="text-xl font-semibold text-blue-800">7. Responsabilités</h3>
            <p>
              Allo Ménage ne pourra être tenu responsable des dommages directs ou indirects liés à l’utilisation du site ou à une mauvaise configuration de votre terminal.
            </p>
          </div>

          <div>
            <h3 class="text-xl font-semibold text-blue-800">8. Modification des CGU</h3>
            <p>
              Les CGU peuvent être modifiées à tout moment. Il vous appartient de consulter régulièrement cette page pour rester informé.
            </p>
          </div>

          <div>
            <h3 class="text-xl font-semibold text-blue-800">9. Droit applicable et litiges</h3>
            <p>
              Les présentes conditions sont régies par le droit marocain. En cas de litige, compétence exclusive est attribuée aux tribunaux de Casablanca.
            </p>
          </div>

          <div>
            <p class="pt-4">
              Pour toute question, veuillez nous écrire à : <a href="mailto:contact@allomenage.com" class="text-blue-600 underline">contact@allomenage.com</a>
            </p>
          </div>
        </div>
      </div>
    </section>

    <MainFooter />
  </div>
</template>

<script setup>
import MainHeader from '@/components/MainHeader.vue'
import MainFooter from '@/components/MainFooter.vue'
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
</style>
