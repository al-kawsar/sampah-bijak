<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { onMounted, ref, computed } from "vue";
import { Card, DatePicker, Select, message, Empty } from "ant-design-vue";
import {
  CalendarOutlined,
  ClockCircleOutlined,
  UserOutlined,
  EnvironmentOutlined,
  CarOutlined,
} from "@ant-design/icons-vue";
import axios from "axios";
import dayjs from "dayjs";
import "dayjs/locale/id";

dayjs.locale("id");

defineOptions({
  layout: AppLayout,
});

const schedules = ref([]);
const loading = ref(true);
const selectedDate = ref(null);
const selectedStatus = ref(null);

// Status colors for tags
const statusColors = {
  pending: "#FFA940",
  confirmed: "#40A9FF",
  completed: "#73D13D",
  cancelled: "#FF4D4F",
};

// Status labels in Indonesian
const statusLabels = {
  pending: "Menunggu",
  confirmed: "Dikonfirmasi",
  completed: "Selesai",
  cancelled: "Dibatalkan",
};

const fetchSchedules = async () => {
  loading.value = true;
  axios
    .get(route("app.pickup-schedules.api"))
    .then((res) => {
      const { data, meta } = res.data;
      schedules.value = data;
    })
    .catch((err) => {
      message.error(err.response.data.message);
    })
    .finally(() => {
      loading.value = false;
    });
};

const filteredSchedules = computed(() => {
  let filtered = [...schedules.value];

  if (selectedDate.value) {
    filtered = filtered.filter(
      (schedule) => schedule.pickup_date === selectedDate.value.format("YYYY-MM-DD")
    );
  }

  if (selectedStatus.value) {
    filtered = filtered.filter((schedule) => schedule.status === selectedStatus.value);
  }

  return filtered;
});

const handleDateChange = (date) => {
  selectedDate.value = date;
};

const handleStatusChange = (status) => {
  selectedStatus.value = status;
};

onMounted(() => {
  fetchSchedules();
});
</script>

<template>
  <div class="container">
    <div class="header">
      <h1 class="title">Jadwal Pengangkutan Sampah</h1>
      <p class="subtitle">
        Lihat jadwal pengangkutan sampah di area Anda
      </p>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
      <div class="filter-container">
        <a-date-picker
          v-model:value="selectedDate"
          @change="handleDateChange"
          placeholder="Pilih Tanggal"
          class="date-picker"
        />
        <a-select
          v-model:value="selectedStatus"
          placeholder="Filter Status"
          class="status-select"
          @change="handleStatusChange"
          allow-clear
        >
          <a-select-option
            v-for="(label, status) in statusLabels"
            :key="status"
            :value="status"
          >
            {{ label }}
          </a-select-option>
        </a-select>
      </div>
    </div>

    <!-- Schedule Cards -->
    <div class="schedule-grid">
      <div
        v-for="schedule in filteredSchedules"
        :key="schedule.id"
        class="schedule-card"
      >
        <!-- Status Badge -->
        <div
          class="status-badge"
          :style="{
            backgroundColor: `${statusColors[schedule.status]}15`,
            color: statusColors[schedule.status],
          }"
        >
          {{ statusLabels[schedule.status] }}
        </div>

        <!-- Schedule Info -->
        <div class="schedule-info">
          <div class="info-item">
            <CalendarOutlined class="info-icon" />
            <span>{{ dayjs(schedule.pickup_date).format("DD MMMM YYYY") }}</span>
          </div>
          
          <div class="info-item">
            <ClockCircleOutlined class="info-icon" />
            <span>{{ dayjs(`2000-01-01 ${schedule.pickup_time}`).format("HH:mm") }} WIB</span>
          </div>

          <div class="info-item">
            <UserOutlined class="info-icon" />
            <span>{{ schedule.user.name }}</span>
          </div>

          <div class="notes-section">
            <h4 class="notes-title">Catatan:</h4>
            <p class="notes-content">{{ schedule.notes || "-" }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-if="!loading && filteredSchedules.length === 0" class="empty-state">
      <a-empty
        description="Tidak ada jadwal pengangkutan yang ditemukan"
      />
    </div>
  </div>
</template>

<style scoped>
.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 24px 16px;
}

.header {
  margin-bottom: 32px;
}

.title {
  font-size: 28px;
  font-weight: bold;
  color: #1f2937;
  margin-bottom: 8px;
}

.subtitle {
  color: #6b7280;
  font-size: 16px;
}

.filter-section {
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  padding: 16px;
  margin-bottom: 24px;
}

.filter-container {
  display: flex;
  flex-wrap: wrap;
  gap: 16px;
}

.date-picker,
.status-select {
  width: 200px;
}

.schedule-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 24px;
}

.schedule-card {
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  transition: box-shadow 0.2s ease;
  padding: 24px;
}

.schedule-card:hover {
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.status-badge {
  display: inline-block;
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 14px;
  font-weight: 500;
  margin-bottom: 16px;
}

.schedule-info {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.info-item {
  display: flex;
  align-items: center;
  color: #4b5563;
}

.info-icon {
  margin-right: 8px;
}

.notes-section {
  margin-top: 16px;
  padding-top: 16px;
  border-top: 1px solid #e5e7eb;
}

.notes-title {
  font-size: 14px;
  font-weight: 500;
  color: #6b7280;
  margin-bottom: 8px;
}

.notes-content {
  color: #4b5563;
}

.empty-state {
  text-align: center;
  padding: 48px 0;
}

/* Responsive Styles */
@media (max-width: 768px) {
  .schedule-grid {
    grid-template-columns: 1fr;
  }
  
  .filter-container {
    flex-direction: column;
  }

  .date-picker,
  .status-select {
    width: 100%;
  }
}
</style>