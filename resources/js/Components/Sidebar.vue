<script setup>
  import { reactive, ref, h, onMounted, computed } from "vue";
  import { usePage, router } from "@inertiajs/vue3";
  import { useMenuItems } from "@/Composables/useMenuItems";
  import { useIconResolver } from "@/Composables/useIconResolver";

  const { props } = usePage();
  const sidebarMenus = computed(() => props.sidebar_menus);
  const { getItem } = useMenuItems();
  const { resolveIcon } = useIconResolver();

  const menuItems = reactive(
    sidebarMenus.value.map((menu) =>
      getItem(
        menu.title,
        menu.key,
        menu.icon ? () => h(resolveIcon(menu.icon)) : null,
        menu.children?.map((child) => getItem(child.title, child.key, null, null))
        )
      )
    );

  const selectedKeys = ref([]);
  const openKeys = ref([]);
  const rootSubmenuKeys = computed(() => sidebarMenus.value.map((menu) => menu.key));
  function findMenuByKey(menus, key) {
    for (const menu of menus) {
      if (menu.key === key) return menu;
      if (menu.children) {
        const found = findMenuByKey(menu.children, key);
        if (found) return found;
      }
    }
    return null;
  }

  function handleClick({ key }) {
    const selectedMenu = findMenuByKey(sidebarMenus.value, key);
    if (selectedMenu?.route) {
      router.get(route(selectedMenu.route));
      selectedKeys.value = [key];
    }

    if (!openKeys.value.includes(key)) {
      openKeys.value = [...openKeys.value, key];
    }
  }

  const onOpenChange = (keys) => {
    let latestOpenKey = keys.find((key) => !openKeys.value.includes(key));

    if (!latestOpenKey && keys.length > 0) {
    latestOpenKey = keys[keys.length - 1]; // Ambil key terakhir sebagai fallback
  }
  if (latestOpenKey && rootSubmenuKeys.value.includes(latestOpenKey)) {
    openKeys.value = [latestOpenKey];
  } else {
    openKeys.value = keys; // Jika tidak, buka semua keys
  }
};

onMounted(() => {
  const currentRoute = route().current();

  function findMenuByRoute(menus, routeName) {
    for (const menu of menus) {
      if (menu.route === routeName) return menu;
      if (menu.children) {
        const found = findMenuByRoute(menu.children, routeName);
        if (found) return found;
      }
    }
    return null;
  }

  const currentMenu = findMenuByRoute(sidebarMenus.value, currentRoute);

  if (currentMenu) {
    selectedKeys.value = [currentMenu.key];
    openKeys.value = [currentMenu.key.split("-")[0]];
  }
});
</script>

<template>
  <a-menu
  v-model:openKeys="openKeys"
  v-model:selectedKeys="selectedKeys"
  mode="inline"
  style="background: #f8fafc"
  :items="menuItems"
  @click="handleClick"
  @openChange="onOpenChange"
  />
</template>
