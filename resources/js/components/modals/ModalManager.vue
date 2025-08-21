<script setup lang="ts">
import { useModalStore } from '@/stores/modalStore';
import { computed } from 'vue';
import Dialog from '../ui/dialog/Dialog.vue';
import DialogContent from '../ui/dialog/DialogContent.vue';

const modalStore = useModalStore();

// Kita perlu menggunakan `watch` untuk mengontrol state 'open' dari Dialog Shadcn,
// karena `v-model` tidak bisa langsung digunakan dengan Pinia state.
const handleUpdateOpen = (open: boolean) => {
    if (!open) {
        modalStore.close();
    }
};

const modalWidthClass = computed(() => {
    const sizeMap: Record<string, string> = {
        sm: 'sm:max-w-sm',
        md: 'sm:max-w-md',
        lg: 'sm:max-w-lg',
        xl: 'sm:max-w-xl',
        '2xl': 'sm:max-w-2xl',
        '3xl': 'sm:max-w-3xl',
        '4xl': 'sm:max-w-4xl',
    };
    return sizeMap[modalStore.size] || 'sm:max-w-md'; // Fallback ke 'md'
});
</script>

<template>
    <Dialog :open="modalStore.isOpen" @update:open="handleUpdateOpen">
        <DialogContent :class="modalWidthClass" @interact-outside="(e) => e.preventDefault()">
            <!-- render modalstore.view -->
            <component v-if="modalStore.view" :is="modalStore.view" v-bind="modalStore.data"></component>
        </DialogContent>
    </Dialog>
</template>
