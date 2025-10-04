<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { DialogClose, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import type { Category } from '@/types';
import { Image as ImageIcon } from 'lucide-vue-next';

defineProps<{
    category: Category;
}>();
</script>

<template>
    <DialogHeader>
        <DialogTitle>Category Details</DialogTitle>
    </DialogHeader>

    <div class="space-y-8 py-4">
        <!-- Category Image Section -->
        <div class="space-y-3">
            <div class="flex justify-center">
                <div v-if="category.image" class="group relative overflow-hidden rounded-lg">
                    <img
                        :src="category.image"
                        class="h-48 w-48 rounded-lg object-cover transition-transform duration-300 group-hover:scale-110"
                        alt="Category image for {{ category.name }}"
                    />

                    <div
                        class="absolute inset-0 flex items-center justify-center bg-black/30 opacity-0 backdrop-blur-sm transition-opacity duration-300 group-hover:opacity-100"
                    >
                        <span class="rounded-md bg-secondary px-2 py-1 text-xs font-medium text-secondary-foreground">
                            {{ category.name }}
                        </span>
                    </div>
                </div>

                <div v-else class="flex h-48 w-48 flex-col items-center justify-center rounded-lg border border-dashed border-gray-300">
                    <ImageIcon class="mb-2 h-12 w-12 text-gray-400" />
                    <p class="text-sm text-gray-500">No image available</p>
                </div>
            </div>
        </div>

        <!-- Category Information Section -->
        <div class="space-y-4">
            <h6 class="text-md font-medium">Category Information</h6>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="space-y-1">
                    <p class="text-sm font-medium text-gray-500">ID</p>
                    <div class="flex items-center gap-2">
                        <span class="rounded-md border border-gray-200 px-2 py-1 text-xs font-medium">
                            {{ category.id }}
                        </span>
                    </div>
                </div>

                <div class="space-y-1">
                    <p class="text-sm font-medium text-gray-500">Name</p>
                    <p class="text-base font-semibold">{{ category.name }}</p>
                </div>

                <div class="space-y-1 md:col-span-2">
                    <p class="text-sm font-medium text-gray-500">Description</p>
                    <p class="text-base">{{ category.description || 'No description provided' }}</p>
                </div>
            </div>
        </div>
    </div>

    <DialogFooter>
        <DialogClose as-child>
            <Button type="button" variant="secondary">Close</Button>
        </DialogClose>
    </DialogFooter>
</template>
