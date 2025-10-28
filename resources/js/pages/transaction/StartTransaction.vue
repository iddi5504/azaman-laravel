<script lang="ts" setup>
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import WalletCard from '@/components/WalletCard.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Wallet } from '@/types';
import { Form, useForm } from '@inertiajs/vue3';

import mtn from '@/assets/images/mtn.png';
import airteltigo from '@/assets/images/airteltigo.webp';
import telecel from '@/assets/images/telecel.png';
import transaction from '@/routes/transaction';

const props = defineProps<{
    wallet: Wallet
}>()

const form = useForm({
    amount: '',
    mobile_money_name: '',
    mobile_money_number: '',
    network_provider: '',
} as {
    amount: string;
    mobile_money_name: string;
    mobile_money_number: string;
    network_provider: string;
});


const submitForm = () => {
    form.post(transaction.store(props.wallet.id).url, {
        onSuccess: () => {
            form.reset('amount', 'mobile_money_name', 'mobile_money_number', 'network_provider');
        },
    });
}

const providers = [
    {
        name: 'mtn',
        logo: mtn,
    },
    {
        name: 'airtel_tigo',
        logo: airteltigo,
    },
    {
        name: 'telecel',
        logo: telecel,
    },
];

const selectProvider = (name: string) => {
    form.network_provider = name;
}

</script>

<template>
    <AppLayout>
        <div class="max-w-2xl mx-auto p-3">
            <WalletCard :wallet="wallet" />

            <form @submit.prevent="submitForm" class="grid gap-5 pt-5 mt-4">
                <div class="space-y-3 p-4 border rounded-lg bg-gray-50 ">
                    <h2 class="text-lg font-semibold">Cashout Request</h2>
                    <p class="text-sm text-gray-600">
                        Input the amount you'd like to cashout, after submitting you'll have 1 hour to upload a proof of
                        payment.
                    </p>

                    <div class="grid gap-2">
                        <Label for="amount">Amount (USD)</Label>
                        <Input id="amount" v-model="form.amount" placeholder="Enter amount" required />
                        <InputError :message="form.errors.amount" />
                        <p v-if="form.amount" class="text-sm text-gray-700">
                            You'll receive: <span class="font-semibold">{{ (Number(form.amount) * 13).toFixed(2) }}
                                GHC</span>
                        </p>
                    </div>

                    <div class="text-sm font-medium text-gray-800 pt-2">
                        Exchange rate<br />
                        <span class="text-green-600">1 USD = 13.00 GHC</span>
                    </div>
                </div>
                <div class="space-y-2">
                    <Label>Select Mobile Money Provider</Label>
                    <div class="flex gap-5">
                        <div v-for="provider in providers" :key="provider.name" @click="selectProvider(provider.name)"
                            class="p-2 rounded-lg border cursor-pointer transition-all duration-200 flex items-center justify-center w-20 h-12"
                            :class="form.network_provider === provider.name ? 'border-blue-500 bg-blue-50' : 'border-gray-300 bg-white'">
                            <img :src="provider.logo" :alt="provider.name" class="max-h-8 object-contain" />
                        </div>
                    </div>
                    <InputError :message="form.errors.network_provider" />

                </div>
                <div class="grid gap-2">
                    <Label for="mobile_money_name">Mobile Money Name</Label>
                    <Input id="mobile_money_name" v-model="form.mobile_money_name" placeholder="e.g. John Doe"
                        required />
                    <InputError :message="form.errors.mobile_money_name" />
                </div>

                <div class="grid gap-2">
                    <Label for="mobile_money_number">Mobile Money Number</Label>
                    <Input id="mobile_money_number" v-model="form.mobile_money_number" placeholder="Eg. 0537532465"
                        required />
                    <InputError :message="form.errors.mobile_money_number" />
                </div>

                <div class="pt-2">
                    <Button type="submit" :loading="form.processing" class="w-full">Submit</Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>