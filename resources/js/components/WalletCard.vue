<script setup lang="ts">
import { walletIconsMap } from '@/lib/constants';
import { Wallet } from '@/types';


defineProps<{ wallet: Wallet }>()
</script>

<template>
    <div class="flex items-center justify-between rounded-lg border p-4 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center gap-4">
            <!-- {{ walletIconsMap[wallet.account_type] }} -->
            <img :src="wallet.icon ? '/storage/' + wallet.icon : walletIconsMap[wallet.account_type]" alt="Icon"
                class="h-10 w-10 rounded-full object-cover border" />
            <div>
                <h3 class="font-semibold text-sm">{{ wallet.owner_name }}</h3>
                <p class="text-xs text-gray-500">{{ wallet.account_type }} | {{ wallet.gender }}</p>
                <p class="text-xs text-gray-400" v-if="wallet.tag">Tag: {{ wallet.tag }}</p>
                <p class="text-xs text-gray-400" v-if="wallet.countries?.length">
                    Countries: {{ wallet.country.join(', ') }}
                </p>
            </div>
        </div>
    </div>
</template>