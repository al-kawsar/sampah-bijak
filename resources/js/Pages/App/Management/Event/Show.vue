<script setup>
  import AppLayout from "@/Layouts/AppLayout.vue";
  import { ref, onMounted, h } from "vue";
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

  onMounted(async () => {
  // Initialize map
    map.value = L.map(mapContainer.value);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
    }).addTo(map.value);

    try {
    // Use a geocoding service to convert address to coordinates
      const response = await fetch(
        `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(props.event.location)}`
        );
      const data = await response.json();

      if (data && data[0]) {
        const { lat, lon } = data[0];
        map.value.setView([lat, lon], 13);
        const marker = L.marker([lat, lon]).addTo(map.value);
        marker.bindPopup(props.event.location).openPopup();
      }
    } catch (error) {
      console.error('Error geocoding address:', error);
    }
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

  const getRegistrationStatus = () => {
    return props.event.registered_count >= props.event.capacity ? 'Full' : 'Open';
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

      <!-- Organizer Information -->
      <Card title="Organizer" class="mb-6" v-if="event.organizer">
        <div class="flex items-center gap-4">
          <Avatar :size="64" :src="event.organizer.avatar_url" />
          <div>
            <h3 class="text-lg font-semibold">{{ event.organizer.name }}</h3>
          </div>
        </div>
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
      :value="event.participant_percentage"
      suffix="%"
      :prefix="h(UserOutlined)"
      />
    </Col>
  </Row>
  <div class="mt-4 text-center">
    <Tag :color="event.registered_count >= event.capacity ? 'red' : 'green'">
      {{ getRegistrationStatus() }}
    </Tag>
  </div>
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
<Button
type="primary"
block
size="large"
class="h-12"
:disabled="event.registered_count >= event.capacity"
>
{{ event.registered_count >= event.capacity ? 'Event Full' : 'Register for Event' }}
</Button>
</Col>
</Row>
</div>
</template>

<style scoped>
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