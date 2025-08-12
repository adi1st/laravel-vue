<script setup lang="ts">
import GlobalAlert from '@/components/GlobalAlert.vue';
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import { useAlertStore, type AlertConfig } from '@/stores/alertStore';
import type { BreadcrumbItemType } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { computed, watch } from 'vue';

const page = usePage();
const alertStore = useAlertStore();

// Buat computed property untuk mendapatkan flash message secara reaktif.
const flash = computed(() => page.props.flash as { message?: string; variant?: AlertConfig['variant']; title?: string } | null);

// Awasi perubahan pada computed property `flash`.
watch(
    flash,
    (newFlash) => {
        if (newFlash?.message) {
            alertStore.showAlert({
                title: newFlash.title || 'Notifikasi',
                description: newFlash.message,
                variant: newFlash.variant || 'default',
            });
            page.props.flash = null;
        }
    },
    {
        immediate: true,
    },
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
        <GlobalAlert />
        <slot />
    </AppLayout>
</template>
