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

</script>
<template>
  <div class="container">
    <!-- Hero Section -->
    <div class="hero">
      <img
      :src="event.thumbnail_url"
      class="hero-image"
      alt="Thumbnail Acara"
      />
      <div class="hero-overlay">
        <h1 class="hero-title">{{ event.title }}</h1>
        <div class="hero-details">
          <span class="hero-detail-item">
            <CalendarOutlined />
            {{ formatDate(event.date) }}
          </span>
          <span class="hero-detail-item">
            <EnvironmentOutlined />
            {{ event.location }}
          </span>
        </div>
      </div>
    </div>

    <!-- Konten Grid -->
    <Row :gutter="[24, 24]">
      <!-- Konten Utama -->
      <Col :span="16">
      <Card title="Tentang Acara" class="content-card">
        <p class="content-text">
          {{ event.description }}
        </p>
      </Card>

      <!-- Informasi Penyelenggara -->
      <Card title="Penyelenggara" class="content-card" v-if="event.organizer">
        <div class="organizer-info">
          <Avatar :size="64" :src="event.organizer.profile.profile_picture" />
          <div>
            <h3 class="organizer-name">{{ event.organizer.profile.full_name }}</h3>
          </div>
        </div>
      </Card>

      <!-- Peta -->
      <Card title="Lokasi" class="content-card">
        {{ event.location }}
        <div ref="mapContainer" class="map-container"></div>
      </Card>
    </Col>

    <!-- Sidebar -->
    <Col :span="8">
    <!-- Statistik Acara -->
    <Card class="content-card">
      <Row :gutter="[16, 16]">
        <Col :span="12">
        <Statistic
        title="Kapasitas"
        :value="event.capacity"
        :prefix="h(TeamOutlined)"
        />
      </Col>
      <Col :span="12">
      <Statistic
      title="Pendaftaran"
      :value="event.participant_percentage"
      suffix="%"
      :prefix="h(UserOutlined)"
      />
    </Col>
  </Row>
  <div class="registration-status">
    <Tag :color="event.registered_count >= event.capacity ? 'red' : 'green'">
      {{ getRegistrationStatus() }}
    </Tag>
  </div>
</Card>

<!-- Jadwal -->
<Card title="Detail Jadwal" class="content-card">
  <div class="schedule-detail">
    <CalendarOutlined class="icon" />
    <div>
      <div class="schedule-title">Tanggal</div>
      <div>{{ new Date(event.date).toLocaleDateString('id-ID') }}</div>
    </div>
  </div>
  <div class="schedule-detail">
    <ClockCircleOutlined class="icon" />
    <div>
      <div class="schedule-title">Waktu</div>
      <div>{{ new Date(event.date).toLocaleTimeString('id-ID') }}</div>
    </div>
  </div>
</Card>

<!-- Tombol Pendaftaran -->
<Button
type="primary"
block
size="large"
class="register-button"
:disabled="event.registered_count >= event.capacity"
>
{{ event.registered_count >= event.capacity ? 'Acara Penuh' : 'Daftar Acara' }}
</Button>
</Col>
</Row>
</div>
</template>

<style scoped>
/***** Container *****/
.container {
  max-width: 1280px;
  margin: 0 auto;
  padding: 24px;
}

/***** Hero Section *****/
.hero {
  position: relative;
  margin-bottom: 32px;
}
.hero-image {
  width: 100%;
  height: 384px;
  object-fit: cover;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}
.hero-overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  padding: 16px;
  background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
  border-bottom-left-radius: 12px;
  border-bottom-right-radius: 12px;
}
.hero-title {
  font-size: 32px;
  font-weight: bold;
  color: white;
  margin-bottom: 8px;
}
.hero-details {
  display: flex;
  gap: 16px;
  color: white;
}
.hero-detail-item {
  display: flex;
  align-items: center;
  gap: 8px;
}

/***** Konten *****/
.content-card {
  margin-bottom: 24px;
}
.content-text {
  font-size: 18px;
  line-height: 1.75;
  white-space: pre-line;
}

/***** Organizer *****/
.organizer-info {
  display: flex;
  align-items: center;
  gap: 16px;
}
.organizer-name {
  font-size: 18px;
  font-weight: 600;
}

/***** Map *****/
.map {
  height: 384px;
  border-radius: 12px;
  background: #f0f0f0;
}

/***** Registration *****/
.registration-status {
  margin-top: 16px;
  text-align: center;
}

/***** Schedule *****/
.schedule-detail {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 16px;
}
.icon {
  font-size: 24px;
  color: #1d4ed8;
}
.schedule-title {
  font-weight: 600;
}

/***** Tombol *****/
.register-button {
  height: 48px;
  font-size: 16px;
}
.map-container {
  height: 384px; /* Setara dengan kelas Tailwind `h-96` */
  width: 100%; /* Lebar penuh */
  border-radius: 12px; /* Setara dengan kelas Tailwind `rounded-lg` */
  overflow: hidden; /* Untuk memastikan konten yang melampaui area peta tidak terlihat */
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Tambahan efek shadow opsional */
}
</style>
