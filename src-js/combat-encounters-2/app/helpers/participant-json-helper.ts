import { ParticipantAbstract } from '../entities';

export class ParticipantJsonHelper {
    private sessionStorageParticipants: string;

    constructor(sessionStorageParticipants: string) {
        this.sessionStorageParticipants = sessionStorageParticipants;
    }

    updateParticipantJson(participants: ParticipantAbstract[]) {
        const json = JSON.stringify(participants);
        const participantsJson = document.getElementById(
            'participants',
        ) as HTMLInputElement;
        participantsJson.value = json;
        sessionStorage.setItem(this.sessionStorageParticipants, json);
    }
}
