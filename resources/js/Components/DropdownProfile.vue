<script setup>
import {
  UpOutlined,
  DownOutlined,
  SettingOutlined,
  LogoutOutlined,
  UserOutlined,
  GiftTwoTone,
} from "@ant-design/icons-vue";
import { ref, computed } from "vue";
import { usePage } from "@inertiajs/vue3";

const { props } = usePage();

const isOpen = ref(false);

const handleDropdown = (open) => {
  isOpen.value = open;
};

const user = computed(() => props.user);
</script>

<template>
  <a-dropdown placement="bottomRight" has-sider arrow @openChange="handleDropdown">
    <a
      class="ant-dropdown-link"
      :style="{
        padding: '0 16px',
        backgroundColor: '#F7F7F9',
        height: '100%',
      }"
    >
      <a-flex
        style="padding: 0; margin: 0; height: 100%"
        justify="center"
        gap="small"
        align="center"
        horizontal
      >
        <a-avatar :src="user.profile_picture" size="large" style="margin-right: 8px" />
        <span>
          <a-typography-title
            :level="5"
            :style="{
              padding: '0',
              margin: '0',
            }"
            >{{ user.username }}</a-typography-title
          >
        </span>
        <DownOutlined
          v-show="!isOpen"
          style="color: #333; padding: 0; margin-top: 0.2rem"
        />
        <UpOutlined v-show="isOpen" style="color: #333; padding: 0; margin-top: 0.2rem" />
      </a-flex>
    </a>

    <template #overlay>
      <a-menu>
        <a-menu-item key="1" :style="{ backgroundColor: '#F0FFF0' }">
          <GiftTwoTone style="margin-right: 8px" two-tone-color="#556B2F" />
          <a @click.prevent size="middle">0 Point</a>
        </a-menu-item>
        <a-menu-divider />

        <a-menu-item key="2">
          <UserOutlined style="margin-right: 8px" />
          <Link :href="route('app.users.show', user.id)">Profile Saya</Link>
        </a-menu-item>

        <a-menu-item key="3">
          <SettingOutlined style="margin-right: 8px" />
          <Link :href="route('app.settings.profile')">Pengaturan</Link>
        </a-menu-item>

        <a-menu-divider />
        <a-menu-item key="4">
          <LogoutOutlined style="margin-right: 8px" />
          <Link :href="route('auth.logout')">Keluar</Link>
        </a-menu-item>
      </a-menu>
    </template>
  </a-dropdown>
</template>
