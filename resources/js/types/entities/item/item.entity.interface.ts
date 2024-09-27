import type { EntityInterface } from "../entity.interface.ts";

export interface NewItemEntityInterface {
    name: string;
    description: string;
}

export interface ItemEntityInterface
    extends EntityInterface,
        NewItemEntityInterface {}
