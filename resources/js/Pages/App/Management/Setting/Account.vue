<template>
  <div class="settings-page">
    <a-row>
      <a-col :span="24">
        <a-card class="settings-card">
          <a-tabs v-model:activeKey="activeKey" @change="handleTabChange">
            <a-tab-pane key="profile" tab="Profil">
            </a-tab-pane>
            <a-tab-pane key="account" tab="Akun">
              <a-row>
                <a-col :span="24">
                  <h1 class="page-title">Pengaturan Akun</h1>
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
                  <a-col :xs="24" :sm="24" :md="12">
                    <div class="form-section">
                      <h3>Informasi Akun</h3>
                      <a-form-item name="username" label="Username">
                        <a-input
                        v-model:value="formState.username"
                        size="large"
                        :prefix="h(UserOutlined)"
                        />
                      </a-form-item>

                      <a-form-item name="email" label="Email">
                        <a-input
                        v-model:value="formState.email"
                        size="large"
                        :prefix="h(MailOutlined)"
                        />
                      </a-form-item>
                    </div>
                  </a-col>

                  <a-col :xs="24" :sm="24" :md="12">
                    <div class="form-section">
                      <h3>Ubah Kata Sandi</h3>
                      <a-form-item name="password" label="Kata Sandi Baru">
                        <a-input-password
                        v-model:value="formState.password"
                        size="large"
                        :prefix="h(LockOutlined)"
                        >
                        <template #suffix>
                          <a-tooltip title="Kata sandi minimal 8 karakter">
                            <InfoCircleOutlined style="color: rgba(0,0,0,.45)" />
                          </a-tooltip>
                        </template>
                      </a-input-password>
                    </a-form-item>

                    <a-form-item name="confirmPassword" label="Konfirmasi Kata Sandi Baru">
                      <a-input-password
                      v-model:value="formState.confirmPassword"
                      size="large"
                      :prefix="h(LockOutlined)"
                      />
                    </a-form-item>
                  </div>
                </a-col>
              </a-row>

              <a-row>
                <a-col :span="24">
                  <div class="form-actions">
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
              </div>
            </a-col>
          </a-row>
        </a-form>
      </a-spin>
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
    MailOutlined,
    LockOutlined,
    SaveOutlined,
    InfoCircleOutlined,
  } from "@ant-design/icons-vue";
  import { message } from "ant-design-vue";
  import { router } from "@inertiajs/vue3";
  import axios from "axios";

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

  const initialValues = reactive({
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

  const hasChanges = computed(() => {
    return (
      formState.username !== initialValues.username ||
      formState.email !== initialValues.email ||
      formState.password !== "" ||
      formState.confirmPassword !== ""
      );
  });

  const loading = ref(false);

  const resetForm = () => {
    formState.username = initialValues.username;
    formState.email = initialValues.email;
    formState.password = "";
    formState.confirmPassword = "";
  };

  const onFinish = async (values) => {
    loading.value = true;
    try {
      const response = await axios.put('/api/user/account', {
        username: values.username,
        email: values.email,
        ...(values.password && { password: values.password }),
      });

      message.success("Account updated successfully");
      initialValues.username = formState.username;
      initialValues.email = formState.email;
      formState.password = "";
      formState.confirmPassword = "";
    } catch (error) {
      message.error(error.response?.data?.message || "Failed to update account");
    } finally {
      loading.value = false;
    }
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

  const fetchAccount = async () => {
    loading.value = true;
    try {
      const response = await axios.get(route('app.user-profile.api'));
      const userAccount = response.data.data;
      formState.username = userAccount.username;
      formState.email = userAccount.email;
      initialValues.username = userAccount.username;
      initialValues.email = userAccount.email;
    } catch (error) {
      message.error(error.response?.data?.message || "Failed to fetch account details");
    } finally {
      loading.value = false;
    }
  };

  onMounted(() => {
    fetchAccount();
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

  .form-section {
    padding: 20px;
  }

  .form-section h3 {
    margin-bottom: 24px;
    color: rgba(0, 0, 0, 0.85);
    font-size: 18px;
    font-weight: 500;
  }

  .form-actions {
    padding: 20px;
    margin-top: 24px;
    border-top: 1px solid #f0f0f0;
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

  :deep(.ant-input-affix-wrapper) {
    border-radius: 6px;
  }

  :deep(.ant-input-affix-wrapper:hover) {
    border-color: #40a9ff;
  }

  :deep(.ant-input-prefix) {
    color: rgba(0, 0, 0, 0.45);
  }
</style>