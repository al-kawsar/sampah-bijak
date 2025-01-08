<template>
  <div class="settings-page">
    <a-tabs v-model:activeKey="activeKey" @change="handleTabChange">
      <a-tab-pane key="profile" tab="Profil">
        <h1 class="text-2xl font-bold mb-6">Pengaturan Profile</h1>
        <a-spin :spinning="loading">
          <a-form
            :model="formState"
            @finish="onFinish"
            @finishFailed="onFinishFailed"
            :rules="rules"
          >
            <a-form-item name="fullName" label="Full Name">
              <a-input v-model:value="formState.fullName" />
            </a-form-item>

            <a-form-item name="phoneNumber" label="Phone Number">
              <a-input v-model:value="formState.phoneNumber" />
            </a-form-item>

            <a-form-item name="profilePicture" label="Profile Picture">
              <a-upload
                v-model:fileList="fileList"
                name="avatar"
                list-type="picture-card"
                class="avatar-uploader"
                :show-upload-list="false"
                :before-upload="beforeUpload"
                @change="handleChange"
              >
                <img v-if="imageUrl" :src="imageUrl" alt="avatar" />
                <div v-else>
                  <plus-outlined />
                  <div class="ant-upload-text">Upload</div>
                </div>
              </a-upload>
            </a-form-item>

            <a-form-item>
              <a-button type="primary" html-type="submit"> Save Changes </a-button>
            </a-form-item>
          </a-form>
        </a-spin>
      </a-tab-pane>
      <a-tab-pane key="account" tab="Akun">
     </a-tab-pane>
    </a-tabs>
  </div>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

import { ref, reactive, onMounted } from "vue";
import { PlusOutlined } from "@ant-design/icons-vue";
import { message } from "ant-design-vue";
import { router } from "@inertiajs/vue3";

defineOptions({
  layout: AppLayout,
});

const activeKey = ref("profile");

const formState = reactive({
  fullName: "",
  phoneNumber: "",
});

const rules = {
  fullName: [{ required: true, message: "Please input your full name" }],
  phoneNumber: [{ required: true, message: "Please input your phone number" }],
};

const loading = ref(false);
const imageUrl = ref("");
const fileList = ref([]);

const dummyProfile = {
  fullName: "Jane Doe",
  phoneNumber: "123-456-7890",
  profilePicture: "https://via.placeholder.com/128",
};

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

const onFinish = (values) => {
  loading.value = true;
  setTimeout(() => {
    console.log("Updated values:", { ...values, profilePicture: imageUrl.value });
    message.success("Profile updated successfully (dummy data)");
    loading.value = false;
  }, 1000);
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

onMounted(() => {
  loading.value = true;
  setTimeout(() => {
    // Simulate fetching data
    formState.fullName = dummyProfile.fullName;
    formState.phoneNumber = dummyProfile.phoneNumber;
    imageUrl.value = dummyProfile.profilePicture;
    loading.value = false;
  }, 1000);
});
</script>

<style scoped>
.avatar-uploader > .ant-upload {
  width: 128px;
  height: 128px;
}
.ant-upload-select-picture-card i {
  font-size: 32px;
  color: #999;
}
.ant-upload-select-picture-card .ant-upload-text {
  margin-top: 8px;
  color: #666;
}
</style>
