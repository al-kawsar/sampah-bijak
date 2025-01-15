<script setup>
  import AppLayout from "@/Layouts/AppLayout.vue";
  import { ref, onMounted } from "vue";
  import { Card, Row, Col, Tag, Avatar, Button, Statistic } from "ant-design-vue";
  import {
    CalendarOutlined,
    EnvironmentOutlined,
    TeamOutlined,
    UserOutlined,
    ClockCircleOutlined
  } from '@ant-design/icons-vue';
  import 'leaflet/dist/leaflet.css';
  import L from 'leaflet';

  defineOptions({
    layout: AppLayout,
  });

  const props = defineProps({
    event: {
      type: Object,
      required: true,
    },
  });

  const map = ref(null);
  const mapContainer = ref(null);

  onMounted(() => {
// Initialize map
  map.value = L.map(mapContainer.value).setView([0, 0], 13); // Default view, will be updated

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
  }).addTo(map.value);

  // You would need to geocode the location string to get coordinates
  // For demo purposes, using default coordinates
  const marker = L.marker([0, 0]).addTo(map.value);
  marker.bindPopup(props.event.location).openPopup();
});

  const formatDate = (date) => {
    return new Date(date).toLocaleDateString('id-ID', {
      weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric',
      hour: '2-digit',
      minute: '2-digit'
    });
  };

  const getParticipantStatus = () => {
  // This would come from your actual data/API
  const registered = 45; // Example number
  return Math.round((registered / props.event.capacity) * 100);
};
</script>

<template>
  <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <!-- Hero Section -->
    <div class="relative mb-8">
      <img
      :src="event.thumbnail_url"
      class="w-full h-96 object-cover rounded-lg shadow-lg"
      alt="Event thumbnail"
      />
      <div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-black/70 to-transparent rounded-b-lg">
        <h1 class="text-4xl font-bold text-white mb-2">{{ event.title }}</h1>
        <div class="flex items-center text-white gap-4">
          <span class="flex items-center gap-2">
            <CalendarOutlined />
            {{ formatDate(event.date) }}
          </span>
          <span class="flex items-center gap-2">
            <EnvironmentOutlined />
            {{ event.location }}
          </span>
        </div>
      </div>
    </div>

    <!-- Content Grid -->
    <Row :gutter="[24, 24]">
      <!-- Main Content -->
      <Col :span="16">
      <Card title="About Event" class="mb-6">
        <p class="text-lg leading-relaxed whitespace-pre-line">
          {{ event.description }}
        </p>
      </Card>

      <!-- Map -->
      <Card title="Location" class="mb-6">
        <div ref="mapContainer" class="h-96 rounded-lg"></div>
      </Card>
    </Col>

    <!-- Sidebar -->
    <Col :span="8">
    <!-- Event Stats -->
    <Card class="mb-6">
      <Row :gutter="[16, 16]">
        <Col :span="12">
        <Statistic
        title="Capacity"
        :value="event.capacity"
        :prefix="h(TeamOutlined)"
        />
      </Col>
      <Col :span="12">
      <Statistic
      title="Registration"
      :value="getParticipantStatus()"
      suffix="%"
      :prefix="h(UserOutlined)"
      />
    </Col>
  </Row>
</Card>

<!-- Date & Time -->
<Card title="Schedule Details" class="mb-6">
  <div class="flex items-center gap-3 mb-4">
    <CalendarOutlined class="text-2xl text-blue-500" />
    <div>
      <div class="font-semibold">Date</div>
      <div>{{ new Date(event.date).toLocaleDateString('id-ID') }}</div>
    </div>
  </div>
  <div class="flex items-center gap-3">
    <ClockCircleOutlined class="text-2xl text-blue-500" />
    <div>
      <div class="font-semibold">Time</div>
      <div>{{ new Date(event.date).toLocaleTimeString('id-ID') }}</div>
    </div>
  </div>
</Card>

<!-- Registration Button -->
<Button type="primary" block size="large" class="h-12">
  Register for Event
</Button>
</Col>
</Row>
</div>
</template>

<style scoped>
/* Add these to your CSS */
:deep(.ant-card-head-title) {
  font-size: 1.25rem;
  font-weight: 600;
}

:deep(.ant-statistic-title) {
  font-size: 1rem;
}

:deep(.ant-statistic-content) {
  font-size: 1.5rem;
}
</style>