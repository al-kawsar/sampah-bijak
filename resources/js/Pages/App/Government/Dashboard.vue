<script setup>
  import { ref, onMounted, h } from 'vue';
  import AppLayout from "@/Layouts/AppLayout.vue";
  import { Card, Row, Col, Statistic } from 'ant-design-vue';
  import {
    BarChartOutlined,
    TeamOutlined,
    FileTextOutlined,
    EnvironmentOutlined
  } from '@ant-design/icons-vue';
  import { Bar } from 'vue-chartjs';
  import axios from 'axios';

  defineOptions({ layout: AppLayout });

  const totalWaste = ref(0);
  const activeUsers = ref(0);
  const totalReports = ref(0);
  const wasteLocations = ref(0);

  const regionData = ref({
    labels: ['Region A', 'Region B', 'Region C', 'Region D'],
    datasets: [{
      label: 'Total Sampah per Region',
      data: [300, 450, 320, 280],
      backgroundColor: '#1890ff'
    }]
  });

  onMounted(async () => {
  // Fetch pemerintah dashboard data
    try {
      const response = await axios.get('/api/waste-reports');
    // Update refs with response data
    } catch (error) {
      console.error('Error fetching dashboard data:', error);
    }
  });
</script>

<template>
  <div class="dashboard-container p-6">
    <h1 class="text-2xl font-bold mb-6">Dashboard Pemerintah</h1>
    
    <Row :gutter="[16, 16]">
      <Col :span="6">
      <Card>
        <Statistic 
        title="Total Sampah" 
        :value="totalWaste"
        :prefix="h(BarChartOutlined)"
        class="text-purple-600"
        suffix="kg"
        />
      </Card>
    </Col>
    <Col :span="6">
    <Card>
      <Statistic 
      title="Pengguna Aktif" 
      :value="activeUsers"
      :prefix="h(TeamOutlined)"
      class="text-blue-600"
      />
    </Card>
  </Col>
  <Col :span="6">
  <Card>
    <Statistic 
    title="Total Laporan" 
    :value="totalReports"
    :prefix="h(FileTextOutlined)"
    class="text-green-600"
    />
  </Card>
</Col>
<Col :span="6">
<Card>
  <Statistic 
  title="Lokasi Pembuangan" 
  :value="wasteLocations"
  :prefix="h(EnvironmentOutlined)"
  class="text-red-600"
  />
</Card>
</Col>
</Row>

<Row class="mt-6" :gutter="[16, 16]">
  <Col :span="16">
  <Card title="Statistik Sampah per Region">
    <Bar 
    :data="regionData"
    :options="{ responsive: true }"
    />
  </Card>
</Col>
<Col :span="8">
<Card title="Ringkasan Laporan">
  <a-timeline>
    <a-timeline-item>
      Region A: 30% peningkatan daur ulang
    </a-timeline-item>
    <a-timeline-item>
      Region B: 25% pengurangan sampah
    </a-timeline-item>
    <a-timeline-item>
      Region C: 40% partisipasi masyarakat
    </a-timeline-item>
  </a-timeline>
</Card>
</Col>
</Row>
</div>
</template>