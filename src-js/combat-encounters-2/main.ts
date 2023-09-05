import { CombatEncounterHandler } from './app';
import { CombatTableHelper, InitiativeTableHelper } from './app/table';
import { CombatTurnFormHelper } from './app/helpers';
import { LocalStorageAdapter } from './app/adapters';
import { FormPageHandler } from './app/form-helper';
import { StartupPage } from './app/form-pages/startup-page';
import { ParticipantsPage } from './app/form-pages/participants-page';
import { InitiativePage } from './app/form-pages/initiative-page';
import { CombatPage } from './app/form-pages/combat-page';
import { Randomiser } from './app/helpers/randomiser';
import { CombatEncounter } from './app/entities';
// const participantJsonHelper = new ParticipantJsonHelper(
//     sessionStorageParticipants,
// );

// const randomiser = ($, self, max, modifier) => {
//     const rand = Math.ceil(Math.random() * max + modifier);
//
//     $(self).siblings('input').val(rand).change();
// };
console.debug('Script!');

// Define a function to be executed when the document is ready
function handleDocumentReady() {
    console.debug('Document ready!');
    const initiativeTable = new InitiativeTableHelper(
        document.getElementById('initiative-table') as HTMLTableElement,
    );
    const combatTable = new CombatTableHelper(
        document.getElementById('combat-table') as HTMLTableElement,
    );
    const combatTurnFormHelper = new CombatTurnFormHelper(
        document.getElementById('source-participant') as HTMLSelectElement,
        document.getElementById('target-participant') as HTMLSelectElement,
        document.getElementById('combat-actions') as HTMLSelectElement,
        document.getElementById('combat-roll') as HTMLInputElement,
        document.getElementById('combat-total') as HTMLInputElement,
        // document.getElementById('combat-movement') as HTMLInputElement,
    );

    const localStorageAdapter = new LocalStorageAdapter();
    const combatEncounterHandler = new CombatEncounterHandler(
        // new CombatHandler(combatTable, combatTurnFormHelper),
        combatTurnFormHelper,
        localStorageAdapter,
    );

    const state = localStorageAdapter.get(combatEncounterHandler.STORAGE_KEY);
    console.debug(JSON.stringify(state));

    let startPage: string = StartupPage.PAGE_ID;
    if (null !== state) {
        const stateProgress =
            combatEncounterHandler.restoreFromJsonString(state);
        if (stateProgress[CombatEncounter.CAMPAIGN_ID_KEY]) {
            startPage = ParticipantsPage.PAGE_ID;
        }
        if (stateProgress[CombatEncounter.PARTICIPANTS_KEY]) {
            startPage = InitiativePage.PAGE_ID;
        }
        if (
            stateProgress[CombatEncounter.ROUND_COUNTER_KEY] &&
            stateProgress[CombatEncounter.TURN_COUNTER_KEY]
        ) {
            startPage = CombatPage.PAGE_ID;
        }
    }

    const formHelper = new FormPageHandler();
    formHelper.addPage(new StartupPage(combatEncounterHandler));
    formHelper.addPage(new ParticipantsPage(combatEncounterHandler));
    formHelper.addPage(
        new InitiativePage(
            combatEncounterHandler,
            initiativeTable,
            new Randomiser(),
        ),
    );
    formHelper.addPage(new CombatPage(combatEncounterHandler, combatTable));
    formHelper.goToPageById(startPage);

    // if (
    //     null !==
    //     restoreInputFromSessionStorage(
    //         $('#campaign-id'),
    //         sessionStorageCampaign,
    //     )
    // ) {
    //     const playerCharactersJson = restoreInputFromSessionStorage(
    //         $('#player-characters'),
    //         sessionStoragePlayerCharacters,
    //     );
    //     const monstersJson = restoreInputFromSessionStorage(
    //         $('#monsters'),
    //         sessionStorageMonsters,
    //     );
    //
    //     if (null !== playerCharactersJson && null !== monstersJson) {
    //         $.each(playerCharactersJson, function (index, playerCharacter) {
    //             const target = 'player-characters';
    //
    //             $(`#autocomplete-${target}-table tbody`).append(
    //                 `<tr><td>${playerCharacter.data.name}</td><td><button class='btn btn-danger' onclick="removeAutocompleteItemFromTable(jQuery, this, '${target}', ${playerCharacter.data.id})" type='button'>Remove</button></td></tr>`,
    //             );
    //         });
    //
    //         $.each(monstersJson, function (index, monster) {
    //             const target = 'monsters';
    //
    //             $(`#autocomplete-${target}-table tbody`).append(
    //                 `<tr><td>${monster.data.name}</td><td><button class='btn btn-danger' onclick="removeAutocompleteItemFromTable(jQuery, this, '${target}', ${monster.data.id})" type='button'>Remove</button></td></tr>`,
    //             );
    //         });
    //
    //         $('#combat-encounters-startup').hide();
    //         $('#combat-encounters-participants').show();
    //
    //         const participantsJson = restoreInputFromSessionStorage(
    //             $('#participants'),
    //             sessionStorageParticipants,
    //         );
    //         if (null !== participantsJson) {
    //             console.log(
    //                 'monster and PC json exists, set up initiative table',
    //             );
    //             combatEncounter.clearParticipants();
    //             combatTable.clearTable();
    //             let participantsStartingValuesSet = true;
    //             const participants: ParticipantAbstract[] = [];
    //
    //             $.each(participantsJson, function (index, participantObj) {
    //                 let participant;
    //                 if (
    //                     participantObj.participantType ===
    //                     ParticipantTypeEnum.PLAYER_CHARACTER
    //                 ) {
    //                     participant = new PlayerCharacter(
    //                         participantObj.id,
    //                         participantObj.name,
    //                         participantObj.armourClass,
    //                         participantObj.maxHitPoints,
    //                         participantObj.dexterityModifier,
    //                         participantObj.startingHitPoints || undefined,
    //                         participantObj.currentHitPoints || undefined,
    //                         participantObj.initiative || undefined,
    //                     );
    //                 } else if (
    //                     participantObj.participantType ===
    //                     ParticipantTypeEnum.MONSTER
    //                 ) {
    //                     participant = new Monster(
    //                         participantObj.id,
    //                         participantObj.name,
    //                         participantObj.armourClass,
    //                         participantObj.maxHitPoints,
    //                         participantObj.dexterityModifier,
    //                         participantObj.monsterInstanceTypeId,
    //                         participantObj.startingHitPoints || undefined,
    //                         participantObj.currentHitPoints || undefined,
    //                         participantObj.initiative || undefined,
    //                     );
    //                 }
    //                 if (
    //                     !participant.getStartingHitPoints() ||
    //                     !participant.getInitiative()
    //                 ) {
    //                     participantsStartingValuesSet = false;
    //                 }
    //                 participants.push(participant);
    //             });
    //
    //             setUpInitiativeTable(participants);
    //             // setParticipantStartingValuesOnCombatEncounter($);
    //             combatEncounter.sortParticipants();
    //
    //             $('#combat-encounters-participants').hide();
    //             $('#combat-encounters-initiative').show();
    //
    //             if (participantsStartingValuesSet) {
    //                 console.log(combatEncounter.getParticipants());
    //                 combatEncounter.setUpCombat();
    //
    //                 $('#combat-encounters-initiative').hide();
    //                 $('#combat-encounters-combat').show();
    //                 // restoreInputFromSessionStorage($('#turns'), sessionStorageTurns);
    //             }
    //         }
    //     }
    // } else {
    //     $('#campaign-id').change();
    //     combatEncounter.clearEncounter();
    // }
}

// Wait for the "DOMContentLoaded" event
document.addEventListener('DOMContentLoaded', handleDocumentReady);
