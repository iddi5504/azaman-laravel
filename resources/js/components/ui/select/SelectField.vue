<script setup lang="ts">
import { defineProps, computed, } from 'vue';
import {
    SelectRoot,
    SelectTrigger,
    SelectValue,
    SelectPortal,
    SelectContent,
    SelectViewport,
    SelectItem,
    SelectItemText,
    SelectItemIndicator,
    SelectScrollUpButton,
    SelectScrollDownButton,
    SelectIcon
} from 'reka-ui';
import { SelectOption } from '@/types';

const emit = defineEmits(['update:modelValue'])
const props = defineProps<{
    options: SelectOption[];
    placeholder?: string;
}>()

const selected = defineModel<String | String[]>()

const selectedItemIcon = computed(() => props.options.find(o => o.value === selected.value)?.icon)
</script>

<template>
    <SelectRoot v-model="selected">
        <SelectTrigger
            class="inline-flex min-w-[160px] items-center justify-between rounded-lg px-4 text-sm h-[35px] gap-2 bg-white text-gray-800 border shadow-sm outline-none hover:bg-gray-50 focus:ring-2 focus:ring-green-500"
            aria-label="Select option">
            <SelectIcon v-if="selectedItemIcon?.length">
                <img :src="selectedItemIcon" class="w-5 h-5 object-contain" />
            </SelectIcon>
            <SelectValue :placeholder="props.placeholder || 'Select...'" />
            <Icon icon="radix-icons:chevron-down" class="h-4 w-4" />
        </SelectTrigger>

        <SelectPortal>
            <SelectContent class="min-w-[160px] bg-white rounded-lg border shadow-md z-50" :side-offset="5">
                <SelectScrollUpButton class="flex items-center justify-center h-6 bg-white">
                    <Icon icon="radix-icons:chevron-up" />
                </SelectScrollUpButton>

                <SelectViewport class="p-1">
                    <SelectItem v-for="option in props.options" :key="option.value ?? Math.random().toString()"
                        :value="option.value"
                        class="relative flex items-center px-3 py-4 h-6 text-sm rounded cursor-pointer select-none data-[highlighted]:bg-green-500 data-[highlighted]:text-white">
                        <SelectItemIndicator class="absolute left-0 w-5 flex justify-center">
                            <Icon icon="radix-icons:check" class="h-3 w-3" />
                        </SelectItemIndicator>
                        <SelectIcon v-if="option.icon">
                            <img :src="option.icon" class="w-6 h-6 object-contain mr-2" />
                        </SelectIcon>
                        <SelectItemText>{{ option.label }}</SelectItemText>
                    </SelectItem>
                </SelectViewport>

                <SelectScrollDownButton class="flex items-center justify-center h-6 bg-white">
                    <Icon icon="radix-icons:chevron-down" />
                </SelectScrollDownButton>
            </SelectContent>
        </SelectPortal>
    </SelectRoot>
</template>
