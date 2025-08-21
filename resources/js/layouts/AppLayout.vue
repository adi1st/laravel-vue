<script setup lang="ts">
import ModalManager from '@/components/modals/ModalManager.vue';
import { Toaster } from '@/components/ui/sonner';
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
// import { useAlertStore, type AlertConfig } from '@/stores/alertStore';
import type { BreadcrumbItemType } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { watch } from 'vue';
import { toast } from 'vue-sonner';
import 'vue-sonner/style.css'; //

const page = usePage();
// const alertStore = useAlertStore();

// Buat computed property untuk mendapatkan flash message secara reaktif.
// const flash = computed(() => page.props.flash as { message?: string; variant?: AlertConfig['variant']; title?: string } | null);

watch(
    () => page.props.flash as { message?: string; variant?: 'default' | 'destructive'; title?: string },
    (flash) => {
        if (flash?.message) {
            if (flash.variant === 'destructive') {
                toast.error(flash.title || 'Notifikasi', {
                    description: flash.message,
                    action: {
                        label: 'OK',
                        onClick: () => console.log('OK'),
                    },
                });
            } else {
                toast.success(flash.title || 'Notifikasi', {
                    description: flash.message,
                    action: {
                        label: 'OK',
                        onClick: () => console.log('OK'),
                    },
                });
            }
            // Hapus flash message setelah ditampilkan
            page.props.flash = null;
        }
    },
    { deep: true },
);

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <slot />
        <ModalManager />
        <Toaster />
    </AppLayout>
</template>
