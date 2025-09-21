<script setup lang="ts">
import { router, usePage } from '@inertiajs/vue3';
import { ListFilter } from 'lucide-vue-next';
import { ref } from 'vue';
import Button from '../ui/button/Button.vue';
import Label from '../ui/label/Label.vue';
import Popover from '../ui/popover/Popover.vue';
import PopoverContent from '../ui/popover/PopoverContent.vue';
import PopoverTrigger from '../ui/popover/PopoverTrigger.vue';
import Select from '../ui/select/Select.vue';
import SelectContent from '../ui/select/SelectContent.vue';
import SelectGroup from '../ui/select/SelectGroup.vue';
import SelectItem from '../ui/select/SelectItem.vue';
import SelectLabel from '../ui/select/SelectLabel.vue';
import SelectTrigger from '../ui/select/SelectTrigger.vue';
import SelectValue from '../ui/select/SelectValue.vue';

const props = defineProps<{
    filters: {
        order: string | null;
    };
}>();

const selectedOrder = ref(props.filters.order || '');

function applyFilters() {
    router.get(
        // Kunjungi URL saat ini
        usePage().url,
        { order: selectedOrder.value },
        {
            preserveState: true,
            replace: true,
            preserveScroll: true,
        },
    );
}

function resetFilters() {
    router.get(
        usePage().url,
        { order: undefined },
        {
            preserveState: true,
            replace: true,
            preserveScroll: true,
        },
    );
    selectedOrder.value = '';
}
</script>

<template>
    <Popover>
        <PopoverTrigger as-child>
            <Button variant="outline"><ListFilter /></Button>
        </PopoverTrigger>
        <PopoverContent class="mr-4 w-80 md:mr-6">
            <div class="grid gap-4">
                <div class="space-y-2">
                    <h4 class="leading-none font-medium">Filters</h4>
                    <p class="text-sm text-muted-foreground">Set the filter below.</p>
                </div>
                <div class="grid gap-2">
                    <div class="grid grid-cols-3 items-center gap-4">
                        <Label for="width">Short By</Label>
                        <Select class="col-span-2 h-8" name="order" v-model="selectedOrder">
                            <SelectTrigger class="w-[180px]">
                                <SelectValue placeholder="Select.." />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectLabel>Select by</SelectLabel>
                                    <SelectItem value="latest"> Latest </SelectItem>
                                    <SelectItem value="oldest"> Oldest </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center justify-end gap-2">
                        <Button @click="resetFilters" variant="secondary">Reset</Button>
                        <Button @click="applyFilters">Apply</Button>
                    </div>
                </div>
            </div>
        </PopoverContent>
    </Popover>
</template>
