<script setup lang="ts">
import AuthLayout from '@/layouts/auth/AuthSimpleLayout.vue';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <AuthLayout :title="title" :description="description">
        <div class="flex gap-4 opacity-80 mx-auto">
            <img src="/assets/paypal.png" alt="PayPal" class="h-16" />
            <img src="/assets/cash-app.png" alt="CashApp" class="h-16" />
            <img src="/assets/apple-pay.png" alt="Apple Pay" class="h-16" />
        </div>
        <slot />
    </AuthLayout>
</template>
