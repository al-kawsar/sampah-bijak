<script setup>
  import AppLayout from "@/Layouts/AppLayout.vue";
  import { router } from "@inertiajs/vue3";
  import { ref } from "vue";
  import { message } from "ant-design-vue";
  import axios from "axios";
  import { UploadOutlined, InboxOutlined, CloudUploadOutlined } from "@ant-design/icons-vue";

  defineOptions({ layout: AppLayout });

  const form = ref({
    title: "",
    description: "",
    date: null,
    location: "",
    thumbnail: null,
    capacity: null,
  });

  const fileList = ref([]);
  const loading = ref(false);
  const imageUrl = ref("");
  const uploadLoading = ref(false);

  const handleChange = (info) => {
    if (info.file.status === "uploading") {
      uploadLoading.value = true;
      return;
    }
    if (info.file.status === "done") {
      uploadLoading.value = false;

      if (fileList.value.length > 0) {
        const file = info.file.originFileObj;
        form.value.thumbnail = file;
        console.log()
        imageUrl.value = URL.createObjectURL(file);
      }

    }
  };

  const beforeUpload = (file) => {
    const isImage = file.type.startsWith("image/");
    if (!isImage) {
      message.error("Silakan unggah file gambar");
      return false;
    }
    const isLt2M = file.size / 1024 / 1024 < 2;
    if (!isLt2M) {
      message.error("Gambar harus lebih kecil dari 2MB");
      return false;
    }
    return true;
  };

  const handleUpload = ({ file, onSuccess }) => {
    setTimeout(() => {
      onSuccess(file, file);
    }, 0);
  };


  const handleSubmit = async () => {
    loading.value = true;
    const formData = new FormData();
    if (form.value.thumbnail !== null) {
      formData.append("thumbnail_url", form.value.thumbnail);
    }

    formData.append("title", form.value.title);
    formData.append("description", form.value.description);
    formData.append("date", form.value.date);
    formData.append("location", form.value.location);
    formData.append("capacity", form.value.capacity);

    axios
    .post(route("app.events.store"), formData, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    })
    .then((res) => {
      message.error(res.data.message);
      router.get(route("app.events.index"));
    })
    .catch((err) => {
      message.error(err.response.data.message);
    })
    .finally(() => (loading.value = false));
  };
</script>
<template>
  <div class="p-6">
    <div class="mb-6">
      <h1 class="text-2xl font-bold">Buat Acara Baru</h1>
    </div>

    <a-card>
      <a-form :model="form" layout="vertical">
        <a-form-item
        label="Judul"
        name="title"
        :rules="[{ required: true, message: 'Silakan masukkan judul acara!' }]"
        >
        <a-input v-model:value="form.title" placeholder="Masukkan judul acara" />
      </a-form-item>

      <a-form-item
      label="Thumbnail"
      name="thumbnail"
      :rules="[{ required: true, message: 'Silakan unggah thumbnail acara!' }]"
      >
      <a-upload-dragger
      name="thumbnail"
      v-model:fileList="fileList"
      :show-upload-list="false"
      :beforeUpload="beforeUpload"
      :maxCount="1"
      :customRequest="handleUpload"
      :multiple="false"
      @change="handleChange"
      >
      <div v-if="imageUrl" class="thumbnail-preview">
        <img :src="imageUrl" alt="thumbnail" />
        <div class="thumbnail-overlay">
          <CloudUploadOutlined /> Ganti Gambar
        </div>
      </div>
      <div v-else class="upload-placeholder">
        <InboxOutlined />
        <p>Klik atau seret file ke area ini untuk mengunggah</p>
        <p class="upload-hint">Mendukung unggahan tunggal. Ukuran file maksimum 2MB.</p>
      </div>
    </a-upload-dragger>
  </a-form-item>

  <a-form-item
  label="Deskripsi"
  name="description"
  :rules="[{ required: true, message: 'Silakan masukkan deskripsi acara!' }]"
  >
  <a-textarea
  v-model:value="form.description"
  placeholder="Masukkan deskripsi acara"
  :rows="4"
  />
</a-form-item>

<a-form-item
label="Tanggal"
name="date"
:rules="[{ required: true, message: 'Silakan pilih tanggal acara!' }]"
>
<a-date-picker
v-model:value="form.date"
format="YYYY-MM-DD"
style="width: 100%"
/>
</a-form-item>

<a-form-item
label="Lokasi"
name="location"
:rules="[{ required: true, message: 'Silakan masukkan lokasi acara!' }]"
>
<a-textarea
v-model:value="form.location"
placeholder="Masukkan lokasi acara"
:rows="2"
/>
</a-form-item>

<a-form-item
label="Kapasitas"
name="capacity"
:rules="[{ required: true, message: 'Silakan masukkan kapasitas acara!' }]"
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
    Buat Acara
  </a-button>
  <a-button @click="() => router.visit(route('app.events.index'))">
    Batal
  </a-button>
</a-space>
</a-form-item>
</a-form>
</a-card>
</div>
</template>


<style scoped>
  .thumbnail-preview {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .thumbnail-preview img {
    max-width: 100%;
    max-height: 500px;
    object-fit: cover;
    object-position: center;
  }

  .thumbnail-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.5);
    color: white;
    cursor: pointer;
  }

  .upload-placeholder {
    text-align: center;
    padding: 20px;
    border: 2px dashed #d9d9d9;
    border-radius: 4px;
  }
</style>