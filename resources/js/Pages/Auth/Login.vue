<script setup>
import { reactive } from "vue";
import { Form, Input, Button, Checkbox, Grid, Typography, message } from "ant-design-vue";
import { MailOutlined, LockOutlined } from "@ant-design/icons-vue";
import { theme } from "ant-design-vue";
import { ref, computed } from "vue";
import { router } from "@inertiajs/vue3";
import axios from "axios";

const { useToken } = theme;
const { token } = useToken();
const screens = Grid.useBreakpoint();

const formState = reactive({
  email: "",
  password: "",
  remember: true,
});

const rules = {
  email: [
    {
      type: "email",
      max: 255,
      min: 8,
      required: true,
    },
  ],
  password: [
    {
      required: true,
      max: 255,
      min: 8,
    },
  ],
};

const styles = {
  container: {
    margin: "0 auto",
    padding: screens.md
      ? `${token.paddingXL}px`
      : `${token.sizeXXL}px ${token.padding}px`,
    width: "380px",
  },
  footer: {
    marginTop: "10px",
    textAlign: "center",
    width: "100%",
  },
  forgotPassword: {
    float: "right",
  },
  header: {
    marginBottom: token.marginXL,
  },
  section: {
    alignItems: "center",
    backgroundColor: token.colorBgContainer,
    display: "flex",
    height: screens.sm ? "100vh" : "100vh",
    padding: screens.md ? `${token.sizeXXL}px 0px` : "0px",
  },
  text: {
    color: token.colorTextSecondary,
  },
  title: {
    fontSize: screens.md ? token.fontSizeHeading2 : token.fontSizeHeading3,
  },
};

const disabled = computed(() => {
  return !(formState.email && formState.password && formState.password.length >= 8);
});

const isLoading = ref(false);

const login = async (values) => {
  isLoading.value = true;
  axios
    .post(route("auth.login.submit"), values)
    .then((res) => {
      router.get(route("app.dashboard"));
    })
    .catch((err) => {
      console.log(err);
      message.error(err.response.data.message);
    })
    .finally(() => {
      isLoading.value = false;
    });
};
</script>

<template>
  <section :style="styles.section">
    <div :style="styles.container">
      <div :style="styles.header">
        <Link :href="route('home.index')">
          <svg
            width="25"
            height="24"
            viewBox="0 0 25 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <rect x="0.464294" width="24" height="24" rx="4.8" fill="#1890FF" />
            <path d="M14.8643 3.6001H20.8643V9.6001H14.8643V3.6001Z" fill="white" />
            <path d="M10.0643 9.6001H14.8643V14.4001H10.0643V9.6001Z" fill="white" />
            <path d="M4.06427 13.2001H11.2643V20.4001H4.06427V13.2001Z" fill="white" />
          </svg>
        </Link>

        <Typography.Title :style="styles.title">Login</Typography.Title>
        <Typography.Text :style="{ marginBottom: '1rem', display: 'inline-block' }">
          Selamat datang kembali! Silakan masukkan detail Anda untuk masuk dan mulai
          menggunakan layanan kami.
        </Typography.Text>
      </div>

      <Form
        name="normal_login"
        :model="formState"
        :rules="rules"
        @finish="login"
        layout="vertical"
        required-mark="optional"
      >
        <Form.Item name="email" :style="{ marginBottom: '2rem', display: 'inlblock' }">
          <Input v-model:value="formState.email" autofocus>
            <template #prefix>
              <MailOutlined />
            </template>
          </Input>
        </Form.Item>

        <Form.Item name="password">
          <Input.Password v-model:value="formState.password">
            <template #prefix>
              <LockOutlined />
            </template>
          </Input.Password>
        </Form.Item>

        <Form.Item>
          <Form.Item name="remember" no-style>
            <Checkbox v-model:checked="formState.remember">Ingat saya</Checkbox>
          </Form.Item>
          <a :style="styles.forgotPassword" href="">Lupa kata sandi?</a>
        </Form.Item>

        <Form.Item :style="{ marginBottom: '0px' }">
          <Button
            block
            type="primary"
            html-type="submit"
            :disabled="disabled"
            :loading="isLoading"
            >Login</Button
          >
          <div :style="styles.footer">
            <Typography.Text :style="styles.text">Belum punya akun? </Typography.Text>
            <Typography.Link href=""> Daftar sekarang</Typography.Link>
          </div>
        </Form.Item>
      </Form>
    </div>
  </section>
</template>
