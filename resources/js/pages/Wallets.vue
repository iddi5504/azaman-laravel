<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import SelectField from '@/components/ui/select/SelectField.vue';
import WalletCard from '@/components/WalletCard.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { accountTypeOptions } from '@/lib/constants';
import { addWallet } from '@/routes';
import * as WalletsRoute from '@/routes/wallets';
import { Wallet } from '@/types';
import { Link, useForm } from '@inertiajs/vue3';
import { useDebounceFn } from '@vueuse/core';
import { X } from 'lucide-vue-next';
import { defineProps, onMounted, reactive, ref, watchEffect } from 'vue';

const props = defineProps<{ wallets: Wallet[], query: Record<string, string> }>();


const form = useForm({})

const query = reactive({
    account_type: '',
    search: ''
})


const filter = () => {
    form.get(WalletsRoute.index({
        query: query
    }).url)
}
const debounceFilter = useDebounceFn(filter, 600)

onMounted(() => {
    Object.keys(query).forEach((q) => {
        (query as any)[q] = props.query[q]
    })
})

</script>

<template>
    <AppLayout>
        <div class="flex gap-3 justify-end px-5 pt-3">
            <Input v-model="query.search" class="w-1/6" placeholder="Search wallets"
                @update:model-value="debounceFilter" />
            <SelectField v-model="query.account_type" @update:model-value="debounceFilter" :options="[
                {
                    label: 'None',
                    value: null,
                },
                ...accountTypeOptions
            ]" id="account_type" placeholder="Select account type">
            </SelectField>
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
