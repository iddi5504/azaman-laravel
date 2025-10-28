<script setup lang="ts">
import { Primitive, type PrimitiveProps } from "reka-ui"
import type { HTMLAttributes } from "vue"

const props = defineProps<PrimitiveProps & {
  variant?: 'success' | 'destructive' | 'alert' | 'warning' | 'pending'
  class?: HTMLAttributes['class']
}>()

const variantClasses = {
  success: 'bg-green-100 text-green-800 border border-green-300',
  destructive: 'bg-red-100 text-red-800 border border-red-300',
  alert: 'bg-yellow-100 text-yellow-800 border border-yellow-300',
  warning: 'bg-orange-100 text-orange-800 border border-orange-300',
  pending: 'bg-gray-100 text-gray-800 border border-gray-300'
}

const baseClass = 'inline-flex items-center rounded-full px-3 py-1 text-xs font-medium'
</script>

<template>
  <Primitive data-slot="badge" :class="[baseClass, variantClasses[props.variant || 'success'], props.class]"
    v-bind="props">
    <slot />
  </Primitive>
</template>
