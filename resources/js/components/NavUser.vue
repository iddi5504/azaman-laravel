<script setup lang="ts">
import UserInfo from '@/components/UserInfo.vue';

import {
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    useSidebar,
} from '@/components/ui/sidebar';
import { usePage } from '@inertiajs/vue3';
import { ChevronsUpDown } from 'lucide-vue-next';
import UserMenuContent from './UserMenuContent.vue';
import { DropdownMenuContent, DropdownMenuRoot, DropdownMenuTrigger, } from 'reka-ui';

const page = usePage();
const user = page.props.auth.user;
const { isMobile, state } = useSidebar();
</script>

<template>
    <SidebarMenu>
        <SidebarMenuItem>
            <DropdownMenuRoot>
                <DropdownMenuTrigger as-child>
                    <SidebarMenuButton size="lg"
                        class="flex w-full items-center justify-between gap-3 rounded-md px-3 py-2 text-sm font-medium transition-colors hover:bg-muted/50 data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground"
                        data-test="sidebar-menu-button">
                        <UserInfo :user="user" />
                        <ChevronsUpDown
                            class="ml-auto h-4 w-4 text-muted-foreground transition-transform duration-200 data-[state=open]:rotate-180" />
                    </SidebarMenuButton>
                </DropdownMenuTrigger>

                <DropdownMenuContent
                    class="min-w-56 w-(--reka-dropdown-menu-trigger-width) rounded-lg border border-border bg-popover p-1 shadow-md"
                    :side="isMobile ? 'bottom' : state === 'collapsed' ? 'left' : 'bottom'" align="end"
                    :side-offset="6">
                    <UserMenuContent :user="user" />
                </DropdownMenuContent>
            </DropdownMenuRoot>
        </SidebarMenuItem>
    </SidebarMenu>
</template>
