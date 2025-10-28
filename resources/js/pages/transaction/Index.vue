<template>
    <AppLayout>
        <div class="p-6 max-w-4xl mx-auto w-full">
            <h1 class="text-2xl font-semibold mb-6">Transactions</h1>

            <div v-if="transactions?.length" class="grid gap-4">
                <TransactionCard v-for="tx in transactions" :key="tx.id" :transaction="tx" />
            </div>

            <div v-else class="text-center py-10 text-gray-500">
                No transactions found.
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import TransactionCard from '@/components/TransactionCard.vue'
import AppLayout from '@/layouts/AppLayout.vue';
import { Transaction } from '@/types';

defineProps<{
    transactions: Transaction[]
}>();
</script>
