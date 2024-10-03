import { SelectInputOptionInterface } from "../../entity-option";

export enum MonsterSizeEnum {
    Unknown = "Unknown",
    Tiny = "Tiny",
    Small = "Small",
    Medium = "Medium",
    Large = "Large",
    Huge = "Huge",
    Gargantuan = "Gargantuan",
}

export class MonsterSizeUtils {
    static values(): MonsterSizeEnum[] {
        return Object.values(MonsterSizeEnum);
    }

    static options(): SelectInputOptionInterface[] {
        return Object.values(MonsterSizeEnum).map((value) => {
            return {
                text: value,
                value: value,
            };
        });
    }
}
