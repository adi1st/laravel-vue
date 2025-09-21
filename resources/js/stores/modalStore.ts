import { defineStore } from 'pinia';
import { ref, shallowRef, type Component } from 'vue';

// tipe payload data modal
type ModalDataPayload = Record<string, any> | null;

export type ModalSize = 'sm' | 'md' | 'lg' | 'xl' | '2xl' | '3xl' | '4xl';

interface ModalOptions {
    size?: ModalSize;
}

export const useModalStore = defineStore('modal', () => {
    // STATE
    const isOpen = ref<boolean>(false);

    // `component` akan menyimpan referensi ke komponen Vue yang akan ditampilkan (misal: CategoryForm)
    // `shallowRef` digunakan untuk performa, karena kita tidak perlu membuat komponen ini reaktif secara mendalam.
    const view = shallowRef<Component | null>(null);

    // `data` akan menyimpan props yang akan dilewatkan ke komponen di dalam modal
    const data = ref<ModalDataPayload>(null);

    //State untuk menyimpan ukuran modal, defaultnya 'md'
    const size = ref<ModalSize>('md');

    // ACTIONS
    function open(component: Component, props: ModalDataPayload = null, options: ModalOptions = {}) {
        view.value = component;
        data.value = props;
        size.value = options.size || 'md';
        isOpen.value = true;
    }
    function close() {
        isOpen.value = false;
        // Reset setelah transisi selesai untuk menghindari kedipan konten
        setTimeout(() => {
            view.value = null;
            data.value = null;
            size.value = 'md';
        }, 200); //sesuaikan transisi sesuai dialog
    }

    return {
        isOpen,
        view,
        data,
        size,
        open,
        close,
    };
});
