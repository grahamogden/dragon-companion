export interface ParticipantFromJson {
    label: string;
    value: number;
    data: {
        id: number;
        name: string;
        armour_class: number;
        max_hit_points: number;
        dexterity_modifier: number;
        temporary_id: number;
    };
}

export interface MonsterParticipantFromJson extends ParticipantFromJson {
    data: {
        id: number;
        name: string;
        armour_class: number;
        max_hit_points: number;
        dexterity_modifier: number;
        temporary_id: number;
        monster_instance_type_id?: number;
    };
}
