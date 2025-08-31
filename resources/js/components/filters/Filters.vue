<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import { ListFilter } from 'lucide-vue-next';
import { ref, watch } from 'vue';
import Button from '../ui/button/Button.vue';
import Input from '../ui/input/Input.vue';
import Label from '../ui/label/Label.vue';
import Popover from '../ui/popover/Popover.vue';
import PopoverContent from '../ui/popover/PopoverContent.vue';
import PopoverTrigger from '../ui/popover/PopoverTrigger.vue';

const props = defineProps<{
    modelValue: string | null;
    routeName: string;
    class?: string;
}>();

const search = ref(props.modelValue || '');

watch(
    search,
    debounce((value: string | null) => {
        router.get(
            route(props.routeName),
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
    <Popover>
        <PopoverTrigger as-child>
            <Button variant="outline"><ListFilter /></Button>
        </PopoverTrigger>
        <PopoverContent class="w-80">
            <div class="grid gap-4">
                <div class="space-y-2">
                    <h4 class="leading-none font-medium">Filters</h4>
                    <p class="text-sm text-muted-foreground">Set the filter below.</p>
                </div>
                <div class="grid gap-2">
                    <div class="grid grid-cols-3 items-center gap-4">
                        <Label for="width">Width</Label>
                        <Input id="width" type="text" default-value="100%" class="col-span-2 h-8" />
                    </div>
                    <div class="grid grid-cols-3 items-center gap-4">
                        <Label for="maxWidth">Max. width</Label>
                        <Input id="maxWidth" type="text" default-value="300px" class="col-span-2 h-8" />
                    </div>
                    <div class="grid grid-cols-3 items-center gap-4">
                        <Label for="height">Height</Label>
                        <Input id="height" type="text" default-value="25px" class="col-span-2 h-8" />
                    </div>
                    <div class="grid grid-cols-3 items-center gap-4">
                        <Label for="maxHeight">Max. height</Label>
                        <Input id="maxHeight" type="text" default-value="none" class="col-span-2 h-8" />
                    </div>
                </div>
            </div>
        </PopoverContent>
    </Popover>
</template>
