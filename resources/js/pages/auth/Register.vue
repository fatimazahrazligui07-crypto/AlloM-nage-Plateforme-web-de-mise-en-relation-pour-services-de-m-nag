<script setup>
import { ref, onMounted, watch } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';

const form = ref({
  nom: '',
  prenom: '',
  email: '',
  password: '',
  password_confirmation: '',
  num_telephone: '',
  ville_id: '',
  quartier_id: '',
  role: 'client' // Par défaut client
});

const villes = ref([]);
const quartiers = ref([]);
const errors = ref({});
const isLoading = ref(false);
const isLoadingQuartiers = ref(false);

// Charger les villes au montage du composant
onMounted(async () => {
  try {
    const response = await fetch('/api/villes');
    const data = await response.json();
    if (data.success) {
      villes.value = data.data;
    }
  } catch (error) {
    console.error('Erreur lors du chargement des villes:', error);
  }
});

// Surveiller les changements de ville pour charger les quartiers
watch(() => form.value.ville_id, async (newVilleId) => {
  if (newVilleId) {
    isLoadingQuartiers.value = true;
    form.value.quartier_id = ''; // Reset quarter selection
    
    try {
      const response = await fetch(`/api/villes/${newVilleId}/quartiers`);
      const data = await response.json();
      if (data.success) {
        quartiers.value = data.data;
      }
    } catch (error) {
      console.error('Erreur lors du chargement des quartiers:', error);
    } finally {
      isLoadingQuartiers.value = false;
    }
  } else {
    quartiers.value = [];
    form.value.quartier_id = '';
  }
});

function submit() {
  errors.value = {};
  isLoading.value = true;
  
  Inertia.post('/api/register', form.value, {
    onSuccess: (response) => {
      if (response.props?.redirect) {
        // Afficher un message de succès avant la redirection
        alert(response.props.message); // Ou utilisez une bibliothèque comme Toastr ou SweetAlert2 pour des notifications plus élégantes
        // Rediriger automatiquement vers la page de connexion
        window.location.href = response.props.redirect;
      }
    },
    onError: (responseErrors) => {
      errors.value = responseErrors;
      isLoading.value = false;
    },
    onFinish: () => {
      isLoading.value = false;
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
        <!-- Logo -->
        <div class="flex items-center mb-2 space-x-3 justify-center">
          <img src="/logo.png" alt="AlloMénage Logo" class="h-30 w-30" />
        </div>

        <h2 class="text-3xl font-bold text-[#0b2c7a] mb-6 text-center">Inscription</h2>

        <!-- Nom -->
        <div class="mb-4">
          <label class="block text-[#0b2c7a] font-semibold mb-1" for="nom">Nom</label>
          <input
            id="nom"
            v-model="form.nom"
            type="text"
            required
            placeholder="Votre nom"
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-[#0b2c7a]"
            :disabled="isLoading"
          />
          <p v-if="errors.nom" class="text-red-500 text-sm mt-1">{{ errors.nom[0] }}</p>
        </div>

        <!-- Prénom -->
        <div class="mb-4">
          <label class="block text-[#0b2c7a] font-semibold mb-1" for="prenom">Prénom</label>
          <input
            id="prenom"
            v-model="form.prenom"
            type="text"
            required
            placeholder="Votre prénom"
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-[#0b2c7a]"
            :disabled="isLoading"
          />
          <p v-if="errors.prenom" class="text-red-500 text-sm mt-1">{{ errors.prenom[0] }}</p>
        </div>

        <!-- Email -->
        <div class="mb-4">
          <label class="block text-[#0b2c7a] font-semibold mb-1" for="email">Email</label>
          <input
            id="email"
            v-model="form.email"
            type="email"
            required
            placeholder="exemple@mail.com"
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-[#0b2c7a]"
            :disabled="isLoading"
          />
          <p v-if="errors.email" class="text-red-500 text-sm mt-1">{{ errors.email[0] }}</p>
        </div>

        <!-- Téléphone -->
        <div class="mb-4">
          <label class="block text-[#0b2c7a] font-semibold mb-1" for="num_telephone">Téléphone</label>
          <input
            id="num_telephone"
            v-model="form.num_telephone"
            type="tel"
            required
            placeholder="06 12 34 56 78"
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-[#0b2c7a]"
            :disabled="isLoading"
          />
          <p v-if="errors.num_telephone" class="text-red-500 text-sm mt-1">{{ errors.num_telephone[0] }}</p>
        </div>

        <!-- Ville -->
        <div class="mb-4">
          <label class="block text-[#0b2c7a] font-semibold mb-1" for="ville_id">Ville</label>
          <select
            id="ville_id"
            v-model="form.ville_id"
            required
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-[#0b2c7a]"
            :disabled="isLoading"
          >
            <option value="">Sélectionnez une ville</option>
            <option v-for="ville in villes" :key="ville.id" :value="ville.id">
              {{ ville.nom_ville }}
            </option>
          </select>
          <p v-if="errors.ville_id" class="text-red-500 text-sm mt-1">{{ errors.ville_id[0] }}</p>
        </div>

        <!-- Quartier -->
        <div class="mb-4">
          <label class="block text-[#0b2c7a] font-semibold mb-1" for="quartier_id">Quartier</label>
          <select
            id="quartier_id"
            v-model="form.quartier_id"
            required
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-[#0b2c7a]"
            :disabled="isLoading || isLoadingQuartiers || !form.ville_id"
          >
            <option value="">
              {{ isLoadingQuartiers ? 'Chargement...' : 'Sélectionnez un quartier' }}
            </option>
            <option v-for="quartier in quartiers" :key="quartier.id" :value="quartier.id">
              {{ quartier.nom_quartier }}
            </option>
          </select>
          <p v-if="errors.quartier_id" class="text-red-500 text-sm mt-1">{{ errors.quartier_id[0] }}</p>
        </div>

        <!-- Mot de passe -->
        <div class="mb-4">
          <label class="block text-[#0b2c7a] font-semibold mb-1" for="password">Mot de passe</label>
          <input
            id="password"
            v-model="form.password"
            type="password"
            required
            placeholder="••••••••"
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-[#0b2c7a]"
            :disabled="isLoading"
          />
          <p v-if="errors.password" class="text-red-500 text-sm mt-1">{{ errors.password[0] }}</p>
        </div>

        <!-- Confirmation mot de passe -->
        <div class="mb-6">
          <label class="block text-[#0b2c7a] font-semibold mb-1" for="password_confirmation">Confirmer mot de passe</label>
          <input
            id="password_confirmation"
            v-model="form.password_confirmation"
            type="password"
            required
            placeholder="••••••••"
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-[#0b2c7a]"
            :disabled="isLoading"
          />
        </div>

       <!-- Bouton s'inscrire -->
        <button
          type="submit"
          :disabled="isLoading"
          class="w-full bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-2 rounded transition mb-4 disabled:opacity-50 disabled:cursor-not-allowed"
        >
          <span v-if="isLoading">Inscription en cours...</span>
          <span v-else>S'inscrire</span>
        </button>
        
        <Link
          href="/"
          class="w-full bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-2 rounded transition mb-4 inline-flex justify-center"
        >
          Retour à l'accueil
        </Link>

        <div class="text-center text-sm text-[#0b2c7a]">
          Déjà inscrit ?
          <Link
            href="/login"
            class="text-yellow-400 font-semibold hover:underline ml-1"
          >
            Se connecter
          </Link>
        </div>
      </form>
    </div>
  </section>
</template>