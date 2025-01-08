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
    width: "5%",
    align: "center",
  },
  {
    title: "Pengguna",
    dataIndex: "user_id",
    key: "user_id",
    width: "15%",
    customRender: ({ record }) => record.user?.profile?.full_name || "Tidak Tersedia",
  },
  {
    title: "Lokasi",
    dataIndex: "location_id",
    key: "location_id",
    width: "20%",
    customRender: ({ record }) => record.location?.name || "Tidak Tersedia",
  },
  {
    title: "Kategori",
    dataIndex: "category_id",
    key: "category_id",
    width: "15%",
    customRender: ({ record }) => record.category?.name || "Tidak Tersedia",
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
    const response = await axios.get(route("app.waste-reports.api"), {
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
        const res = await axios.delete(route("app.waste-reports.destroy", record.id));
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

const handleVerification = (record) => {
  router.get(route("app.waste-reports.edit", record.id));
};

const handleCreate = () => {
  router.get(route("app.waste-reports.create"));
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
          
        </a-col>
        <a-col :span="8" class="text-right">
          
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
        <template #bodyCell="{ column, record, index }">
          <!-- Actions column -->

          <template v-if="column.key === 'type'">
            <a-tag :color="getTagColor(record.type)">{{ record.type }}</a-tag>
          </template>
          <template v-else-if="column.key === 'id'">
            {{ (pagination.current - 1) * pagination.pageSize + index + 1 }}
          </template>

          <template v-if="column.key === 'actions'">
            <a-space>
              <a-button type="primary" ghost size="middle" @click="handleVerification(record)">
                <template #icon>
                  <EditOutlined />
                </template>
                Verifikasi
              </a-button>
            </a-space>
          </template>
        </template>
      </a-table>
    </div>
  </div>
</template>
