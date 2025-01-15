<script setup>
defineProps({
  content: String,
  collapsed: Boolean,
});
</script>
<template>
  <a-flex gap="small" class="logo" justify="center" align="center" horizontal>
    <img src="/logo.png" alt="logo" />
    <a-typography-title
      v-show="!collapsed"
      :level="4"
      :style="{ margin: 0, padding: 0 }"
      >{{ content }}</a-typography-title
    >
  </a-flex>
</template>

<style scoped>
.logo {
  height: 44px;
  cursor: pointer;
  margin: 16px;
  margin-bottom: 2rem;
}

.logo img {
  height: 100%;
}
</style>
