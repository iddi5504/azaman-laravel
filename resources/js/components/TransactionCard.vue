<template>
    <Link :href="TransactionRoute.show(transaction.id).url">
    <Card
        class="p-5 rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all duration-200 hover:-translate-y-0.5 bg-card">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                    {{ transaction.wallet.name }}
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ transaction.wallet.owner_name }}
                </p>
            </div>
            <Badge :variant="badgeColor" class="capitalize px-2 py-0.5 text-xs font-medium">
                {{ transaction.status }}
            </Badge>
        </div>

        <div class="text-center py-3 border-y border-gray-100 dark:border-gray-800 my-3">
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Amount</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">
                {{ transaction.details.amount }}
                <span class="text-base text-gray-500 dark:text-gray-400">GHS</span>
            </p>
        </div>

        <div class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
            <div class="flex justify-between">
                <span>Mobile Money Name</span>
                <span class="font-medium">{{
                    transaction.details.mobile_money_name
                    }}</span>
            </div>
            <div class="flex justify-between">
                <span>Number</span>
                <span class="font-medium">{{
                    transaction.details.mobile_money_number
                    }}</span>
            </div>
            <div class="flex justify-between">
                <span>Network</span>
                <span class="capitalize font-medium">{{
                    transaction.details.network_provider
                    }}</span>
            </div>
        </div>

        <div class="mt-5 flex justify-between items-center text-xs text-gray-400 dark:text-gray-500">
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
        case 'completed':
            return 'success'
        case 'failed':
            return 'destructive'
        default:
            return 'alert'
    }
})

function formatDate(date: string) {
    return new Date(date).toLocaleString()
}
</script>
