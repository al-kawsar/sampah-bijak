<script setup>
  import AppLayout from "@/Layouts/AppLayout.vue";
  import { ref, onMounted, computed } from 'vue';
  import axios from "axios";
  import {
    UserOutlined,
    MailOutlined,
    PhoneOutlined,
    EnvironmentOutlined,
    ReconciliationOutlined,
    TeamOutlined
  } from '@ant-design/icons-vue';
  import {
    Card,
    Descriptions,
    Avatar,
    Tabs,
    Table,
    Badge
  } from 'ant-design-vue';

  defineOptions({
    layout: AppLayout,
  });

  const props = defineProps({
    user: {
      type: Object,
      required: true,
    },
  });

  const activeTab = ref('1');
  const wasteReports = ref([]);
  const eventParticipations = ref([]);

// Helper function for status badge
  const getStatusColor = (status) => {
    const statusColors = {
      pending: 'warning',
      verified: 'processing',
      resolved: 'success',
      registered: 'processing',
      attended: 'success',
      cancelled: 'error',
    };
    return statusColors[status] || 'default';
  };

  const formatDate = (date) => {
    return new Date(date).toLocaleDateString();
  };

  const capitalizeFirst = (str) => {
    return str.charAt(0).toUpperCase() + str.slice(1);
  };

// Columns for waste reports table
  const wasteColumns = [
  {
    title: 'Date',
    dataIndex: 'created_at',
    key: 'created_at',
    customRender: ({ text }) => formatDate(text),
  },
  {
    title: 'Location',
    dataIndex: 'location',
    key: 'location',
  },
  {
    title: 'Category',
    dataIndex: 'category',
    key: 'category',
  },
  {
    title: 'Weight (kg)',
    dataIndex: 'estimated_weight',
    key: 'weight',
  },
  {
    title: 'Status',
    dataIndex: 'status',
    key: 'status',
  },
  ];

// Columns for events table
  const eventColumns = [
  {
    title: 'Event Date',
    dataIndex: 'registered_at',
    key: 'date',
    customRender: ({ text }) => formatDate(text),
  },
  {
    title: 'Status',
    dataIndex: 'status',
    key: 'status',
  },
  ];

// Fetch waste reports and events on component mount
  onMounted(async () => {
    try {
    // Simulate API calls - replace with actual API endpoints
      // const wasteResponse = await axios.get(`/api/users/${props.user.id}/waste-reports`);
      // wasteReports.value = wasteResponse.data;

      // const eventsResponse = await axios.get(`/api/users/${props.user.id}/events`);
      // eventParticipations.value = eventsResponse.data;
    } catch (error) {
      console.error('Error fetching user data:', error);
    }
  });
</script>

<template>
  <div class="p-6">
    <!-- Profile Header -->
    <a-card class="user-card">
      <div class="user-card-content">
        <a-avatar
        :size="96"
        :src="user.profile_picture"
        :alt="user.full_name"
        class="user-avatar"
        />
        <div class="user-info">
          <h1 class="user-name">{{ user.full_name }}</h1>
          <div class="user-details">
            <a-badge
            :status="user.role === 'admin' ? 'success' : 'default'"
            :text="user.role"
            class="user-role"
            />
            <span class="separator">|</span>
            <span class="user-region">
              <environment-outlined class="region-icon" />
              {{ user.region }}
            </span>
          </div>
        </div>
      </div>
    </a-card>

    <!-- Profile Details -->
    <a-card class="mt-6">
      <a-tabs v-model:activeKey="activeTab">
        <!-- Personal Information Tab -->
        <a-tab-pane key="1" tab="Personal Information">
          <a-descriptions bordered>
            <a-descriptions-item label="Username">
              <user-outlined class="mr-2" />{{ user.username }}
            </a-descriptions-item>
            <a-descriptions-item label="Email">
              <mail-outlined class="mr-2" />{{ user.email }}
            </a-descriptions-item>
            <a-descriptions-item label="Phone">
              <phone-outlined class="mr-2" />{{ user.phone_number }}
            </a-descriptions-item>
            <a-descriptions-item label="Address">
              <environment-outlined class="mr-2" />{{ user.address }}
            </a-descriptions-item>
          </a-descriptions>
        </a-tab-pane>

        <!-- Waste Reports Tab -->
        <a-tab-pane v-if="user.role === 'warga'" key="2" tab="Waste Reports">
          <a-table
          :columns="wasteColumns"
          :data-source="wasteReports"
          :row-key="record => record.id"
          :pagination="{ pageSize: 5 }"
          >
          <template #bodyCell="{ column, text }">
            <template v-if="column.dataIndex === 'status'">
              <a-badge :status="getStatusColor(text)" :text="capitalizeFirst(text)" />
            </template>
          </template>
        </a-table>
      </a-tab-pane>

      <!-- Event Participations Tab -->
      <a-tab-pane key="3" v-if="user.role === 'warga'"  tab="Events">
        <a-table
        :columns="eventColumns"
        :data-source="eventParticipations"
        :row-key="record => record.id"
        :pagination="{ pageSize: 5 }"
        >
        <template #bodyCell="{ column, text }">
          <template v-if="column.dataIndex === 'status'">
            <a-badge :status="getStatusColor(text)" :text="capitalizeFirst(text)" />
          </template>
        </template>
      </a-table>
    </a-tab-pane>
  </a-tabs>
</a-card>
</div>
</template>

<style scoped>
  .ant-descriptions-item-label {
    width: 150px;
  }
  .user-card {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    padding: 16px;
  }

  .user-card-content {
    display: flex;
    align-items: center;
    gap: 16px;
  }

  .user-avatar {
    border: 2px solid #1890ff; /* Primary color */
    border-radius: 50%;
  }

  .user-info {
    flex-grow: 1;
  }

  .user-name {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 8px;
  }

  .user-details {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #666;
  }

  .separator {
    color: #ccc;
  }

  .user-region {
    display: flex;
    align-items: center;
    font-size: 14px;
  }

  .region-icon {
    margin-right: 4px;
    color: #999;
  }
</style>