import { FormPage } from '../form-helper/form-page';
import { NotFoundException } from '../exceptions';
import { CombatEncounterHandler } from '../combat-encounter-handler';
import { FormPageInterface } from '../form-helper';

export class StartupPage extends FormPage implements FormPageInterface {
    static readonly PAGE_ID: string = 'combat-encounters-startup';
    private readonly _campaignIdInput: HTMLInputElement;

    constructor(private readonly combatEncounter: CombatEncounterHandler) {
        super(StartupPage.PAGE_ID);
        this._campaignIdInput = this.initCampaignIdInput();
    }

    buildForm(): void {
        console.debug('Building startup page');
    }

    action(): void {
        const campaignId = Number(this._campaignIdInput.value);
        this.combatEncounter.updateCampaign(campaignId);
        return;
    }

    isValid(): string[] {
        const campaignId = this._campaignIdInput.value;
        if (null === campaignId || isNaN(+campaignId)) {
            return ['Please select a valid campaign ID'];
        }

        return [];
    }

    private initCampaignIdInput() {
        const campaignIdInput = this._fieldset.querySelector(
            '#campaign-id',
        ) as HTMLInputElement | null;

        if (campaignIdInput === null) {
            throw new NotFoundException('#campaign-id not found');
        }

        campaignIdInput.addEventListener('change', function (event) {
            event.preventDefault();
            const input = event.target as HTMLInputElement;
            if (!input.value) {
                alert('No campaign selected!');
                return;
            }
        });

        return campaignIdInput;
    }
}
