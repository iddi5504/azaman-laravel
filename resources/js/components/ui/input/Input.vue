<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { cn } from '@/lib/utils'
import { useVModel } from '@vueuse/core'

const props = defineProps<{
  defaultValue?: string | number
  modelValue?: string | number
  class?: HTMLAttributes['class']
}>()

const emits = defineEmits<{
  (e: 'update:modelValue', payload: string | number): void
}>()

const modelValue = useVModel(props, 'modelValue', emits, {
  passive: true,
  defaultValue: props.defaultValue,
})
</script>

<template>
  <input v-model="modelValue" data-slot="input" :class="cn(
    'w-full rounded-lg border border-gray-300 bg-secondary-background px-4 py-2 text-sm text-foreground  placeholder-gray-400 dark:placeholder-gray-500 shadow-sm transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/40 focus:outline-none',
    'disabled:cursor-not-allowed disabled:opacity-50',
    'file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-indigo-600',
    'aria-invalid:border-red-500 aria-invalid:ring-red-500/30',
    props.class,
  )">
</template>
