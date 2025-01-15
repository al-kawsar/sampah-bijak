<script setup>
  import {
    Form,
    Input,
    Button,
    Checkbox,
    Grid,
    Typography,
    message,
    Card,
  } from "ant-design-vue";
  import { MailOutlined, LockOutlined } from "@ant-design/icons-vue";
  import { theme } from "ant-design-vue";
  import { reactive, watch, ref, computed } from "vue";
  import { router } from "@inertiajs/vue3";
  import axios from "axios";

  import { usePage } from "@inertiajs/vue3";

  const { useToken } = theme;
  const { token } = useToken();
  const screens = Grid.useBreakpoint();

  const { props } = usePage();

  const errors = computed(() => props.errors);

  watch(
    () => errors,
    (newErrors) => {
      console.log(errors);
      if (newErrors?.message) {
        message.error(newErrors.message);
      }
    }
    );

  const formState = reactive({
    email: "",
    password: "",
    remember: true,
  });

  const rules = {
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
      maxWidth: "400px",
      boxShadow: "0 4px 12px rgba(0, 0, 0, 0.15)",
      borderRadius: "8px",
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
      message.error(err.response.data.message);
    })
    .finally(() => {
      isLoading.value = false;
    });
  };
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
        <Typography.Title :style="styles.title">Login</Typography.Title>
        <Typography.Text :style="{ marginBottom: '1rem', display: 'inline-block' }">
          Selamat datang kembali!.
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
        <Typography.Link @click.prevent>
          <Link :href="route('auth.register.index')"
          >Daftar sekarang</Link
          ></Typography.Link
          >
        </div>
      </Form.Item>
    </Form>
  </div>
</Card>
</section>
</template>
