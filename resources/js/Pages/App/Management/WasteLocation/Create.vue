<template>
  <div class="p-6">
    <a-card title="Create Waste Location">
      <a-form :model="form" layout="vertical" @finish="handleSubmit">
        <a-form-item
          label="Name"
          name="name"
          :rules="[{ required: true, message: 'Please input location name!' }]"
        >
          <a-input v-model:value="form.name" />
        </a-form-item>

        <a-form-item
          label="Type"
          name="type"
          :rules="[{ required: true, message: 'Please select location type!' }]"
        >
          <a-select v-model:value="form.type">
            <a-select-option value="TPS">TPS</a-select-option>
            <a-select-option value="TPA">TPA</a-select-option>
            <a-select-option value="Pusat Daur Ulang">Pusat Daur Ulang</a-select-option>
            <a-select-option value="Tempat Pengolahan Sampah Organik"
              >Tempat Pengolahan Sampah Organik</a-select-option
            >
            <a-select-option value="Tempat Pembuangan Limbah Berbahaya"
              >Tempat Pembuangan Limbah Berbahaya</a-select-option
            >
          </a-select>
        </a-form-item>

        <a-form-item
          label="Address"
          name="address"
          :rules="[{ required: true, message: 'Please input address!' }]"
        >
          <a-textarea v-model:value="form.address" :rows="4" />
        </a-form-item>

        <a-row :gutter="16">
          <a-col :span="12">
            <a-form-item
              label="Latitude"
              name="latitude"
              :rules="[
                { required: true, message: 'Please input latitude!' },
                { type: 'number', message: 'Please input a valid number!' },
              ]"
            >
              <a-input-number
                v-model:value="form.latitude"
                :precision="8"
                style="width: 100%"
              />
            </a-form-item>
          </a-col>
          <a-col :span="12">
            <a-form-item
              label="Longitude"
              name="longitude"
              :rules="[
                { required: true, message: 'Please input longitude!' },
                { type: 'number', message: 'Please input a valid number!' },
              ]"
            >
              <a-input-number
                v-model:value="form.longitude"
                :precision="8"
                style="width: 100%"
              />
            </a-form-item>
          </a-col>
        </a-row>

        <a-form-item
          label="Capacity (tons)"
          name="capacity"
          :rules="[
            { required: true, message: 'Please input capacity!' },
            { type: 'number', message: 'Please input a valid number!' },
          ]"
        >
          <a-input-number
            v-model:value="form.capacity"
            :precision="2"
            style="width: 100%"
          />
        </a-form-item>

        <a-form-item
          label="Contact Number"
          name="contact_number"
          :rules="[{ required: true, message: 'Please input contact number!' }]"
        >
          <a-input v-model:value="form.contact_number" />
        </a-form-item>

        <a-form-item>
          <a-space>
            <a-button type="primary" :loading="loading" html-type="submit">
              Submit
            </a-button>
            <Link :href="route('app.waste-locations.index')">
              <a-button>Cancel</a-button>
            </Link>
          </a-space>
        </a-form-item>
      </a-form>
    </a-card>
  </div>
</template>

<script setup>
import { reactive, ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
import { message } from "ant-design-vue";
import axios from "axios";

import AppLayout from "@/Layouts/AppLayout.vue";
defineOptions({
  layout: AppLayout,
});

const form = reactive({
  name: "",
  type: undefined,
  address: "",
  latitude: null,
  longitude: null,
  capacity: null,
  contact_number: "",
});
const loading = ref(false);

const handleSubmit = async () => {
  loading.value = true;
  try {
    const response = await axios.post(route("app.waste-locations.store"), form);
    console.log(response);
    message.success(response.data.message);
    router.get(route("app.waste-locations.index"));
  } catch (error) {
    message.error(error.response?.data?.message);
  } finally {
    loading.value = false;
  }
};
</script>
