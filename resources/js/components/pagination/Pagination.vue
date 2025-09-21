<script setup lang="ts">
import { buttonVariants } from '@/components/ui/button'; // Impor buttonVariants
import { cn } from '@/lib/utils'; // Impor cn utility
import { Link } from '@inertiajs/vue3';

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

defineProps<{
    links: PaginationLink[];
}>();
</script>

<template>
    <div v-if="links.length > 3" class="flex flex-wrap items-center gap-2">
        <template v-for="(link, key) in links" :key="key">
            <!-- Tombol non-link (misalnya '...') yang dinonaktifkan -->
            <div
                v-if="link.url === null"
                :class="cn(buttonVariants({ variant: 'outline' }), 'cursor-not-allowed text-muted-foreground')"
                v-html="link.label"
            />
            <!-- Komponen Link yang bisa diklik, sekarang ditata seperti Button -->
            <Link v-else :class="cn(buttonVariants({ variant: link.active ? 'default' : 'outline' }))" :href="link.url">
                <span v-html="link.label"></span>
            </Link>
        </template>
    </div>
</template>
