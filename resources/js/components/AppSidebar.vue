<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid, User, PlusCircle, Clipboard, Video, Wallet } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';
import wallets from '@/routes/wallets';
import transaction from '@/routes/transaction';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'Wallets',
        href: wallets.index(),
        icon: Wallet,
    },
    // {
    //     title: 'Start Transfer',
    //     href: transaction.create().url,
    //     icon: PlusCircle,
    // },
    {
        title: 'Transactions',
        href: transaction.index().url,
        icon: Clipboard,
    },
    {
        title: 'Transaction History',
        href: '#',
        icon: Folder,
    },
    {
        title: 'Profile / Settings',
        href: '#',
        icon: User,
    },
    {
        title: 'Tutorials',
        href: '#',
        icon: Video,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset"
        class="bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700">
        <SidebarHeader class="p-4">
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child class="w-full">
                        <Link :href="dashboard()" class="flex items-center space-x-2">
                        <AppLogo class="w-8 h-8" />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent class="mt-6">
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter class="p-4 space-y-2 border-t border-gray-200 dark:border-gray-700">
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
