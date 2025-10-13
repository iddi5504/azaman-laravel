<script setup lang="ts">
import { AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogPortal, AlertDialogRoot, AlertDialogTitle, AlertDialogTrigger, DialogOverlay } from 'reka-ui';


defineProps<{
    title: string;
    description: string;
    cancelText: string;
    confirmText: string;
}>()

defineEmits<{
    (event: 'cancel'): void,
    (event: 'confirm'): void
}>()

const isOpen = defineModel<boolean>();

</script>
<template>
    <AlertDialogRoot :open="isOpen">
        <AlertDialogTrigger>
            <slot />
        </AlertDialogTrigger>

        <AlertDialogPortal>
            <DialogOverlay class="fixed inset-0 z-40 bg-black/20 backdrop-blur-[2px]" />

            <AlertDialogContent
                class="fixed left-1/2 top-1/2 z-50 w-full max-w-sm -translate-x-1/2 -translate-y-1/2 rounded-lg border border-gray-200 bg-white p-6 shadow-xl dark:border-gray-700 dark:bg-gray-800">
                <AlertDialogTitle class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                    {{ title }}
                </AlertDialogTitle>

                <AlertDialogDescription class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                    {{ description }}
                </AlertDialogDescription>

                <div class="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2 mt-4">
                    <AlertDialogCancel @click="() => {
                        isOpen = false;
                        $emit('cancel')
                    }"
                        class="mt-2 sm:mt-0 inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 transition">
                        {{ cancelText }}
                    </AlertDialogCancel>

                    <AlertDialogAction @click="$emit('confirm')"
                        class="inline-flex items-center justify-center rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 transition">
                        {{ confirmText }}
                    </AlertDialogAction>
                </div>
            </AlertDialogContent>
        </AlertDialogPortal>
    </AlertDialogRoot>
</template>
