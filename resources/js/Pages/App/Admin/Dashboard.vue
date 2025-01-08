<script setup>
import { ref, onMounted } from 'vue';
import AppLayout from "@/Layouts/AppLayout.vue";
import { Card, Row, Col, Statistic, Table } from 'ant-design-vue';
import {
  UserOutlined,
  ProfileOutlined,
  NotificationOutlined,
  SettingOutlined
} from '@ant-design/icons-vue';
import { Pie } from 'vue-chartjs';
import axios from 'axios';

defineOptions({ layout: AppLayout });

const totalUsers = ref(0);
const totalReports = ref(0);
const activeEvents = ref(0);
const systemConfigs = ref(0);

const userColumns = [
  { title: 'Username', dataIndex: 'username', key: 'username' },
  { title: 'Role', dataIndex: 'role', key: 'role' },
  { title: 'Region', dataIndex: 'region', key: 'region' },
  { title: 'Status', dataIndex: 'status', key: 'status' },
];

const userData = ref([]);

onMounted(async () => {
  // Fetch admin dashboard data
  try {
    const response = await axios.get('/api/users');
    // Update refs with response data
  } catch (error) {
    console.error('Error fetching dashboard data:', error);
  }
});
</script>

<template>
  <div class="dashboard-container p-6">
    <h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>
    
    <Row :gutter="[16, 16]">
      <Col :span="6">
        <Card>
          <Statistic 
            title="Total Pengguna" 
            :value="totalUsers"
            :prefix="h(UserOutlined)"
            class="text-blue-600"
          />
        </Card>
      </Col>
      <Col :span="6">
        <Card>
          <Statistic 
            title="Total Laporan" 
            :value="totalReports"
            :prefix="h(ProfileOutlined)"
            class="text-green-600"
          />
        </Card>
      </Col>
      <Col :span="6">
        <Card>
          <Statistic 
            title="Event Aktif" 
            :value="activeEvents"
            :prefix="h(NotificationOutlined)"
            class="text-orange-600"
          />
        </Card>
      </Col>
      <Col :span="6">
        <Card>
          <Statistic 
            title="Konfigurasi Sistem" 
            :value="systemConfigs"
            :prefix="h(SettingOutlined)"
            class="text-purple-600"
          />
        </Card>
      </Col>
    </Row>

    <Row class="mt-6" :gutter="[16, 16]">
      <Col :span="16">
        <Card title="Daftar Pengguna Terbaru">
          <Table 
            :columns="userColumns" 
            :data-source="userData" 
            :pagination="{ pageSize: 5 }"
          />
        </Card>
      </Col>
      <Col :span="8">
        <Card title="Distribusi Role Pengguna">
          <Pie 
            :data="{
              labels: ['Admin', 'Pemerintah', 'Petugas', 'Warga'],
              datasets: [{
                data: [5, 15, 30, 50],
                backgroundColor: ['#722ed1', '#1890ff', '#52c41a', '#faad14']
              }]
            }"
            :options="{ responsive: true }"
          />
        </Card>
      </Col>
    </Row>
  </div>
</template>