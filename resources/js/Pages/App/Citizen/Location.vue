<script setup>
  import AppLayout from "@/Layouts/AppLayout.vue";
  import { onMounted, ref, nextTick, computed } from "vue";
  import axios from "axios";
  import {
    Card,
    Tooltip,
    Badge,
    Button,
    Statistic,
    Row,
    Col,
    Input,
    Space
  } from "ant-design-vue";
  import {
    EnvironmentOutlined,
    PhoneOutlined,
    InboxOutlined,
    AimOutlined,
    FilterOutlined,
    ReloadOutlined
  } from '@ant-design/icons-vue';

  defineOptions({
    layout: AppLayout,
  });

  const wasteLocations = ref([]);
  const loading = ref(true);
  const map = ref(null);
  const markers = ref({});
  const activeLocation = ref(null);
  const selectedType = ref('all');
  const searchQuery = ref('');

  const filteredLocations = computed(() => {
    return wasteLocations.value.filter(location => {
      const matchesType = selectedType.value === 'all' || location.type === selectedType.value;
      const matchesSearch = location.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      location.address.toLowerCase().includes(searchQuery.value.toLowerCase());
      return matchesType && matchesSearch;
    });
  });

  const statistics = computed(() => ({
    total: wasteLocations.value.length,
    types: wasteLocations.value.reduce((acc, loc) => {
      acc[loc.type] = (acc[loc.type] || 0) + 1;
      return acc;
    }, {}),
    totalCapacity: wasteLocations.value.reduce((sum, loc) => sum + parseFloat(loc.capacity), 0)
  }));

  const getTypeColor = (type) => {
    const colors = {
      'TPS': '#1677ff',
      'TPA': '#52c41a',
      'TPS 3R': '#722ed1',
      'TPST': '#faad14'
    };
    return colors[type] || '#000000';
  };

  const fetchData = async () => {
    try {
      loading.value = true;
      const response = await axios.get('/api/waste-locations');
      wasteLocations.value = response.data.data;
      await initializeMap();
    } catch (error) {
      console.error('Error fetching data:', error);
    } finally {
      loading.value = false;
    }
  };

  const focusLocation = (location) => {
    if (!map.value) return;
    activeLocation.value = location.id;
    map.value.setView([location.latitude, location.longitude], 16, {
      animate: true,
      duration: 1
    });
    const marker = markers.value[location.id];
    if (marker) {
      marker.openPopup();
    }
  };

  const createCustomIcon = (type) => {
    return L.divIcon({
      className: 'custom-marker',
      html: `
      <div class="marker-container">
      <div class="marker-dot" style="background-color: ${getTypeColor(type)};"></div>
      <div class="marker-pulse" style="border-color: ${getTypeColor(type)};"></div>
      </div>
      `,
      iconSize: [30, 30],
      iconAnchor: [15, 15],
      popupAnchor: [0, -15]
    });
  };

  const initializeMap = async () => {
    await nextTick();

    if (!window.L) {
      const link = document.createElement('link');
      link.rel = 'stylesheet';
      link.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
      document.head.appendChild(link);

      const script = document.createElement('script');
      script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
      await new Promise((resolve) => {
        script.onload = resolve;
        document.head.appendChild(script);
      });
    }

    const centerLat = wasteLocations.value[0]?.latitude;
    const centerLng = wasteLocations.value[0]?.longitude;

    map.value = L.map('map').setView([centerLat, centerLng], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
    }).addTo(map.value);

    wasteLocations.value.forEach((location) => {
      const customIcon = createCustomIcon(location.type);
      const marker = L.marker([location.latitude, location.longitude], { icon: customIcon })
      .bindPopup(`
        <div class="custom-popup">
        <h3>${location.name}</h3>
        <div class="popup-type" style="background-color: ${getTypeColor(location.type)}">
        ${location.type}
        </div>
        <div class="popup-content">
        <p><strong>Kapasitas:</strong> ${location.capacity} ton</p>
        <p><strong>Alamat:</strong> ${location.address}</p>
        <p><strong>Kontak:</strong> ${location.contact_number}</p>
        </div>
        </div>
        `, {
          className: 'custom-popup-container'
        })
      .addTo(map.value);

      markers.value[location.id] = marker;
      marker.on('click', () => {
        activeLocation.value = location.id;
      });
    });
  };

  onMounted(() => {
    fetchData();
  });
</script>

<template>
  <div class="waste-container">
    <!-- Statistics Section -->
    <Row :gutter="[16, 16]" class="statistics-section">
      <Col :span="24" :md="6">
      <Card class="statistic-card">
        <Statistic
        title="Total Lokasi"
        :value="statistics.total"
        :value-style="{ color: '#1677ff' }"
        />
      </Card>
    </Col>
    <Col :span="24" :md="6">
    <Card class="statistic-card">
      <Statistic
      title="Total Kapasitas"
      :value="statistics.totalCapacity"
      :value-style="{ color: '#52c41a' }"
      suffix="ton"
      />
    </Card>
  </Col>
  <Col :span="24" :md="6">
  <Card class="statistic-card">
    <Statistic
    title="Tipe Terbanyak"
    :value="Object.entries(statistics.types).sort((a,b) => b[1] - a[1])[0]?.[0] || '-'"
    :value-style="{ color: '#722ed1' }"
    />
  </Card>
</Col>
<Col :span="24" :md="6">
<Card class="statistic-card">
  <Statistic
  title="Rata-rata Kapasitas"
  :value="(statistics.totalCapacity / statistics.total).toFixed(1)"
  :value-style="{ color: '#faad14' }"
  suffix="ton"
  />
</Card>
</Col>
</Row>

<!-- Map Section -->
<Card class="map-card">
  <template #title>
    <div class="map-header">
      <h1 class="map-title">Peta Lokasi Tempat Sampah</h1>
      <Space>
        <Input.Search
        v-model:value="searchQuery"
        placeholder="Cari lokasi..."
        style="width: 200px"
        />
        <Space>
          <Button
          v-for="type in ['all', 'TPS', 'TPA', 'TPS 3R', 'TPST']"
          :key="type"
          :type="selectedType === type ? 'primary' : 'default'"
          @click="selectedType = type"
          >
          <Badge v-if="type !== 'all'" :color="getTypeColor(type)" />
          {{ type === 'all' ? 'Semua' : type }}
        </Button>
      </Space>
    </Space>
  </div>
</template>
<div id="map" class="map-container"></div>
</Card>

<!-- Location Cards -->
<Row :gutter="[16, 16]" class="location-cards">
  <Col v-for="location in filteredLocations"
  :key="location.id"
  :span="24"
  :md="12"
  :lg="8">
  <Card
  :class="['location-card', { 'location-card-active': activeLocation === location.id }]"
  hoverable
  @click="focusLocation(location)"
  >
  <template #title>
    <div class="card-header">
      <div class="card-title">
        <div class="type-indicator" :style="{ backgroundColor: getTypeColor(location.type) }"></div>
        <span>{{ location.name }}</span>
      </div>
      <Button
      type="primary"
      shape="circle"
      @click.stop="focusLocation(location)"
      >
      <template #icon><AimOutlined /></template>
    </Button>
  </div>
</template>

<div class="card-content">
  <div class="type-badge" :style="{
    backgroundColor: `${getTypeColor(location.type)}20`,
    color: getTypeColor(location.type)
  }">
  {{ location.type }}
</div>

<div class="info-item">
  <EnvironmentOutlined />
  <span>{{ location.address }}</span>
</div>

<div class="info-item">
  <PhoneOutlined />
  <span>{{ location.contact_number }}</span>
</div>

<div class="info-item">
  <InboxOutlined />
  <span>Kapasitas: {{ location.capacity }} ton</span>
</div>
</div>
</Card>
</Col>
</Row>
</div>
</template>

<style>
  .waste-container {
    padding: 24px;
    max-width: 1400px;
    margin: 0 auto;
  }

  .statistics-section {
    margin-bottom: 24px;
  }

  .statistic-card {
    text-align: center;
    transition: box-shadow 0.3s;
  }

  .statistic-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }

  .map-card {
    margin-bottom: 24px;
  }

  .map-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
  }

  .map-title {
    font-size: 24px;
    margin: 0;
    font-weight: 600;
  }

  .map-container {
    height: 500px;
    border-radius: 8px;
    overflow: hidden;
  }

  .location-cards {
    margin-top: 24px;
  }

  .location-card {
    transition: all 0.3s;
  }

  .location-card:hover {
    transform: translateY(-4px);
  }

  .location-card-active {
    border: 2px solid #1890ff;
  }

  .card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .card-title {
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .type-indicator {
    width: 12px;
    height: 12px;
    border-radius: 50%;
  }

  .card-content {
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .type-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 16px;
    font-size: 12px;
  }

  .info-item {
    display: flex;
    align-items: flex-start;
    gap: 8px;
  }

  .info-item .anticon {
    margin-top: 4px;
  }

/* Marker Styles */
.marker-container {
  position: relative;
  width: 30px;
  height: 30px;
}

.marker-dot {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 12px;
  height: 12px;
  border-radius: 50%;
  box-shadow: 0 0 10px rgba(0,0,0,0.3);
}

.marker-pulse {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 30px;
  height: 30px;
  border: 3px solid;
  border-radius: 50%;
  animation: pulse 2s infinite;
  opacity: 0.5;
}

@keyframes pulse {
  0% {
    transform: translate(-50%, -50%) scale(0.5);
    opacity: 0.8;
  }
  100% {
    transform: translate(-50%, -50%) scale(1.5);
    opacity: 0;
  }
}

/* Popup Styles */
.custom-popup {
  padding: 12px;
  min-width: 200px;
}

.custom-popup h3 {
  margin: 0 0 8px 0;
  font-size: 16px;
  font-weight: 600;
}

.popup-type {
  display: inline-block;
  padding: 2px 8px;
  border-radius: 12px;
  color: white;
  font-size: 12px;
  margin-bottom: 8px;
}

.popup-content p {
  margin: 4px 0;
  font-size: 13px;
}

.leaflet-popup-content-wrapper {
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}

.leaflet-popup-tip-container {
  display: none;
}

/* Responsive Styles */
@media (max-width: 768px) {
  .map-header {
    flex-direction: column;
    align-items: stretch;
  }

  .waste-container {
    padding: 16px;
  }
}
</style>