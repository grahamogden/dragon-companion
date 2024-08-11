import type { EntityInterface } from '../entity/EntityInterface'

export interface NewItemEntityInterface {
    name: string
    description: string
}

export interface ItemEntityInterface extends EntityInterface, NewItemEntityInterface {}
