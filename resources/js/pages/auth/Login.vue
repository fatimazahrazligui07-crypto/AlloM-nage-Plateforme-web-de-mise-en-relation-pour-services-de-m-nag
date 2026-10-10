<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

import { Link } from '@inertiajs/inertia-vue3'; 

import { Mail, Lock, Eye, EyeOff } from 'lucide-vue-next';

const email = ref('');
const password = ref('');
const errorMessage = ref('');
const loading = ref(false);
const showPassword = ref(false);

// Props pour récupérer les messages flash
const props = defineProps({
  success: {
    type: String,
    default: null
  },
  error: {
    type: String,
    default: null
  }
});

// Initialiser les messages
if (props.error) {
  errorMessage.value = props.error;
}

// Fonction pour basculer la visibilité du mot de passe
const togglePasswordVisibility = () => {
  showPassword.value = !showPassword.value;
};

// Fonction pour soumettre le formulaire
function submit() {
  if (!email.value || !password.value) {
    errorMessage.value = 'Veuillez remplir tous les champs';
    return;
  }

  errorMessage.value = '';
  loading.value = true;

  // Envoie la requête de connexion via Inertia
  Inertia.post('/api/login', {
    email: email.value,
    password: password.value,
  }, {
    onSuccess: (response) => {
      loading.value = false;
      // La redirection sera gérée côté serveur
    },
    onError: (errors) => {
      loading.value = false;
      errorMessage.value = errors.message || 'Email ou mot de passe incorrect';
    },
    onFinish: () => {
      loading.value = false;
    }
  });
}
</script>

<template>
  <section
    class="relative bg-cover bg-center bg-no-repeat overflow-hidden min-h-screen"
    style="background-image: url('/background.jpg');"
  >
    <div class="bg-[#f3f9f7]/80 min-h-screen flex items-center justify-center px-6 py-20">
      <form
        @submit.prevent="submit"
        class="bg-white bg-opacity-90 backdrop-blur-md rounded-lg shadow-lg p-8 max-w-md w-full"
      >
        <!-- Logo et titre -->
        <div class="flex items-center mb-2 space-x-3 justify-center">
          <img src="/logo.png" alt="AlloMénage Logo" class="h-20 w-20" />
        </div>

        <h2 class="text-3xl font-bold text-[#0b2c7a] mb-6 text-center">Connexion</h2>

        <!-- Message de succès -->
        <div v-if="props.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
          <span class="block sm:inline">{{ props.success }}</span>
        </div>

        <!-- Champ Email -->
        <div class="mb-4 relative">
          <label class="block text-[#0b2c7a] font-semibold mb-1" for="email">Email</label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
              <Mail class="h-5 w-5 text-gray-400" />
            </span>
            <input
              id="email"
              v-model="email"
              type="email"
              required
              placeholder="exemple@mail.com"
              class="w-full border border-gray-300 rounded pl-10 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-[#0b2c7a] transition-all"
              :disabled="loading"
            />
          </div>
        </div>

        <!-- Champ Mot de passe -->
        <div class="mb-4 relative">
          <label class="block text-[#0b2c7a] font-semibold mb-1" for="password">Mot de passe</label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
              <Lock class="h-5 w-5 text-gray-400" />
            </span>
            <input
              id="password"
              v-model="password"
              :type="showPassword ? 'text' : 'password'"
              required
              placeholder="••••••••"
              class="w-full border border-gray-300 rounded pl-10 pr-10 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-[#0b2c7a] transition-all"
              :disabled="loading"
            />
            <button
              type="button"
              @click="togglePasswordVisibility"
              class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600"
              :disabled="loading"
            >
              <Eye v-if="!showPassword" class="h-5 w-5" />
              <EyeOff v-else class="h-5 w-5" />
            </button>
          </div>
        </div>

        <!-- Message d'erreur -->
        <div v-if="errorMessage" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
          <span class="block sm:inline">{{ errorMessage }}</span>
        </div>

        <!-- Bouton de connexion -->
        <button
          type="submit"
          :disabled="loading"
          class="w-full bg-yellow-400 hover:bg-yellow-500 disabled:bg-yellow-300 disabled:cursor-not-allowed text-white font-bold py-2 rounded transition mb-4 flex items-center justify-center"
        >
          <span v-if="loading" class="inline-block animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-2"></span>
          {{ loading ? 'Connexion...' : 'Se connecter' }}
        </button>
        
        <!-- Lien retour à l'accueil -->
        <Link
          href="/"
          class="w-full bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 rounded transition mb-4 inline-flex justify-center items-center"
        >
          Retour à l'accueil
        </Link>

        <!-- Lien d'inscription -->
        <div class="text-center">
          <p class="text-sm text-gray-600">
            Je n'ai pas de compte ! 
            <Link href="/register" class="text-yellow-600 hover:text-yellow-500 font-medium underline">
              S'inscrire
            </Link>
          </p>
        </div>

        <!-- Lien mot de passe oublié -->
        <div class="text-center mt-2">
          <Link href="/forgot-password" class="text-sm text-gray-500 hover:text-gray-700 underline">
            Mot de passe oublié ?
          </Link>
        </div>
        <!-- Affichage d'une alerte temporaire -->
    <div v-if="alertMessage" class="alert">
      {{ alertMessage }}
    </div>
      </form>
    </div>
  </section>
</template>
