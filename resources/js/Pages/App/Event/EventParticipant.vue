<script setup>
  import AppLayout from "@/Layouts/AppLayout.vue";
  import { ref, onMounted } from "vue";
  import { router } from '@inertiajs/vue3';
  import axios from 'axios';
  import {
    CalendarOutlined,
    EnvironmentOutlined,
    CheckCircleOutlined,
    ClockCircleOutlined,
    CloseCircleOutlined,
    UserOutlined,
    FilterOutlined
  } from '@ant-design/icons-vue';

  defineOptions({
    layout: AppLayout,
  });

// State
  const participations = ref([]);
  const loading = ref(false);
  const activeTab = ref('all');
  const filterStatus = ref([]);
  const pagination = ref({
    current: 1,
    pageSize: 10,
    total: 0
  });

// Status badge configurations
  const statusConfig = {
    registered: {
      color: 'processing',
      icon: ClockCircleOutlined,
      text: 'Terdaftar'
    },
    attended: {
      color: 'success',
      icon: CheckCircleOutlined,
      text: 'Hadir'
    },
    cancelled: {
      color: 'error',
      icon: CloseCircleOutlined,
      text: 'Dibatalkan'
    }
  };

// Methods
  const fetchEvents = async () => {
    loading.value = true;
    try {
      const response = await axios.get(route('app.event-participants.api'), {
        params: {
          status: filterStatus.value,
          page: pagination.value.current,
          limit: pagination.value.pageSize
        }
      });
      participations.value = response.data.data;
      pagination.value.total = response.data.meta.total;
    } catch (error) {
      message.error('Gagal memuat data partisipasi event');
    } finally {
      loading.value = false;
    }
  };

  const handleTabChange = (tabKey) => {
    activeTab.value = tabKey;
    filterStatus.value = tabKey === 'all' ? [] : [tabKey];
    pagination.value.current = 1;
    fetchEvents();
  };

  const formatDate = (date) => {
    return new Date(date).toLocaleDateString('id-ID', {
      weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric',
    });
  };

  const formatTime = (date) => {
    return new Date(date).toLocaleTimeString('id-ID', {
      hour: '2-digit',
      minute: '2-digit'
    });
  };

  onMounted(() => {
    fetchEvents();
  });
</script>

<template>
  <div class="event-participations">
    <!-- Header Section -->
    <a-row>
      <a-col :span="24">
        <div class="header-content">
          <a-page-header
          title="Event Saya"
          subtitle="Daftar partisipasi event Anda"
          >
          <template #extra>
            <a-space>
              <a-button type="primary" @click="() => router.visit('/events')">
                Cari Event Baru
              </a-button>
            </a-space>
          </template>
        </a-page-header>
      </div>
    </a-col>
  </a-row>

  <!-- Tabs & Content -->
  <a-card :bordered="false">
    <a-tabs v-model:activeKey="activeTab" @change="handleTabChange">
      <a-tab-pane key="all" tab="Semua Event" />
      <a-tab-pane key="registered" tab="Terdaftar" />
      <a-tab-pane key="attended" tab="Telah Hadir" />
      <a-tab-pane key="cancelled" tab="Dibatalkan" />
    </a-tabs>

    <a-spin :spinning="loading">
      <div v-if="participations.length > 0">
        <a-list
        :data-source="participations"
        :pagination="false"
        item-layout="vertical"
        >
        <template #renderItem="{ item }">
          <a-list-item>
            <a-card :bordered="false" class="participation-card">
              <a-row :gutter="[16, 16]">
                <!-- Event Image -->
                <a-col :xs="24" :sm="8" :md="6">
                  <img
                  v-if="item.event && item.event.thumbnail_url"
                  :src="item.event.thumbnail_url"
                  :alt="item.event.title"
                  class="event-image"
                  />
                  <img
                  v-else
                  src="https://thumbs.dreamstime.com/b/vector-illustration-avatar-dummy-logo-collection-image-icon-stock-isolated-object-set-symbol-web-137160339.jpg"
                  alt="Gambar tidak tersedia"
                  class="event-image"
                  />
                </a-col>

                <!-- Event Details -->
                <a-col :xs="24" :sm="16" :md="18">
                  <div class="event-info">
                    <div class="event-header">
                      <h3 class="event-title">{{ item.event.title }}</h3>
                      <a-tag :color="statusConfig[item.status].color">
                        <component :is="statusConfig[item.status].icon" />
                        <span>{{ statusConfig[item.status].text }}</span>
                      </a-tag>
                    </div>

                    <a-descriptions :column="{ xxl: 2, xl: 2, lg: 2, md: 1, sm: 1, xs: 1 }">
                      <a-descriptions-item>
                        <template #label>
                          <CalendarOutlined class="icon" /> Tanggal Event
                        </template>
                        {{ formatDate(item.event.date) }}
                      </a-descriptions-item>

                      <a-descriptions-item>
                        <template #label>
                          <ClockCircleOutlined class="icon" /> Waktu
                        </template>
                        {{ formatTime(item.event.date) }}
                      </a-descriptions-item>

                      <a-descriptions-item>
                        <template #label>
                          <EnvironmentOutlined class="icon" /> Lokasi
                        </template>
                        {{ item.event.location }}
                      </a-descriptions-item>

                      <a-descriptions-item>
                        <template #label>
                          <UserOutlined class="icon" /> Penyelenggara
                        </template>
                        {{ item.event.organizer?.username }}
                      </a-descriptions-item>
                    </a-descriptions>

                    <div class="registration-info">
                      <p>Terdaftar pada: {{ formatDate(item.registered_at) }}</p>
                    </div>

                    <div class="action-buttons">
                      <a-button @click="() => router.visit(`/events/${item.event.id}`)">
                        Lihat Detail Event
                      </a-button>
                    </div>
                  </div>
                </a-col>
              </a-row>
            </a-card>
          </a-list-item>
        </template>
      </a-list>

      <!-- Pagination -->
      <div class="pagination">
        <a-pagination
        v-model:current="pagination.current"
        :total="pagination.total"
        :pageSize="pagination.pageSize"
        @change="fetchEvents"
        show-quick-jumper
        show-size-changer
        :pageSizeOptions="['10', '20', '30', '40']"
        />
      </div>
    </div>

    <a-empty
    v-else-if="!loading"
    description="Belum ada event yang diikuti"
    >
    <template #extra>
      <a-button type="primary" @click="() => router.visit('/events')">
        Cari Event
      </a-button>
    </template>
  </a-empty>
</a-spin>
</a-card>
</div>
</template>

<style scoped>
  .event-participations {
    padding: 24px;
  }

  .header-content {
    margin-bottom: 24px;
    background: #fff;
  }

  .participation-card {
    margin-bottom: 16px;
  }

  .event-image {
    width: 100%;
    height: 160px;
    object-fit: cover;
    border-radius: 8px;
  }

  .event-info {
    height: 100%;
    display: flex;
    flex-direction: column;
  }

  .event-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
  }

  .event-title {
    margin: 0;
    font-size: 18px;
  }

  .icon {
    color: #1890ff;
  }

  .registration-info {
    margin-top: 16px;
    color: rgba(0, 0, 0, 0.45);
  }

  .action-buttons {
    margin-top: 16px;
  }

  .pagination {
    margin-top: 24px;
    text-align: right;
  }
</style>