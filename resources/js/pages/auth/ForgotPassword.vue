<script setup lang="ts">
import { ref } from 'vue';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { LoaderCircle } from 'lucide-vue-next';

// Initialisation du formulaire avec useForm
const form = useForm({
  email: '',
});

const successMessage = ref('');
const errorMessage = ref('');

// Soumettre le formulaire
function submit() {
  successMessage.value = '';
  errorMessage.value = '';
  form.clearErrors();

  // Utilisation de Inertia pour envoyer les données du formulaire
  form.post('/api/forgot-password', {
    onSuccess: () => {
      successMessage.value = 'Un email de réinitialisation a été envoyé si cet email est enregistré.';
    },
    onError: () => {
      errorMessage.value = 'Erreur lors de la demande. Veuillez réessayer.';
    },
  });
}
</script>

<template>
  <AuthLayout
    title="Mot de passe oublié"
    description="Entrez votre email pour recevoir un lien de réinitialisation de mot de passe"
    class="bg-white min-h-screen flex flex-col items-center justify-center px-6 py-20"
  >
    <div class="w-full max-w-md p-8 bg-white rounded-xl shadow-2xl">
      <!-- Logo -->
      <div class="flex justify-center mb-1">
        <img src="/logo.png" alt="AlloMénage Logo" class="h-30 w-30" />
      </div>
      <h3 class="text-2xl font-light text-[#0b2c7a] mb-6 text-center">
        Mot de passe oublié
      </h3>

      <form @submit.prevent="submit" class="space-y-6">
        <!-- Email avec champ de saisie -->
        <div class="relative">
          <Label for="email" class="block text-[#0b2c7a] font-semibold mb-1">Email</Label>
          <div class="relative">
            <Input
              id="email"
              v-model="form.email"
              type="email"
              required
              placeholder="exemple@mail.com"
              class="w-full border border-gray-300 rounded pl-10 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-[#0b2c7a]"
            />
            <InputError :message="form.errors.email" class="mt-2" />
          </div>
        </div>

        <!-- Messages de succès / erreur -->
        <p v-if="successMessage" class="text-green-600 mb-4 text-center font-semibold">
          {{ successMessage }}
        </p>
        <p v-if="errorMessage" class="text-red-500 mb-4 text-center font-semibold">
          {{ errorMessage }}
        </p>

        <!-- Bouton de soumission -->
        <Button
          type="submit"
          class="w-full bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-2 rounded transition"
        >
          <LoaderCircle v-if="form.processing" class="animate-spin mr-2" />
          Envoyer le lien de réinitialisation
        </Button>
      </form>

      <!-- Lien retour vers la connexion -->
      <div class="flex flex-col items-center justify-center text-sm text-[#0b2c7a] space-y-2">
       <a href="/login" class="text-black-400 font-semibold hover:underline">
           Connexion
        </a>
      </div>

      <!-- Lien retour à la page d'accueil -->
      <div class="flex flex-col items-center justify-center text-sm text-[#0b2c7a] space-y-2">
       <a href="/" class="text-black-400 font-light hover:underline">
             ← Retour à la page d'accueil
        </a>
      </div>
    </div>
  </AuthLayout>
</template>
