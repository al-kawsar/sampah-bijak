<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { router } from "@inertiajs/vue3";
import { ref } from "vue";
import { message } from "ant-design-vue";
import axios from "axios";
import { UploadOutlined, InboxOutlined } from "@ant-design/icons-vue";

defineOptions({
  layout: AppLayout,
});

const form = ref({
  title: "",
  description: "",
  date: null,
  location: "",
  thumbnail: null,
  capacity: null,
});

const loading = ref(false);
const fileList = ref([]);

const handleChange = (file) => {
  console.log("handleChange", file);
  //   fileList.value = [...(fileList.value || []), file];
  return false;
};

const beforeUpload = (file) => {
  console.log("beforeUpload", file);
  return false;
};

const handleSubmit = async () => {
  loading.value = true;
  const formData = new FormData();
  if (form.value.image !== null) {
    formData.append("thumbnail", form.value.image);
  }

  formData.append("title", form.value.title);
  formData.append("description", form.value.description);
  formData.append("date", form.value.date);
  formData.append("location", form.value.location);
  formData.append("capacity", form.value.capacity);

  axios
    .post(route("app.madings.store"), formData)
    .then((res) => {
      notify(
        {
          group: "top",
          text: res.data.message,
          type: "success",
        },
        2500
      );
      form.value = {
        title: "",
        description: "",
        date: "",
        location: "",
        capacity: "",
        thumbnail: "",
      };
    })
    .catch((err) => {
      console.log(err);
    })
    .finally(() => (loading.value = false));
};
</script>

<template>
  <div class="p-6">
    <div class="mb-6">
      <h1 class="text-2xl font-bold">Create New Event</h1>
    </div>

    <a-card>
      <a-form :model="form" layout="vertical">
        <a-form-item
          label="Title"
          name="title"
          :rules="[{ required: true, message: 'Please input event title!' }]"
        >
          <a-input v-model:value="form.title" placeholder="Enter event title" />
        </a-form-item>

        <a-form-item
          label="Thumbnail"
          name="thumbnail"
          :rules="[{ required: true, message: 'Please upload event thumbnail!' }]"
        >
          <a-upload-dragger
            name="thumbnail"
            :maxCount="1"
            :multiple="false"
            @change="handleChange"
          >
            <p class="ant-upload-drag-icon">
              <InboxOutlined />
            </p>
            <p class="ant-upload-text">Click or drag file to this area to upload</p>
            <p class="ant-upload-hint">
              Support for a single upload. Maximum file size 2MB.
            </p>
          </a-upload-dragger>
        </a-form-item>

        <a-form-item
          label="Description"
          name="description"
          :rules="[{ required: true, message: 'Please input event description!' }]"
        >
          <a-textarea
            v-model:value="form.description"
            placeholder="Enter event description"
            :rows="4"
          />
        </a-form-item>

        <a-form-item
          label="Date"
          name="date"
          :rules="[{ required: true, message: 'Please select event date!' }]"
        >
          <a-date-picker
            v-model:value="form.date"
            :show-time="true"
            format="YYYY-MM-DD HH:mm:ss"
            style="width: 100%"
          />
        </a-form-item>

        <a-form-item
          label="Location"
          name="location"
          :rules="[{ required: true, message: 'Please input event location!' }]"
        >
          <a-textarea
            v-model:value="form.location"
            placeholder="Enter event location"
            :rows="2"
          />
        </a-form-item>

        <a-form-item
          label="Capacity"
          name="capacity"
          :rules="[{ required: true, message: 'Please input event capacity!' }]"
        >
          <a-input-number v-model:value="form.capacity" :min="1" style="width: 100%" />
        </a-form-item>

        <a-form-item>
          <a-space>
            <a-button
              type="primary"
              html-type="submit"
              @click="handleSubmit"
              :loading="loading"
            >
              Create Event
            </a-button>
            <a-button @click="() => router.visit(route('app.events.index'))">
              Cancel
            </a-button>
          </a-space>
        </a-form-item>
      </a-form>
    </a-card>
  </div>
</template>
