<script setup>
  import axios from "axios";
  import { ref, onMounted } from "vue";
  import AppLayout from "@/Layouts/AppLayout.vue";
  import { router } from "@inertiajs/vue3";
  import { message } from "ant-design-vue";
  import { debounce } from "lodash";

  import {
    UserOutlined,
    MailOutlined,
    LockOutlined,
    PhoneOutlined,
    PictureOutlined,
  } from "@ant-design/icons-vue";

  defineOptions({
    layout: AppLayout,
  });

  const loading = ref(false);
  const imageUrl = ref("");
  const regions = ref([]);
  const roles = ref([]);

  const form = ref({
    username: "",
    email: "",
    password: "",
    region_id: undefined,
    role_id: undefined,
    full_name: "",
    phone_number: "",
    profile_picture: null,
  });

  const fetchRegions = async (search = "") => {
    try {
      const response = await axios.get(route('app.regions.api'), {
        params: {
          search,
        },
      });
      const { data } = response.data;

      regions.value = data || [];
    } catch (error) {
      console.error("Failed to fetch regions:", error);
      message.error(err.response.data.message);
    }
  };

  const fetchRoles = async (search = "") => {
    try {
      const response = await axios.get(route('app.roles.api'), {
        params: {
          search,
        },
      });
      const { data } = response.data;
      roles.value = data || [];
    } catch (error) {
      console.error("Failed to fetch roles:", error);
      message.error(err.response.data.message);
    }
  };
  const handleSubmit = async () => {
    loading.value = true;
    try {
      await router.post(route('app.users.store'), form.value, {
        onSuccess: () => {
          message.success("User created successfully");
          router.visit(route('app.users.index'));
        },
        onError: (errors) => {
          console.log(errors);
          message.error(err.response.data.message);

        },
      });
    } finally {
      loading.value = false;
    }
  };

  const handleImageUpload = (info) => {
    if (info.file.status === "done") {
      imageUrl.value = URL.createObjectURL(info.file.originFileObj);
      form.value.profile_picture = info.file.response.path;
    }
  };

// Event Handlers

// Debounce Implementation with setTimeout
  let regionTimeout;
  const handleSearchRegion = (value) => {
    if (regionTimeout) clearTimeout(regionTimeout);
    regionTimeout = setTimeout(() => {
      fetchRegions(value);
    }, 300);
  };

  let roleTimeout;
  const handleSearchRole = (value) => {
    if (roleTimeout) clearTimeout(roleTimeout);
    roleTimeout = setTimeout(() => {
      fetchRoles(value);
    }, 300);
  };
  onMounted(() => {
    fetchRegions();
    fetchRoles();
  });
</script>

<template>
  <div class="p-6">
    <a-card title="Create New User" class="max-w-3xl mx-auto">
      <a-form :model="form" layout="vertical" @finish="handleSubmit">

        <a-form-item
        label="Username"
        name="username"
        :rules="[{ required: true, message: 'Please input username!' }]"
        >
        <a-input v-model:value="form.username" placeholder="Enter username">
          <template #prefix>
            <UserOutlined />
          </template>
        </a-input>
      </a-form-item>

      <a-form-item
      label="Email"
      name="email"
      :rules="[
        { required: true, message: 'Please input email!' },
        { type: 'email', message: 'Please enter a valid email!' },
        ]"
        >
        <a-input v-model:value="form.email" placeholder="Enter email">
          <template #prefix>
            <MailOutlined />
          </template>
        </a-input>
      </a-form-item>

      <a-form-item
      label="Password"
      name="password"
      :rules="[{ required: true, message: 'Please input password!' }]"
      >
      <a-input-password v-model:value="form.password" placeholder="Enter password">
        <template #prefix>
          <LockOutlined />
        </template>
      </a-input-password>
    </a-form-item>

    <a-row :gutter="16">
      <a-col :span="12">
        <a-form-item
        label="Region"
        name="region_id"
        :rules="[{ required: true, message: 'Please select region!' }]"
        >
        <a-select
        v-model:value="form.region_id"
        placeholder="Select region"
        :options="regions"
        :field-names="{ label: 'region_name', value: 'id' }"
        />

      </a-form-item>
    </a-col>

    <a-col :span="12">
      <a-form-item
      label="Role"
      name="role_id"
      :rules="[{ required: true, message: 'Please select role!' }]"
      >
      <a-select
      v-model:value="form.role_id"
      placeholder="Select role"
      :options="roles"
      :field-names="{ label: 'name', value: 'id' }"
      />
    </a-form-item>
  </a-col>
</a-row>

<a-form-item
label="Full Name"
name="full_name"
:rules="[{ required: true }]"
>
<a-input v-model:value="form.full_name" placeholder="Enter full name">
  <template #prefix>
    <UserOutlined />
  </template>
</a-input>
</a-form-item>

<a-form-item
label="Phone Number"
name="phone_number"
:rules="[{ required: true}]"
>
<a-input
v-model:value="form.phone_number"
placeholder="Enter phone number"
>
<template #prefix>
  <PhoneOutlined />
</template>
</a-input>
</a-form-item>

        <!-- <a-form-item label="Profile Picture" name="form.profile_picture">
          <a-upload
            v-model:file-list="fileList"
            name="profile_picture"
            :show-upload-list="false"
            action="/api/uploads"
            :before-upload="beforeUpload"
            @change="handleImageUpload"
          >
            <a-button>
              <template #icon>
                <PictureOutlined />
              </template>
              Upload Profile Picture
            </a-button>
          </a-upload>
          <div class="mt-2">
            <img
              v-if="imageUrl"
              :src="imageUrl"
              alt="avatar"
              class="w-32 h-32 object-cover rounded"
            />
          </div>
        </a-form-item> -->

        <a-form-item class="text-right">
          <a-space>
            <a-button @click="() => router.visit('/users')"> Cancel </a-button>
            <a-button type="primary" html-type="submit" :loading="loading">
              Create User
            </a-button>
          </a-space>
        </a-form-item>
      </a-form>
    </a-card>
  </div>
</template>
