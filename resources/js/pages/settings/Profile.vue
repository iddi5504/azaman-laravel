<script setup lang="ts">
import ProfileController from '@/actions/App/Http/Controllers/Settings/ProfileController';
import { edit } from '@/routes/profile';
import { send } from '@/routes/verification';
import { Form, Head, Link, usePage } from '@inertiajs/vue3';

import DeleteUser from '@/components/DeleteUser.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { type BreadcrumbItem } from '@/types';

interface Props {
    mustVerifyEmail: boolean;
    status?: string;
}

defineProps<Props>();

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Profile settings',
        href: edit().url,
    },
];

const page = usePage();
const user = page.props.auth.user;

const handleFileChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files?.[0]) {
        const preview = URL.createObjectURL(target.files?.[0])

        document.getElementById('profile')?.setAttribute('src', preview)
    }
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">

        <Head title="Profile settings" />

        <SettingsLayout>
            <div class="flex flex-col space-y-8">
                <HeadingSmall title="Profile Information"
                    description="Update your personal details and profile photo" />

                <Form v-bind="ProfileController.update.form()" class="grid gap-6 max-w-xl"
                    v-slot="{ errors, processing, recentlySuccessful }">
                    <div class="grid gap-2">
                        <Label for="profile_picture">Profile Picture</Label>
                        <div class="flex items-center gap-4">
                            <div
                                class="relative w-20 h-20 rounded-full overflow-hidden border border-neutral-300 dark:border-neutral-700">
                                <img id="profile"
                                    :src="user.profile_picture ? '/storage/' + user.profile_picture : '/assets/images/user.png'"
                                    alt="Profile Picture" class="w-full h-full object-cover" />
                            </div>

                            <Input id="profile_picture" type="file" @change="handleFileChange" name="profile_picture"
                                accept="image/*" class="w-full" />
                        </div>
                        <InputError :message="errors.profile_picture" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="name">Full Name</Label>
                        <Input id="name" name="name" :default-value="user.name" required autocomplete="name"
                            placeholder="John Doe" />
                        <InputError :message="errors.name" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="username">Username</Label>
                        <Input id="username" name="username" :default-value="user.username" required
                            autocomplete="username" placeholder="johndoe" />
                        <InputError :message="errors.username" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="email">Email Address</Label>
                        <Input id="email" type="email" name="email" :default-value="user.email" required
                            autocomplete="email" placeholder="email@example.com" />
                        <InputError :message="errors.email" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="phone">Phone Number</Label>
                        <Input id="phone" type="tel" name="phone" :default-value="user.phone" autocomplete="tel"
                            placeholder="+1 555 123 4567" />
                        <InputError :message="errors.phone" />
                    </div>

                    <div v-if="mustVerifyEmail && !user.email_verified_at">
                        <p class="-mt-2 text-sm text-muted-foreground">
                            Your email address is unverified.
                            <Link :href="send()" as="button"
                                class="text-primary underline underline-offset-4 hover:text-primary/80">
                            Click here to resend the verification email.
                            </Link>
                        </p>

                        <div v-if="status === 'verification-link-sent'" class="mt-2 text-sm font-medium text-green-600">
                            A new verification link has been sent to your email address.
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <Button :disabled="processing" data-test="update-profile-button">
                            <LoaderCircle v-if="processing" class="h-4 w-4 animate-spin" />
                            Save Changes
                        </Button>

                        <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                            <p v-show="recentlySuccessful" class="text-sm text-muted-foreground">
                                Saved successfully.
                            </p>
                        </Transition>
                    </div>
                </Form>

                <Separator />

                <div>
                    <!-- <HeadingSmall title="Delete Account"
                        description="Permanently remove your account and all associated data" /> -->
                    <!-- <DeleteUser /> -->
                </div>
            </div>
        </SettingsLayout>
    </AppLayout>

</template>
