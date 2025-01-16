<script setup>
  import { ref } from "vue";
  import AppLayout from "@/Layouts/AppLayout.vue";
  import { Card, Breadcrumb } from "ant-design-vue";
  import { BookOutlined, ClockCircleOutlined, ArrowLeftOutlined } from "@ant-design/icons-vue";
  import { router } from "@inertiajs/vue3";

  defineOptions({
    layout: AppLayout,
  });

// Define props from Inertia
  const props = defineProps({
    module: {
      type: Object,
      required: true
    }
  });

  const goBack = () => {
    router.get('/learnings');
  };
</script>

<template>
  <div class="learning-module-detail">
    <!-- Breadcrumb Navigation -->
    <Breadcrumb class="breadcrumb-nav">
      <Breadcrumb.Item>
        <a @click="goBack">
          <ArrowLeftOutlined /> Back to Modules
        </a>
      </Breadcrumb.Item>
      <Breadcrumb.Item>
        <BookOutlined /> Module Detail
      </Breadcrumb.Item>
    </Breadcrumb>

    <div class="module-content">
      <!-- Header Section -->
      <div class="module-header">
        <img :src="module.thumbnail" :alt="module.title" class="module-thumbnail" />
        <div class="header-content">
          <h1 class="module-title">{{ module.title }}</h1>
          <div class="module-meta">
            <span class="meta-item">
              <ClockCircleOutlined />
              {{ new Date(module.created_at).toLocaleDateString("id-ID") }}
            </span>
          </div>
        </div>
      </div>

      <!-- Description Card -->
      <Card class="description-card">
        <h2>Description</h2>
        <p>{{ module.description }}</p>
      </Card>

      <!-- Main Content -->
      <Card class="content-card">
        <div v-html="module.content" class="formatted-content"></div>
      </Card>
    </div>
  </div>
</template>

<style scoped>
  .learning-module-detail {
    padding: 24px;
    max-width: 1200px;
    margin: 0 auto;
  }

  .breadcrumb-nav {
    margin-bottom: 24px;
  }

  .module-content {
    display: flex;
    flex-direction: column;
    gap: 24px;
  }

  .module-header {
    display: flex;
    flex-direction: column;
    gap: 24px;
    margin-bottom: 24px;
  }

  .module-thumbnail {
    width: 100%;
    max-height: 400px;
    object-fit: cover;
    border-radius: 8px;
  }

  .header-content {
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .module-title {
    font-size: 32px;
    margin: 0;
    color: #1f2937;
  }

  .module-meta {
    display: flex;
    gap: 16px;
    color: #6b7280;
  }

  .meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .description-card,
  .content-card {
    background: white;
    border-radius: 8px;
  }

  .formatted-content {
    line-height: 1.6;
  }

  .formatted-content :deep(h2) {
    font-size: 24px;
    margin-top: 32px;
    margin-bottom: 16px;
    color: #1f2937;
  }

  .formatted-content :deep(h3) {
    font-size: 20px;
    margin-top: 24px;
    margin-bottom: 12px;
    color: #374151;
  }

  .formatted-content :deep(p) {
    margin-bottom: 16px;
    color: #4b5563;
  }

  .formatted-content :deep(ul),
  .formatted-content :deep(ol) {
    margin-bottom: 16px;
    padding-left: 24px;
  }

  .formatted-content :deep(li) {
    margin-bottom: 8px;
  }

  @media (min-width: 768px) {
    .module-header {
      flex-direction: row;
      align-items: flex-start;
    }

    .module-thumbnail {
      width: 400px;
    }

    .header-content {
      flex: 1;
      padding: 0 24px;
    }
  }
</style>