<script setup>
import { reactive, ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
import { message } from "ant-design-vue";
import axios from "axios";

import AppLayout from "@/Layouts/AppLayout.vue";
defineOptions({
  layout: AppLayout,
});

const form = ref({
  name: "",
  description: "",
});
const loading = ref(false);

const handleSubmit = async () => {
  loading.value = true;
  try {
    const response = await axios.post(route("app.waste-categories.store"), form.value);
    console.log(response);
    message.success(response.data.message);
    router.get(route("app.waste-categories.index"));
  } catch (error) {
    message.error(error.response?.data?.message);
  } finally {
    loading.value = false;
  }
};
</script>

<template>
  <div class="p-6">
    <a-card title="Create Waste Category">
      <a-form :model="form" layout="vertical" @finish="handleSubmit">
        <a-form-item
          label="Name"
          name="name"
          :rules="[{ required: true, message: 'Please input category name!' }]"
        >
          <a-input v-model:value="form.name" />
        </a-form-item>

        <a-form-item
          label="Description"
          name="description"
          :rules="[{ required: true, message: 'Please input category description!' }]"
        >
          <a-textarea v-model:value="form.description" :rows="4" />
        </a-form-item>

        <a-form-item>
          <a-space>
            <a-button type="primary" :loading="loading" html-type="submit">
              Submit
            </a-button>
            <Link :href="route('app.waste-categories.index')">
              <a-button>Cancel</a-button>
            </Link>
          </a-space>
        </a-form-item>
      </a-form>
    </a-card>
  </div>
</template>
