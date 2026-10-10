<script setup>
import { ref, onMounted, watch } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

const form = ref({
  nom: '',
  prenom: '',
  email: '',
  password: '',
  password_confirmation: '',
  num_telephone: '',
  ville_id: '',
  quartier_id: '',
  nom_Entreprise: '',
  ICE: '',
  Bank: '',
  RIB: '',
  role: 'prestataire',
  fichier_assurance: null,
  logo: null
});

const villes = ref([]);
const quartiers = ref([]);
const errors = ref({});
const isLoading = ref(false);
const isLoadingQuartiers = ref(false);

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

watch(() => form.value.ville_id, async (newVilleId) => {
  if (newVilleId) {
    isLoadingQuartiers.value = true;
    form.value.quartier_id = '';
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

function handleFileUpload(event, fieldName) {
  const file = event.target.files[0];
  if (file) {
    form.value[fieldName] = file;
  }
}

function submit() {
  errors.value = {};
  isLoading.value = true;

  const formData = new FormData();
  Object.keys(form.value).forEach(key => {
    if (form.value[key] !== null && form.value[key] !== '') {
      formData.append(key, form.value[key]);
    }
  });

  // Sécuriser la récupération du CSRF token
  const csrfMeta = document.querySelector('meta[name="csrf-token"]');
  const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

  fetch('/api/register-prestataire', {
    method: 'POST',
    body: formData,
    headers: {
      'X-CSRF-TOKEN': csrfToken
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert(data.message);
      window.location.href = data.redirect;
    } else {
      errors.value = data.errors || {};
      if (data.message) {
        alert(data.message);
      }
    }
  })
  .catch(error => {
    console.error('Erreur:', error);
    alert('Une erreur est survenue lors de l\'inscription');
  })
  .finally(() => {
    isLoading.value = false;
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
        class="bg-white bg-opacity-90 backdrop-blur-md rounded-lg shadow-lg p-8 max-w-4xl w-full"
      >
        <!-- Logo -->
        <div class="flex items-center mb-2 space-x-3 justify-center">
          <img src="/logo.png" alt="AlloMénage Logo" class="h-30 w-30" />
        </div>

        <h2 class="text-3xl font-bold text-[#0b2c7a] mb-6 text-center">Inscription Prestataire</h2>

        <!-- Informations personnelles -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
          <!-- Nom -->
          <div>
            <label class="block text-[#0b2c7a] font-semibold mb-1" for="nom">Nom</label>
            <input
              id="nom"
              v-model="form.nom"
              type="text"
              required
              placeholder="Votre nom"
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-[#0b2c7a]"
            />
            <p v-if="errors.nom" class="text-red-500 text-sm mt-1">{{ errors.nom[0] }}</p>
          </div>

          <!-- Prénom -->
          <div>
            <label class="block text-[#0b2c7a] font-semibold mb-1" for="prenom">Prénom</label>
            <input
              id="prenom"
              v-model="form.prenom"
              type="text"
              required
              placeholder="Votre prénom"
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-[#0b2c7a]"
            />
            <p v-if="errors.prenom" class="text-red-500 text-sm mt-1">{{ errors.prenom[0] }}</p>
          </div>
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
          />
          <p v-if="errors.num_telephone" class="text-red-500 text-sm mt-1">{{ errors.num_telephone[0] }}</p>
        </div>

        <!-- Ville et Quartier -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
          <!-- Ville -->
          <div>
            <label class="block text-[#0b2c7a] font-semibold mb-1" for="ville_id">Ville</label>
            <select
              id="ville_id"
              v-model="form.ville_id"
              required
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-[#0b2c7a]"
            >
              <option value="">Sélectionnez une ville</option>
              <option v-for="ville in villes" :key="ville.id" :value="ville.id">
                {{ ville.nom_ville }}
              </option>
            </select>
            <p v-if="errors.ville_id" class="text-red-500 text-sm mt-1">{{ errors.ville_id[0] }}</p>
          </div>

          <!-- Quartier -->
          <div>
            <label class="block text-[#0b2c7a] font-semibold mb-1" for="quartier_id">Quartier</label>
            <select
              id="quartier_id"
              v-model="form.quartier_id"
              required
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-[#0b2c7a]"
              :disabled="isLoadingQuartiers || !form.ville_id"
            >
              <option value="">Sélectionnez un quartier</option>
              <option v-for="quartier in quartiers" :key="quartier.id" :value="quartier.id">
                {{ quartier.nom_quartier }}
              </option>
            </select>
            <p v-if="errors.quartier_id" class="text-red-500 text-sm mt-1">{{ errors.quartier_id[0] }}</p>
          </div>
        </div>

        <!-- Informations entreprise -->
        <div class="mb-4">
          <label class="block text-[#0b2c7a] font-semibold mb-1" for="nom_Entreprise">Nom de l'entreprise</label>
          <input
            id="nom_Entreprise"
            v-model="form.nom_Entreprise"
            type="text"
            required
            placeholder="Nom de votre entreprise"
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-[#0b2c7a]"
          />
          <p v-if="errors.nom_Entreprise" class="text-red-500 text-sm mt-1">{{ errors.nom_Entreprise[0] }}</p>
        </div>

        <!-- Informations bancaires -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
          <!-- ICE -->
          <div>
            <label class="block text-[#0b2c7a] font-semibold mb-1" for="ICE">ICE (optionnel)</label>
            <input
              id="ICE"
              v-model="form.ICE"
              type="text"
              placeholder="Numéro ICE"
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-[#0b2c7a]"
            />
            <p v-if="errors.ICE" class="text-red-500 text-sm mt-1">{{ errors.ICE[0] }}</p>
          </div>

          <!-- Bank -->
          <div>
            <label class="block text-[#0b2c7a] font-semibold mb-1" for="Bank">Banque (optionnel)</label>
            <input
              id="Bank"
              v-model="form.Bank"
              type="text"
              placeholder="Nom de la banque"
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-[#0b2c7a]"
            />
            <p v-if="errors.Bank" class="text-red-500 text-sm mt-1">{{ errors.Bank[0] }}</p>
          </div>

          <!-- RIB -->
          <div>
            <label class="block text-[#0b2c7a] font-semibold mb-1" for="RIB">RIB (optionnel)</label>
            <input
              id="RIB"
              v-model="form.RIB"
              type="text"
              placeholder="Numéro RIB"
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-[#0b2c7a]"
            />
            <p v-if="errors.RIB" class="text-red-500 text-sm mt-1">{{ errors.RIB[0] }}</p>
          </div>
        </div>

        <!-- Upload fichiers -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
          <!-- Fichier assurance -->
          <div>
            <label class="block text-[#0b2c7a] font-semibold mb-1" for="fichier_assurance">
              Fichier d'assurance (optionnel)
            </label>
            <input
              id="fichier_assurance"
              type="file"
              accept=".pdf,.jpg,.jpeg,.png"
              @change="handleFileUpload($event, 'fichier_assurance')"
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-[#0b2c7a]"
            />
            <p v-if="errors.fichier_assurance" class="text-red-500 text-sm mt-1">{{ errors.fichier_assurance[0] }}</p>
          </div>

          <!-- Logo -->
          <div>
            <label class="block text-[#0b2c7a] font-semibold mb-1" for="logo">Logo (optionnel)</label>
            <input
              id="logo"
              type="file"
              accept=".jpg,.jpeg,.png"
              @change="handleFileUpload($event, 'logo')"
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-[#0b2c7a]"
            />
            <p v-if="errors.logo" class="text-red-500 text-sm mt-1">{{ errors.logo[0] }}</p>
          </div>
        </div>

        <!-- Mots de passe -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
          <!-- Mot de passe -->
          <div>
            <label class="block text-[#0b2c7a] font-semibold mb-1" for="password">Mot de passe</label>
            <input
              id="password"
              v-model="form.password"
              type="password"
              required
              placeholder="••••••••"
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-[#0b2c7a]"
            />
            <p v-if="errors.password" class="text-red-500 text-sm mt-1">{{ errors.password[0] }}</p>
          </div>

          <!-- Confirmation mot de passe -->
          <div>
            <label class="block text-[#0b2c7a] font-semibold mb-1" for="password_confirmation">
              Confirmer le mot de passe
            </label>
            <input
              id="password_confirmation"
              v-model="form.password_confirmation"
              type="password"
              required
              placeholder="••••••••"
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-[#0b2c7a]"
            />
            <p v-if="errors.password_confirmation" class="text-red-500 text-sm mt-1">{{ errors.password_confirmation[0] }}</p>
          </div>
        </div>

        <!-- Bouton s'inscrire -->
        <button
          type="submit"
          :disabled="isLoading"
          class="w-full bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-3 rounded transition mb-4 disabled:opacity-50 disabled:cursor-not-allowed"
        >
          <span v-if="isLoading">Inscription en cours...</span>
          <span v-else>S'inscrire comme prestataire</span>
        </button>

        <!-- Liens de navigation -->
        <div class="flex flex-col sm:flex-row gap-2 mb-4">
          <Link
            href="/"
            class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 rounded transition text-center"
          >
            Retour à l'accueil
          </Link>
        
        </div>

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