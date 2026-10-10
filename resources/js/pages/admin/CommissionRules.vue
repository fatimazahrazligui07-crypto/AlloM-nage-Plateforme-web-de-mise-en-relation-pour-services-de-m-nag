<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import Sidebar from '@/components/Admin/Sidebar.vue';
import '../../../css/global.css'

const props = defineProps({ rules: Array })
const form = useForm({ min_amount: '', max_amount: '', rate: '', id: null })
const isEditing = ref(false)

const handleSubmit = () => {
  if (isEditing.value && form.id) {
    form.put(route('admin.commission-rules.update', form.id), {
      onSuccess: () => {
        isEditing.value = false
        form.reset()
      }
    })
  } else {
    form.post(route('admin.commission-rules.store'), {
      onSuccess: () => form.reset()
    })
  }
}

const editRule = (rule) => {
  form.min_amount = rule.min_amount
  form.max_amount = rule.max_amount
  form.rate = rule.rate
  form.id = rule.id
  isEditing.value = true
}

const cancelEdit = () => {
  isEditing.value = false
  form.reset()
}

const deleteRule = (id) => {
  if (confirm('Voulez-vous vraiment supprimer cette règle ?')) {
    form.delete(route('admin.commission-rules.destroy', id))
  }
}
</script>

<template>
  <div class="min-h-screen bg-gray-50">
    <Sidebar />
    <div class="lg:pl-64">
      <div class="p-8">
        <h1 class="text-2xl font-bold mb-4">Gestion des Commissions</h1>
        <form @submit.prevent="handleSubmit" class="mb-6 flex gap-4">
          <input v-model="form.min_amount" type="number" step="0.01" placeholder="Min" class="border p-2 rounded" />
          <input v-model="form.max_amount" type="number" step="0.01" placeholder="Max" class="border p-2 rounded" />
          <input v-model="form.rate" type="number" step="0.01" placeholder="%" class="border p-2 rounded" />
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            {{ isEditing ? 'Enregistrer' : 'Ajouter' }}
          </button>
          <button v-if="isEditing" type="button" @click="cancelEdit" class="ml-2 bg-gray-400 text-white px-4 py-2 rounded">
            Annuler
          </button>
        </form>
        <table class="min-w-full bg-white shadow rounded">
          <thead>
            <tr class="bg-blue-600 text-white">
              <th class="py-2 px-4 text-center">Intervalle</th>
              <th class="py-2 px-4 text-center">Pourcentage</th>
              <th class="py-2 px-4 text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="rule in rules" :key="rule.id">
              <td class="py-2 px-4 text-center">{{ rule.min_amount }} - {{ rule.max_amount }} MAD</td>
              <td class="py-2 px-4 text-center">{{ rule.rate }} %</td>
              <td class="py-2 px-4">
                <div class="flex justify-center gap-2">
                  <button
                    class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded"
                    @click="editRule(rule)"
                  >
                    Modifier
                  </button>
                  <button
                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded"
                    @click="deleteRule(rule.id)"
                  >
                    Annuler
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>