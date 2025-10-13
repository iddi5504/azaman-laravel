<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import WalletCard from '@/components/WalletCard.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { addWallet } from '@/routes';
import { Wallet } from '@/types';
import { Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';

defineProps<{ wallets: Wallet[] }>();

</script>

<template>
    <AppLayout>
        <div class="flex justify-end px-5 pt-3">
            <Link v-if="$page.props.isAdmin" :href="addWallet()">
            <Button as="button">New wallet</Button>
            </Link>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 p-5">
            <WalletCard v-for="wallet in wallets" :key="wallet.id" :wallet="wallet" />

            <div v-if="wallets.length === 0" class="col-span-full text-center text-gray-400 text-sm">
                No wallets available.
            </div>
        </div>
    </AppLayout>
</template>
