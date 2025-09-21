import { useModalStore } from '@/stores/modalStore';

export function useCrudModal<T extends { id: number | string; name?: string }>(
    deleteComponent: any,
    formComponent: any,
    detailsComponent: any,
    deleteRouteName: string,
    entityName: string = 'Item',
) {
    const modalStore = useModalStore();

    const openDeleteModal = (item: T) => {
        modalStore.open(
            deleteComponent,
            {
                title: `Delete ${entityName}: ${item.name || item.id}`,
                message: `Are you sure you want to delete this ${entityName.toLowerCase()}? This action cannot be undone.`,
                deleteUrl: route(deleteRouteName, item.id),
            },
            { size: 'sm' },
        );
    };

    const openCreateModal = () => {
        modalStore.open(formComponent, null, { size: 'md' });
    };

    const openUpdateModal = (item: T) => {
        modalStore.open(formComponent, { [entityName.toLowerCase()]: item }, { size: 'lg' });
    };

    const openViewModal = (item: T) => {
        modalStore.open(detailsComponent, { [entityName.toLowerCase()]: item }, { size: 'md' });
    };

    return {
        openDeleteModal,
        openCreateModal,
        openUpdateModal,
        openViewModal,
    };
}
