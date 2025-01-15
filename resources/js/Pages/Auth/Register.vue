<script setup>
import { reactive, onMounted } from "vue";
import {
  Form,
  Input,
  Button,
  Grid,
  Typography,
  message,
  Card,
  Select,
  Upload,
} from "ant-design-vue";
import {
  UserOutlined,
  MailOutlined,
  LockOutlined,
  PhoneOutlined,
  UploadOutlined,
  IdcardOutlined,
} from "@ant-design/icons-vue";
import { theme } from "ant-design-vue";
import { ref, computed } from "vue";
import { router } from "@inertiajs/vue3";
import axios from "axios";

const { useToken } = theme;
const { token } = useToken();
const screens = Grid.useBreakpoint();

const formState = reactive({
  username: "sasas",
  email: "saasa@gmail.com   ",
  password: "123123123",
  password_confirmation: "123123123",
  region_id: undefined,
  full_name: "sasjahjshj",
  phone_number: "09201909",
  address: "sakjsakjskaj",
  profile_picture: null,
});

const rules = {
  username: [
    { required: true, message: "Silakan masukkan username Anda." },
    { max: 255, message: "Username tidak boleh lebih dari 255 karakter." },
  ],
  email: [
    { required: true, message: "Silakan masukkan alamat email Anda." },
    { type: "email", message: "Silakan masukkan alamat email yang valid." },
    { max: 255, message: "Alamat email tidak boleh lebih dari 255 karakter." },
  ],
  password: [
    { required: true, message: "Silakan masukkan kata sandi Anda." },
    { min: 8, message: "Kata sandi harus memiliki panjang minimal 8 karakter." },
    { max: 255, message: "Kata sandi tidak boleh lebih dari 255 karakter." },
  ],
  password_confirmation: [
    { required: true, message: "Silakan konfirmasi kata sandi Anda." },
    {
      validator: async (rule, value) => {
        if (value !== formState.password) {
          throw new Error("Konfirmasi kata sandi tidak cocok.");
        }
      },
    },
  ],
  region_id: [{ required: true, message: "Silakan pilih region Anda." }],
  full_name: [
    { required: true, message: "Silakan masukkan nama lengkap Anda." },
    { max: 255, message: "Nama lengkap tidak boleh lebih dari 255 karakter." },
  ],
  phone_number: [
    { required: true, message: "Silakan masukkan nomor telepon Anda." },
    { max: 255, message: "Nomor telepon tidak boleh lebih dari 255 karakter." },
  ],
  address: [
    { required: true, message: "Silakan masukkan alamat Anda." },
    { max: 255, message: "Alamat tidak boleh lebih dari 255 karakter." },
  ],
};

const styles = {
  container: {
    margin: "0 auto",
    padding: screens.md
      ? `${token.paddingXL}px`
      : `${token.sizeXXL}px ${token.padding}px`,
  },
  card: {
    width: "100%",
    maxWidth: "500px",
    boxShadow: "0 4px 12px rgba(0, 0, 0, 0.15)",
    borderRadius: "8px",
  },
  footer: {
    marginTop: "10px",
    textAlign: "center",
    width: "100%",
  },
  header: {
    marginBottom: token.marginXL,
  },
  section: {
    minHeight: "100vh",
    display: "flex",
    justifyContent: "center",
    alignItems: "center",
    background: `linear-gradient(135deg, ${token.colorPrimary} 0%, ${token.colorPrimaryActive} 100%)`,
  },
  text: {
    color: token.colorTextSecondary,
  },
  title: {
    fontSize: screens.md ? token.fontSizeHeading2 : token.fontSizeHeading3,
  },
};

const disabled = computed(() => {
  return !(
    formState.username &&
    formState.email &&
    formState.password &&
    formState.password_confirmation &&
    formState.region_id &&
    formState.full_name &&
    formState.phone_number &&
    formState.address &&
    formState.password.length >= 8
  );
});

const isLoading = ref(false);
const regions = ref([]);
const fileList = ref([]);

const register = async (values) => {
  isLoading.value = true;
  const formData = new FormData();

  Object.keys(values).forEach((key) => {
    if (values[key] !== null && values[key] !== undefined) {
      formData.append(key, values[key]);
    }
  });

  if (fileList.value.length > 0) {
    formData.append("profile_picture", fileList.value[0].originFileObj); // Use the file object
  }

  axios
    .post(route("auth.register.submit"), formData, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    })
    .then((res) => {
      message.success("Registrasi berhasil");
      router.get(route("auth.login.index"));
    })
    .catch((err) => {
      console.log(err);
      message.error(err.response.data.message);
    })
    .finally(() => {
      isLoading.value = false;
    });
};

const handleUpload = ({ file, onSuccess }) => {
  onSuccess(file);
};

const beforeUpload = (file) => {
  const isJpgOrPng = file.type === "image/jpeg" || file.type === "image/png";
  if (!isJpgOrPng) {
    message.error("Silakan unggah file gambar PNG/JPG");
  }
  const isLt2M = file.size / 1024 / 1024 < 2; // Limit file size to 2MB
  if (!isLt2M) {
    message.error("Gambar harus lebih kecil dari 2MB");
  }
  return isJpgOrPng && isLt2M;
};

const fetchRegions = (search = "") => {
  isLoading.value = true;
  axios
    .get(route("app.regions.api"), {
      params: {
        search,
      },
    })
    .then((res) => {
      const { data } = res.data;
      regions.value = data || [];
    })
    .catch((err) => {
      message.error(err.response.data.message);
    })
    .finally(() => {
      isLoading.value = false;
    });
};
onMounted(() => {
  fetchRegions();
});
</script>

<template>
  <section :style="styles.section">
    <Card :style="styles.card" :bodyStyle="{ padding: `${token.paddingLG}px` }">
      <div :style="styles.container">
        <div :style="styles.header">
          <Link :href="route('home.index')">
            <a-flex gap="small" class="logo" justify="center" align="center" horizontal>
              <img src="/logo.png" alt="logo" width="44" />
              <a-typography-title :level="4" :style="{ margin: 0, padding: 0 }"
                >SampahBijak</a-typography-title
              >
            </a-flex>
          </Link>
          <a-divider />
          <Typography.Title :style="styles.title">Registrasi</Typography.Title>
          <Typography.Text :style="{ marginBottom: '1rem', display: 'inline-block' }">
            Daftar akun baru Anda sekarang!
          </Typography.Text>
        </div>

        <Form
          name="register_form"
          :model="formState"
          :rules="rules"
          @finish="register"
          layout="vertical"
          required-mark="optional"
        >
          <Form.Item name="username">
            <Input v-model:value="formState.username" placeholder="Username">
              <template #prefix>
                <UserOutlined />
              </template>
            </Input>
          </Form.Item>

          <Form.Item name="email">
            <Input v-model:value="formState.email" placeholder="Email">
              <template #prefix>
                <MailOutlined />
              </template>
            </Input>
          </Form.Item>

          <Form.Item name="password">
            <Input.Password v-model:value="formState.password" placeholder="Kata Sandi">
              <template #prefix>
                <LockOutlined />
              </template>
            </Input.Password>
          </Form.Item>

          <Form.Item name="password_confirmation">
            <Input.Password
              v-model:value="formState.password_confirmation"
              placeholder="Konfirmasi Kata Sandi"
            >
              <template #prefix>
                <LockOutlined />
              </template>
            </Input.Password>
          </Form.Item>

          <Form.Item name="region_id">
            <Select
              v-model:value="formState.region_id"
              placeholder="Pilih Wilayah"
              :options="regions"
              :field-names="{ label: 'region_name', value: 'id' }"
            />
          </Form.Item>

          <Form.Item name="full_name">
            <Input v-model:value="formState.full_name" placeholder="Nama Lengkap">
              <template #prefix>
                <IdcardOutlined />
              </template>
            </Input>
          </Form.Item>

          <Form.Item name="phone_number">
            <Input v-model:value="formState.phone_number" placeholder="Nomor Telepon">
              <template #prefix>
                <PhoneOutlined />
              </template>
            </Input>
          </Form.Item>

          <Form.Item name="address">
            <Input.TextArea
              v-model:value="formState.address"
              placeholder="Alamat"
              :autoSize="{ minRows: 2, maxRows: 6 }"
            />
          </Form.Item>

          <Form.Item name="profile_picture">
            <Upload
              v-model:fileList="fileList"
              name="profile_picture"
              :customRequest="handleUpload"
              :beforeUpload="beforeUpload"
              listType="picture"
              :maxCount="1"
            >
              <Button><UploadOutlined /> Upload Foto Profil</Button>
            </Upload>
          </Form.Item>

          <Form.Item :style="{ marginBottom: '0px' }">
            <Button
              block
              type="primary"
              html-type="submit"
              :disabled="disabled"
              :loading="isLoading"
              >Daftar</Button
            >
            <div :style="styles.footer">
              <Typography.Text :style="styles.text">Sudah punya akun? </Typography.Text>
              <Typography.Link>
                <Link :href="route('auth.login.index')">Login</Link>
              </Typography.Link>
            </div>
          </Form.Item>
        </Form>
      </div>
    </Card>
  </section>
</template>
