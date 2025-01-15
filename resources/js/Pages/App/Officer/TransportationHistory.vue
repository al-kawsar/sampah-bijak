<script setup>
  import { ref, onMounted, h } from 'vue';
  import AppLayout from "@/Layouts/AppLayout.vue";
  import {
    Table,
    Tag,
    Card,
    Typography,
    Space
  } from 'ant-design-vue';
  import {
    CalendarOutlined,
    ClockCircleOutlined,
    FileTextOutlined,
  } from '@ant-design/icons-vue';
  import axios from 'axios';

  defineOptions({ layout: AppLayout });

  const columns = [
  {
    title: 'Tanggal Pengangkutan',
    dataIndex: 'pickup_date',
    key: 'pickup_date',
    width: '15%',
    customRender: ({ text }) => (
      h(Space, { size: 'small' }, [
        h(CalendarOutlined),
        h('span', text)
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
        h(ClockCircleOutlined),
        h('span', text)
        ])
      )
  },
  {
    title: 'Catatan',
    dataIndex: 'notes',
    key: 'notes',
    customRender: ({ text }) => (
      h(Space, { size: 'small' }, [
        h(FileTextOutlined),
        h('span', text)
        ])
      )
  },
  ];

  const loading = ref(false);
  const dataSource = ref([]);

  const fetchData = async () => {
    try {
      loading.value = true;
      const response = await axios.get('/api/pickup-schedules');
      dataSource.value = response.data.data.map(item => ({
        ...item,
        key: item.id,
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
  <div class="p-6">
    <Card>
      <Typography.Title :level="4" class="!mb-6">
        Riwayat Pengangkutan
      </Typography.Title>

      <Table
      :columns="columns"
      :data-source="dataSource"
      :loading="loading"
      :scroll="{ x: 800 }"
      >
      <template #emptyText>
        <div class="py-8">
          Tidak ada riwayat pengangkutan
        </div>
      </template>
    </Table>
  </Card>
</div>
</template>