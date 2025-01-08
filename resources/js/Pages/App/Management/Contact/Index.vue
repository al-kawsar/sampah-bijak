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
  CheckCircleFilled,
  RocketOutlined,
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

// Table columns definition
const columns = [
  {
    title: "ID",
    dataIndex: "id",
    key: "id",
    width: "10%",
  },
  {
    title: "Nama",
    dataIndex: "name",
    key: "name",
    width: "15%",
  },
  {
    title: "Email",
    dataIndex: "email",
    key: "email",
    width: "20%",
  },
  {
    title: "Subjek",
    dataIndex: "subject",
    key: "subject",
    width: "20%",
  },
  {
    title: "Pesan",
    dataIndex: "message",
    key: "message",
    width: "20%",
  },
  {
    title: "Aksi",
    key: "actions",
    width: "20%",
    align: "center",
  },
];

const fetchData = async (params = {}) => {
  loading.value = true;
  try {
    const response = await axios.get(route("app.contacts.api"), {
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
    message.error("Failed to fetch data");
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
    title: "hapus?",
    content: "This action cannot be undone.",
    okText: "Yes",
    okType: "danger",
    cancelText: "No",
    async onOk() {
      try {
        const res = await axios.delete(route("app.contacts.destroy", record.id));
        console.log("res", res);
        message.success(res.data.message);
        fetchData();
      } catch (err) {
        const errorMessage =
          err.response?.data?.message || "Terjadi kesalahan saat menghapus data.";
        message.error(errorMessage);
      }
    },
  });
};

const handleEdit = (record) => {
  router.get(route("app.contacts.edit", record.id));
};

const handleCreate = () => {
  router.get(route("app.contacts.create"));
};

// Initial load
onMounted(() => {
  fetchData();
});
</script>

<template>
  <div class="p-6">
    <div class="mb-6">
      <a-tabs v-model:activeKey="activeKey" @change="handleTabChange">
        <a-tab-pane key="unread" tab="Belum dibaca">
          <h1 class="text-2xl font-bold mb-6">Pesan Belum Dibaca</h1>
          <a-table
            :columns="columns"
            :data-source="datas"
            :pagination="pagination"
            :loading="loading"
            @change="handleTableChange"
            row-key="id"
          >
            <template #bodyCell="{ column, record }">
              <!-- Actions column -->
              <template v-if="column.key === 'actions'">
                <a-space>
                  <a-button type="primary" ghost size="large" @click="handleEdit(record)">
                    <template #icon> <CheckCircleFilled /> </template>
                    Tandai sudah dibaca
                  </a-button>
                </a-space>
              </template>
            </template>
          </a-table>
        </a-tab-pane>
        <a-tab-pane key="read" tab="Sudah dibaca">
          <h1 class="text-2xl font-bold mb-6">Pesan Sudah Dibaca</h1>
        </a-tab-pane>
      </a-tabs>
    </div>
  </div>
</template>
