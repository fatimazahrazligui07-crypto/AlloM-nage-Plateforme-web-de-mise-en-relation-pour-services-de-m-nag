<template>
  <div>
    <Head>
      <meta name="csrf-token" :content="$page.props.csrf_token">
    </Head>
    
    <slot />
  </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'
</script>
