<template>
  <div class="settings-page">
    <a-tabs v-model:activeKey="activeKey" @change="handleTabChange">
      <a-tab-pane key="profile" tab="Profil">
      </a-tab-pane>
      <a-tab-pane key="account" tab="Akun">
        <h1 class="text-2xl font-bold mb-6">Pengaturan Akun</h1>
        <a-spin :spinning="loading">
          <a-form
            :model="formState"
            @finish="onFinish"
            @finishFailed="onFinishFailed"
            :rules="rules"
          >
            <a-form-item name="username" label="Username">
              <a-input v-model:value="formState.username" />
            </a-form-item>

            <a-form-item name="email" label="Email">
              <a-input v-model:value="formState.email" />
            </a-form-item>

            <a-form-item name="password" label="New Password">
              <a-input-password v-model:value="formState.password" />
            </a-form-item>

            <a-form-item name="confirmPassword" label="Confirm New Password">
              <a-input-password v-model:value="formState.confirmPassword" />
            </a-form-item>

            <a-form-item>
              <a-button type="primary" html-type="submit"> Save Changes </a-button>
            </a-form-item>
          </a-form>
        </a-spin>
      </a-tab-pane>
    </a-tabs>
  </div>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref, reactive, onMounted } from "vue";
import { message } from "ant-design-vue";

import { router } from "@inertiajs/vue3";

defineOptions({
  layout: AppLayout,
});

const activeKey = ref("account");

const formState = reactive({
  username: "",
  email: "",
  password: "",
  confirmPassword: "",
});

const rules = {
  username: [{ required: true, message: "Please input your username" }],
  email: [
    { required: true, message: "Please input your email" },
    { type: "email", message: "Please enter a valid email" },
  ],
  password: [{ min: 8, message: "Password must be at least 8 characters" }],
  confirmPassword: [{ validator: validateConfirmPassword, trigger: "change" }],
};

function validateConfirmPassword(rule, value) {
  if (value && value !== formState.password) {
    return Promise.reject("The two passwords do not match");
  }
  return Promise.resolve();
}

const loading = ref(false);

// Data Dummy
const dummyData = {
  username: "JohnDoe",
  email: "john.doe@example.com",
};

// Load Dummy Data
const fetchAccount = () => {
  loading.value = true;
  setTimeout(() => {
    formState.username = dummyData.username;
    formState.email = dummyData.email;
    loading.value = false;
  }, 500); // Simulasi waktu tunggu
};

const onFinish = (values) => {
  loading.value = true;
  setTimeout(() => {
    console.log("Updated Data:", values);
    message.success("Account updated successfully");
    // Clear password fields after successful update
    formState.password = "";
    formState.confirmPassword = "";
    loading.value = false;
  }, 500); // Simulasi waktu pemrosesan
};

const onFinishFailed = (errorInfo) => {
  console.log("Failed:", errorInfo);
  message.error("Please fill all required fields correctly");
};

const handleTabChange = (key) => {
  if (key === "profile") {
    router.get(route("app.settings.profile"));
  }
};

onMounted(() => {
  fetchAccount();
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
