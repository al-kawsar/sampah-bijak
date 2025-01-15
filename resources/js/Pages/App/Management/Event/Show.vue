<script setup>
  import AppLayout from "@/Layouts/AppLayout.vue";
  defineOptions({
    layout: AppLayout,
  });

  const props = defineProps({
    event: {
      required: true,
    },
  });
</script>

<template>
  <h1>Halaman Event</h1>
  <p>id: {{ event.id }}</p>
  <p>title: {{ event.title }}</p>
  <p>description: {{ event.description }}</p>
  <p>date: {{ event.date }}</p>
</template>
