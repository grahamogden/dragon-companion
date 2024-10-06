import type {
    EntityInterface,
    IndexEntityInterface,
} from "../entity.interface.js";
import { ChallengeRatingEnum } from "./challenge-rating.enum.js";
import { MonsterSizeEnum } from "./monster-size.enum.js";

export interface NewMonsterEntityInterface {
    name: string;
    description?: string;
    size?: MonsterSizeEnum;
    default_hit_points?: number;
    calculated_hit_points_dice_count?: number;
    calculated_hit_points_dice_type?: number;
    calculated_hit_points_modifier?: number;
    armour_class?: number;
    speed?: number;
    challenge_rating?: ChallengeRatingEnum;
    species_id?: number;
}

export interface MonsterEntityInterface
    extends EntityInterface,
        NewMonsterEntityInterface {}

export interface MonsterIndexEntityInterface
    extends MonsterEntityInterface,
        IndexEntityInterface {}
