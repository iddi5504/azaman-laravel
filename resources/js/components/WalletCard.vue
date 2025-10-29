<script setup lang="ts">
import { accountTypeOptions, walletIconsMap } from '@/lib/constants';
import { Wallet } from '@/types';
import { Edit, MenuIcon, Trash, View } from 'lucide-vue-next';
import DropdownMenu from './ui/dropdown-menu/DropdownMenu.vue';
import AlertDialog from './ui/alert-dialog/AlertDialog.vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import wallets from '@/routes/wallets';
import * as walletRoute from '@/routes/wallet';
import Button from './ui/button/Button.vue';
import Dialog from './ui/dialog/Dialog.vue';
import transaction from '@/routes/transaction';


const props = defineProps<{ wallet: Wallet }>()

const showDeleteDialog = ref(false)
const showWalletDetailsDialog = ref(false)

const editWallet = () => {
    form.get(walletRoute.edit(props.wallet.id).url);
}

const startTransaction = () => {
    form.get(transaction.create(props.wallet.id).url)
}

const form = useForm({});
const deleteWallet = () => {
    form.delete(wallets.destroy(props.wallet.id).url)
}
</script>

<template>
    <div @click="showWalletDetailsDialog = true"
        class="flex items-center justify-between rounded-lg border cursor-pointer border-gray-200 bg-white p-4 shadow-sm hover:shadow-md dark:border-gray-700 dark:bg-gray-800 transition-shadow">
        <div class="flex items-center gap-4 flex-1">
            <img :src="wallet.icon ? '/storage/' + wallet.icon : walletIconsMap[wallet.account_type]" alt="Wallet Icon"
                class="h-12 w-12 object-cover " />

            <div class="flex flex-col">
                <h3 class="font-semibold text-sm text-gray-900 dark:text-gray-100">
                    {{ wallet.owner_name }}
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    {{ wallet.account_type }} • {{ wallet.gender }}
                </p>
                <p v-if="wallet.tag" class="text-xs text-gray-400 dark:text-gray-500">
                    Tag: {{ wallet.tag }}
                </p>
                <p v-if="wallet.countries?.length" class="text-xs text-gray-400 dark:text-gray-500">
                    Countries: {{ wallet.countries.join(', ') }}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <DropdownMenu :items="[
                {
                    title: 'View',
                    icon: View,
                    action: () => {
                        showWalletDetailsDialog = true;
                    },
                },
                {
                    title: 'Edit',
                    icon: Edit,
                    action: editWallet,
                },
                {
                    title: 'Delete',
                    icon: Trash,
                    status: 'danger',
                    action() {
                        showDeleteDialog = true
                    },
                },
            ]">
                <MenuIcon
                    class="w-5 h-5 text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-100 transition" />
            </DropdownMenu>
        </div>


        <AlertDialog v-model="showDeleteDialog" @confirm="deleteWallet"
            :title="`Are you sure you want to delete ${wallet.name ?? ''}?`" cancel-text="Cancel" confirm-text="Delete"
            description="This action is irreversible." />

        <Dialog v-model="showWalletDetailsDialog" title="Wallet details">
            <div class="rounded-xl border bg-white p-6 shadow-sm hover:shadow-md transition m-2">
                <div class="flex items-center gap-4 mb-4">
                    <img :src="wallet.icon ? '/storage/' + wallet.icon : walletIconsMap[wallet.account_type.toLowerCase()]"
                        alt="Wallet Icon" class="h-14 w-14 rounded-full border object-cover" />
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">{{ wallet.owner_name }}</h2>
                        <p class="text-sm text-gray-500">{{accountTypeOptions.find((a) => a.value ===
                            wallet.account_type)?.label}}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-y-3 gap-x-6 text-sm">
                    <div>
                        <span class="block text-gray-400">Wallet ID</span>
                        <span class="font-medium text-gray-800">{{ wallet.id }}</span>
                    </div>

                    <div>
                        <span class="block text-gray-400">Name</span>
                        <span class="font-medium text-gray-800">{{ wallet.name }}</span>
                    </div>

                    <div>
                        <span class="block text-gray-400">Gender</span>
                        <span class="font-medium text-gray-800 capitalize">{{ wallet.gender }}</span>
                    </div>

                    <div>
                        <span class="block text-gray-400">Account Type</span>
                        <span class="font-medium text-gray-800">{{accountTypeOptions.find((a) => a.value ===
                            wallet.account_type)?.label}}</span>
                    </div>

                    <div v-if="wallet.tag">
                        <span class="block text-gray-400">Tag</span>
                        <span class="font-medium text-gray-800">{{ wallet.tag }}</span>
                    </div>

                    <div v-if="wallet.countries?.length">
                        <span class="block text-gray-400">Countries</span>
                        <span class="font-medium text-gray-800">{{ wallet.countries.join(', ') }}</span>
                    </div>
                </div>
            </div>

            <template #actions>
                <Button v-if="$page.props.isAdmin" :variant="'outline'" @click="editWallet()">Edit </Button>
                <Button @click="showWalletDetailsDialog = false" :variant="'outline'">Close</Button>
                <Button @click="startTransaction">Start a Transaction</Button>
            </template>
        </Dialog>
    </div>
</template>
