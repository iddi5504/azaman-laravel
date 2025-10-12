<script setup lang="ts">
import EmailVerificationNotificationController from '@/actions/App/Http/Controllers/Auth/EmailVerificationNotificationController';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { logout } from '@/routes';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    status?: string;
}>();
</script>

<template>
    <AuthLayout title="Verify your email"
        description="Before continuing, please check your email for a verification link. If you didn’t receive one, you can request another below.">

        <Head title="Email Verification" />

        <div v-if="status === 'verification-link-sent'"
            class="mb-6 rounded-lg bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
            A new verification link has been sent to your email address.
        </div>

        <Form v-bind="EmailVerificationNotificationController.store.form()" class="flex flex-col gap-6 items-center"
            v-slot="{ processing }">
            <Button :disabled="processing" class="w-full">
                <LoaderCircle v-if="processing" class="h-4 w-4 animate-spin mr-2" />
                Resend verification email
            </Button>

            <TextLink :href="logout()" as="button" class="text-sm text-gray-600 hover:text-gray-900 transition-colors">
                Log out
            </TextLink>
        </Form>
    </AuthLayout>

</template>
