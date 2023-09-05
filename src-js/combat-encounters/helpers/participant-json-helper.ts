import * as $ from 'jquery';
import { Participant } from '../../../../dist/entities/participant';

export class ParticipantJsonHelper {
    private sessionStorageParticipants: string;

    constructor(sessionStorageParticipants) {
        this.sessionStorageParticipants = sessionStorageParticipants;
    }

    updateParticipantJson(participants: Participant[]) {
        const json = JSON.stringify(participants); //this.combatEncounter.getParticipants());
        $('#participants').val(json);
        sessionStorage.setItem(this.sessionStorageParticipants, json);
    }
}
