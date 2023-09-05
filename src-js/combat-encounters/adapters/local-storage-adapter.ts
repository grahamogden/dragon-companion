import { StorageAdapterInterface } from './storage-adapter-interface';

export class LocalStorageAdapter implements StorageAdapterInterface {
    delete(key: string): void {
        localStorage.removeItem(key);
    }

    get(key: string): string {
        return localStorage.getItem(key);
    }

    save(key: string, value: string) {
        localStorage.setItem(key, value);
    }
}
