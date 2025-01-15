<script setup>
  import AppLayout from "@/Layouts/AppLayout.vue";
  import { ref, onMounted } from 'vue';
  import {
    Form,
    Input,
    Select,
    InputNumber,
    Button,
    message,
    Card,
    Table,
    Tag,
    Upload
  } from 'ant-design-vue';
  import { PlusOutlined, UploadOutlined } from '@ant-design/icons-vue';
  import axios from 'axios';

  const formRef = ref();
  const loading = ref(false);
  const locations = ref([]);
  const categories = ref([]);
  const myReports = ref([]);
  const activeTab = ref('form');
  const fileList = ref([]);

  const formState = ref({
    location_id: undefined,
    category_id: undefined,
    estimated_weight: 1,
    description: '',
    photo: undefined,
    coordinates: null
  });

  const columns = [
  {
    title: 'Location',
    dataIndex: ['location', 'name'],
    key: 'location',
  },
  {
    title: 'Category',
    dataIndex: ['category', 'name'],
    key: 'category',
  },
  {
    title: 'Weight (kg)',
    dataIndex: 'estimated_weight',
    key: 'estimated_weight',
  },
  {
    title: 'Photo',
    dataIndex: 'photo_path',
    key: 'photo_path',
    customRender: ({ text }) => {
      return text ? (
        `<a href="${text}" target="_blank">View Photo</a>`
        ) : (
        `<span>No photo</span>`
        );
      }
    },
    {
      title: 'Status',
      dataIndex: 'status',
      key: 'status',
      customRender: ({ text }) => {
        const statusColors = {
          pending: 'warning',
          verified: 'success',
          resolved: 'processing'
        };
        return `<span style="color: ${statusColors[text]}">${text.toUpperCase()}</span>`;
      }
    },
    {
      title: 'Reported Date',
      dataIndex: 'created_at',
      key: 'created_at',
      customRender: ({ text }) => new Date(text).toLocaleDateString()
    }
    ];

  const rules = {
    location_id: [{ required: true, message: 'Please select location' }],
    category_id: [{ required: true, message: 'Please select waste category' }],
    estimated_weight: [{ required: true, message: 'Please enter estimated weight' }],
    description: [{ required: true, message: 'Please provide description' }]
  };

// Get current location
  const getCurrentLocation = () => {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          formState.value.coordinates = {
            type: 'Point',
            coordinates: [position.coords.longitude, position.coords.latitude]
          };
        },
        (error) => {
          console.error('Error getting location:', error);
          message.warning('Could not get your current location');
        }
        );
    }
  };

  const fetchLocationsAndCategories = async () => {
    try {
      const [locResponse, catResponse] = await Promise.all([
        axios.get('/api/waste-locations'),
        axios.get('/api/waste-categories')
        ]);
      locations.value = locResponse.data;
      categories.value = catResponse.data;
    } catch (error) {
      console.error('Error fetching data:', error);
      message.error('Failed to load required data');
    }
  };

  const fetchMyReports = async () => {
    try {
      loading.value = true;
      const response = await axios.get('/api/waste-reports');
      myReports.value = response.data;
    } catch (error) {
      console.error('Error fetching reports:', error);
      message.error('Failed to load your reports');
    } finally {
      loading.value = false;
    }
  };

  const handleUploadChange = (info) => {
    if (info.file.status === 'done') {
      formState.value.photo = info.file.response.path;
      message.success(`${info.file.name} file uploaded successfully`);
    } else if (info.file.status === 'error') {
      message.error(`${info.file.name} file upload failed.`);
    }
    fileList.value = info.fileList;
  };

  const onSubmit = async () => {
    try {
      await formRef.value.validate();
      loading.value = true;

      const formData = new FormData();
      Object.keys(formState.value).forEach(key => {
        if (formState.value[key] !== undefined) {
          if (key === 'coordinates') {
            formData.append(key, JSON.stringify(formState.value[key]));
          } else {
            formData.append(key, formState.value[key]);
          }
        }
      });

      await axios.post('/api/waste-reports', formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
      });

      message.success('Waste report submitted successfully!');
      formRef.value.resetFields();
      fileList.value = [];
      fetchMyReports();
      activeTab.value = 'reports';
    } catch (error) {
      console.error('Error:', error);
      message.error('Failed to submit report');
    } finally {
      loading.value = false;
    }
  };

  onMounted(() => {
    fetchLocationsAndCategories();
    fetchMyReports();
    getCurrentLocation();
  });
</script>

<template>
  <AppLayout>
    <div class="waste-report-container">
      <div class="page-header">
        <h1>Laporan Sampah</h1>
        <div class="tab-controls">
          <Button
          :type="activeTab === 'form' ? 'primary' : 'default'"
          @click="activeTab = 'form'"
          >
          <PlusOutlined /> Laporan Baru
        </Button>
        <Button
        :type="activeTab === 'reports' ? 'primary' : 'default'"
        @click="activeTab = 'reports'"
        >
        Laporan Saya
      </Button>
    </div>
  </div>

  <!-- Report Form -->
  <div v-if="activeTab === 'form'" class="report-form-section">
    <Card class="form-card">
      <Form
      ref="formRef"
      :model="formState"
      :rules="rules"
      layout="vertical"
      >
      <div class="form-grid">
        <Form.Item label="Lokasi" name="location_id">
          <Select
          v-model:value="formState.location_id"
          placeholder="Pilih lokasi"
          show-search
          :filter-option="(input, option) =>
          option.children.toLowerCase().indexOf(input.toLowerCase()) >= 0"
          >
          <Select.Option
          v-for="loc in locations"
          :key="loc.id"
          :value="loc.id"
          >
          {{ loc.name }}
        </Select.Option>
      </Select>
    </Form.Item>

    <Form.Item label="Kategori Sampah" name="category_id">
      <Select
      v-model:value="formState.category_id"
      placeholder="Pilih kategori"
      show-search
      :filter-option="(input, option) =>
      option.children.toLowerCase().indexOf(input.toLowerCase()) >= 0"
      >
      <Select.Option
      v-for="cat in categories"
      :key="cat.id"
      :value="cat.id"
      >
      {{ cat.name }}
    </Select.Option>
  </Select>
</Form.Item>

<Form.Item label="Perkiraan Berat (kg)" name="estimated_weight">
  <InputNumber
  v-model:value="formState.estimated_weight"
  :min="1"
  class="weight-input"
  />
</Form.Item>
</div>

<Form.Item label="Deskripsi" name="description">
  <Input.TextArea
  v-model:value="formState.description"
  :rows="4"
  placeholder="Jelaskan situasi sampah..."
  />
</Form.Item>

<!-- <Form.Item label="Foto" name="photo">
  <Upload
  v-model:fileList="fileList"
  name="photo"
  @change="handleUploadChange"
  :maxCount="1"
  >
  <Button>
    <UploadOutlined /> Upload Foto
  </Button>
</Upload>
</Form.Item> -->

<Form.Item>
  <Button
  type="primary"
  size="large"
  :loading="loading"
  @click="onSubmit"
  class="submit-button"
  >
  Kirim Laporan
</Button>
</Form.Item>
</Form>
</Card>
</div>

<!-- My Reports Table -->
<div v-else class="my-reports-section">
  <Card>
    <Table
    :columns="columns"
    :data-source="myReports"
    :loading="loading"
    :pagination="{ pageSize: 10 }"
    class="reports-table"
    rowKey="id"
    />
  </Card>
</div>
</div>
</AppLayout>
</template>

<style scoped>
  .waste-report-container {
    padding: 24px;
    min-height: 100vh;
  }

  .page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
  }

  .page-header h1 {
    font-size: 24px;
    margin: 0;
    color: #1f2937;
    font-weight: 600;
  }

  .tab-controls {
    display: flex;
    gap: 12px;
  }

  .form-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  }

  .form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
  }

  .weight-input {
    width: 100%;
  }

  .submit-button {
    width: 100%;
    height: 48px;
    font-size: 16px;
    margin-top: 16px;
  }

  .reports-table {
    margin-top: 16px;
  }

  :deep(.ant-card) {
    border-radius: 12px;
  }

  :deep(.ant-input),
  :deep(.ant-select-selector),
  :deep(.ant-input-number) {
    border-radius: 8px;
  }

  :deep(.ant-btn) {
    border-radius: 6px;
  }

  :deep(.ant-form-item-label) {
    font-weight: 500;
  }
</style>