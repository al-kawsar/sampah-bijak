<script setup>
  import AppLayout from "@/Layouts/AppLayout.vue";
  import { ref, onMounted } from "vue";
  import { router } from "@inertiajs/vue3";
  import { Form, Input, Button, Card, Alert, Row, Col, Descriptions } from 'ant-design-vue';
  import {
    CalendarOutlined,
    EnvironmentOutlined,
    UserOutlined,
  } from '@ant-design/icons-vue';

  defineOptions({
    layout: AppLayout,
  });

  const props = defineProps({
    event: {
      type: Object,
      required: true,
    },
    user: {
      type: Object,
      required: true,
    },
  });

  const form = ref({
    user_id: props.user.id,
    event_id: props.event.id,
    status: 'registered',
  });

  const loading = ref(false);
  const error = ref('');
  const success = ref(false);

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

  const handleSubmit = async () => {
    loading.value = true;
    error.value = '';

    try {
      await router.post(route('app.event-participants.store'), form.value, {
        onSuccess: () => {
          success.value = true;
          setTimeout(() => {
            router.visit(route('app.event-participants.show', props.event.id));
          }, 2000);
        },
        onError: (errors) => {
          error.value = Object.values(errors)[0];
        },
      });
    } finally {
      loading.value = false;
    }
  };
</script>

<template>
  <div class="container mx-auto p-6">
    <Row :gutter="[24, 24]">
      <Col :span="16">
      <Card title="Registrasi Acara" class="mb-6">
        <!-- Event Details -->
        <Descriptions bordered>
          <Descriptions.Item label="Acara" :span="3">
            {{ event.title }}
          </Descriptions.Item>
          <Descriptions.Item label="Tanggal">
            <CalendarOutlined /> {{ formatDate(event.date) }}
          </Descriptions.Item>
          <Descriptions.Item label="Lokasi" :span="2">
            <EnvironmentOutlined /> {{ event.location }}
          </Descriptions.Item>
          <Descriptions.Item label="Kapasitas">
            {{ event.capacity }} peserta
          </Descriptions.Item>
          <Descriptions.Item label="Terdaftar" :span="2">
            {{ event.registered_count }} peserta
          </Descriptions.Item>
        </Descriptions>

        <!-- Registration Form -->
        <Form
        layout="vertical"
        class="mt-6"
        @finish="handleSubmit"
        >
        <!-- User Info Preview -->
        <div class="bg-gray-50 p-4 rounded-lg mb-6">
          <h3 class="text-lg font-semibold mb-4">
            <UserOutlined /> Informasi Peserta
          </h3>
          <Descriptions bordered size="small">
            <Descriptions.Item label="Nama" :span="3">
              {{ user.profile.full_name }}
            </Descriptions.Item>
            <Descriptions.Item label="Email" :span="3">
              {{ user.email }}
            </Descriptions.Item>
          </Descriptions>
        </div>

        <!-- Error Alert -->
        <Alert
        v-if="error"
        type="error"
        :message="error"
        class="mb-4"
        showIcon
        />

        <!-- Success Alert -->
        <Alert
        v-if="success"
        type="success"
        message="Registrasi berhasil! Anda akan dialihkan ke halaman detail acara."
        class="mb-4"
        showIcon
        />

        <!-- Submit Button -->
        <Form.Item>
          <Button
          type="primary"
          html-type="submit"
          :loading="loading"
          :disabled="success"
          block
          size="large"
          >
          Konfirmasi Pendaftaran
        </Button>
      </Form.Item>
    </Form>
  </Card>
</Col>

<!-- Sidebar -->
<Col :span="8">
<Card title="Catatan Penting" class="mb-6">
  <ul class="list-disc pl-4 space-y-2">
    <li>Pastikan data diri Anda sudah benar</li>
    <li>Pendaftaran tidak dapat dibatalkan setelah dikonfirmasi</li>
    <li>Harap hadir tepat waktu saat acara berlangsung</li>
    <li>Informasi detail akan dikirim melalui email</li>
  </ul>
</Card>
</Col>
</Row>
</div>
</template>

<style scoped>
  .container {
    max-width: 1280px;
  }
</style>