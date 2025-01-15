<script setup>
  import { ref, onMounted, h } from "vue";
  import { usePage } from "@inertiajs/vue3";
  import axios from "axios";
  import {
    Layout,
    Menu,
    Card,
    Form,
    Input,
    Button,
    Collapse,
    notification,
    Statistic,
  } from "ant-design-vue";
  import {
    BookOutlined,
    CalendarOutlined,
    QuestionCircleOutlined,
    TeamOutlined,
    EnvironmentOutlined,
  } from "@ant-design/icons-vue";

  const { Header, Content, Footer } = Layout;
  const { Panel } = Collapse;
  const { props } = usePage();

// Navigation
  const selectedKeys = ref(["1"]);
  const isLogin = ref(false);

// Data states
  const learningModules = ref([]);
  const events = ref([]);
  const faqs = ref([]);
  const loading = ref({
    learnings: true,
    events: true,
    faqs: true
  });

// Stats based on data
  const statsData = ref([
    { title: "Modul Pembelajaran", value: "0", icon: BookOutlined },
    { title: "Event Terlaksana", value: "0", icon: CalendarOutlined },
    { title: "FAQ", value: "0", icon: QuestionCircleOutlined },
    { title: "Total Lokasi", value: "0", icon: EnvironmentOutlined },
    ]);

// Contact form
  const formState = ref({
    name: "",
    email: "",
    subject: "",
    message: "",
  });

// Fetch learning modules
  const fetchLearningModules = async () => {
    try {
      loading.value.learnings = true;
      const response = await axios.get('/api/learnings', {
        params: {
          limit: 3
        }
      });
      learningModules.value = response.data.data;
      statsData.value[0].value = `${response.data.length}+`;
    } catch (error) {
      notification.error({
        message: 'Error',
        description: 'Gagal memuat data pembelajaran'
      });
    } finally {
      loading.value.learnings = false;
    }
  };

// Fetch events
  const fetchEvents = async () => {
    try {
      loading.value.events = true;
      const response = await axios.get('/api/events', {
        params: {
          limit: 3
        }
      });
      events.value = response.data.data;
      statsData.value[1].value = `${response.data.length}+`;
    } catch (error) {
      notification.error({
        message: 'Error',
        description: 'Gagal memuat data event'
      });
    } finally {
      loading.value.events = false;
    }
  };

// Fetch FAQs
  const fetchFaqs = async () => {
    try {
      loading.value.faqs = true;
      const response = await axios.get('/api/faqs');
      faqs.value = response.data.data.sort((a, b) => a.order_number - b.order_number);
      statsData.value[2].value = `${response.data.length}+`;
    } catch (error) {
      notification.error({
        message: 'Error',
        description: 'Gagal memuat data FAQ'
      });
    } finally {
      loading.value.faqs = false;
    }
  };

// Submit contact form
  const onSubmit = async () => {
    try {
      await axios.post('/contacts', formState.value);
      notification.success({
        message: 'Sukses',
        description: 'Pesan Anda telah terkirim. Tim kami akan segera menghubungi.',
      });
      formState.value = {
        name: "",
        email: "",
        subject: "",
        message: "",
      };
    } catch (error) {
      notification.error({
        message: 'Error',
        description: 'Gagal mengirim pesan'
      });
    }
  };

  onMounted(async () => {
    if (props.user) {
      isLogin.value = true;
    }

  // Fetch all data in parallel
    await Promise.all([
      fetchLearningModules(),
      fetchEvents(),
      fetchFaqs()
      ]);
  });
</script>

<template>
  <Layout class="layout">
    <Header class="header">
      <div class="logo">
        <span class="logo-text">SampahBijak</span>
      </div>
      <Menu v-model:selectedKeys="selectedKeys" mode="horizontal" class="menu">
        <Menu.Item key="1">Beranda</Menu.Item>
        <Menu.Item key="2">Pembelajaran</Menu.Item>
        <Menu.Item key="3">Event</Menu.Item>
        <Menu.Item key="4">FAQ</Menu.Item>
      </Menu>
      <template v-if="isLogin">
        <Link :href="route('app.dashboard')">
        <Button type="primary" class="login-button">Dashboard</Button>
      </Link>
    </template>
    <template v-else>
      <Link :href="route('auth.login.index')">
      <Button type="primary" class="login-button">Masuk</Button>
    </Link>
  </template>

</Header>

<Content>
      <!-- Hero Section <section class="hero">
        <div class="hero-content">
          <h1 class="hero-title">Kelola Sampah untuk Masa Depan Hijau</h1>
          <p class="hero-description">
            Platform digital untuk mengelola sampah dengan bijak dan berkelanjutan
          </p>
          <Button type="primary" size="large" class="hero-button">
            Mulai Sekarang
          </Button>
        </div>
      </section>


      <!-- Learning Modules -->
      <section class="learning-modules-section">
        <div class="container">
          <h2 class="section-title">Modul Pembelajaran</h2>
          <div class="modules-grid">
            <Card
            v-for="module in learningModules"
            :key="module.id"
            hoverable
            :loading="loading.learnings"
            class="learning-card"
            >
            <template #cover>
              <img :src="module.thumbnail" :alt="module.title" />
            </template>
            <Card.Meta :title="module.title" :description="module.description" />
            <div class="module-button">
              <Button type="link" @click="$inertia.visit(`/learning/${module.id}`)">
                Pelajari Selengkapnya
              </Button>
            </div>
          </Card>
        </div>
      </div>
    </section>

    <!-- Events Section -->
    <section class="events-section">
      <div class="container">
        <h2 class="section-title">Event Mendatang</h2>
        <div class="events-grid">
          <Card
          v-for="event in events"
          :key="event.id"
          hoverable
          :loading="loading.events"
          class="event-card"
          >
          <template #cover>
            <img :src="event.thumbnail_url" :alt="event.title" />
          </template>
          <h3 class="event-title">{{ event.title }}</h3>
          <p class="event-description">{{ event.description }}</p>
          <div class="event-details">
            <CalendarOutlined class="event-icon" />
            {{ new Date(event.date).toLocaleDateString('id-ID', {
              year: 'numeric',
              month: 'long',
              day: 'numeric'
            }) }}
          </div>
          <div class="event-location">
            <EnvironmentOutlined class="event-icon" />
            {{ event.location }}
          </div>
          <div class="event-capacity">
            <TeamOutlined class="event-icon" />
            Kapasitas: {{ event.capacity }} peserta
          </div>
          <Button type="primary" @click="$inertia.visit(`/events/${event.id}`)">
            Daftar Sekarang
          </Button>
        </Card>
      </div>
    </div>
  </section>

  <!-- FAQ Section -->
  <section class="faq-section">
    <div class="container">
      <h2 class="section-title">FAQ</h2>
      <Collapse class="faq-collapse" :loading="loading.faqs">
        <Panel
        v-for="faq in faqs"
        :key="faq.id"
        :header="faq.question"
        >
        <p>{{ faq.answer }}</p>
      </Panel>
    </Collapse>
  </div>
</section>

<!-- Contact Section -->
<section class="contact-section">
  <div class="container">
    <h2 class="section-title">Hubungi Kami</h2>
    <Form
    :model="formState"
    @finish="onSubmit"
    layout="vertical"
    class="contact-form"
    >
    <Form.Item label="Nama" name="name" :rules="[{ required: true, message: 'Silakan masukkan nama Anda' }]">
      <Input v-model:value="formState.name" />
    </Form.Item>
    <Form.Item
    label="Email"
    name="email"
    :rules="[
      { required: true, message: 'Silakan masukkan email Anda' },
      { type: 'email', message: 'Format email tidak valid' }
      ]"
      >
      <Input v-model:value="formState.email" />
    </Form.Item>
    <Form.Item
    label="Subjek"
    name="subject"
    :rules="[{ required: true, message: 'Silakan masukkan subjek pesan' }]"
    >
    <Input v-model:value="formState.subject" />
  </Form.Item>
  <Form.Item
  label="Pesan"
  name="message"
  :rules="[{ required: true, message: 'Silakan masukkan pesan Anda' }]"
  >
  <Input.TextArea v-model:value="formState.message" :rows="4" />
</Form.Item>
<Form.Item>
  <Button type="primary" html-type="submit" block>
    Kirim Pesan
  </Button>
</Form.Item>
</Form>
</div>
</section>
</Content>

<Footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div>
        <h3 class="footer-title">Tentang SampahBijak</h3>
        <p>Platform pengelolaan sampah digital untuk masa depan yang lebih berkelanjutan.</p>
      </div>
      <div>
        <h3 class="footer-title">Kontak</h3>
        <p>Email: info@sampahbijak.id</p>
        <p>Telepon: (021) 1234-5678</p>
        <p>Alamat: Jl. Hijau No. 123, Jakarta</p>
      </div>
      <div>
        <h3 class="footer-title">Sosial Media</h3>
        <div class="social-media-links">
          <a href="#" class="social-link">Instagram</a>
          <a href="#" class="social-link">Twitter</a>
          <a href="#" class="social-link">Facebook</a>
        </div>
      </div>
    </div>
  </div>
</Footer>
</Layout>
</template>

<style scoped>
  .layout {
    min-height: 100vh;
  }

  .header {
    position: fixed;
    width: 100%;
    z-index: 1000;
    background: white;
    padding: 0 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
  }

  .logo {
    display: flex;
    align-items: center;
  }

  .logo-text {
    font-size: 24px;
    font-weight: bold;
  }

  .menu {
    flex: 1;
    justify-content: center;
  }

  .hero {
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
    url("/api/placeholder/1920/1080");
    background-size: cover;
    background-position: center;
    color: white;
    text-align: center;
    padding: 0 24px;
  }

  .hero-title {
    font-size: 40px;
    font-weight: bold;
    margin-bottom: 24px;
  }

  .hero-description {
    font-size: 20px;
    margin-bottom: 32px;
  }

  .stats-section, .learning-modules-section, .events-section, .faq-section, .contact-section {
    padding: 64px 0;
  }

  .container {
    width: 90%;
    margin: 0 auto;
  }

  .stats-grid, .modules-grid, .events-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 16px;
  }

  .section-title {
    font-size: 32px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 32px;
  }

  .footer {
    background-color: #333;
    color: white;
    padding: 48px 0;
  }

  .footer-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 32px;
  }

  .footer-title {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 16px;
  }

  .social-media-links {
    display: flex;
    gap: 16px;
  }

  .social-link {
    color: white;
    text-decoration: none;
    transition: color 0.3s;
  }

  .social-link:hover {
    color: #4CAF50;
  }
</style>