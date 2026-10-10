<script setup>
import MainFooter from '@/components/MainFooter.vue'
import Topbar from '@/components/Topbar.vue'
</script>

<template>
  <div class="min-h-screen flex flex-col bg-gray-50">
    <Topbar />
    <main class="flex-1">
      <slot />
    </main>
    <MainFooter />
  </div>
</template>
