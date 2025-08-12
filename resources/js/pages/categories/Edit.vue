<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
// import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

interface Category {
    id: number;
    name: string;
    description: string;
    image: string;
}

const props = defineProps<{ category: Category }>();

const form = useForm({
    name: props.category.name,
    description: props.category.description,
});

const submit = () => {
    form.put(route('categories.update', props.category.id));
};
</script>

<template>
    <Head title="Edit a Category" />

    <AppLayout :breadcrumbs="[{ title: 'Create a Category', href: '/categories/${props.category.id}/edit' }]">
        <div class="space-y-6 px-4 py-6">
            <HeadingSmall title="Edit" description="Edit a Category" />
            <form @submit.prevent="submit" class="w-8/12 space-y-4">
                <div class="space-y-2">
                    <Label for="Category name">Name</Label>
                    <Input type="text" v-model="form.name" placeholder="Name" required />
                    <InputError :message="form.errors.name" />
                </div>
                <div class="space-y-2">
                    <Label for="Category description">Description</Label>
                    <Input type="text" v-model="form.description" placeholder="Description" />
                    <InputError :message="form.errors.description" />
                </div>

                <Button :disabled="form.processing">Save Update</Button>
            </form>
        </div>
    </AppLayout>
</template>
