<script setup>
import { ref  } from "vue";
import Sidebar from "@/Components/Sidebar.vue";
import Notification from "@/Components/Notification.vue";
import Logo from "@/Components/LogoApp.vue";
import DropdownProfile from "@/Components/DropdownProfile.vue";
const collapsed = ref(false);
</script>

<template>
  <a-layout>
    <a-layout-header
      :style="{
        paddingLeft: collapsed ? 80 + 16 + 'px' : 255 + 16 + 'px',
        paddingRight: '0',
        boxShadow: '0 2px 10px rgba(0, 0, 0, 0.1)',
        position: 'fixed',
        zIndex: 1,
        width: '100%',
      }"
      style="background: #fff"
    >
      <a-flex
        gap="large"
        style="padding: 0; margin: 0; height: 100%"
        class="logo"
        justify="flex-end"
        align="center"
        horizontal
      >
        <Notification />
        <DropdownProfile />
      </a-flex>
    </a-layout-header>
    <a-layout style="min-height: 100vh">
      <a-layout-sider
        :style="{
          overflow: 'auto',
          height: '100vh',
          position: 'fixed',
          zIndex: 2,
          left: 0,
          top: 0,
          bottom: 0,
        }"
        style="background: #f8fafc"
        width="255"
        v-model:collapsed="collapsed"
        collapsible
      >
        <Logo :collapsed="collapsed" content="SampahBijak" />
        <Sidebar />
      </a-layout-sider>
      <a-layout
        :style="{ marginLeft: collapsed ? '80px' : '255px' }"
        style="background: white"
      >
        <a-layout-content style="margin: 24px 16px; margin-top: calc(64px + 16px)">
          <slot></slot>
        </a-layout-content>
      </a-layout>
    </a-layout>
  </a-layout>
</template>
