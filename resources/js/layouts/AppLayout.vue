<script setup lang="ts">
import Alert from '@/components/ui/alert/Alert.vue';
import AlertDescription from '@/components/ui/alert/AlertDescription.vue';
import AlertTitle from '@/components/ui/alert/AlertTitle.vue';
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});


</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div v-if="$page.props.flash" class="mb-1 p-5">
            <Alert :variant="$page.props.flash.status">
                <AlertTitle>{{ $page.props.flash.message }}</AlertTitle>
                <AlertDescription>{{ $page.props.flash.description }}</AlertDescription>
            </Alert>
        </div>
        <slot />
    </AppLayout>
</template>
