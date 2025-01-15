<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { router } from "@inertiajs/vue3";
import { ref } from "vue";
import { message } from "ant-design-vue";
import axios from "axios";

defineOptions({
  layout: AppLayout,
});

const props = defineProps({
  region: {
    type: Object,
    required: true,
  },
});

const form = ref({
  region_name: props.region.region_name,
});

const loading = ref(false);

const handleSubmit = async () => {
  loading.value = true;
  try {
    const response = await axios.put(
      route("app.regions.update", props.region.id),
      form.value
    );
    message.success(response.data.message || "Region updated successfully");
    router.visit(route("app.regions.index")); // Menggunakan Inertia router untuk navigasi
  } catch (error) {
    message.error(error.response?.data?.message || "Failed to update region");
  } finally {
    loading.value = false;
  }
};
</script>

<template>
  <div class="p-6">
    <div class="mb-6">
      <h1 class="text-2xl font-bold">Ubah Wilayah</h1>
    </div>

    <a-card>
      <a-form :model="form" layout="vertical" @finish="handleSubmit">
        <a-form-item
          label="Nama Wilayah"
          name="region_name"
          :rules="[{ required: true, message: 'Please input region name!' }]"
        >
          <a-input v-model:value="form.region_name" placeholder="Enter region name" />
        </a-form-item>

        <a-form-item>
          <a-space>
            <a-button type="primary" html-type="submit" :loading="loading">
              Simpan Perubahan
            </a-button>
            <a-button @click="() => router.get(route('app.regions.index'))">
              Kembali
            </a-button>
          </a-space>
        </a-form-item>
      </a-form>
    </a-card>
  </div>
</template>
