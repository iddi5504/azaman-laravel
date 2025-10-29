<template>
    <AppLayout>
        <div class="p-6 max-w-4xl mx-auto w-full">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold ">Transactions</h1>
                <div class="flex gap-3 justify-end px-5 w-full">
                    <SelectField v-model="form.wallet" @update:model-value="debounceFilter" :options="wallets"
                        id="wallet" placeholder="Select wallet">
                    </SelectField>
                    <SelectField v-model="form.transaction_status" @update:model-value="debounceFilter" :options="[
                        {
                            label: 'All',
                            value: null,
                        },
                        ...transactionStatusOptions
                    ]" id="transaction_status" placeholder="Select transaction status">
                    </SelectField>
                </div>
            </div>

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
import Input from '@/components/ui/input/Input.vue';
import SelectField from '@/components/ui/select/SelectField.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { transactionStatusOptions } from '@/lib/constants';
import transaction from '@/routes/transaction';
import { Transaction } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { useDebounceFn } from '@vueuse/core';
import { onMounted, ref } from 'vue';

const props = defineProps<{
    transactions: Transaction[],
    query: Record<string, string>,
    wallets: {
        label: string;
        value: string;
    }[];
}>();

const form = useForm<{

    transaction_status: string | null;
    wallet: string | null;
}>({
    transaction_status: null,
    wallet: null
});

onMounted(() => {
    form.wallet = props.query.wallet || null;
    form.transaction_status = props.query.transaction_status || null;
})

const filter = () => {
    form.get(transaction.index().url, {
        preserveState: true,
        replace: true,
    });
};

const debounceFilter = useDebounceFn(filter, 600);
</script>
