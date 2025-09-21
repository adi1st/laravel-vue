<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { DialogClose, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import type { Category } from '@/types';

defineProps<{
    category: Category;
}>();
</script>

<template>
    <DialogHeader>
        <DialogTitle>Category Details</DialogTitle>
    </DialogHeader>

    <div class="grid gap-4 py-4">
        <div class="flex items-center">
            <strong class="w-24">ID:</strong>
            <span>{{ category.id }}</span>
        </div>
        <div class="flex items-center">
            <strong class="w-24">Name:</strong>
            <span>{{ category.name }}</span>
        </div>
        <div class="flex items-center">
            <strong class="w-24">Description:</strong>
            <span>{{ category.description }}</span>
        </div>
        <div class="flex items-center">
            <strong class="w-24">Category Image:</strong>
            <img v-if="category.image" :src="category.image" class="h-40 w-40" alt="category image" />
        </div>
    </div>

    <DialogFooter>
        <DialogClose as-child>
            <Button type="button" variant="secondary">Close</Button>
        </DialogClose>
    </DialogFooter>
</template>
