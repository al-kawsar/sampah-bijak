<template>
  <div class="settings-page">
    <a-row>
      <a-col :span="24">
        <a-card class="settings-card">
          <a-tabs v-model:activeKey="activeKey" @change="handleTabChange">
            <a-tab-pane key="profile" tab="Profil">
              <a-row>
                <a-col :span="24">
                  <h1 class="page-title">Pengaturan Profil</h1>
                  <a-divider />
                </a-col>
              </a-row>

              <a-spin :spinning="loading">
                <a-form
                :model="formState"
                @finish="onFinish"
                @finishFailed="onFinishFailed"
                :rules="rules"
                layout="vertical"
                >
                <a-row :gutter="[24, 0]">
                  <a-col :span="8">
                    <div class="profile-image-section">
                      <h3>Foto Profil</h3>
                      <a-upload
                      v-model:fileList="fileList"
                      name="avatar"
                      list-type="picture-card"
                      class="avatar-uploader"
                      :show-upload-list="false"
                      :before-upload="beforeUpload"
                      @change="handleChange"
                      >
                      <div class="upload-wrapper">
                        <template v-if="imageUrl">
                          <img :src="imageUrl" alt="avatar" class="avatar-image" />
                          <div class="upload-overlay">
                            <CameraOutlined />
                            <span>Ganti Foto</span>
                          </div>
                        </template>
                        <template v-else>
                          <div class="upload-placeholder">
                            <UserOutlined />
                            <div>Unggah Foto</div>
                          </div>
                        </template>
                      </div>
                    </a-upload>
                    <div class="upload-hint">
                      Disarankan: JPG atau PNG persegi, maks 2MB
                    </div>
                  </div>
                </a-col>

                <a-col :span="16">
                  <div class="form-section">
                    <a-form-item name="fullName" label="Nama Lengkap">
                      <a-input
                      v-model:value="formState.fullName"
                      size="large"
                      :prefix="h(UserOutlined)"
                      />
                    </a-form-item>

                    <a-form-item name="phoneNumber" label="Nomor Telepon">
                      <a-input
                      v-model:value="formState.phoneNumber"
                      size="large"
                      :prefix="h(PhoneOutlined)"
                      />
                    </a-form-item>

                    <a-form-item>
                      <a-space>
                        <a-button
                        type="primary"
                        html-type="submit"
                        :disabled="!hasChanges"
                        size="large"
                        >
                        <template #icon>
                          <SaveOutlined />
                        </template>
                        Simpan Perubahan
                      </a-button>
                      <a-button
                      v-if="hasChanges"
                      @click="resetForm"
                      size="large"
                      >
                      Batal
                    </a-button>
                  </a-space>
                </a-form-item>
              </div>
            </a-col>
          </a-row>
        </a-form>
      </a-spin>
    </a-tab-pane>
    <a-tab-pane key="account" tab="Akun">
    </a-tab-pane>
  </a-tabs>
</a-card>
</a-col>
</a-row>
</div>
</template>

<script setup>
  import AppLayout from "@/Layouts/AppLayout.vue";
  import { ref, reactive, onMounted, computed, h } from "vue";
  import {
    UserOutlined,
    PhoneOutlined,
    CameraOutlined,
    SaveOutlined
  } from "@ant-design/icons-vue";
  import { message } from "ant-design-vue";
  import { router } from "@inertiajs/vue3";
  import axios from "axios";

  defineOptions({
    layout: AppLayout,
  });

  const activeKey = ref("profile");

  const formState = reactive({
    fullName: "",
    phoneNumber: "",
    profilePicture: "",
  });
  const initialValues = reactive({ ...formState });

  const hasChanges = computed(() => {
    return (
      formState.fullName !== initialValues.fullName ||
      formState.phoneNumber !== initialValues.phoneNumber ||
      formState.profilePicture !== initialValues.profilePicture
      );
  });

  const rules = {
    fullName: [{ required: true, message: "Please input your full name" }],
    phoneNumber: [{ required: true, message: "Please input your phone number" }],
  };

  const loading = ref(false);
  const imageUrl = ref("");
  const fileList = ref([]);

  const beforeUpload = (file) => {
    const isJpgOrPng = file.type === "image/jpeg" || file.type === "image/png";
    if (!isJpgOrPng) {
      message.error("You can only upload JPG or PNG file!");
    }
    const isLt2M = file.size / 1024 / 1024 < 2;
    if (!isLt2M) {
      message.error("Image must be smaller than 2MB!");
    }
    return isJpgOrPng && isLt2M;
  };

  const handleChange = (info) => {
    if (info.file.status === "uploading") {
      loading.value = true;
      return;
    }
    if (info.file.status === "done") {
      getBase64(info.file.originFileObj, (url) => {
        loading.value = false;
        imageUrl.value = url;
      });
    }
    if (info.file.status === "error") {
      loading.value = false;
      message.error("Upload failed");
    }
  };

  const getBase64 = (img, callback) => {
    const reader = new FileReader();
    reader.addEventListener("load", () => callback(reader.result));
    reader.readAsDataURL(img);
  };

  const resetForm = () => {
    formState.fullName = initialValues.fullName;
    formState.phoneNumber = initialValues.phoneNumber;
    imageUrl.value = initialValues.profilePicture;
  };

  const onFinish = async (values) => {
    loading.value = true;
    try {
      const response = await axios.put('/api/user/profile', {
        ...values,
        profilePicture: imageUrl.value,
      });
      message.success("Profile updated successfully");
      Object.assign(initialValues, formState);
    } catch (error) {
      message.error(error.response?.data?.message || "Failed to update profile");
    } finally {
      loading.value = false;
    }
  };

  const onFinishFailed = (errorInfo) => {
    console.log("Failed:", errorInfo);
    message.error("Please fill all required fields correctly");
  };

  const handleTabChange = (key) => {
    if (key === "account") {
      router.get(route("app.settings.account"));
    }
  };

  const fetchProfile = async () => {
    loading.value = true;
    try {
      const response = await axios.get(route('app.user-profile.api'));
      const userProfile = response.data.data;
      formState.fullName = userProfile.full_name;
      formState.phoneNumber = userProfile.phone_number;
      imageUrl.value = userProfile.profile_picture;
      Object.assign(initialValues, formState);
    } catch (error) {
      message.error(error.response?.data?.message || "Failed to fetch profile");
    } finally {
      loading.value = false;
    }
  };

  onMounted(() => {
    fetchProfile();
  });
</script>

<style scoped>
  .settings-page {
    padding: 24px;
  }

  .settings-card {
    background: #fff;
    border: none;
    border-radius: 8px;
  }

  .page-title {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 0;
    color: rgba(0, 0, 0, 0.85);
  }

  .profile-image-section {
    text-align: center;
    padding: 20px;
  }

  .profile-image-section h3 {
    margin-bottom: 16px;
    color: rgba(0, 0, 0, 0.85);
  }

  .avatar-uploader {
    width: 100%;
  }

  .avatar-uploader > .ant-upload {
    width: 200px;
    height: 200px;
    margin: 0 auto;
    border-radius: 8px;
    overflow: hidden;
  }

  .upload-wrapper {
    position: relative;
    width: 100%;
    height: 100%;
  }

  .avatar-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .upload-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    color: white;
    opacity: 0;
    transition: opacity 0.3s;
  }

  .upload-wrapper:hover .upload-overlay {
    opacity: 1;
  }

  .upload-overlay span {
    margin-top: 8px;
  }

  .upload-placeholder {
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background: #fafafa;
  }

  .upload-placeholder .anticon {
    font-size: 32px;
    color: #999;
    margin-bottom: 8px;
  }

  .upload-hint {
    margin-top: 12px;
    color: rgba(0, 0, 0, 0.45);
    font-size: 12px;
  }

  .form-section {
    padding: 20px;
  }

  :deep(.ant-form-item-label > label) {
    font-weight: 500;
  }

  :deep(.ant-tabs-nav) {
    margin-bottom: 0;
  }

  :deep(.ant-card-body) {
    padding: 0;
  }

  :deep(.ant-tabs-content) {
    padding: 24px;
  }
</style>