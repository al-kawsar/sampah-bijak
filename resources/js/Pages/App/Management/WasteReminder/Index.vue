<script setup>
  import AppLayout from "@/Layouts/AppLayout.vue";
  import { onMounted, ref } from "vue";
  import {
    Card,
    Button,
    Form,
    Input,
    TimePicker,
    Select,
    Switch,
    List,
    Tag,
    Modal,
    message
  } from 'ant-design-vue';
  import {
    BellOutlined,
    DeleteOutlined,
    EditOutlined,
    PlusOutlined,
  } from '@ant-design/icons-vue';
  import dayjs from 'dayjs';
  import axios from 'axios';

  defineOptions({
    layout: AppLayout,
  });

  const reminders = ref([]);
  const showModal = ref(false);
  const loading = ref(false);
  const formRef = ref();
  const editingId = ref(null);

  const formState = ref({
    title: '',
    description: '',
    reminder_time: '',
    frequency: 'daily',
    is_active: true
  });

  const frequencyOptions = [
    { label: 'Harian', value: 'daily' },
    { label: 'Mingguan', value: 'weekly' },
    { label: 'Bulanan', value: 'monthly' }
    ];

  const frequencyColors = {
    daily: 'blue',
    weekly: 'green',
    monthly: 'purple'
  };

  const fetchReminders = async () => {
    try {
      loading.value = true;
      const response = await axios.get('/api/waste-reminders');
      reminders.value = response.data.data;
    } catch (error) {
      message.error('Gagal memuat pengingat');
    } finally {
      loading.value = false;
    }
  };

  const handleSubmit = async () => {
    try {
      await formRef.value.validate();
      loading.value = true;

      const data = {
        ...formState.value,
        reminder_time: dayjs(formState.value.reminder_time).format('HH:mm')
      };

      if (editingId.value) {
        await axios.patch(`/waste-reminders/${editingId.value}`, data);
        message.success('Pengingat berhasil diperbarui');
      } else {
        await axios.post('/waste-reminders', data);
        message.success('Pengingat berhasil dibuat');
      }

      showModal.value = false;
      resetForm();
      fetchReminders();
    } catch (error) {
      message.error('Gagal menyimpan pengingat');
    } finally {
      loading.value = false;
    }
  };

  const handleEdit = (reminder) => {
    editingId.value = reminder.id;
    formState.value = {
      ...reminder,
      reminder_time: dayjs(reminder.reminder_time, 'HH:mm')
    };
    showModal.value = true;
  };

  const handleDelete = async (id) => {
    try {
      await Modal.confirm({
        title: 'Hapus Pengingat',
        content: 'Anda yakin ingin menghapus pengingat ini?',
        okText: 'Ya',
        cancelText: 'Tidak',
        async onOk() {
          await axios.delete(route('app.waste-reminders.destroy',id));
          message.success('Pengingat berhasil dihapus');
          fetchReminders();
        }
      });
    } catch (error) {
      message.error('Gagal menghapus pengingat');
    }
  };

  const handleToggleActive = async (reminder) => {
    try {
      await axios.patch(`/waste-reminders/${reminder.id}`, {
        ...reminder,
        is_active: !reminder.is_active
      });
      fetchReminders();
      message.success(`Pengingat ${reminder.is_active ? 'dinonaktifkan' : 'diaktifkan'}`);
    } catch (error) {
      message.error('Gagal mengubah status pengingat');
    }
  };

  const resetForm = () => {
    formRef.value?.resetFields();
    editingId.value = null;
    formState.value = {
      title: '',
      description: '',
      reminder_time: '',
      frequency: 'daily',
      is_active: true
    };
  };

  const rules = {
    title: [{ required: true, message: 'Masukkan judul pengingat' }],
    description: [{ required: true, message: 'Masukkan deskripsi pengingat' }],
    reminder_time: [{ required: true, message: 'Pilih waktu pengingat' }],
    frequency: [{ required: true, message: 'Pilih frekuensi pengingat' }]
  };

  onMounted(fetchReminders);
</script>

<template>
  <div class="reminder-container">
    <div class="header">
      <div class="header-content">
        <h1 class="title">
          <BellOutlined /> Pengingat Pengelolaan Sampah
        </h1>
        <Button type="primary" @click="showModal = true">
          <PlusOutlined /> Tambah Pengingat
        </Button>
      </div>
    </div>

    <div class="reminder-grid">
      <Card v-for="reminder in reminders"
      :key="reminder.id"
      class="reminder-card"
      :class="{ 'inactive': !reminder.is_active }">
      <div class="reminder-header">
        <Tag :color="frequencyColors[reminder.frequency]">
          {{ reminder.frequency === 'daily' ? 'Harian' :
          reminder.frequency === 'weekly' ? 'Mingguan' : 'Bulanan' }}
        </Tag>
        <div class="reminder-actions">
          <Switch
          :checked="reminder.is_active"
          @change="() => handleToggleActive(reminder)"
          size="small"
          />
          <Button type="text" @click="handleEdit(reminder)">
            <EditOutlined />
          </Button>
          <Button type="text" danger @click="handleDelete(reminder.id)">
            <DeleteOutlined />
          </Button>
        </div>
      </div>

      <h3>{{ reminder.title }}</h3>
      <p>{{ reminder.description }}</p>
      <div class="reminder-time">
        <BellOutlined /> {{ reminder.reminder_time }}
      </div>
    </Card>
  </div>

  <!-- Form Modal -->
  <Modal
  :title="editingId ? 'Edit Pengingat' : 'Tambah Pengingat Baru'"
  v-model:open="showModal"
  @cancel="resetForm"
  :confirmLoading="loading"
  @ok="handleSubmit"
  >
  <Form
  ref="formRef"
  :model="formState"
  :rules="rules"
  layout="vertical"
  >
  <Form.Item label="Judul" name="title">
    <Input v-model:value="formState.title" placeholder="Masukkan judul pengingat" />
  </Form.Item>

  <Form.Item label="Deskripsi" name="description">
    <Input.TextArea
    v-model:value="formState.description"
    placeholder="Masukkan deskripsi pengingat"
    :rows="3"
    />
  </Form.Item>

  <Form.Item label="Waktu Pengingat" name="reminder_time">
    <TimePicker
    v-model:value="formState.reminder_time"
    format="HH:mm"
    style="width: 100%"
    placeholder="Pilih waktu"
    />
  </Form.Item>

  <Form.Item label="Frekuensi" name="frequency">
    <Select
    v-model:value="formState.frequency"
    :options="frequencyOptions"
    placeholder="Pilih frekuensi"
    />
  </Form.Item>

  <Form.Item name="is_active" label="Status">
    <Switch v-model:checked="formState.is_active" />
    <span class="ml-2">{{ formState.is_active ? 'Aktif' : 'Nonaktif' }}</span>
  </Form.Item>
</Form>
</Modal>
</div>
</template>

<style scoped>
  .reminder-container {
    padding: 24px;
    min-height: 100vh;
  }

  .header {
    background: white;
    padding: 24px;
    border-radius: 8px;
    margin-bottom: 24px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  }

  .header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .title {
    font-size: 24px;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .reminder-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
  }

  .reminder-card {
    border-radius: 8px;
    transition: all 0.3s ease;
  }

  .reminder-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }

  .reminder-card.inactive {
    opacity: 0.7;
  }

  .reminder-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
  }

  .reminder-actions {
    display: flex;
    gap: 8px;
    align-items: center;
  }

  .reminder-time {
    margin-top: 16px;
    color: #666;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  h3 {
    margin: 16px 0 8px;
    color: #1f2937;
  }

  p {
    color: #4b5563;
    margin-bottom: 8px;
  }

  :deep(.ant-card-body) {
    padding: 20px;
  }

  :deep(.ant-form-item-label) {
    font-weight: 500;
  }
</style>