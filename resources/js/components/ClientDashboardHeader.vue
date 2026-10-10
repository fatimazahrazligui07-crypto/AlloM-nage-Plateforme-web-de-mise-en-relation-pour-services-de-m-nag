<template>
  <header :class="[isScrolled ? 'fixed top-0 left-0 w-full bg-blue-900 shadow-md transition-all duration-300 z-50' : 'bg-white shadow', 'transition-all duration-300']">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

      <!-- Logo + Texte -->
      <div class="flex items-center space-x-3">
        <!-- Logo -->
        <img src="/logo.png" alt="Allo Ménage Logo" class="h-20 w-auto" />
        <!-- Texte -->
        <div class="text-2xl font-bold" :class="isScrolled ? 'text-white' : 'text-[#0b2c7a]'">
          Allo Ménage
        </div>
      </div>

      <!-- NAVIGATION -->
      <nav class="flex space-x-6 font-medium items-center relative" :class="isScrolled ? 'text-white' : 'text-gray-800'">
        <Link href="/Welcomeclient" class="hover:text-yellow-400">Accueil</Link>

       
        <Link href="/dashboard/client/apropos" class="hover:text-yellow-400">À propos</Link>
        <Link href="/dashboard/client/services" class="hover:text-yellow-400">Services</Link>
        <Link href="/dashboard/client/prestataires" class="hover:text-yellow-400">Prestataires</Link>
        <Link href="/dashboard/client" class="hover:text-yellow-400">Tableau de bord</Link>
      </nav>
     <Link href="/dashboard/client/profile" class="flex items-center space-x-2 px-4 py-2 hover:text-yellow-400"
      :class="isScrolled ? 'text-white' : 'text-gray-700'">
  <User class="w-5 h-5" />
  <span>Profil</span>
</Link>



      

    </div>
  </header>
</template>


<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { Link } from '@inertiajs/inertia-vue3'
import { User } from 'lucide-vue-next'

const isScrolled = ref(false)
const showDropdown = ref(false)

const toggleDropdown = () => { 
  showDropdown.value = !showDropdown.value 
}

const handleScroll = () => {
  isScrolled.value = window.scrollY > 50
}

onMounted(() => window.addEventListener('scroll', handleScroll))
onUnmounted(() => window.removeEventListener('scroll', handleScroll))
</script>



