<script setup lang="ts">
import AuthenticatedSessionController from '@/actions/App/Http/Controllers/Auth/AuthenticatedSessionController';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { register } from '@/routes';
import { request } from '@/routes/password';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();
</script>

<template>
    <AuthBase title="Azaman" description="Pickups Made Perfect">

        <Head title="Log in" />

        <div class="flex flex-col items-center gap-6">


            <Form v-bind="AuthenticatedSessionController.store.form()" :reset-on-success="['password']"
                v-slot="{ errors, processing }"
                class="w-full max-w-md flex flex-col gap-6 bg-white rounded-2xl p-6 shadow-lg">
                <div v-if="status" class="text-center text-sm font-medium text-green-600">
                    {{ status }}
                </div>

                <div class="grid gap-2">
                    <Label for="email">Email address</Label>
                    <Input id="email" type="email" name="email" required autofocus :tabindex="1" autocomplete="email"
                        placeholder="email@example.com" />
                    <InputError :message="errors.email" />
                </div>

                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="password">Password</Label>
                        <TextLink v-if="canResetPassword" :href="request()" class="text-sm" :tabindex="5">
                            Forgot password?
                        </TextLink>
                    </div>
                    <Input id="password" type="password" name="password" required :tabindex="2"
                        autocomplete="current-password" placeholder="••••••••" />
                    <InputError :message="errors.password" />
                </div>

                <div class="flex items-center justify-between">
                    <Label for="remember" class="flex items-center space-x-3">
                        <Checkbox id="remember" name="remember" :tabindex="3" />
                        <span>Remember me</span>
                    </Label>
                </div>

                <Button type="submit" class="mt-4 w-full" :tabindex="4" :loading="processing" :disabled="processing"
                    data-test="login-button">

                    Log in
                </Button>

                <div class="text-center text-sm text-muted-foreground">
                    Don’t have an account?
                    <TextLink :href="register()" :tabindex="5">Sign up</TextLink>
                </div>
            </Form>
        </div>
    </AuthBase>


</template>
