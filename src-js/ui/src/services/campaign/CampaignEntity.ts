import type { CampaignEntityInterface } from '.'

export class CampaignEntity implements CampaignEntityInterface {
    id: number | null
    name: string
    synopsis: string

    constructor(id: number | null = null, name: string = '', synopsis: string = '') {
        this.id = id
        this.name = name
        this.synopsis = synopsis
    }
}
