<script lang="ts" setup>
import Button from '@/components/ui/button/Button.vue';
import WalletCard from '@/components/WalletCard.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Wallet } from '@/types';
import { Form } from '@inertiajs/vue3';

defineProps<{
    wallet: Wallet
}>()


</script>

<template>
    <AppLayout>
        <div class="w-3/6 mx-auto">
            <WalletCard :wallet="wallet" />

            <Form>
                <template>
                    <div>
                    </div>
                </template>
            </Form>
        </div>
    </AppLayout>
</template>