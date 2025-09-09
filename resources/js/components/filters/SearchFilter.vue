<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { router, usePage } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import { ref, watch } from 'vue';

const props = defineProps<{
    modelValue: string | null;
    class?: string;
}>();

const search = ref(props.modelValue || '');

watch(
    search,
    debounce((value: string | null) => {
        router.get(
            usePage().url,
            { search: value || undefined },
            {
                preserveState: true,
                replace: true,
                preserveScroll: true,
            },
        );
    }, 300),
);
</script>

<template>
    <div :class="props.class">
        <Input v-model="search" type="text" placeholder="Search..." class="w-full" />
    </div>
</template>
