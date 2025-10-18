<script setup lang="ts">
import UserInfo from '@/components/UserInfo.vue';

import { logout } from '@/routes';
import { edit } from '@/routes/profile';
import type { User } from '@/types';
import { Link, router } from '@inertiajs/vue3';
import { LogOut, Settings } from 'lucide-vue-next';
import { DropdownMenuGroup, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator } from 'reka-ui';

interface Props {
    user: User;
}

const handleLogout = () => {
    router.flushAll();
};

defineProps<Props>();
</script>

<template>
    <div class="min-w-[200px]">
        <DropdownMenuLabel class="p-0 font-normal">
            <div
                class="flex items-center gap-3 px-3 py-2 text-left text-sm hover:bg-muted/50 transition-colors rounded-md">
                <UserInfo :user="user" :show-email="true" />
            </div>
        </DropdownMenuLabel>

        <DropdownMenuSeparator class="my-1" />

        <DropdownMenuGroup>
            <DropdownMenuItem :as-child="true">
                <Link
                    class="flex items-center w-full px-3 py-2 text-sm rounded-md transition-colors hover:bg-muted focus:bg-muted"
                    :href="edit()" prefetch as="button">
                <Settings class="mr-2 h-4 w-4 text-muted-foreground" />
                <span>Settings</span>
                </Link>
            </DropdownMenuItem>
        </DropdownMenuGroup>

        <DropdownMenuSeparator class="my-1" />

        <DropdownMenuItem :as-child="true">
            <Link
                class="flex items-center w-full px-3 py-2 text-sm text-red-600 rounded-md transition-colors hover:bg-red-50 focus:bg-red-50"
                :href="logout()" @click="handleLogout" as="button" data-test="logout-button">
            <LogOut class="mr-2 h-4 w-4" />
            <span>Log out</span>
            </Link>
        </DropdownMenuItem>
    </div>
</template>
