// src/composables/useMenuItems.js
export function useMenuItems() {
    function getItem(label, key, icon = null, children = null, type = null) {
      return { label, key, icon, children, type };
    }
  
    return {
      getItem
    };
  }