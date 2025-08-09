<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { Bell } from 'lucide-vue-next';

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

const page = usePage();
</script>

<template>
    <Head title="Categories" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6">
            <div class="flex flex-col space-y-6">
                <div v-if="page.props.flash?.message" class="alert">
                    <Alert>
                        <Bell class="h-4 w-4" />
                        <AlertTitle>Notification</AlertTitle>
                        <AlertDescription> {{ page.props.flash.message }} </AlertDescription>
                    </Alert>
                </div>
                <HeadingSmall title="Categories" description="Manage your categories" />
                <Link :href="route('categories.create')"><Button>Add Category</Button></Link>
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
                                <Link :href="route('categories.destroy', category.id)" method="delete" as="button"
                                    ><Button variant="destructive">Delete</Button></Link
                                >
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
