import { WalletType } from '@/lib/constants';
import { InertiaLinkProps } from '@inertiajs/vue3';
import type { LucideIcon } from 'lucide-vue-next';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface SelectOption {
    label: string;
    value: string | number | null;
    icon?: string;
}


export interface NavItem {
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type AppPageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    isAdmin: boolean;
    flash: { message: string; status: 'success' | 'error' | 'info' } | null;
    sidebarOpen: boolean;
};

export interface User {
    id: number;
    name: string;
    phone: number;
    username: string;
    email: string;
    avatar?: string;
    profile_picture?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export type BreadcrumbItemType = BreadcrumbItem;


export interface Wallet {
    id: number;
    name: string;
    gender: string;
    owner_name: string;
    icon?: string;
    account_type: WalletType;
    tag?: string;
    countries?: string[];
}