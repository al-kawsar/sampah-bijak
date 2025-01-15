<script setup>
  import AppLayout from "@/Layouts/AppLayout.vue";
  import { ref, onMounted } from "vue";
  import {
    Table,
    Button,
    Modal,
    Form,
    Input,
    DatePicker,
    TimePicker,
    Select,
    message,
    Tag
  } from "ant-design-vue";
  import axios from "axios";

  defineOptions({
    layout: AppLayout,
  });

  const dataSource = ref([]);
  const loading = ref(false);
  const visible = ref(false);
  const formMode = ref('create');
  const editId = ref(null);
  const pagination = ref({
    current: 1,
    pageSize: 10,
    total: 0,
  });

  const formState = ref({
    pickup_date: '',
    pickup_time: '',
    notes: '',
    status: 'pending'
  });

  const getStatusColor = (status) => {
    const statusColors = {
      pending: 'orange',
      confirmed: 'blue',
      completed: 'green',
      cancelled: 'red',
    };
    return statusColors[status] || 'default';
  };

  const columns = [
  {
    title: 'Tanggal Pengambilan',
    dataIndex: 'pickup_date',
    key: 'pickup_date',
  },
  {
    title: 'Waktu Pengambilan',
    dataIndex: 'pickup_time',
    key: 'pickup_time',
  },
  {
    title: 'Catatan',
    dataIndex: 'notes',
    key: 'notes',
  },
  {
    title: 'Status',
    dataIndex: 'status',
    key: 'status',
  },
  {
    title: 'Aksi',
    key: 'action',
    width: 200,
  },
  ];

  const fetchData = (params = {}) => {
    loading.value = true;
    axios.get(route('app.pickup-schedules.api'), {
      params: {
        page: params.page || pagination.value.current,
        limit: params.pageSize || pagination.value.pageSize,
        search: params.search,
      },
    })
    .then((response) => {
      console.log(response);
      dataSource.value = response.data.data;
      pagination.value = {
        ...pagination.value,
        total: response.data.meta.total,
      };
    })
    .catch((error) => {
    // Menangani error jika terjadi
      console.log(error);
      const errorMessage = error.response?.data?.message || 'Gagal mengambil data';
      message.error(errorMessage);
    })
    .finally(() => {
      loading.value = false;
    });
  };


  const handleTableChange = (pag) => {
    pagination.value.current = pag.current;
    fetchData();
  };

  const showModal = () => {
    formMode.value = 'create';
    editId.value = null;
    formState.value = {
      pickup_date: '',
      pickup_time: '',
      notes: '',
      status: 'pending'
    };
    visible.value = true;
  };

  const handleEdit = (record) => {
    formMode.value = 'edit';
    editId.value = record.id;
    formState.value = { ...record };
    visible.value = true;
  };

  const handleDelete = async (id) => {
    try {
      await axios.delete(route('app.pickup-schedules.destroy',id));
      message.success('Jadwal berhasil dihapus');
      fetchData();
    } catch (error) {
      message.error('Gagal menghapus jadwal');
    }
  };

  const handleSubmit = async () => {
    try {
      if (formMode.value === 'create') {
        await axios.post('/pickup-schedules', formState.value);
        message.success('Jadwal berhasil ditambahkan');
      } else {
        await axios.put(`/pickup-schedules/${editId.value}`, formState.value);
        message.success('Jadwal berhasil diperbarui');
      }
      visible.value = false;
      fetchData();
    } catch (error) {
      message.error('Gagal menyimpan jadwal');
    }
  };

  onMounted(() => {
    fetchData();
  });
</script>

<template>
  <div class="p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-semibold">Manajemen Jadwal Pengangkutan</h1>
      <Button type="primary" @click="showModal">
        + Tambah Jadwal
      </Button>
    </div>

    <Table
    :columns="columns"
    :data-source="dataSource"
    :loading="loading"
    :pagination="pagination"
    @change="handleTableChange"
    >
    <template #bodyCell="{ column, record }">
      <template v-if="column.key === 'status'">
        <Tag :color="getStatusColor(record.status)">
          {{ record.status }}
        </Tag>
      </template>
      <template v-if="column.key === 'action'">
        <div class="space-x-2">
          <Button type="primary" @click="handleEdit(record)">
            Edit
          </Button>
          <Button type="primary" danger @click="handleDelete(record.id)">
            Hapus
          </Button>
        </div>
      </template>
    </template>
  </Table>

  <Modal
  :open="visible"
  :title="formMode === 'create' ? 'Tambah Jadwal' : 'Edit Jadwal'"
  @ok="handleSubmit"
  @cancel="visible = false"
  >
  <Form layout="vertical">
    <Form.Item label="Tanggal Pengambilan">
      <DatePicker
      v-model:value="formState.pickup_date"
      class="w-full"
      format="YYYY-MM-DD"
      />
    </Form.Item>
    <Form.Item label="Waktu Pengambilan">
      <TimePicker
      v-model:value="formState.pickup_time"
      class="w-full"
      format="HH:mm"
      />
    </Form.Item>
    <Form.Item label="Catatan">
      <Input.TextArea
      v-model:value="formState.notes"
      :rows="4"
      />
    </Form.Item>
    <Form.Item label="Status">
      <Select v-model:value="formState.status" class="w-full">
        <Select.Option value="pending">Pending</Select.Option>
        <Select.Option value="confirmed">Confirmed</Select.Option>
        <Select.Option value="completed">Completed</Select.Option>
        <Select.Option value="cancelled">Cancelled</Select.Option>
      </Select>
    </Form.Item>
  </Form>
</Modal>
</div>
</template>