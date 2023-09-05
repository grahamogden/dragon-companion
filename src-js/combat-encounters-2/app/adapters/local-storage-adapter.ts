import { StorageAdapterInterface } from './storage-adapter-interface';

export class LocalStorageAdapter implements StorageAdapterInterface {
    delete(key: string) {
        localStorage.removeItem(key);
    }

    get(key: string): string | null {
        return localStorage.getItem(key);
    }

    save(key: string, value: string) {
        console.debug(`Updating ${key} with: ${value};`);
        localStorage.setItem(key, value);
    }
}
