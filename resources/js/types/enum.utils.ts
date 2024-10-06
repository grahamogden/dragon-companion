import { SelectInputOptionInterface } from "./entity-option";

export class EnumUtils {
    static getKeys<T>(enumObj: T): Array<keyof T> {
        return Object.keys(enumObj as object) as Array<keyof T>;
    }

    static getValues<T>(enumObj: T): Array<T[keyof T]> {
        return Object.values(enumObj as object) as Array<T[keyof T]>;
    }

    static getValueByKey<T>(enumObj: T, key: keyof T): T[keyof T] | undefined {
        return enumObj[key];
    }

    static getKeyByValue<T>(
        enumObj: T,
        value: T[keyof T]
    ): keyof T | undefined {
        const entry = Object.entries(enumObj as object).find(
            ([_, v]) => v === value
        );
        return entry ? (entry[0] as keyof T) : undefined;
    }

    static getSelectOptions<T>(enumObj: T): SelectInputOptionInterface[] {
        return Object.values(enumObj as object).map((value) => {
            return {
                text: value,
                value: value,
            };
        });
    }
}
