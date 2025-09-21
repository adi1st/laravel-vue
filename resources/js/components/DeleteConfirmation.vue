<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { DialogClose, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { useModalStore } from '@/stores/modalStore';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{
    title: string;
    message: string;
    deleteUrl: string; // URL untuk endpoint delete
}>();

const modalStore = useModalStore();
const isProcessing = ref(false);

function confirmDelete() {
    isProcessing.value = true;
    router.delete(props.deleteUrl, {
        onSuccess: () => modalStore.close(),
        onFinish: () => (isProcessing.value = false),
    });
}
</script>

<template>
    <DialogHeader>
        <DialogTitle>{{ props.title }}</DialogTitle>
        <DialogDescription>
            {{ props.message }}
        </DialogDescription>
    </DialogHeader>

    <DialogFooter class="mt-4">
        <DialogClose as-child>
            <Button type="button" variant="secondary">Cancel</Button>
        </DialogClose>
        <Button type="button" variant="destructive" @click="confirmDelete" :disabled="isProcessing">
            {{ isProcessing ? 'Deleting...' : 'Confirm Delete' }}
        </Button>
    </DialogFooter>
</template>
