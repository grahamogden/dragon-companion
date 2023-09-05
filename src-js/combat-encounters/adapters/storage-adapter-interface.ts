export interface StorageAdapterInterface {
    delete(key: string);
    get(key: string);
    save(key: string, value: unknown);
}
