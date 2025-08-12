<script setup lang="ts">
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { useAlertStore } from '@/stores/alertStore';
import { TransitionRoot } from '@headlessui/vue';
import { Bell } from 'lucide-vue-next';

// Dapatkan instance dari alert store (sudah di-type dengan benar dari store)
const alertStore = useAlertStore();
</script>

<template>
    <!-- Wrapper untuk memposisikan alert di pojok kanan atas -->
    <div class="fixed top-5 right-5 z-50 w-full max-w-sm">
        <TransitionRoot
            :show="alertStore.show"
            enter="transition-transform duration-300 ease-out"
            enter-from="translate-x-full opacity-0"
            enter-to="translate-x-0 opacity-100"
            leave="transition-all duration-300 ease-in"
            leave-from="opacity-100"
            leave-to="opacity-0"
        >
            <Alert :variant="alertStore.variant" class="border border-gray-600 shadow-md">
                <Bell class="h-4 w-4" />
                <AlertTitle class="font-bold">{{ alertStore.title }}</AlertTitle>
                <AlertDescription v-if="alertStore.description">
                    {{ alertStore.description }}
                </AlertDescription>
            </Alert>
        </TransitionRoot>
    </div>
</template>
