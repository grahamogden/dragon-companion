import type {
    EntityInterface,
    IndexEntityInterface,
} from "../entity.interface.ts";

export interface NewItemEntityInterface {
    name: string;
    description?: string | null;
}

export interface ItemEntityInterface
    extends EntityInterface,
        NewItemEntityInterface {}

export interface ItemIndexEntityInterface
    extends ItemEntityInterface,
        IndexEntityInterface {}
