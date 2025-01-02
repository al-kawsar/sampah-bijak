<script setup>
import { router } from "@inertiajs/vue3";
import { computed } from "vue";
import { Button, Result } from "ant-design-vue";
import {
  StopOutlined,
  WarningOutlined,
  ExclamationCircleOutlined,
  CloseCircleOutlined,
} from "@ant-design/icons-vue";

const props = defineProps({
  status: {
    type: Number,
    default: 404,
  },
});

const title = computed(() => {
  return {
    503: "Service Unavailable",
    500: "Server Error",
    404: "Page Not Found",
    403: "Forbidden",
  }[props.status];
});

const description = computed(() => {
  return {
    503: "Maaf, kami sedang melakukan pemeliharaan. Harap kembali beberapa saat lagi.",
    500: "Ups, ada yang salah dengan server kami.",
    404: "Maaf, halaman yang Anda cari tidak dapat ditemukan.",
    403: "Maaf, Anda dilarang mengakses halaman ini.",
  }[props.status];
});

const icon = computed(() => {
  return {
    503: WarningOutlined,
    500: CloseCircleOutlined,
    404: ExclamationCircleOutlined,
    403: StopOutlined,
  }[props.status];
});

const status = computed(() => {
  return {
    503: "warning",
    500: "error",
    404: "info",
    403: "error",
  }[props.status];
});

const handleBackHome = () => {
  router.get(route("home.index"));
};

const handleReload = () => {
  window.location.reload();
};
</script>

<template>
  <div class="error-page">
    <Result :status="props.status" :title="title" :sub-title="description">
      <template #icon>
        <component :is="icon" class="result-icon" />
      </template>
      <template #extra>
        <div class="button-container">
          <Button type="primary" size="large" @click="handleBackHome">
            Kembali ke Beranda
          </Button>
          <Button size="large" @click="handleReload"> Muat Ulang Halaman </Button>
        </div>
      </template>
    </Result>
  </div>
</template>

<style scoped>
.error-page {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 24px;
  background-color: #f5f5f5;
}

.result-icon {
  font-size: 72px;
}

.result-icon.warning {
  color: #faad14;
}

.result-icon.error {
  color: #ff4d4f;
}

.result-icon.info {
  color: #1890ff;
}

.button-container {
  display: flex;
  gap: 16px;
  justify-content: center;
  flex-wrap: wrap;
}

/* Responsive Styles */
@media (max-width: 576px) {
  .error-page {
    padding: 16px;
  }

  .result-icon {
    font-size: 56px;
  }

  .button-container {
    flex-direction: column;
    width: 100%;
  }

  .button-container .ant-btn {
    width: 100%;
  }
}
</style>
