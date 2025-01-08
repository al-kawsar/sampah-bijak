<script setup>
import { ref, onMounted, h } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import {
  Card,
  Row,
  Col,
  Statistic,
  List,
  Progress,
  Avatar,
  Tooltip,
} from "ant-design-vue";
import {
  ClearOutlined,
  CalendarOutlined,
  BellOutlined,
  EnvironmentOutlined,
  UserOutlined,
  ArrowUpOutlined,
  ArrowDownOutlined,
} from "@ant-design/icons-vue";

import { Line } from "vue-chartjs";
import {
  Chart as ChartJS,
  Title,
  Tooltip as ChartTooltip,
  Legend,
  LineElement,
  LinearScale,
  PointElement,
  CategoryScale,
} from "chart.js";

ChartJS.register(
  Title,
  ChartTooltip,
  Legend,
  LineElement,
  LinearScale,
  PointElement,
  CategoryScale
);

import axios from "axios";

defineOptions({ layout: AppLayout });

const stats = ref([
  {
    title: "Laporan Sampah",
    value: 0,
    icon: ClearOutlined,
    color: "green",
    trend: 12.5,
  },
  {
    title: "Event Mendatang",
    value: 0,
    icon: CalendarOutlined,
    color: "blue",
    trend: -5.2,
  },
  {
    title: "Pengingat Aktif",
    value: 0,
    icon: BellOutlined,
    color: "orange",
    trend: 8.7,
  },
  {
    title: "Lokasi Terdekat",
    value: 0,
    icon: EnvironmentOutlined,
    color: "red",
    trend: 15.3,
  },
]);

const remindersList = ref([
  {
    id: 1,
    title: "Pengangkutan Sampah",
    description: "Jadwal minggu ini",
    time: "09:00 AM",
    avatar: "https://cdn-icons-png.flaticon.com/512/7034/7034885.png",
  },
  {
    id: 2,
    title: "Kerja Bakti",
    description: "Bersihkan lingkungan",
    time: "14:00 PM",
    avatar:
      "https://greenmunicipalfund.ca/sites/default/files/2024-01/community_efficiency_financing.png",
  },
]);

const chartData = ref({
  labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
  datasets: [
    {
      label: "Laporan Sampah",
      data: [12, 19, 15, 17, 14, 13],
      borderColor: "#4CAF50",
      backgroundColor: "rgba(76, 175, 80, 0.2)",
      tension: 0.4,
      fill: true,
    },
  ],
});

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      display: false,
    },
  },
  scales: {
    y: {
      beginAtZero: true,
    },
  },
};

// onMounted(async () => {});
</script>

<template>
  <div class="dashboard-container">
    <div class="dashboard-header">
      <h1 class="dashboard-title">Dashboard Warga</h1>
      <div class="dashboard-header-actions">
        <Avatar :size="40" :icon="h(UserOutlined)" class="user-avatar" />
        <BellOutlined class="notification-icon" />
      </div>
    </div>

    <Row :gutter="[16, 16]" class="stats-row">
      <Col v-for="(stat, index) in stats" :key="index" :span="6">
        <Card :hoverable="true" class="stat-card">
          <div class="stat-card-content">
            <div :class="`stat-icon-wrapper stat-icon-${stat.color}`">
              <component :is="stat.icon" :class="`stat-icon stat-icon-${stat.color}`" />
            </div>
            <div class="stat-details">
              <Statistic :title="stat.title" :value="stat.value" />
              <div class="stat-trend">
                <component
                  :is="stat.trend > 0 ? ArrowUpOutlined : ArrowDownOutlined"
                  :class="stat.trend > 0 ? 'trend-up' : 'trend-down'"
                />
                <span
                  :class="stat.trend > 0 ? 'trend-up' : 'trend-down'"
                  class="trend-percentage"
                >
                  {{ Math.abs(stat.trend) }}%
                </span>
              </div>
            </div>
          </div>
        </Card>
      </Col>
    </Row>

    <Row :gutter="[16, 16]">
      <Col :span="16">
        <Card title="Statistik Laporan Sampah" class="chart-card">
          <div class="chart-container">
            <Line :data="chartData" :options="chartOptions" />
          </div>
        </Card>
      </Col>

      <Col :span="8">
        <Card title="Pengingat Terdekat" class="reminders-card">
          <List :data-source="remindersList">
            <template #renderItem="{ item }">
              <List.Item>
                <List.Item.Meta :title="item.title" :description="item.description">
                  <template #avatar>
                    <Avatar :src="item.avatar" />
                  </template>
                </List.Item.Meta>
                <div class="reminder-time">{{ item.time }}</div>
              </List.Item>
            </template>
          </List>
        </Card>
      </Col>
    </Row>
  </div>
</template>

<style scoped>
.dashboard-container {
  padding: 24px;
}

.dashboard-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
}

.dashboard-title {
  font-size: 24px;
  font-weight: bold;
  color: #333;
}

.dashboard-header-actions {
  display: flex;
  align-items: center;
  gap: 16px;
}

.user-avatar {
  cursor: pointer;
}

.notification-icon {
  font-size: 20px;
  color: #666;
  cursor: pointer;
}

.stats-row {
  margin-bottom: 24px;
}

.stat-card {
  transition: all 0.3s ease;
}

.stat-card:hover {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.stat-card-content {
  display: flex;
  align-items: center;
}

.stat-icon-wrapper {
  margin-right: 16px;
  padding: 12px;
  border-radius: 50%;
}

.stat-icon-green {
  background-color: #e6f7ff;
  color: #4caf50;
}
.stat-icon-blue {
  background-color: #e6f7ff;
  color: #1890ff;
}
.stat-icon-orange {
  background-color: #fff7e6;
  color: #fa8c16;
}
.stat-icon-red {
  background-color: #fff1f0;
  color: #ff4d4f;
}

.stat-details {
  flex-grow: 1;
}

.stat-trend {
  display: flex;
  align-items: center;
}

.trend-up {
  color: #52c41a;
}

.trend-down {
  color: #ff4d4f;
}

.trend-percentage {
  margin-left: 4px;
  font-size: 14px;
}

.chart-card {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.chart-container {
  height: 350px;
}

.reminders-card {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.reminder-time {
  color: #999;
}
</style>
