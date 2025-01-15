<script setup>
  import {
    BellOutlined,
    CheckCircleOutlined,
    InboxOutlined,
    MailOutlined,
    ClockCircleOutlined,
    DeleteOutlined,
  } from "@ant-design/icons-vue";
  import { ref, onMounted } from "vue";

  const open = ref(false);
  const activeKey = ref("1");
  const notifications = ref([]);
  const unreadCount = ref(0);

  const fetchNotifications = () => {
    notifications.value = [
    {
      id: 1,
      title: "Pembaruan Sistem",
      message: "Sistem telah diperbarui ke versi terbaru",
      type: "info",
      is_read: false,
      created_at: "2024-01-13 10:30:00"
    },
    {
      id: 2,
      title: "Peringatan Keamanan",
      message: "Ada upaya login yang mencurigakan",
      type: "warning",
      is_read: false,
      created_at: "2024-01-13 09:15:00"
    },
    {
      id: 3,
      title: "Tugas Selesai",
      message: "Laporan bulanan telah selesai diproses",
      type: "success",
      is_read: true,
      created_at: "2024-01-12 15:45:00"
    }
    ];
    updateUnreadCount();
  };

  const updateUnreadCount = () => {
    unreadCount.value = notifications.value.filter(n => !n.is_read).length;
  };

  const markAsRead = (notificationId) => {
    const notification = notifications.value.find(n => n.id === notificationId);
    if (notification) {
      notification.is_read = true;
      updateUnreadCount();
    }
  };

  const deleteNotification = (notificationId) => {
    notifications.value = notifications.value.filter(n => n.id !== notificationId);
    updateUnreadCount();
  };

  const formatDate = (dateString) => {
    return new Date(dateString).toLocaleString('id-ID', {
      day: 'numeric',
      month: 'short',
      hour: '2-digit',
      minute: '2-digit'
    });
  };

  const getTypeColor = (type) => {
    const colors = {
      info: '#1890ff',
      warning: '#faad14',
      success: '#52c41a',
      error: '#f5222d'
    };
    return colors[type] || colors.info;
  };

  const afterOpenChange = (bool) => {
    console.log("open", bool);
  };

  const showDrawer = () => {
    open.value = true;
  };

  onMounted(() => {
    fetchNotifications();
  });
</script>

<template>
  <a-badge :count="unreadCount" @click="showDrawer" style="cursor: pointer">
    <a-avatar size="middle" :style="{ background: '#f0f4f0', color: '#3a7d44' }">
      <template #icon><BellOutlined /></template>
    </a-avatar>
  </a-badge>

  <a-drawer
  v-model:open="open"
  title="Notifikasi"
  placement="right"
  :width="380"
  @after-open-change="afterOpenChange"
  >
  <a-tabs v-model:activeKey="activeKey" class="notification-tabs">
    <a-tab-pane key="1">
      <template #tab>
        <span>
          <InboxOutlined />
          Belum Dibaca ({{ unreadCount }})
        </span>
      </template>
      <div class="notifications-container">
        <template v-for="notification in notifications.filter(n => !n.is_read)" :key="notification.id">
          <a-card class="notification-card" :bordered="false">
            <template #extra>
              <a-space>
                <a-tooltip title="Tandai sudah dibaca">
                  <a-button
                  type="text"
                  size="small"
                  @click="markAsRead(notification.id)"
                  >
                  <template #icon><MailOutlined /></template>
                </a-button>
              </a-tooltip>
              <a-tooltip title="Hapus">
                <a-button
                type="text"
                size="small"
                @click="deleteNotification(notification.id)"
                >
                <template #icon><DeleteOutlined style="color: #ff4d4f" /></template>
              </a-button>
            </a-tooltip>
          </a-space>
        </template>
        <div class="notification-content">
          <div class="notification-header">
            <span class="notification-dot" :style="{ background: getTypeColor(notification.type) }"></span>
            <span class="notification-title">{{ notification.title }}</span>
          </div>
          <p class="notification-message">{{ notification.message }}</p>
          <div class="notification-footer">
            <ClockCircleOutlined style="margin-right: 5px" />
            {{ formatDate(notification.created_at) }}
          </div>
        </div>
      </a-card>
    </template>
  </div>
</a-tab-pane>

<a-tab-pane key="2">
  <template #tab>
    <span>
      <CheckCircleOutlined />
      Sudah Dibaca
    </span>
  </template>
  <div class="notifications-container">
    <template v-for="notification in notifications.filter(n => n.is_read)" :key="notification.id">
      <a-card class="notification-card" :bordered="false">
        <template #extra>
          <a-tooltip title="Hapus">
            <a-button
            type="text"
            size="small"
            @click="deleteNotification(notification.id)"
            >
            <template #icon><DeleteOutlined style="color: #ff4d4f" /></template>
          </a-button>
        </a-tooltip>
      </template>
      <div class="notification-content">
        <div class="notification-header">
          <span class="notification-dot" :style="{ background: getTypeColor(notification.type) }"></span>
          <span class="notification-title">{{ notification.title }}</span>
        </div>
        <p class="notification-message">{{ notification.message }}</p>
        <div class="notification-footer">
          <ClockCircleOutlined style="margin-right: 5px" />
          {{ formatDate(notification.created_at) }}
        </div>
      </div>
    </a-card>
  </template>
</div>
</a-tab-pane>
</a-tabs>
</a-drawer>
</template>

<style scoped>
  .notification-tabs {
    margin-top: -24px;
  }

  .notifications-container {
    margin-top: 16px;
  }

  .notification-card {
    margin-bottom: 16px;
    border-radius: 8px;
    background: #fafafa;
    transition: all 0.3s;
  }

  .notification-card:hover {
    background: #f0f2f5;
  }

  .notification-content {
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  .notification-header {
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .notification-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
  }

  .notification-title {
    font-weight: 600;
    color: #000000d9;
  }

  .notification-message {
    margin: 0;
    color: #000000a6;
    font-size: 14px;
  }

  .notification-footer {
    font-size: 12px;
    color: #00000073;
    display: flex;
    align-items: center;
  }

  :deep(.ant-drawer-body) {
    padding: 24px 16px !important;
  }

  :deep(.ant-card-body) {
    padding: 16px;
  }
</style>