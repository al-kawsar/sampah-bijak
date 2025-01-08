<script setup>
import { ref, onMounted } from 'vue';
import AppLayout from "@/Layouts/AppLayout.vue";
import { Card, Row, Col, Statistic, Table } from 'ant-design-vue';
import {
  ClockCircleOutlined,
  CheckCircleOutlined,
  WarningOutlined,
  TeamOutlined
} from '@ant-design/icons-vue';
import { Doughnut } from 'vue-chartjs';
import axios from 'axios';

defineOptions({ layout: AppLayout });

const pendingPickups = ref(0);
const completedPickups = ref(0);
const urgentReports = ref(0);
const totalLocations = ref(0);

const pickupColumns = [
  { title: 'ID', dataIndex: 'id', key: 'id' },
  { title: 'Tanggal', dataIndex: 'pickup_date', key: 'pickup_date' },
  { title: 'Waktu', dataIndex: 'pickup_time', key: 'pickup_time' },
  { title: 'Status', dataIndex: 'status', key: 'status' },
];

const pickupData = ref([]);

onMounted(async () => {
  // Fetch petugas dashboard data
  try {
    const response = await axios.get('/api/pickup-schedules');
    // Update refs with response data
  } catch (error) {
    console.error('Error fetching dashboard data:', error);
  }
});
</script>

<template>
  <div class="dashboard-container p-6">
    <h1 class="text-2xl font-bold mb-6">Dashboard Petugas</h1>
    
    <Row :gutter="[16, 16]">
      <Col :span="6">
        <Card>
          <Statistic 
            title="Pickup Tertunda" 
            :value="pendingPickups"
            :prefix="h(ClockCircleOutlined)"
            class="text-yellow-600"
          />
        </Card>
      </Col>
      <Col :span="6">
        <Card>
          <Statistic 
            title="Pickup Selesai" 
            :value="completedPickups"
            :prefix="h(CheckCircleOutlined)"
            class="text-green-600"
          />
        </Card>
      </Col>
      <Col :span="6">
        <Card>
          <Statistic 
            title="Laporan Urgent" 
            :value="urgentReports"
            :prefix="h(WarningOutlined)"
            class="text-red-600"
          />
        </Card>
      </Col>
      <Col :span="6">
        <Card>
          <Statistic 
            title="Total Lokasi" 
            :value="totalLocations"
            :prefix="h(TeamOutlined)"
            class="text-blue-600"
          />
        </Card>
      </Col>
    </Row>

    <Row class="mt-6" :gutter="[16, 16]">
      <Col :span="16">
        <Card title="Jadwal Pickup Hari Ini">
          <Table 
            :columns="pickupColumns" 
            :data-source="pickupData" 
            :pagination="{ pageSize: 5 }"
          />
        </Card>
      </Col>
      <Col :span="8">
        <Card title="Status Pickup">
          <Doughnut 
            :data="{
              labels: ['Pending', 'Confirmed', 'Completed', 'Cancelled'],
              datasets: [{
                data: [30, 20, 40, 10],
                backgroundColor: ['#faad14', '#1890ff', '#52c41a', '#ff4d4f']
              }]
            }"
            :options="{ responsive: true }"
          />
        </Card>
      </Col>
    </Row>
  </div>
</template>