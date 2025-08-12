import { defineStore } from 'pinia';
import { ref } from 'vue';

// Definisikan tipe untuk varian alert agar lebih aman
type AlertVariant = 'default' | 'destructive';

// Definisikan interface untuk konfigurasi alert
export interface AlertConfig {
    title: string;
    description?: string;
    variant?: AlertVariant;
    duration?: number;
}

export const useAlertStore = defineStore('alert', () => {
    // === STATE ===
    const show = ref<boolean>(false);
    const title = ref<string>('');
    const description = ref<string>('');
    const variant = ref<AlertVariant>('default');

    // Variabel untuk menampung timer
    let timer: ReturnType<typeof setTimeout> | null = null;

    // === ACTIONS ===

    // Fungsi untuk menampilkan alert, sekarang dengan parameter yang diketik
    function showAlert(config: AlertConfig) {
        // Jika ada alert yang sedang berjalan, batalkan timer-nya
        if (timer) {
            clearTimeout(timer);
        }

        // Set state dari alert berdasarkan konfigurasi yang diberikan
        show.value = true;
        title.value = config.title;
        description.value = config.description || '';
        variant.value = config.variant || 'default';

        // Set timer baru untuk menyembunyikan alert secara otomatis
        timer = setTimeout(() => {
            hideAlert();
        }, config.duration || 5000); // Default 5 detik
    }

    // Fungsi untuk menyembunyikan alert
    function hideAlert() {
        show.value = false;
    }

    return { show, title, description, variant, showAlert, hideAlert };
});
