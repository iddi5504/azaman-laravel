<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { accountTypeOptions, countryOptions, genderOptions } from '@/lib/constants';
import Button from '@/components/ui/button/Button.vue';
import Label from '@/components/ui/label/Label.vue';
import Input from '@/components/ui/input/Input.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import SelectField from '@/components/ui/select/SelectField.vue';
import wallets from '@/routes/wallets';
import InputError from '@/components/InputError.vue';
import { onMounted } from 'vue';
import { Wallet } from '@/types';
import { preProcessFile } from 'typescript';
import wallet, * as WalletRoute from '@/routes/wallet';

const form = useForm({
    gender: '',
    owner_name: '',
    name: '',
    icon: null,
    account_type: '',
    tag: '',
    country: [] as string[],
});

const props = defineProps<{
    editMode: boolean,
    wallet: Wallet
}>()

onMounted(() => {
    if (props.wallet) {
        Object.keys(props.wallet).forEach((k) => {
            (form as any)[k] = props.wallet[k as keyof Wallet]
        })
    }
})



const handleSubmit = () => {
    if (props.editMode) {
        form.patch(WalletRoute.edit(props.wallet.id).url, {
            onSuccess: () => form.reset('icon'),
        });
    } else {
        form.post(wallets.index.form().action, {
            onSuccess: () => form.reset('icon'),
        });
    }
};
</script>

<template>
    <AppLayout>
        <div class="max-w-3xl mx-auto p-6 space-y-6">
            <h1 class="text-2xl font-bold">{{ editMode ? 'Update' : 'Create' }} Wallet</h1>

            <form @submit.prevent="handleSubmit" class="space-y-6">
                <!-- Name -->
                <div class="grid gap-2">
                    <Label for="name">Name</Label>
                    <Input id="name" v-model="form.name" placeholder="Name" required />

                    <InputError :message="form.errors.name" />
                </div>
                <!-- Gender -->
                <div class="grid gap-2">
                    <Label for="gender">Gender</Label>
                    <SelectField v-model="form.gender" :options="genderOptions" id="gender" placeholder="Select gender">
                    </SelectField>
                    <InputError :message="form.errors.gender" />
                </div>

                <!-- Owner Name -->
                <div class="grid gap-2">
                    <Label for="owner_name">Owner Name</Label>
                    <Input id="owner_name" v-model="form.owner_name" placeholder="Owner name" required />
                    <InputError :message="form.errors.owner_name" />

                </div>

                <!-- Icon -->
                <div class="grid gap-2">
                    <Label for="icon">Icon</Label>
                    <Input id="icon" type="file" @change="(e: any) => form.icon = e.target?.files?.[0]" />
                </div>

                <!-- Account Type -->
                <div class="grid gap-2">
                    <Label for="account_type">Account Type</Label>
                    <SelectField v-model="form.account_type" :options="accountTypeOptions" id="account_type"
                        placeholder="Select account type">
                    </SelectField>
                    <InputError :message="form.errors.account_type" />

                </div>

                <!-- Tag -->
                <div class="grid gap-2">
                    <Label for="tag">Tag</Label>
                    <Input id="tag" v-model="form.tag" placeholder="Optional tag" />
                    <InputError :message="form.errors.tag" />

                </div>

                <!-- country -->
                <div class="grid gap-2">
                    <Label for="country">Countries</Label>
                    <SelectField v-model="form.country" :options="countryOptions" placeholder="Select countries" />
                    <InputError :message="form.errors.country" />

                </div>

                <Button type="submit" :loading="form.processing" class="mt-4 w-full">{{ editMode ? 'Edit' : 'Create' }}
                    Wallet</Button>
            </form>
        </div>
    </AppLayout>
</template>
