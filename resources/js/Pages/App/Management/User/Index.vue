<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import axios from "axios";
import { ref, onMounted } from "vue";
import { router } from "@inertiajs/vue3";
import {
  UserOutlined,
  EditOutlined,
  DeleteOutlined,
  PlusOutlined,
  SearchOutlined,
} from "@ant-design/icons-vue";

import { message, Modal } from "ant-design-vue";
defineOptions({
  layout: AppLayout,
});

// State management
const searchQuery = ref("");
const loading = ref(false);
const datas = ref([]);
const pagination = ref({
  current: 1,
  pageSize: 10,
  total: 0,
});

const columns = [
  {
    title: "ID",
    dataIndex: "id",
    key: "id",
    width: "5%", // ID biasanya pendek, jadi 5% cukup
    align: "center",
  },
  {
    title: "Username",
    dataIndex: "username",
    key: "username",
    width: "15%", // Username biasanya pendek, sehingga lebih kecil dari nama lengkap
  },
  {
    title: "Nama Lengkap",
    dataIndex: "email",
    key: "email",
    width: "20%", // Nama lengkap memerlukan lebih banyak ruang
    customRender: ({ record }) => record.profile?.full_name || "Tidak Tersedia",
  },
  {
    title: "Email",
    dataIndex: "email",
    key: "email",
    width: "25%", // Email biasanya lebih panjang
  },
  {
    title: "Nomor Telepon",
    dataIndex: "number_phone",
    key: "number_phone",
    width: "15%", // Nomor telepon biasanya pendek
    customRender: ({ record }) => record.profile?.phone_number || "Tidak Tersedia",
  },
  {
    title: "Role",
    dataIndex: "role_id",
    key: "role_id",
    width: "10%", // Role biasanya satu kata
    customRender: ({ record }) => record.role?.name || "Tidak Tersedia",
  },
  {
    title: "Actions",
    key: "actions",
    width: "10%", // Tindakan membutuhkan ruang kecil untuk tombol
    align: "center",
  },
];

const fetchData = async (params = {}) => {
  loading.value = true;
  try {
    const response = await axios.get(route("app.users.api"), {
      params: {
        search: searchQuery.value,
        limit: params.pageSize || pagination.value.pageSize,
        page: params.current || pagination.value.current,
        type: "search",
      },
    });

    const { data, meta } = response.data;
    datas.value = data || [];
    pagination.value = {
      current: meta.current_page,
      pageSize: meta.per_page,
      total: meta.total,
    };
  } catch (error) {
    console.error(error);
    message.error("Failed to fetch users");
  } finally {
    loading.value = false;
  }
};

const handleTableChange = (pag) => {
  fetchData({
    current: pag.current,
    pageSize: pag.pageSize,
  });
};

const handleSearch = () => {
  pagination.value.current = 1;
  fetchData();
};

const handleDelete = async (record) => {
  Modal.confirm({
    title: "Are you sure you want to delete this user?",
    content: "This action cannot be undone.",
    okText: "Yes",
    okType: "danger",
    cancelText: "No",
    async onOk() {
      try {
        const res = await axios.delete(route("app.users.destroy", record.id));
        message.success(res.data.message);
        fetchData();
      } catch (err) {
        // Pastikan untuk memeriksa apakah err.response ada sebelum mengakses data
        const errorMessage =
          err.response?.data?.message || "Terjadi kesalahan saat menghapus pengguna.";
        message.error(errorMessage);
      }
    },
  });
};

const handleEdit = (record) => {
  router.get(route("app.users.edit", record.id));
};

const handleCreate = () => {
  router.get(route("app.users.create"));
};

// Initial load
onMounted(() => {
  fetchData();
});
</script>

<template>
  <div class="p-6">
    <div class="mb-6">
      <a-row :gutter="16" class="mb-4">
        <a-col :span="16">
          <a-input-search
            v-model:value="searchQuery"
            placeholder="Search by username or email"
            enter-button
            @search="handleSearch"
            :loading="loading"
          >
            <template #prefix>
              <SearchOutlined />
            </template>
          </a-input-search>
        </a-col>
        <a-col :span="8" class="text-right">
          <a-button type="primary" @click="handleCreate">
            <template #icon>
              <PlusOutlined />
            </template>
            Add Data
          </a-button>
        </a-col>
      </a-row>

      <a-table
        :columns="columns"
        :data-source="datas"
        :pagination="pagination"
        :loading="loading"
        @change="handleTableChange"
        row-key="id"
      >
        <!-- Username column with icon -->
        <template #bodyCell="{ column, record, index }">
          <template v-if="column.key === 'username'">
            <span>
              <UserOutlined class="mr-2" />
              {{ record.username }}
            </span>
          </template>

          <template v-else-if="column.key === 'id'">
            {{ (pagination.current - 1) * pagination.pageSize + index + 1 }}
          </template>

          <!-- Actions column -->
          <template v-else-if="column.key === 'actions'">
            <a-space>
              <a-button type="primary" ghost size="middle" @click="handleEdit(record)">
                <template #icon>
                  <EditOutlined />
                </template>
                Edit
              </a-button>
              <a-button
                type="primary"
                danger
                ghost
                size="middle"
                @click="handleDelete(record)"
              >
                <template #icon>
                  <DeleteOutlined />
                </template>
                Delete
              </a-button>
            </a-space>
          </template>
        </template>
      </a-table>
    </div>
  </div>
</template>
