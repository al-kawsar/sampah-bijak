<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref, onMounted } from "vue";
import { router } from '@inertiajs/vue3';
import axios from 'axios';
import { 
  CalendarOutlined, 
  EnvironmentOutlined, 
  TeamOutlined,
  SearchOutlined,
  UserOutlined,
  ClockCircleOutlined
} from '@ant-design/icons-vue';

defineOptions({
  layout: AppLayout,
});

const events = ref([]);
const loading = ref(false);
const searchQuery = ref('');
const selectedDate = ref(null);
const pagination = ref({
  current: 1,
  pageSize: 9,
  total: 0
});

const fetchEvents = async () => {
  loading.value = true;
  try {
    const response = await axios.get('/api/events', {
      params: {
        search: searchQuery.value,
        date: selectedDate.value,
        page: pagination.value.current,
        limit: pagination.value.pageSize
      }
    });
    events.value = response.data.data;
    pagination.value.total = response.data.pagination.total;
  } catch (error) {
    message.error('Gagal memuat data event');
  } finally {
    loading.value = false;
  }
};

const handleSearch = () => {
  pagination.value.current = 1;
  fetchEvents();
};

const handleDateChange = (date) => {
  selectedDate.value = date;
  pagination.value.current = 1;
  fetchEvents();
};

const handleRegister = (eventId) => {
  router.get(`/events/${eventId}`);
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

const getStatusColor = (date) => {
  const eventDate = new Date(date);
  const now = new Date();
  if (eventDate < now) return 'error';
  if (eventDate.getTime() - now.getTime() < 7 * 24 * 60 * 60 * 1000) return 'warning';
  return 'success';
};

onMounted(() => {
  fetchEvents();
});
</script>

<template>
  <div class="event-page">
    <!-- Header Section -->
    <a-row class="header-section">
      <a-col :span="24">
        <div class="header-content">
          <h1 class="main-title">Event Komunitas</h1>
          <p class="subtitle">Temukan dan ikuti berbagai event menarik di sekitar Anda</p>
          
          <!-- Search Bar -->
          <div class="search-container">
            <a-input-search
              v-model:value="searchQuery"
              placeholder="Cari event..."
              enter-button="Cari"
              size="large"
              @search="handleSearch"
              class="search-input"
            >
              <template #prefix>
                <SearchOutlined />
              </template>
            </a-input-search>
          </div>
        </div>
      </a-col>
    </a-row>

    <a-row class="main-content">
      <a-col :span="24">
        <!-- Filter Section -->
        <div class="filter-section">
          <a-date-picker
            v-model:value="selectedDate"
            placeholder="Filter berdasarkan tanggal"
            @change="handleDateChange"
            class="date-picker"
          />
        </div>

        <!-- Events Grid -->
        <a-spin :spinning="loading">
          <a-row :gutter="[16, 16]" v-if="events.length > 0">
            <a-col :xs="24" :sm="12" :md="8" v-for="event in events" :key="event.id">
              <a-card hoverable class="event-card">
                <template #cover>
                  <div class="card-image-container">
                    <img :src="event.thumbnail_url" :alt="event.title" class="event-image" />
                    <a-tag 
                      :color="getStatusColor(event.date)"
                      class="status-tag"
                    >
                      {{ new Date(event.date) < new Date() ? 'Selesai' : 'Akan Datang' }}
                    </a-tag>
                  </div>
                </template>

                <a-card-meta :title="event.title">
                  <template #description>
                    <div class="event-details">
                      <div class="detail-item">
                        <CalendarOutlined class="detail-icon" />
                        {{ formatDate(event.date) }}
                      </div>
                      
                      <div class="detail-item">
                        <ClockCircleOutlined class="detail-icon" />
                        {{ formatTime(event.date) }}
                      </div>
                      
                      <div class="detail-item">
                        <EnvironmentOutlined class="detail-icon" />
                        {{ event.location }}
                      </div>
                      
                      <div class="detail-item">
                        <TeamOutlined class="detail-icon" />
                        {{ event.capacity }} peserta
                      </div>
                      
                      <div class="detail-item">
                        <UserOutlined class="detail-icon" />
                        Diselenggarakan oleh: {{ event.organizer?.username }}
                      </div>

                      <div class="event-description">
                        {{ event.description }}
                      </div>
                    </div>
                  </template>
                </a-card-meta>

                <a-button 
                  type="primary" 
                  block
                  size="large"
                  @click="handleRegister(event.id)"
                  class="register-button"
                >
                  Lihat Detail & Daftar
                </a-button>
              </a-card>
            </a-col>
          </a-row>
          
          <div v-else-if="!loading" class="empty-state">
            <a-empty description="Tidak ada event ditemukan" />
          </div>
        </a-spin>

        <!-- Pagination -->
        <div class="pagination-container">
          <a-pagination
            v-model:current="pagination.current"
            :total="pagination.total"
            :pageSize="pagination.pageSize"
            @change="fetchEvents"
            show-quick-jumper
            show-size-changer
            :pageSizeOptions="['9', '18', '27', '36']"
          />
        </div>
      </a-col>
    </a-row>
  </div>
</template>

<style scoped>
.event-page {
  background: #f0f2f5;
  min-height: 100vh;
}

.header-section {
  background: linear-gradient(135deg, #1890ff 0%, #096dd9 100%);
  padding: 48px 24px;
}

.header-content {
  text-align: center;
  max-width: 800px;
  margin: 0 auto;
}

.main-title {
  color: #fff;
  font-size: 32px;
  margin-bottom: 16px;
}

.subtitle {
  color: rgba(255, 255, 255, 0.85);
  font-size: 16px;
  margin-bottom: 32px;
}

.search-container {
  max-width: 600px;
  margin: 0 auto;
}

.search-input {
  width: 100%;
}

.main-content {
  padding: 24px;
  max-width: 1200px;
  margin: 0 auto;
}

.filter-section {
  display: flex;
  justify-content: flex-end;
  margin-bottom: 24px;
}

.date-picker {
  width: 240px;
}

.event-card {
  height: 100%;
  display: flex;
  flex-direction: column;
}

.card-image-container {
  position: relative;
  height: 200px;
  overflow: hidden;
}

.event-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.status-tag {
  position: absolute;
  top: 12px;
  right: 12px;
}

.event-details {
  margin-top: 16px;
}

.detail-item {
  margin-bottom: 8px;
  color: rgba(0, 0, 0, 0.65);
}

.detail-icon {
  margin-right: 8px;
  color: #1890ff;
}

.event-description {
  margin: 16px 0;
  color: rgba(0, 0, 0, 0.65);
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.register-button {
  margin-top: 16px;
}

.pagination-container {
  margin-top: 48px;
  text-align: center;
}

.empty-state {
  padding: 48px 0;
  text-align: center;
}
</style>