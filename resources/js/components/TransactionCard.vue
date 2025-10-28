<template>
    <Link :href="TransactionRoute.show(transaction.id).url">
    <Card class="p-5 rounded-xl border hover:shadow-md transition-all duration-200">
        <div class="flex justify-between items-center mb-3">
            <div>
                <h3 class="text-base font-semibold text-gray-900">{{ transaction.wallet.name }}</h3>
                <p class="text-sm text-gray-500">{{ transaction.wallet.owner_name }}</p>
            </div>
            <Badge :variant="badgeColor" class="capitalize bg-secondary">{{ transaction.status }}</Badge>
        </div>

        <div class="space-y-2 text-sm text-gray-700">
            <div class="flex justify-between">
                <span>Amount</span>
                <span class="font-medium">{{ transaction.details.amount }} GHS</span>
            </div>
            <div class="flex justify-between">
                <span>Mobile Money Name</span>
                <span>{{ transaction.details.mobile_money_name }}</span>
            </div>
            <div class="flex justify-between">
                <span>Number</span>
                <span>{{ transaction.details.mobile_money_number }}</span>
            </div>
            <div class="flex justify-between">
                <span>Network</span>
                <span class="capitalize">{{ transaction.details.network_provider }}</span>
            </div>
        </div>

        <div class="mt-4 text-xs text-gray-400 flex justify-between">
            <span>{{ formatDate(transaction.created_at) }}</span>
            <span>ID: {{ transaction.id }}</span>
        </div>
    </Card>
    </Link>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import Card from './ui/card/Card.vue'
import { Transaction, TransactionDetails, Wallet } from '@/types'
import { Link } from '@inertiajs/vue3';
import * as TransactionRoute from '@/routes/transaction';
import Badge from './ui/badge/Badge.vue';


const props = withDefaults(defineProps<{ transaction: Transaction, expand?: boolean }>(), {
    expand: false
})

const badgeColor = computed(() => {
    switch (props.transaction.status) {
        case 'pending':
            return 'pending'
        case 'processing':
            return 'alert'
        case 'success':
            return 'success'
        case 'failed':
            return 'destructive'
        default:
            return 'secondary'
    }
})

function formatDate(date: string) {
    return new Date(date).toLocaleString()
}
</script>
