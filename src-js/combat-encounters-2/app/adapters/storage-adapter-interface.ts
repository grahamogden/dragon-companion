export interface StorageAdapterInterface {
    delete(key: string): void;
    get(key: string): unknown;
    save(key: string, value: unknown): void;
}
