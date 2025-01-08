<template>
    <div class="p-6">
      <a-card title="Edit Waste Category">
        <a-form
          :model="form"
          layout="vertical"
          @finish="handleSubmit"
        >
          <a-form-item
            label="Name"
            name="name"
            :rules="[{ required: true, message: 'Please input category name!' }]"
          >
            <a-input v-model:value="form.name" />
          </a-form-item>
  
          <a-form-item
            label="Description"
            name="description"
            :rules="[{ required: true, message: 'Please input category description!' }]"
          >
            <a-textarea v-model:value="form.description" :rows="4" />
          </a-form-item>
  
          <a-form-item>
            <a-space>
              <a-button type="primary" html-type="submit">
                Update
              </a-button>
              <Link :href="route('app.waste-categories.index')">
                <a-button>Cancel</a-button>
              </Link>
            </a-space>
          </a-form-item>
        </a-form>
      </a-card>
    </div>
  </template>
  
  <script setup>
  import { reactive } from 'vue'
  import { Link, router } from '@inertiajs/vue3'
  import { message } from 'ant-design-vue'
  
  import AppLayout from "@/Layouts/AppLayout.vue";
defineOptions({
  layout: AppLayout,
});


  const props = defineProps({
    wasteCategory: {
      type: Object,
      required: true
    }
  })
  
  const form = reactive({
    name: props.wasteCategory.name,
    description: props.wasteCategory.description
  })
  
  const handleSubmit = () => {
    router.put(route('app.waste-categories.update', props.wasteCategory.id), form, {
      onSuccess: () => {
        message.success('Waste category updated successfully')
      },
      onError: (errors) => {
        message.error('Failed to update waste category')
      }
    })
  }
  </script>
