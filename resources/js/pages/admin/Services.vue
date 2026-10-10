<script setup>
import { ref } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import Sidebar from '@/components/Admin/Sidebar.vue';
import '../../../css/global.css'

const props = defineProps({
  services: Array,
  typeServices: Array,
});

const isModalOpen = ref(false);
const isEditMode = ref(false);
const selectedService = ref(null);

const form = useForm({
  id: null,
  title: '',
  description: '',
  type_id: '',
  logo: null,
  _method: 'POST',
});

const openModal = (service = null) => {
  if (service) {
    isEditMode.value = true;
    selectedService.value = service;
    form.id = service.id;
    form.title = service.title;
    form.description = service.description;
    form.type_id = service.type_service.id;
    form._method = 'POST'; // Inertia uses POST for file uploads
  } else {
    isEditMode.value = false;
    selectedService.value = null;
    form.reset();
    form._method = 'POST';
  }
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
  form.reset();
  form.clearErrors();
};

const onFileChange = (e) => {
  form.logo = e.target.files[0];
};

const submit = () => {
  const url = isEditMode.value
    ? route('admin.services.update', { service: form.id })
    : route('admin.services.store');
  
  form.post(url, {
    onSuccess: () => closeModal(),
  });
};

const deleteService = (service) => {
  if (confirm('Êtes-vous sûr de vouloir supprimer ce service ?')) {
    const deleteForm = useForm({});
    deleteForm.delete(route('admin.services.destroy', { service: service.id }), {
        onSuccess: () => {
            // Gérer la réussite de la suppression si nécessaire
        }
    });
  }
};
</script>

<template>
  <div class="bg-gray-100 min-h-screen">
    <Sidebar />
    <div class="lg:pl-64">
      <div class="py-8">
        <div>
          <h1 class="text-2xl font-semibold leading-tight px-4 sm:px-8">Gestion des Services</h1>
        </div>
        <div class="my-2 flex sm:flex-row flex-col px-4 sm:px-8">
          <div class="block relative">
            <span class="h-full absolute inset-y-0 left-0 flex items-center pl-2">
              <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current text-gray-500">
                <path d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z"></path>
              </svg>
            </span>
            <input placeholder="Rechercher"
              class="appearance-none rounded-r rounded-l sm:rounded-l-none border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" />
          </div>
          <div class="sm:ml-auto">
            <button @click="openModal()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
              Ajouter un Service
            </button>
          </div>
        </div>
        <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
          <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
            <table class="min-w-full leading-normal">
              <thead>
                <tr>
                  <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Logo
                  </th>
                  <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Titre
                  </th>
                  <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Description
                  </th>
                  <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Type
                  </th>
                  <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Actions
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="service in services" :key="service.id">
                  <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    <div class="flex items-center">
                      <div class="flex-shrink-0 w-10 h-10">
                        <img class="w-full h-full rounded-full" :src="`/storage/${service.logo}`" alt="" v-if="service.logo"/>
                      </div>
                    </div>
                  </td>
                  <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    <p class="text-gray-900 whitespace-no-wrap">{{ service.title }}</p>
                  </td>
                  <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    <p class="text-gray-900 whitespace-no-wrap">{{ service.description.substring(0, 50) }}...</p>
                  </td>
                  <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    <p class="text-gray-900 whitespace-no-wrap">{{ service.type_service ? service.type_service.nom_type : 'Non défini' }}</p>
                  </td>
                  <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    <button @click="openModal(service)" class="text-indigo-600 hover:text-indigo-900">Modifier</button>
                    <button @click="deleteService(service)" class="text-red-600 hover:text-red-900 ml-4">Supprimer</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <teleport to="body">
      <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center">
        <!-- Fond assombri -->
        <div class="absolute inset-0 bg-gray-500 opacity-50"></div>
        <!-- Modale -->
        <div class="relative z-50 bg-white rounded-lg shadow-xl p-6 w-full max-w-lg">
          <form @submit.prevent="submit">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">{{ isEditMode ? 'Modifier le Service' : 'Ajouter un Service' }}</h3>
            <div class="mb-4">
              <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
              <input v-model="form.title" type="text" id="title" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
              <div v-if="form.errors.title" class="text-red-500 text-xs mt-1">{{ form.errors.title }}</div>
            </div>
            <div class="mb-4">
              <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
              <textarea v-model="form.description" id="description" rows="3" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
              <div v-if="form.errors.description" class="text-red-500 text-xs mt-1">{{ form.errors.description }}</div>
            </div>
            <div class="mb-4">
              <label for="type_id" class="block text-sm font-medium text-gray-700">Type de Service</label>
              <select v-model="form.type_id" id="type_id" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                <option v-for="type in typeServices" :key="type.id" :value="type.id">{{ type.nom_type }}</option>
              </select>
              <div v-if="form.errors.type_id" class="text-red-500 text-xs mt-1">{{ form.errors.type_id }}</div>
            </div>
            <div class="mb-4">
              <label for="logo" class="block text-sm font-medium text-gray-700">Logo</label>
              <input @change="onFileChange" type="file" id="logo" class="mt-1">
              <div v-if="form.errors.logo" class="text-red-500 text-xs mt-1">{{ form.errors.logo }}</div>
            </div>
            <div class="flex justify-end space-x-2 mt-6">
              <button @click="closeModal" type="button" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Annuler</button>
              <button type="submit" :disabled="form.processing" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                {{ isEditMode ? 'Mettre à jour' : 'Sauvegarder' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </teleport>
  </div>
</template>