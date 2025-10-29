<script setup lang="ts">
import { DialogClose, DialogContent, DialogOverlay, DialogPortal, DialogRoot, DialogTitle, DialogTrigger, } from 'reka-ui'
import { XCircle } from 'lucide-vue-next';


defineProps<{
  title: string;
}>()

const isOpen = defineModel<boolean>()

</script>

<template>
  <DialogRoot :open="isOpen">
    <DialogTrigger>
      <slot name="trigger" />
    </DialogTrigger>

    <DialogPortal>
      <DialogOverlay class="fixed inset-0 z-40 bg-black/20 backdrop-blur-[2px]" />

      <DialogContent class="m-3 fixed inset-0 z-50 flex items-center justify-center text-sm text-foreground">
        <div class="relative w-full max-w-md rounded-2xl bg-popover p-6 shadow-xl">
          <DialogClose @click="isOpen = false"
            class="absolute right-3 top-3 text-secondary-foreground hover:text-gray-600 transition">
            <XCircle class="h-5 w-5" />
          </DialogClose>

          <DialogTitle class="mb-4 text-lg font-semibold">
            {{ title }}
          </DialogTitle>

          <slot />

          <div class="flex justify-end gap-3 mt-6">
            <slot name="actions" />
          </div>
        </div>
      </DialogContent>
    </DialogPortal>
  </DialogRoot>
</template>
