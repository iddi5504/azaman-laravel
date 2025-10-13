<script setup lang="ts">
import { DropdownMenuContent, DropdownMenuItem, DropdownMenuPortal, DropdownMenuRoot, type DropdownMenuRootEmits, DropdownMenuTrigger, useForwardPropsEmits } from 'reka-ui'
import { type Component } from 'vue';

export type DropdownMenuItem<T> = {
  title: string;
  action: (payload: T) => void,
  icon: Component
  status?: 'neutral' | 'danger'
}


const props = defineProps<{
  items: DropdownMenuItem<any>[]
}>()
const emits = defineEmits<DropdownMenuRootEmits>()

const forwarded = useForwardPropsEmits(props, emits)
</script>

<template>
  <DropdownMenuRoot data-slot="dropdown-menu" v-bind="forwarded">
    <DropdownMenuTrigger @click.stop
      class="inline-flex items-center justify-center hover:bg-gray-200 p-1 dark:hover:bg-gray-700 transition">
      <slot />
    </DropdownMenuTrigger>

    <DropdownMenuPortal>
      <DropdownMenuContent
        class="z-50 mt-2 w-44 rounded-md border border-gray-200 bg-white p-1 shadow-lg dark:border-gray-700 dark:bg-gray-800">
        <DropdownMenuItem v-for="item in items" :key="item.title" @select="() => item.action(item)"
          class="flex items-center gap-2 cursor-pointer rounded-md px-2 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 dark:focus:bg-gray-700 transition"
          :class="{
            'text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/40': item.status === 'danger'
          }">
          <component v-if="item.icon" :is="item.icon" class="h-4 w-4" />
          {{ item.title }}
        </DropdownMenuItem>
      </DropdownMenuContent>
    </DropdownMenuPortal>
  </DropdownMenuRoot>
</template>
