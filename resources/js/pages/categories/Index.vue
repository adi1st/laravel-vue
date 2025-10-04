<script setup lang="ts">
import DeleteConfirmation from '@/components/DeleteConfirmation.vue';
import Filters from '@/components/filters/Filters.vue';
import SearchFilter from '@/components/filters/SearchFilter.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import Pagination from '@/components/pagination/Pagination.vue';
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
// import { useModalStore } from '@/stores/modalStore';
import { useCrudModal } from '@/composables/useCrudModals';
import type { Category, PaginatedResponse } from '@/types';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Eye, Plus, SquarePen, Trash } from 'lucide-vue-next';
import CategoryDetails from './partials/CategoryDetails.vue';
import CategoryForm from './partials/CategoryForm.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Categories',
        href: '/categories',
    },
];

defineProps<{
    categories: PaginatedResponse<Category>;
    search: string;
    filters: {
        order: string;
    };
}>();

const { openDeleteModal, openCreateModal, openUpdateModal, openViewModal } = useCrudModal<Category>(
    DeleteConfirmation,
    CategoryForm,
    CategoryDetails,
    'categories.destroy',
    'Category',
);
</script>

<template>
    <Head title="Categories" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6">
            <div class="flex flex-col space-y-6">
                <div class="flex items-center justify-between gap-4">
                    <HeadingSmall title="Categories" description="Manage your categories" />
                    <Button class="ml-auto" @click="openCreateModal"><Plus class="h-4 w-4" /> Add Category</Button>
                </div>
                <!-- Filter-->
                <div class="flex items-center justify-end space-x-4">
                    <SearchFilter :model-value="search || null" class="max-w-sm" />
                    <Filters :filters="filters || null" />
                </div>
                <Table>
                    <TableCaption>A list of your recent categories.</TableCaption>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="w-[100px]">ID</TableHead>
                            <!-- <TableHead class="w-[100px]"> Image </TableHead> -->
                            <TableHead>Name</TableHead>
                            <TableHead>Description</TableHead>
                            <TableHead class="text-right">Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="category in categories.data" :key="category.id">
                            <TableCell class="font-medium">{{ category.id }}</TableCell>
                            <!-- <TableCell> <img :src="category.image" alt="category image" class="w-[100px]" /> </TableCell> -->
                            <TableCell class="font-medium">{{ category.name }}</TableCell>
                            <TableCell>{{ category.description ?? '' }}</TableCell>
                            <TableCell class="text-right">
                                <Button variant="ghost" @click="openViewModal(category)" class="mr-2"><Eye /></Button>
                                <Button variant="outline" @click="openUpdateModal(category)" class="mr-2"><SquarePen /></Button>
                                <Button variant="destructive" @click="openDeleteModal(category)" class="mr-2"><Trash /></Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
                <div class="d-flex justify-content-center mx-auto mt-4">
                    <Pagination :links="categories.links" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
