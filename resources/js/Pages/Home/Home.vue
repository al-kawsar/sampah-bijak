<script setup>
import { ref } from "vue";
import {
  Button,
  Layout,
  Menu,
  Card,
  Statistic,
  Timeline,
  notification,
} from "ant-design-vue";

const { Header, Content, Footer } = Layout;

// Navigation state
const selectedKeys = ref(["1"]);

// Stats data
const statsData = ref([
  { title: "Sampah Terkelola", value: "50,000+", suffix: "ton" },
  { title: "Komunitas Aktif", value: "120+", suffix: "kelompok" },
  { title: "Pengguna Aktif", value: "25,000+", suffix: "orang" },
  { title: "Dampak Lingkungan", value: "30%", suffix: "pengurangan emisi" },
]);

// Programs data
const programs = ref([
  {
    title: "Bank Sampah Digital",
    description:
      "Sistem pengelolaan sampah berbasis teknologi untuk memudahkan tracking dan penukaran poin sampah.",
    icon: "mobile-outlined",
  },
  {
    title: "Edukasi Lingkungan",
    description:
      "Program pelatihan dan workshop tentang pengelolaan sampah yang bertanggung jawab.",
    icon: "book-outlined",
  },
  {
    title: "Pickup Sampah",
    description:
      "Layanan penjemputan sampah terjadwal dengan sistem pemilahan yang tepat.",
    icon: "car-outlined",
  },
]);

// News data
const news = ref([
  {
    title: "SampahBijak Raih Penghargaan Inovasi Teknologi Hijau 2024",
    date: "15 Jan 2024",
    image:
      "https://duitin.id/images/thumbnail/1604568406-Blog-02---Mengenal-Plastik-(1280-x-720).jpg",
  },
  {
    title: "Kolaborasi dengan 50 Sekolah untuk Program Edukasi Sampah",
    date: "10 Jan 2024",
    image: "https://duitin.id/images/thumbnail/1604569755-sungai1280x720.jpg",
  },
  {
    title: "Launching Fitur Baru: Tracking Sampah Real-time",
    date: "5 Jan 2024",
    image:
      "https://duitin.id/images/thumbnail/1616816699-Blog-13---Eco-Family-Antisipasi-Bencana-Ekosistem-Mulai-Dari-Diri-Sendiri-dan-Keluarga-(1280-x-720).jpg",
  },
]);

// Contact form
const formState = ref({
  name: "",
  email: "",
  message: "",
});

const isLogin = "Login";

const onSubmit = () => {
  notification.success({
    message: "Pesan Terkirim",
    description: "Terima kasih atas pesan Anda. Tim kami akan segera menghubungi Anda.",
  });
};
</script>

<template>
  <Layout class="layout">
    <!-- Header Section -->
    <Header class="header">
      <div class="logo">
        <img src="/logo.png" alt="SampahBijak Logo" />
      </div>
      <Menu v-model:selectedKeys="selectedKeys" mode="horizontal" class="menu">
        <Menu.Item key="1">Beranda</Menu.Item>
        <Menu.Item key="2">Acara</Menu.Item>
        <Menu.Item key="3">Berita</Menu.Item>
        <Menu.Item key="4">Tentang Kami</Menu.Item>
      </Menu>
      <Link :href="route('auth.login.index')">
        <Button type="primary" class="login-button"> {{ isLogin }} </Button>
      </Link>
    </Header>

    <Content>
      <!-- Hero Section -->
      <section class="hero">
        <div class="hero-content">
          <h1>Kelola Sampah dengan Bijak untuk Masa Depan yang Lebih Baik</h1>
          <p>
            Platform digital yang menghubungkan masyarakat, pengepul, dan industri daur
            ulang untuk menciptakan ekosistem pengelolaan sampah yang berkelanjutan.
          </p>
          <Button type="primary" size="large">Mulai Sekarang</Button>
        </div>
      </section>

      <!-- Stats Section -->
      <section class="stats">
        <div class="stats-container">
          <Card v-for="stat in statsData" :key="stat.title">
            <Statistic :title="stat.title" :value="stat.value" :suffix="stat.suffix" />
          </Card>
        </div>
      </section>

      <!-- Features Section -->
      <section class="features">
        <h2>Fitur Unggulan</h2>
        <div class="features-grid">
          <Card v-for="program in programs" :key="program.title" class="feature-card">
            <template #cover>
              <div class="icon-wrapper">
                <i :class="program.icon"></i>
              </div>
            </template>
            <Card.Meta :title="program.title" :description="program.description" />
          </Card>
        </div>
      </section>

      <!-- How It Works Section -->
      <section class="how-it-works">
        <h2>Cara Kerja</h2>
        <Timeline mode="alternate">
          <Timeline.Item>
            <h3>Kumpulkan Sampah</h3>
            <p>
              Pilah sampah sesuai jenisnya dan kumpulkan di tempat yang telah ditentukan.
            </p>
          </Timeline.Item>
          <Timeline.Item>
            <h3>Scan & Upload</h3>
            <p>Gunakan aplikasi untuk memindai dan mengunggah data sampah Anda.</p>
          </Timeline.Item>
          <Timeline.Item>
            <h3>Dapatkan Poin</h3>
            <p>
              Terima poin reward yang dapat ditukarkan dengan berbagai hadiah menarik.
            </p>
          </Timeline.Item>
          <Timeline.Item>
            <h3>Dampak Positif</h3>
            <p>Kontribusi Anda membantu menciptakan lingkungan yang lebih bersih.</p>
          </Timeline.Item>
        </Timeline>
      </section>

      <!-- Impact Section -->
      <section class="impact">
        <h2>Dampak Lingkungan</h2>
        <div class="impact-content">
          <div class="impact-text">
            <h3>Bersama Menciptakan Perubahan</h3>
            <p>Melalui platform SampahBijak, kami telah berhasil:</p>
            <ul>
              <li>Mengurangi 500 ton sampah plastik dari TPA</li>
              <li>Memberdayakan 1000+ pemulung</li>
              <li>Mendaur ulang 70% sampah yang terkumpul</li>
              <li>Mengedukasi 10.000+ masyarakat</li>
            </ul>
          </div>
          <div class="impact-image">
            <img
              src="https://duitin.id/images/header/1699231449005-blog36-1,5degrees(1920x1080).jpg"
              alt="Dampak Lingkungan"
            />
          </div>
        </div>
      </section>

      <!-- News Section -->
      <section class="news">
        <h2>Berita Terkini</h2>
        <div class="news-grid">
          <Card v-for="item in news" :key="item.title" hoverable>
            <template #cover>
              <img :src="item.image" :alt="item.title" />
            </template>
            <Card.Meta :title="item.title">
              <template #description>
                <p>{{ item.date }}</p>
              </template>
            </Card.Meta>
          </Card>
        </div>
      </section>

      <!-- Partners Section -->
      <section class="partners">
        <h2>Mitra Kami</h2>
        <div class="partners-grid">
          <img src="https://duitin.id/revamp-3/assets/mitra/ikea.jpg" alt="Partner 4" />
          <img
            src="https://duitin.id/revamp-3/assets/mitra/unilever.png"
            alt="Partner 1"
          />
          <img
            src="https://duitin.id/revamp-3/assets/mitra/dje%20holdings.png"
            alt="Partner 2"
          />
          <img
            src="https://duitin.id/revamp-3/assets/mitra/mondelez.jpg"
            alt="Partner 3"
          />
        </div>
      </section>

      <!-- Join Community Section -->
      <section class="join-community">
        <div class="join-content">
          <h2>Bergabung dengan Komunitas</h2>
          <p>
            Jadilah bagian dari perubahan. Bersama kita wujudkan Indonesia bebas sampah.
          </p>
          <Button type="primary" size="large">Gabung Sekarang</Button>
        </div>
      </section>
    </Content>

    <Footer class="footer">
      <div class="footer-content">
        <div class="footer-section">
          <h3>SampahBijak</h3>
          <p>
            Platform pengelolaan sampah digital untuk masa depan yang lebih berkelanjutan.
          </p>
        </div>
        <div class="footer-section">
          <h3>Tautan</h3>
          <ul>
            <li>Tentang Kami</li>
            <li>Karir</li>
            <li>Blog</li>
            <li>Kebijakan Privasi</li>
          </ul>
        </div>
        <div class="footer-section">
          <h3>Kontak</h3>
          <p>Email: info@sampahbijak.id</p>
          <p>Telepon: (021) 1234-5678</p>
          <p>Alamat: Jl. Hijau No. 123, Jakarta</p>
        </div>
      </div>
    </Footer>
  </Layout>
</template>

<style scoped>
img {
  display: block;
  width: 100%;
}
.layout {
  min-height: 100vh;
}

.header {
  display: flex;
  background: transparent;
  align-items: center;
  justify-content: space-between;
  background: white;
  padding: 0 50px;
  backdrop-filter: blue(10px);
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
  position: fixed;
  width: 100%;
  z-index: 1000;
}
.logo img {
  height: 40px;
}

.menu {
  flex: 1;
  justify-content: center;
}

.login-button {
  margin-left: 20px;
}

/* Hero Section */
.hero {
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
    url("https://duitin.id/images/header/1684920800503-blog27-jamurpemecahplastik(1920x1080).jpg");
  background-size: cover;
  background-position: center;
  color: #fff;
  text-align: center;
  padding: 0 20px;
}

.hero-content {
  max-width: 800px;
}

.hero h1 {
  font-size: 3.5rem;
  margin-bottom: 20px;
  color: #fff;
}

/* Stats Section */
.stats {
  padding: 80px 50px;
  background: #f8f9fa;
}

.stats-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
  max-width: 1200px;
  margin: 0 auto;
}

/* Features Section */
.features {
  padding: 80px 50px;
  text-align: center;
}

.features-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 30px;
  max-width: 1200px;
  margin: 40px auto 0;
}

/* How It Works Section */
.how-it-works {
  padding: 80px 50px;
  background: #f8f9fa;
  text-align: center;
}

/* Impact Section */
.impact {
  padding: 80px 50px;
}

.impact-content {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 40px;
  max-width: 1200px;
  margin: 40px auto 0;
}

/* News Section */
.news {
  padding: 80px 50px;
  background: #f8f9fa;
}

.news-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 30px;
  max-width: 1200px;
  margin: 40px auto 0;
}

/* Partners Section */
.partners {
  padding: 80px 50px;
  text-align: center;
}

.partners-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 40px;
  max-width: 1200px;
  margin: 40px auto 0;
  align-items: center;
}

.partners-grid > img {
  display: block;
  border-radius: 2rem;
  width: 100%;
}

/* Join Community Section */
.join-community {
  padding: 100px 50px;
  background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
    url("https://duitin.id/images/header/1637938125-Blog-18---Lifepal-(1920-x-1080).jpg");
  background-size: cover;
  background-position: center;
  color: #fff;
  text-align: center;
}

/* Contact Section */
.contact {
  padding: 80px 50px;
  background: #f8f9fa;
}

.contact-form {
  max-width: 600px;
  margin: 40px auto 0;
}

/* Footer */
.footer {
  background: #001529;
  color: #fff;
  padding: 60px 50px;
}

.footer-content {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 40px;
  max-width: 1200px;
  margin: 0 auto;
}

/* Responsive Design */
@media (max-width: 768px) {
  .header {
    padding: 0 20px;
  }

  .hero h1 {
    font-size: 2.5rem;
  }

  .impact-content {
    grid-template-columns: 1fr;
  }
}

h2 {
  font-size: 2.5rem;
  margin-bottom: 20px;
}
</style>
