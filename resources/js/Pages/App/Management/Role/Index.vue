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


// Table columns definition
  const columns = [
  {
    title: "ID",
    dataIndex: "id",
    key: "id",
    width: "25%",
  },
  {
    title: "Name",
    dataIndex: "name",
    key: "name",
    width: "25%",
  },
  {
    title: "Deskripsi",
    dataIndex: "description",
    key: "description",
    width: "25%",
  },
  ];

  const fetchData = async (params = {}) => {
    loading.value = true;
    try {
      const response = await axios.get(route("app.roles.api"), {
        params: {
          search: searchQuery.value,
          limit: params.pageSize,
          page: params.current,
          type: "search",
        },
      });

      const { data } = response.data;
      datas.value = data || [];
    } catch (error) {
      console.error(error);
      message.error(error.response.data.message ||"Gagal mengambil data role");
    } finally {
      loading.value = false;
    }
  };



  const handleSearch = () => {
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
          const res = await axios.delete(route("app.roles.destroy", record.id));
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
    router.get(route("app.roles.edit", record.id));
  };

  const handleCreate = () => {
    router.get(route("app.roles.create"));
  };

// Initial load
  onMounted(() => {
    fetchData();
  });
</script>

<template>
  <div class="p-6">
    <div class="mb-6">
      <a-table
      :columns="columns"
      :data-source="datas"
      :loading="loading"
      row-key="id"
      >
    </a-table>
  </div>
</div>
</template>
