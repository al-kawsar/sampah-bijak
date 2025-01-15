<script setup>
  import { ref, onMounted, h } from 'vue';
  import AppLayout from "@/Layouts/AppLayout.vue";
  import {
    Table,
    Tag,
    Card,
    Typography,
    Space,
    Badge,
    Statistic,
    Row,
    Col
  } from 'ant-design-vue';
  import {
    CalendarOutlined,
    ClockCircleOutlined,
    FileTextOutlined,
    CarOutlined,
    CheckCircleOutlined,
    FieldTimeOutlined
  } from '@ant-design/icons-vue';
  import axios from 'axios';
  import dayjs from 'dayjs';

  defineOptions({ layout: AppLayout });

  const columns = [
  {
    title: 'Tanggal',
    dataIndex: 'pickup_date',
    key: 'pickup_date',
    width: '20%',
    sorter: (a, b) => dayjs(a.pickup_date).unix() - dayjs(b.pickup_date).unix(),
    customRender: ({ text }) => (
      h(Space, { size: 'small' }, [
        h(CalendarOutlined, { style: { color: '#1890ff' } }),
        h('span', dayjs(text).format('DD MMMM YYYY'))
        ])
      )
  },
  {
    title: 'Waktu',
    dataIndex: 'pickup_time',
    key: 'pickup_time',
    width: '15%',
    customRender: ({ text }) => (
      h(Space, { size: 'small' }, [
        h(ClockCircleOutlined, { style: { color: '#1890ff' } }),
        h('span', dayjs(`2000-01-01 ${text}`).format('HH:mm'))
        ])
      )
  },
  {
    title: 'Catatan',
    dataIndex: 'notes',
    key: 'notes',
    ellipsis: true,
    customRender: ({ text }) => (
      h(Space, { size: 'small' }, [
        h(FileTextOutlined, { style: { color: '#1890ff' } }),
        h('span', text || '-')
        ])
      )
  },
  {
    title: 'Status',
    dataIndex: 'status',
    key: 'status',
    width: '15%',
    align: 'center',
    filters: [
      { text: 'Menunggu', value: 'pending' },
      { text: 'Dikonfirmasi', value: 'confirmed' }
      ],
    onFilter: (value, record) => record.status === value,
    customRender: ({ text }) => {
      const config = {
        pending: { color: 'orange', label: 'Menunggu' },
        confirmed: { color: 'blue', label: 'Dikonfirmasi' },
        completed: { color: 'green', label: 'Selesai' },
        cancelled: { color: 'red', label: 'Dibatalkan' }
      }[text];

      return h(Tag, {
        color: config.color,
        style: {
          minWidth: '100px',
          textAlign: 'center',
          textTransform: 'uppercase',
          fontSize: '12px'
        }
      }, config.label);
    }
  }
  ];

  const loading = ref(false);
  const todaySchedules = ref([]);
  const upcomingSchedules = ref([]);

  const fetchData = async () => {
    try {
      loading.value = true;
      const response = await axios.get('/api/pickup-schedules/oos');

      const today = dayjs().format('YYYY-MM-DD');

      todaySchedules.value = response.data
      .filter(item => dayjs(item.pickup_date).format('YYYY-MM-DD') === today)
      .map(item => ({
        ...item,
        key: item.id
      }));

      upcomingSchedules.value = response.data
      .filter(item => dayjs(item.pickup_date).format('YYYY-MM-DD') > today)
      .map(item => ({
        ...item,
        key: item.id
      }));

    } catch (error) {
      console.error('Error fetching data:', error);
    } finally {
      loading.value = false;
    }
  };

  onMounted(() => {
    fetchData();
  });
</script>

<template>
  <div class="bg-gray-50 min-h-screen p-6">
    <div class="max-w-7xl mx-auto">
      <!-- Overview Stats -->
      <Row :gutter="16" class="mb-6">
        <Col :span="8">
        <Card>
          <Statistic
          title="Jadwal Hari Ini"
          :value="todaySchedules.length"
          :value-style="{ color: '#1890ff' }"
          >
          <template #prefix>
            <CarOutlined />
          </template>
        </Statistic>
      </Card>
    </Col>
    <Col :span="8">
    <Card>
      <Statistic
      title="Jadwal Mendatang"
      :value="upcomingSchedules.length"
      :value-style="{ color: '#52c41a' }"
      >
      <template #prefix>
        <FieldTimeOutlined />
      </template>
    </Statistic>
  </Card>
</Col>
<Col :span="8">
<Card>
  <Statistic
  title="Total Jadwal"
  :value="todaySchedules.length + upcomingSchedules.length"
  :value-style="{ color: '#722ed1' }"
  >
  <template #prefix>
    <CheckCircleOutlined />
  </template>
</Statistic>
</Card>
</Col>
</Row>

<!-- Today's Schedules -->
<Card
class="mb-6 shadow-sm"
:bordered="false"
>
<template #title>
  <Space>
    <Badge status="processing" />
    <Typography.Title :level="4" style="margin: 0">
      Jadwal Hari Ini
    </Typography.Title>
  </Space>
</template>

<Table
:columns="columns"
:data-source="todaySchedules"
:loading="loading"
:pagination="{
  pageSize: 5,
  showSizeChanger: false,
  showTotal: total => `Total ${total} jadwal`
}"
:scroll="{ x: 800 }"
size="middle"
>
<template #emptyText>
  <div class="py-8 text-gray-500">
    Tidak ada jadwal pengangkutan hari ini
  </div>
</template>
</Table>
</Card>

<!-- Upcoming Schedules -->
<Card
:bordered="false"
class="shadow-sm"
>
<template #title>
  <Space>
    <Badge status="warning" />
    <Typography.Title :level="4" style="margin: 0">
      Jadwal Mendatang
    </Typography.Title>
  </Space>
</template>

<Table
:columns="columns"
:data-source="upcomingSchedules"
:loading="loading"
:pagination="{
  pageSize: 10,
  showSizeChanger: false,
  showTotal: total => `Total ${total} jadwal`
}"
:scroll="{ x: 800 }"
size="middle"
>
<template #emptyText>
  <div class="py-8 text-gray-500">
    Tidak ada jadwal pengangkutan mendatang
  </div>
</template>
</Table>
</Card>
</div>
</div>
</template>