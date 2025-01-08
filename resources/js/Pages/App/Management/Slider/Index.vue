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
    width: "10%",
  },
  {
    title: "Image",
    dataIndex: "image",
    key: "image",
    width: "20%",
    align: "center",
  },
  {
    title: "Urutan",
    dataIndex: "order_number",
    key: "order_number",
    width: "30%",
  },
  {
    title: "Status",
    dataIndex: "is_active",
    key: "is_active",
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
    const response = await axios.get(route("app.sliders.api"), {
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
        const res = await axios.delete(route("app.sliders.destroy", record.id));
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
  router.get(route("app.sliders.edit", record.id));
};

const handleCreate = () => {
  router.get(route("app.sliders.create"));
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
            placeholder="Searching Data"
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
        <template #bodyCell="{ column, record }">
          <template v-if="column.key === 'image'">
            <a-image :width="150" :src="record.image" />
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
