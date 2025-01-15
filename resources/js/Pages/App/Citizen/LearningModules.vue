<script setup>
  import { ref, onMounted, computed, h } from "vue";
  import AppLayout from "@/Layouts/AppLayout.vue";
  import { Card, Input, Table, Switch, Skeleton, Empty, Tag } from "ant-design-vue";
  import {
    SearchOutlined,
    BookOutlined,
    ClockCircleOutlined,
    EyeOutlined,
  } from "@ant-design/icons-vue";
  import axios from "axios";
  import { router } from "@inertiajs/vue3";

  defineOptions({
    layout: AppLayout,
  });

  const searchQuery = ref("");
  const isLoading = ref(true);
const viewMode = ref("card"); // 'card' or 'table'
const learningModules = ref([]);

const columns = [
{
  title: "Thumbnail",
  dataIndex: "thumbnail",
  key: "thumbnail",
  width: 120,
  customRender: ({ text }) =>
  h("img", {
    src: text,
    alt: "thumbnail",
    style: {
      width: "100px",
      height: "60px",
      objectFit: "cover",
      borderRadius: "4px",
    },
  }),
},
{
  title: "Title",
  dataIndex: "title",
  key: "title",
  sorter: (a, b) => a.title.localeCompare(b.title),
},
{
  title: "Description",
  dataIndex: "description",
  key: "description",
  ellipsis: true,
},
{
  title: "Created At",
  dataIndex: "created_at",
  key: "created_at",
  width: 200,
  customRender: ({ text }) => new Date(text).toLocaleDateString("id-ID"),
},
{
  title: "Action",
  key: "action",
  width: 100,
  customRender: ({ record }) =>
  h(
    "a-button",
    {
      type: "link",
      onClick: () => viewDetail(record.id),
    },
    [h(EyeOutlined), " View"]
    ),
},
];

const fetchLearningModules = async () => {
  try {
    isLoading.value = true;
    const response = await axios.get("/api/learnings");
    learningModules.value = response.data.data;
  } catch (error) {
    console.error("Error fetching Modul Pembelajaran:", error);
  } finally {
    isLoading.value = false;
  }
};

const viewDetail = (id) => {
  router.get(`/learnings/${id}`);
};

const filteredModules = computed(() => {
  // Pastikan learningModules.value adalah array sebelum melakukan filter
  if (!Array.isArray(learningModules.value)) {
    return [];
  }

  return learningModules.value.filter(
    (module) =>
    module.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    module.description.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

onMounted(() => {
  fetchLearningModules();
});
</script>

<template>
  <div class="learning-modules-page">
    <!-- Header Section -->
    <div class="header-section">
      <h1 class="page-title"><BookOutlined /> Modul Pembelajaran</h1>
      <div class="header-controls">
        <Input
        v-model:value="searchQuery"
        placeholder="Search modules..."
        :prefix="h(SearchOutlined)"
        class="search-input"
        />
      </div>
    </div>

    <!-- Content Section -->
    <div class="content-section">
      <!-- Loading State -->
      <Skeleton active :loading="isLoading">
        <!-- Card View -->
        <div class="card-grid">
          <Card
          v-for="module in filteredModules"
          :key="module.id"
          hoverable
          class="module-card"
          @click="viewDetail(module.id)"
          >
          <img :src="module.thumbnail" :alt="module.title" class="card-thumbnail" />
          <Card.Meta :title="module.title">
            <template #description>
              <p class="card-description">{{ module.description }}</p>
              <div class="card-footer">
                <Tag color="blue">
                  <ClockCircleOutlined />
                  {{ new Date(module.created_at).toLocaleDateString("id-ID") }}
                </Tag>
              </div>
            </template>
          </Card.Meta>
        </Card>
      </div>
      <!-- Empty State -->
      <Empty v-if="!isLoading && filteredModules.length === 0" />
    </Skeleton>
  </div>
</div>
</template>

<style scoped>
  .learning-modules-page {
    padding: 24px;
  }

  .header-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
  }

  .page-title {
    font-size: 24px;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .header-controls {
    display: flex;
    gap: 16px;
    align-items: center;
  }

  .search-input {
    width: 300px;
  }

  .card-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
  }

  .module-card {
    height: 100%;
    transition: transform 0.2s;
  }

  .module-card:hover {
    transform: translateY(-4px);
  }

  .card-thumbnail {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px 8px 0 0;
  }

  .card-description {
    margin: 8px 0;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .card-footer {
    margin-top: 16px;
    display: flex;
    justify-content: flex-end;
  }
</style>
