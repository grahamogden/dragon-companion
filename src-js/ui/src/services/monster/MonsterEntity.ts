import type { MonsterEntityInterface } from './MonsterEntityInterface.ts'

export class MonsterEntity implements MonsterEntityInterface {
    id?: number
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

    constructor(
        id?: number,
        name: string = '',
        description?: string,
        size?: number,
        default_hit_points?: number,
        calculated_hit_points_dice_count?: number,
        calculated_hit_points_dice_type?: number,
        calculated_hit_points_modifier?: number,
        armour_class?: number,
        speed?: number,
        challenge_rating?: number,
    ) {
        this.id = id
        this.name = name
        this.description = description
        this.size = size
        this.default_hit_points = default_hit_points
        this.calculated_hit_points_dice_count = calculated_hit_points_dice_count
        this.calculated_hit_points_dice_type = calculated_hit_points_dice_type
        this.calculated_hit_points_modifier = calculated_hit_points_modifier
        this.armour_class = armour_class
        this.speed = speed
        this.challenge_rating = challenge_rating
    }
}
