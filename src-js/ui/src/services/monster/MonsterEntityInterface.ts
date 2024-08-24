import type { EntityInterface } from '../entity/EntityInterface.ts'

export interface NewMonsterEntityInterface {
    name: string
    description?: string
    size?: number
    default_hit_points?: number
    calculated_hit_points_dice_count?: number
    calculated_hit_points_dice_type?: number
    calculated_hit_points_modifier?: number
    armour_class?: number
    speed?: number
    challenge_rating?: number
}

export interface MonsterEntityInterface extends EntityInterface, NewMonsterEntityInterface {}
