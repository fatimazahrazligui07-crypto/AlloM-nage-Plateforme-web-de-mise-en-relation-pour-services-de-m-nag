<template>
  <div class="timeline-item">
    <!-- Timeline Dot (avec couleur bleue et icône dynamique) -->
    <div class="timeline-dot">
      <i :class="item.icon"></i>  <!-- Icône dynamique -->
    </div>

    <!-- Timeline Content -->
    <div class="timeline-content">
      <p class="timeline-date">{{ item.date }}</p>
      <h3 class="timeline-title">{{ item.title }}</h3>
      <p class="timeline-description">{{ item.description }}</p>
    </div>
  </div>
</template>

<script setup>
defineProps({
  item: Object
})
</script>

<style scoped>
.timeline-item {
  display: flex;
  align-items: center;
  margin-bottom: 40px;
  position: relative;
}

.timeline-dot {
  width: 100px;
  height: 80px;
  border-radius: 30%;
  background-color: #1E3A8A; /* Couleur bleue */
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 90px;
  color: white;
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
  
}

.timeline-content {
  padding-left: 60px;
  border-left: 3px solid #1E3A8A; /* Couleur bleue */
  max-width: 600px;
}

.timeline-date {
  font-size: 14px;
  color: #1E3A8A; /* Couleur bleue */
  font-weight: bold;
  margin-bottom: 8px;
}

.timeline-title {
  font-size: 22px;
  font-weight: 600;
  color: #1E3A8A; /* Couleur bleue */
  margin-bottom: 10px;
}

.timeline-description {
  font-size: 16px;
  color: #4b5563;
  line-height: 1.5;
}
</style>
