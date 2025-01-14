<script setup>
  import { ref, onMounted, h } from "vue";
  import AppLayout from "@/Layouts/AppLayout.vue";
  import { Card, Row, Col, Statistic, Table } from "ant-design-vue";
  import {
    UserOutlined,
    ProfileOutlined,
    NotificationOutlined,
  } from "@ant-design/icons-vue";
  import { Pie } from "vue-chartjs";
  import axios from "axios";

  defineOptions({ layout: AppLayout });

  const props = defineProps({
    data: {
      required: false
    }
  });

  const totalUsers = ref(props.data.totalUsers);
  const totalReports = ref(props.data.totalReports);
  const activeEvents = ref(props.data.totalEvents);
  const totalModules = ref(props.data.totalModules);

  const chartData = ref({
    labels: ['Total Users', 'Total Waste Reports', 'Active Events', 'Total Modules'],
    datasets: [
    {
      data: [
        totalUsers.value,
        totalReports.value,
        activeEvents.value,
        totalModules.value,
        ],
      backgroundColor: ['#722ed1', '#1890ff', '#52c41a', '#faad14'],
    },
    ],
  });


  const userColumns = [
  {
    title: "Username",
    dataIndex: "username",
    key: "username",
  },
  {
    title: "Role",
    dataIndex: "role_id",
    key: "role_id",
    customRender: ({ record }) => record.role?.name || "Tidak Tersedia",
  },
  {
    title: "Region",
    dataIndex: "region_id",
    key: "region_id",
    customRender: ({ record }) => record.region?.region_name || "Tidak Tersedia",
  },
  ];
  const userData = ref([]);

  onMounted(async () => {
  // Fetch admin dashboard data
    try {
      const response = await axios.get("/api/users");
      userData.value = response.data.data;
    } catch (error) {
      console.error("Error fetching dashboard data:", error);
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
  title="Total Module Pembelajaran"
  :value="totalModules"
  :prefix="h(ProfileOutlined)"
  class="text-green-600"
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
  :data="chartData"
  :options="{ responsive: true }"
  />
</Card>
</Col>
</Row>
</div>
</template>
