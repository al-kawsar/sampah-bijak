
<script setup>
  import { reactive, ref} from 'vue'
  import { Link, router } from '@inertiajs/vue3'
  import { message } from 'ant-design-vue'
  import axios from "axios";

  import AppLayout from "@/Layouts/AppLayout.vue";
  defineOptions({
    layout: AppLayout,
  });

  const formRef = ref();
  const loading = ref(false);

  const props = defineProps({
    wasteCategory: {
      type: Object,
      required: true
    }
  })

  const form = reactive({
    name: props.wasteCategory.name,
    description: props.wasteCategory.description
  })

  const handleSubmit = async () => {
    await formRef.value.validate();
    loading.value = true
    axios
    .put(route("app.waste-categories.update", props.wasteCategory.id), form)
    .then((response) => {
      message.success(response?.data?.message ||"Waste category updated successfully");
      router.get(route('app.waste-categories.index'));
    })
    .catch((error) => {
      message.error(error.response.data.message ||"Failed to update waste category");
    }).finally( ()=> {
      loading.value = false;
    });
  };
</script>

<template>
  <div class="p-6">
    <a-card title="Edit Waste Category">
      <a-form
      ref="formRef"
      :model="form"
      layout="vertical"
      >
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
      <a-button type="primary" html-type="submit" :loading="loading" @click="handleSubmit">
        Perbarui
      </a-button>
      <Link :href="route('app.waste-categories.index')">
      <a-button>Batal</a-button>
    </Link>
  </a-space>
</a-form-item>
</a-form>
</a-card>
</div>
</template>