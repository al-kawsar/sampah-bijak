<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
defineOptions({
  layout: AppLayout,
});

const props = defineProps({
  user: {
    type: Array,
  },
});

// const sidebarMenus = computed(() => props.sidebar_menus);
</script>

<template>
  <p>username : {{ user.username }}</p>
  <p>email : {{ user.email }}</p>
  <p>role_id : {{ user.role_id }}</p>
  <p>region_id : {{ user.region_id }}</p>
  <h1>Halaman Show Profile</h1>
</template>
