<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';

interface Category {
    id: number;
    name: string;
    description: string;
    image: string;
}

interface Props {
    categories: Category[];
}

// get props from inertia
const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Categories',
        href: '/categories',
    },
];

const handleDelete = (id: number) => {
    if (confirm('Are you sure you want to delete this category?')) {
        router.delete(route('categories.destroy', id));
    }
};
</script>

<template>
    <Head title="Categories" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6">
            <div class="flex flex-col space-y-6">
                <HeadingSmall title="Categories" description="Manage your categories" />
                <div class="flex justify-end">
                    <Link :href="route('categories.create')"
                        ><Button class="ml-auto"><Plus class="h-4 w-4" /> Add Category</Button></Link
                    >
                </div>
                <Table>
                    <TableCaption>A list of your recent categories.</TableCaption>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="w-[100px]">ID</TableHead>
                            <TableHead class="w-[100px]"> Image </TableHead>
                            <TableHead>Name</TableHead>
                            <TableHead>Description</TableHead>
                            <TableHead class="text-right">Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="category in props.categories" :key="category.id">
                            <TableCell class="font-medium">{{ category.id }}</TableCell>
                            <TableCell> <img src="{{ category.image??'' }}" alt="category image" class="w-[100px]" /> </TableCell>
                            <TableCell class="font-medium">{{ category.name }}</TableCell>
                            <TableCell>{{ category.description ?? '' }}</TableCell>
                            <TableCell class="text-right">
                                <Link :href="route('categories.edit', category.id)" class="mr-2"><Button variant="secondary">Edit</Button></Link>
                                <Button variant="destructive" @click="handleDelete(category.id)">Delete</Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
