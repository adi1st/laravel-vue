<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { DialogClose, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import DialogDescription from '@/components/ui/dialog/DialogDescription.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useModalStore } from '@/stores/modalStore';
import type { Category } from '@/types';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
    category?: Category;
}>();

const modalStore = useModalStore();
const isUpdateMode = !!props.category;

const form = useForm({
    name: props.category?.name || '',
    description: props.category?.description || '',
    image: null as File | null,
});

const title = isUpdateMode ? 'Update Category' : 'Create New Category';

function submit() {
    const options = {
        onSuccess: () => modalStore.close(),
        forceFormData: true,
    };

    if (isUpdateMode) {
        form.transform((data) => {
            const formData = new FormData();
            formData.append('name', data.name);
            formData.append('description', data.description);
            formData.append('_method', 'PUT');

            if (data.image) {
                formData.append('image', data.image);
            }

            return formData;
        }).post(route('categories.update', props.category!.id), options);
    } else {
        form.transform((data) => {
            const formData = new FormData();
            formData.append('name', data.name);
            formData.append('description', data.description);

            if (data.image) {
                formData.append('image', data.image);
            }

            return formData;
        }).post(route('categories.store'), options);
    }
}
</script>

<template>
    <form @submit.prevent="submit">
        <DialogHeader>
            <DialogTitle>{{ title }}</DialogTitle>
            <DialogDescription> {{ title }} here. Click save when you're done. </DialogDescription>
        </DialogHeader>
        <div class="grid gap-4 py-4">
            <div class="grid grid-cols-4 items-center gap-4">
                <Label for="name" class="text-right">Name</Label>
                <Input id="name" v-model="form.name" class="col-span-3" />
                <div v-if="form.errors.name" class="col-span-3 col-start-2 text-sm text-red-600">
                    {{ form.errors.name }}
                </div>
            </div>
            <div class="grid grid-cols-4 items-center gap-4">
                <Label for="description" class="text-right">Description</Label>
                <Input id="description" v-model="form.description" class="col-span-3" />
                <div v-if="form.errors.description" class="col-span-3 col-start-2 text-sm text-red-600">
                    {{ form.errors.description }}
                </div>
            </div>
            <div class="grid grid-cols-4 items-center gap-4">
                <Label for="image" class="text-right">Image</Label>
                <Input
                    id="image"
                    type="file"
                    accept="image/*"
                    class="col-span-3"
                    @change="(e: Event) => (form.image = (e.target as HTMLInputElement).files?.[0] || null)"
                />
                <div v-if="form.errors.image" class="col-span-3 col-start-2 text-sm text-red-600">
                    {{ form.errors.image }}
                </div>
            </div>
        </div>
        <DialogFooter>
            <DialogClose as-child>
                <Button type="button" variant="secondary">Cancel</Button>
            </DialogClose>
            <Button type="submit" :disabled="form.processing">
                {{ form.processing ? 'Saving...' : 'Save changes' }}
            </Button>
        </DialogFooter>
    </form>
</template>
