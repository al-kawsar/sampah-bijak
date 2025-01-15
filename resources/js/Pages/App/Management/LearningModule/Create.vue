<script setup>
  import AppLayout from "@/Layouts/AppLayout.vue";
  import { ref, reactive, computed } from "vue";
  import { Form, Input, Button, message, Upload, Card, Progress } from "ant-design-vue";
  import {
    CloudUploadOutlined,
    SaveOutlined,
    ArrowLeftOutlined,
    PictureOutlined,
  } from "@ant-design/icons-vue";
  import Editor from "@tinymce/tinymce-vue";
  import axios from "axios";
  import { router } from "@inertiajs/vue3";

  defineOptions({
    layout: AppLayout,
  });

  const formRef = ref();
  const loading = ref(false);
  const imageUrl = ref("");
  const uploadLoading = ref(false);
  const progress = ref(0);
  const fileList = ref([]);

  const formState = reactive({
    title: "",
    description: "",
    content: "",
    thumbnail: "",
  });

  const rules = {
    title: [{ required: true, message: "Judul harus diisi", trigger: "blur" }],
    description: [{ required: true, message: "Deskripsi harus diisi", trigger: "blur" }],
    content: [{ required: true, message: "Konten harus diisi", trigger: "blur" }],
    thumbnail: [{ required: true, message: "Thumbnail harus diisi", trigger: "change" }],
  };

  const editorConfig = {
    height: 500,
    menubar: false,
    plugins: [
      "advlist autolink lists link image charmap preview anchor searchreplace visualblocks fullscreen insertdatetime media table code help wordcount save",
      ],
    toolbar:
    "formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | removeformat | help",
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

  const handleChange = (info) => {
    if (info.file.status === "uploading") {
      uploadLoading.value = true;
      progress.value = Math.round(info.file.percent);
      return;
    }
    if (info.file.status === "done") {
      uploadLoading.value = false;
      progress.value = 100;

      if (fileList.value.length > 0) {
        const file = info.file.originFileObj;
        formState.thumbnail = file;
        imageUrl.value = URL.createObjectURL(file);
      }

    }
  };

  const handleUpload = ({ file, onSuccess }) => {
    setTimeout(() => {
      onSuccess(file, file);
    }, 0);
  };

  const onSubmit = async () => {
    await formRef.value.validate();
    loading.value = true;

    const formData = new FormData();
    formData.append("title", formState.title);
    formData.append("description", formState.description);
    formData.append("content", formState.content);

    if(formState.thumbnail){
      formData.append("thumbnail", formState.thumbnail);
    }

  //   if (fileList.value.length > 0) {
  //   formData.append("thumbnail", fileList.value[0].originFileObj); // Use the file object
  // }

    axios
    .post(route("app.learnings.store"), formData, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    })
    .then((res) => {
      message.success(res.data.message);
      router.get(route("app.learnings.index"));
    })
    .catch((err) => {
      console.log(err);
      message.error(err.response.data.message);
    })
    .finally(() => {
      loading.value = false;
    });
  };

  const onCancel = () => {
    router.get("/learnings");
  };

  const formCompletion = computed(() => {
    let completed = 0;
    if (formState.title) completed++;
    if (formState.description) completed++;
    if (formState.content) completed++;
    if (formState.thumbnail) completed++;
    return Math.round((completed / 4) * 100);
  });
</script>

<template>
  <div class="create-module-container">
    <div class="page-header">
      <Button @click="onCancel" class="back-button" type="link">
        <ArrowLeftOutlined /> Kembali ke Daftar Modul
      </Button>
      <Progress
      :percent="formCompletion"
      size="small"
      :show-info="false"
      class="completion-progress"
      />
    </div>

    <div class="content-layout">
      <div class="form-section">
        <Card class="form-card">
          <h1 class="form-title">Modul Pembelajaran</h1>

          <Form
          ref="formRef"
          :model="formState"
          :rules="rules"
          layout="vertical"
          class="modern-form"
          >
          <div class="input-group">
            <Form.Item label="Judul" name="title">
              <Input
              v-model:value="formState.title"
              placeholder="Enter an engaging title"
              size="large"
              class="modern-input"
              />
            </Form.Item>

            <Form.Item label="Deskripsi" name="description">
              <Input.TextArea
              v-model:value="formState.description"
              placeholder="Write a brief description"
              :rows="4"
              class="modern-textarea"
              />
            </Form.Item>
          </div>

          <Form.Item label="Konten" name="content" class="content-editor">
            <div class="editor-container">
              <Editor
              v-model="formState.content"
              api-key="uznu6jesdowws1y81ijo3mj3wq002hvrukm1wkbf7s62l2gn"
              :init="editorConfig"
              class="modern-editor"
              />
            </div>
          </Form.Item>
        </Form>
      </Card>
    </div>

    <div class="sidebar-section">
      <Card class="thumbnail-card">
        <div class="thumbnail-header"><PictureOutlined /> Thumbnail</div>

        <Form.Item name="thumbnail">
          <div class="upload-container">
            <Upload
            name="thumbnail"
            v-model:fileList="fileList"
            :show-upload-list="false"
            :customRequest="handleUpload"
            :maxCount="1"
            :beforeUpload="beforeUpload"
            @change="handleChange"
            class="modern-upload"
            >
            <div v-if="imageUrl" class="thumbnail-preview">
              <img :src="imageUrl" alt="thumbnail" />
              <div class="thumbnail-overlay">
                <CloudUploadOutlined /> Change Image
              </div>
            </div>
            <div v-else class="upload-placeholder">
              <CloudUploadOutlined />
              <span>Click or drag to upload</span>
              <span class="upload-hint">PNG, JPG up to 2MB</span>
            </div>
          </Upload>
          <Progress
          v-if="uploadLoading"
          :percent="progress"
          size="small"
          status="active"
          />
        </div>
      </Form.Item>

      <div class="action-buttons">
        <Button @click="onCancel" class="cancel-button"> Kembali </Button>
        <Button
        type="primary"
        @click="onSubmit"
        :loading="loading"
        class="submit-button"
        >
        <SaveOutlined /> Publikasi Modul
      </Button>
    </div>
  </Card>
</div>
</div>
</div>
</template>

<style scoped>
  .create-module-container {
    padding: 24px;
    min-height: 100vh;
  }

  .page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
  }

  .back-button {
    font-size: 16px;
    padding: 0;
  }

  .completion-progress {
    width: 200px;
  }

  .content-layout {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 24px;
  }

  .form-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  }

  .form-title {
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 32px;
    color: #1f2937;
  }

  .modern-form :deep(.ant-form-item-label) label {
    font-weight: 500;
    color: #374151;
  }

  .input-group {
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

  .modern-input {
    border-radius: 8px;
    border: 1.5px solid #e5e7eb;
    transition: all 0.3s;
  }

  .modern-input:hover,
  .modern-input:focus {
    border-color: #4f46e5;
    box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.1);
  }

  .modern-textarea {
    border-radius: 8px;
    border: 1.5px solid #e5e7eb;
    resize: none;
  }

  .editor-container {
    border-radius: 8px;
    overflow: hidden;
    border: 1.5px solid #e5e7eb;
  }

  .thumbnail-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  }

  .thumbnail-header {
    font-size: 16px;
    font-weight: 500;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
    color: #374151;
  }

  .upload-container {
    width: 100%;
  }

  .modern-upload {
    width: 100%;
  }

  .upload-placeholder {
    border: 2px dashed #e5e7eb;
    border-radius: 8px;
    padding: 32px 16px;
    text-align: center;
    color: #6b7280;
    transition: all 0.3s;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    gap: 8px;
    align-items: center;
  }

  .upload-placeholder:hover {
    border-color: #4f46e5;
    color: #4f46e5;
  }

  .upload-hint {
    font-size: 12px;
    color: #9ca3af;
  }

  .thumbnail-preview {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
  }

  .thumbnail-preview img {
    width: 100%;
    height: 200px;
    object-fit: cover;
  }

  .thumbnail-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    opacity: 0;
    transition: opacity 0.3s;
  }

  .thumbnail-preview:hover .thumbnail-overlay {
    opacity: 1;
  }

  .action-buttons {
    display: flex;
    gap: 12px;
    margin-top: 24px;
  }

  .cancel-button {
    flex: 1;
  }

  .submit-button {
    flex: 2;
    height: 40px;
    border-radius: 6px;
    background: #4f46e5;
    border-color: #4f46e5;
  }

  .submit-button:hover {
    background: #4338ca;
    border-color: #4338ca;
  }

  @media (max-width: 1024px) {
    .content-layout {
      grid-template-columns: 1fr;
    }
  }
</style>
