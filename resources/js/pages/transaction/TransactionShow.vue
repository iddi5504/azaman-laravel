<script setup lang="ts">
import TransactionCard from '@/components/TransactionCard.vue';
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import * as TransactionRoute from '@/routes/transaction';
import transactionProof from '@/routes/transactionProof';
import { Transaction } from '@/types';
import { Form } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{
    transaction: Transaction
}>();

const fileInput = ref<HTMLInputElement | null>(null);
const previewUrl = ref<string | null>(null);
const dragging = ref(false);
const error = ref<string | null>(null);
function openFileDialog() {
    fileInput.value?.click();
}

const onFileChange = (event: Event) => {
    const file = (event.target as HTMLInputElement).files?.[0];
    previewUrl.value = file ? URL.createObjectURL(file) : null;
}

const removeFile = () => {
    previewUrl.value = null;

}

</script>

<template>
    <AppLayout>
        <div class="p-6 max-w-4xl mx-auto w-full">
            <h1 class="text-2xl font-semibold mb-6">Transaction Details</h1>

            <TransactionCard expand :transaction="transaction" />
            <!-- div of submitted proof images -->
            <div v-if="transaction.transaction_proofs.length" class="mt-5">
                <h2 class="text-lg font-semibold mb-3">Submitted Proofs of Payment</h2>
                <div v-if="transaction.transaction_proofs.length" class="grid grid-cols-2 gap-4">
                    <div v-for="proof in transaction.transaction_proofs" :key="proof.id" class="border rounded-lg p-2">
                        <img :src="proof.file_path" alt="Proof Image" class="w-full h-48 object-contain rounded-md" />
                    </div>
                </div>
                <p v-else class="text-gray-500">No proofs of payment submitted yet.</p>
            </div>

            <Form v-if="!$page.props.isAdmin" :action="transactionProof.store(transaction.id)" reset-on-success
                v-slot="{ processing }" method="post" enctype="multipart/form-data">
                <div class="p-4 rounded-lg bg-white border mt-5">
                    <h2 class="text-lg font-semibold mb-1">Upload proof of payment</h2>
                    <p class="text-sm text-gray-600 mb-4">
                        Once proof of payment is submitted, payment will begin processings.
                    </p>

                    <div class="relative flex flex-col items-center justify-center p-6 border-2 border-dashed rounded-lg cursor-pointer hover:bg-gray-50 transition"
                        @click="openFileDialog" :class="dragging ? 'bg-gray-50 border-blue-300' : ''">
                        <input ref="fileInput" name="image" type="file" accept="image/*" class="hidden"
                            @change="onFileChange" />

                        <template v-if="previewUrl">
                            <img :src="previewUrl" class="max-h-48 object-contain rounded-md" />
                            <div class="flex gap-2 mt-3">
                                <button type="button" class="px-3 py-1 text-sm rounded bg-gray-100"
                                    @click.stop="removeFile">Remove</button>
                                <a :href="previewUrl" target="_blank"
                                    class="px-3 py-1 text-sm rounded bg-gray-100">Open</a>
                            </div>
                        </template>

                        <template v-else>
                            <svg class="w-10 h-10 text-gray-400 mb-2" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 15a4 4 0 004 4h10a4 4 0 004-4V7a4 4 0 00-4-4H7a4 4 0 00-4 4v8z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M8 11l3 3 5-5">
                                </path>
                            </svg>
                            <div class="text-center">
                                <div class="text-sm font-medium text-gray-900">Click or drop an image here to upload
                                </div>
                                <div class="text-xs text-gray-500 mt-1">PNG, JPG, JPEG. Max 10 MB.</div>
                            </div>
                        </template>
                    </div>

                    <div v-if="error" class="text-sm text-red-600 mt-3">{{ error }}</div>
                </div>

                <!-- submit -->
                <Button type="submit" :loading="processing" class="w-full mt-5">Submit Proof Of Payment</Button>
            </Form>
            <!-- approve -->
            <div v-if="$page.props.isAdmin" class="mt-5">
                <div class="flex justify-evenly w-full gap-4">
                    <Form class="w-full" method="patch" :action="TransactionRoute.rejectTransaction(transaction.id).url"
                        v-slot="{ processing }">
                        <Button type="submit" :loading="processing" variant="outline" class="w-full bg-red-50">
                            Reject Transaction
                        </Button>
                    </Form>
                    <Form class="w-full" method="patch"
                        :action="TransactionRoute.approveTransaction(transaction.id).url" v-slot="{ processing }">
                        <Button type="submit" :loading="processing" class="w-full bg-green-600 hover:bg-green-700">
                            Approve Transaction
                        </Button>
                    </Form>

                </div>
                <p class="text-sm text-gray-600 mt-2">Once approved, the transaction will be processed.</p>
            </div>
        </div>
    </AppLayout>
</template>